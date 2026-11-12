<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class DgePayService
{
    protected string $clientId;

    protected string $clientSecret;

    protected string $clientApiKey;

    protected string $baseUrl;

    public const STATUS_SUCCESS = '3';

    public const STATUS_CANCELLED = '8';

    public function __construct()
    {
        $this->clientId = (string) config('services.dgepay.client_id');
        $this->clientSecret = (string) config('services.dgepay.client_secret');
        $this->clientApiKey = (string) (config('services.dgepay.client_api_key') ?? config('services.dgepay.api_key'));
        $this->baseUrl = rtrim((string) config('services.dgepay.base_url', 'https://api-uat.dgepay.net/dipon/v3'), '/');
    }

    /**
     * Authenticate with DGePay and retrieve JWT bearer token.
     *
     * @return array{success: bool, access_token?: string, message?: string}
     */
    public function authenticate(): array
    {
        try {
            $basicAuth = base64_encode($this->clientId.':'.$this->clientSecret);

            $response = Http::withHeaders([
                'Authorization' => 'Basic '.$basicAuth,
                'Content-Type' => 'application/json',
            ])->post($this->baseUrl.'/payment_gateway/authenticate', [
                'client_id' => $this->clientId,
                'client_secret' => $this->clientSecret,
            ]);

            $data = $response->json() ?? [];

            if (! $response->successful() || empty($data['data']['access_token'])) {
                Log::warning('DGePay authentication failed', ['status' => $response->status(), 'response' => $data]);

                return [
                    'success' => false,
                    'message' => $data['message'] ?? 'Authentication failed with DGePay.',
                ];
            }

            return [
                'success' => true,
                'access_token' => $data['data']['access_token'],
            ];
        } catch (Exception $e) {
            Log::error('DGePay authentication exception', ['error' => $e->getMessage()]);

            return [
                'success' => false,
                'message' => 'Could not connect to DGePay: '.$e->getMessage(),
            ];
        }
    }

    /**
     * Initiate payment session with DGePay gateway.
     *
     * @param  array{
     *     amount: float|int,
     *     orderId: string,
     *     redirectUrl: string,
     *     description?: string,
     *     meta_data?: array
     * }  $paymentData
     * @return array{success: bool, payment_url?: string, transaction_id?: string, message?: string}
     */
    public function initiatePayment(array $paymentData): array
    {
        try {
            $auth = $this->authenticate();
            if (! $auth['success']) {
                return $auth;
            }

            $payload = [
                'amount' => (float) ($paymentData['amount'] ?? 0),
                'customer_token' => $paymentData['customer_token'] ?? null,
                'note' => $paymentData['description'] ?? 'Payment',
                'payee_information' => $paymentData['payee_information'] ?? null,
                'payment_method' => $paymentData['payment_method'] ?? null,
                'redirect_url' => $paymentData['redirectUrl'],
                'unique_txn_id' => $paymentData['orderId'],
                'meta_data' => $paymentData['meta_data'] ?? null,
                'unique_user_reference' => $paymentData['unique_user_reference'] ?? null,
            ];

            $signature = $this->generateSignature($payload);
            $encryptedBody = $this->encryptPayload($payload);

            $response = Http::withHeaders([
                'Authorization' => 'Bearer '.$auth['access_token'],
                'Signature' => $signature,
                'Content-Type' => 'application/json',
            ])->withBody($encryptedBody, 'application/json')
                ->post($this->baseUrl.'/payment_gateway/initiate_payment');

            $data = $response->json() ?? [];

            if (! $response->successful() || empty($data['data']['webview_url'])) {
                Log::warning('DGePay initiate payment failed', [
                    'status' => $response->status(),
                    'response' => $data,
                ]);

                $errorMessage = $data['error'][0] ?? $data['message'] ?? 'Failed to initiate DGePay payment.';

                return [
                    'success' => false,
                    'message' => $errorMessage,
                ];
            }

            return [
                'success' => true,
                'payment_url' => $data['data']['webview_url'],
                'transaction_id' => $data['data']['unique_txn_id'] ?? $paymentData['orderId'],
            ];
        } catch (Exception $e) {
            Log::error('DGePay initiate payment exception', ['error' => $e->getMessage()]);

            return [
                'success' => false,
                'message' => 'Could not connect to DGePay: '.$e->getMessage(),
            ];
        }
    }

    /**
     * Check transaction status directly server-to-server.
     *
     * @return array{success: bool, data?: array, message?: string}
     */
    public function getTransactionStatus(string $uniqueTxnId): array
    {
        try {
            $auth = $this->authenticate();
            if (! $auth['success']) {
                return $auth;
            }

            $payload = ['unique_txn_id' => $uniqueTxnId];
            $signature = $this->generateSignature($payload);
            $encryptedBody = $this->encryptPayload($payload);

            $response = Http::withHeaders([
                'Authorization' => 'Bearer '.$auth['access_token'],
                'Signature' => $signature,
                'Content-Type' => 'application/json',
            ])->withBody($encryptedBody, 'application/json')
                ->post($this->baseUrl.'/payment_gateway/check_transaction_status');

            $data = $response->json() ?? [];

            if (! $response->successful()) {
                Log::warning('DGePay transaction status check failed', [
                    'unique_txn_id' => $uniqueTxnId,
                    'response' => $data,
                ]);

                return [
                    'success' => false,
                    'message' => $data['message'] ?? 'Failed to check payment status.',
                ];
            }

            return [
                'success' => true,
                'data' => $data['data'] ?? $data,
            ];
        } catch (Exception $e) {
            Log::error('DGePay status check exception', ['error' => $e->getMessage()]);

            return [
                'success' => false,
                'message' => 'Could not connect to DGePay: '.$e->getMessage(),
            ];
        }
    }

    /**
     * Decrypt callback data received from DGePay redirect.
     * Restores '+' signs corrupted by query string parser if necessary.
     */
    public function decryptCallbackData(string $encryptedData): ?array
    {
        try {
            $cleaned = str_replace(' ', '+', $encryptedData);

            $decrypted = openssl_decrypt($cleaned, 'AES-128-ECB', $this->clientSecret, 0);

            if ($decrypted === false) {
                $decoded = base64_decode($cleaned, true);
                if ($decoded !== false) {
                    $decrypted = openssl_decrypt($decoded, 'AES-128-ECB', $this->clientSecret, OPENSSL_RAW_DATA);
                }
            }

            if ($decrypted === false || $decrypted === null) {
                Log::warning('DGePay callback decryption failed', ['preview' => substr($encryptedData, 0, 80)]);

                return null;
            }

            $parsed = json_decode($decrypted, true);

            return is_array($parsed) ? $parsed : null;
        } catch (Exception $e) {
            Log::warning('DGePay callback decryption exception', ['error' => $e->getMessage()]);

            return null;
        }
    }

    /**
     * Parse raw/decrypted callback array.
     *
     * @return array{
     *     is_success: bool,
     *     is_cancelled: bool,
     *     unique_txn_id: string,
     *     txn_number: string,
     *     message: string,
     *     status_code: string,
     *     payment_method: string,
     *     amount: mixed,
     *     metadata: array
     * }
     */
    public function parseCallbackResult(array $params): array
    {
        $statusCode = (string) ($params['status_code'] ?? '');
        $status = (string) ($params['status'] ?? '');
        $message = (string) ($params['message'] ?? '');

        $isSuccess = ($params['unique_txn_id'] ?? '') !== '' && (
            $statusCode === self::STATUS_SUCCESS
            || in_array($status, ['1', 'success', 'completed', 'COMPLETED'], true)
        );

        $isCancelled = $statusCode === self::STATUS_CANCELLED
            || in_array($status, ['cancel', 'cancelled'], true)
            || stripos($message, 'cancel') !== false;

        return [
            'is_success' => $isSuccess,
            'is_cancelled' => $isCancelled,
            'unique_txn_id' => (string) ($params['unique_txn_id'] ?? ''),
            'txn_number' => (string) ($params['txn_number'] ?? ''),
            'txn_id' => (string) ($params['txn_id'] ?? ''),
            'message' => $message,
            'status_code' => $statusCode,
            'payment_method' => (string) ($params['payment_method'] ?? ''),
            'amount' => $params['amount'] ?? null,
            'metadata' => $params['metadata'] ?? [],
        ];
    }

    /**
     * Generate HMAC-SHA256 signature according to DGePay API specifications.
     */
    public function generateSignature(array $data): string
    {
        $flatString = $this->flattenParams($data);
        $flatString = str_replace(['{', '}', '"', ':', ' ', ','], '', $flatString);

        $hmac = hash_hmac('sha256', $flatString, $this->clientApiKey, true);

        return base64_encode($hmac);
    }

    /**
     * Recursively flatten array for signature generation.
     */
    protected function flattenParams(array $data): string
    {
        ksort($data);

        $result = '';
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                $result .= $key.$this->flattenParams($value);
            } else {
                if (is_null($value)) {
                    $strValue = 'null';
                } elseif (is_bool($value)) {
                    $strValue = $value ? 'true' : 'false';
                } elseif (is_int($value) || is_float($value)) {
                    $strValue = number_format((float) $value, 1, '.', '');
                } else {
                    $strValue = (string) $value;
                }
                $result .= $key.$strValue;
            }
        }

        return $result;
    }

    /**
     * AES-128-ECB encryption using client_secret.
     */
    public function encryptPayload(array $data): string
    {
        $json = json_encode($data);

        return openssl_encrypt($json, 'AES-128-ECB', $this->clientSecret, 0);
    }

    /**
     * Generate unique transaction ID (e.g. DG742189).
     */
    public static function generateTransactionId(string $prefix = 'DG'): string
    {
        return $prefix.random_int(100000, 999999);
    }

    /**
     * Helper to encode stateless customer payload in callback or metadata.
     */
    public function encodeCustomerPayload(array $data): string
    {
        $json = json_encode($data);

        return openssl_encrypt($json, 'AES-128-ECB', $this->clientSecret, 0);
    }

    /**
     * Helper to decode stateless customer payload.
     */
    public function decodeCustomerPayload(string $encrypted): ?array
    {
        $decrypted = openssl_decrypt(str_replace(' ', '+', $encrypted), 'AES-128-ECB', $this->clientSecret, 0);
        if ($decrypted === false) {
            return null;
        }

        $decoded = json_decode($decrypted, true);

        return is_array($decoded) ? $decoded : null;
    }
}
