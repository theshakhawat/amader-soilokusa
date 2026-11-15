<?php

namespace App\Services;

use DgePay\DgePay;
use Exception;
use Illuminate\Support\Facades\Log;

class DgePayService
{
    protected DgePay $client;

    public const STATUS_SUCCESS = '3';
    public const STATUS_CANCELLED = '8';

    public function __construct()
    {
        $this->client = new DgePay([
            'client_id'      => (string) config('services.dgepay.client_id'),
            'client_secret'  => (string) config('services.dgepay.client_secret'),
            'client_api_key' => (string) (config('services.dgepay.client_api_key') ?? config('services.dgepay.api_key')),
            'base_url'       => rtrim((string) config('services.dgepay.base_url', 'https://api-uat.dgepay.net/dipon/v3'), '/'),
        ]);

        $this->client->setLogger(function (string $level, string $message, array $context) {
            Log::log($level === 'error' ? 'error' : 'warning', "DGePay: {$message}", $context);
        });
    }

    /**
     * Initiate payment session with DGePay gateway.
     *
     * @param array{
     *     amount: float|int,
     *     orderId: string,
     *     redirectUrl: string,
     *     description?: string,
     *     donor_name?: string,
     *     donor_phone?: string,
     *     meta_data?: array,
     *     unique_user_reference?: string
     * } $paymentData
     * @return array{success: bool, payment_url?: string, transaction_id?: string, message?: string}
     */
    public function initiatePayment(array $paymentData): array
    {
        try {
            // Ensure DGePay required meta_data structure
            $metaData = $paymentData['meta_data'] ?? [];
            $metaData = [
                'custom_field_1' => (string) ($metaData['custom_field_1'] ?? $paymentData['donor_name'] ?? 'Donor'),
                'custom_field_2' => (string) ($metaData['custom_field_2'] ?? $paymentData['donor_phone'] ?? '01700000000'),
                'custom_field_3' => (string) ($metaData['custom_field_3'] ?? $paymentData['description'] ?? 'Donation'),
            ];

            $orderId = $paymentData['orderId'] ?? self::generateTransactionId();

            return $this->client->initiatePayment([
                'amount'                => (float) ($paymentData['amount'] ?? 0),
                'description'           => $paymentData['description'] ?? 'Donation Agamir Shoilokuya',
                'orderId'               => $orderId,
                'redirectUrl'           => $paymentData['redirectUrl'],
                'unique_user_reference' => (string) ($paymentData['unique_user_reference'] ?? ('donor_' . ($paymentData['donor_phone'] ?? 'guest'))),
                'meta_data'             => $metaData,
            ]);
        } catch (Exception $e) {
            Log::error('DGePay initiate payment exception', ['error' => $e->getMessage()]);

            return [
                'success' => false,
                'message' => 'Could not connect to DGePay: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Check transaction status directly server-to-server.
     */
    public function getTransactionStatus(string $uniqueTxnId): array
    {
        return $this->client->getTransactionStatus($uniqueTxnId);
    }

    /**
     * Decrypt callback data received from DGePay redirect.
     */
    public function decryptCallbackData(string $encryptedData): ?array
    {
        return $this->client->decryptCallbackData($encryptedData);
    }

    /**
     * Parse raw or decrypted callback parameters.
     */
    public function parseCallbackResult(array $params): array
    {
        return $this->client->parseCallbackResult($params);
    }

    /**
     * Check if a status code means success.
     */
    public static function isSuccessStatus(string|int $statusCode): bool
    {
        return DgePay::isSuccessStatus((string) $statusCode);
    }

    /**
     * Check if a status code means cancelled.
     */
    public static function isCancelledStatus(string|int $statusCode): bool
    {
        return DgePay::isCancelledStatus((string) $statusCode);
    }

    /**
     * Generate unique transaction ID (e.g. DG20261115143500940).
     */
    public static function generateTransactionId(string $prefix = 'DG'): string
    {
        return DgePay::generateTransactionId($prefix);
    }
}
