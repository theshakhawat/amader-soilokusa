<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use App\Services\DgePayService;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DonationController extends Controller
{
    public function __construct(
        protected DgePayService $dgePayService
    ) {}

    /**
     * Helper to normalize Bengali numerals to English digits.
     */
    protected function normalizeBnDigits(string $value): string
    {
        $bn = ['০', '১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯'];
        $en = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];

        return str_replace($bn, $en, $value);
    }

    /**
     * Initiate a donation payment session via DGePay.
     */
    public function initiate(Request $request): RedirectResponse
    {
        // Normalize Bengali numbers if input
        if ($request->has('amount')) {
            $request->merge(['amount' => $this->normalizeBnDigits((string)$request->amount)]);
        }
        if ($request->has('phone')) {
            $request->merge(['phone' => $this->normalizeBnDigits((string)$request->phone)]);
        }

        $validated = $request->validate([
            'amount' => 'required|numeric|min:10',
            'name'   => 'required|string|max:120',
            'phone'  => 'required|string|max:20',
        ], [
            'amount.required' => 'অনুদানের পরিমাণ উল্লেখ করুন।',
            'amount.numeric'  => 'অনুদানের পরিমাণ সঠিক সংখ্যা হতে হবে।',
            'amount.min'      => 'সর্বনিম্ন ১০ টাকা অনুদান দেওয়া যাবে।',
            'name.required'   => 'আপনার নাম লিখুন।',
            'phone.required'  => 'মোবাইল নম্বর লিখুন।',
        ]);

        $trxId = DgePayService::generateTransactionId();

        // Save pending donation record
        $donation = Donation::create([
            'trx_id'         => $trxId,
            'donor_name'     => $validated['name'],
            'donor_phone'    => $validated['phone'],
            'amount'         => (float) $validated['amount'],
            'currency'       => 'BDT',
            'payment_method' => 'DgePay',
            'status'         => Donation::STATUS_PENDING,
            'is_manual'      => false,
        ]);

        // Initiate DGePay payment
        $paymentResult = $this->dgePayService->initiatePayment([
            'amount'                => (float) $validated['amount'],
            'orderId'               => $trxId,
            'description'           => 'Agamir Shoilokuya Donation',
            'donor_name'            => $validated['name'],
            'donor_phone'           => $validated['phone'],
            'redirectUrl'           => route('donations.callback'),
            'unique_user_reference' => 'donor_' . preg_replace('/\D/', '', $validated['phone']),
            'meta_data'             => [
                'custom_field_1' => $validated['name'],
                'custom_field_2' => $validated['phone'],
                'custom_field_3' => (string) $donation->id,
            ],
        ]);

        if (!($paymentResult['success'] ?? false) || empty($paymentResult['payment_url'])) {
            $errorMessage = $paymentResult['message'] ?? 'পেমেন্ট গেটওয়েতে সংযোগ করতে সমস্যা হয়েছে। অনুগ্রহ করে আবার চেষ্টা করুন।';

            $donation->update([
                'status' => Donation::STATUS_FAILED,
                'notes'  => $errorMessage,
            ]);

            return back()->with('donation_result', 'failed')
                         ->with('donation_message', $errorMessage);
        }

        // Redirect user to DGePay checkout webview
        return redirect()->away($paymentResult['payment_url']);
    }

    /**
     * Handle callback redirect from DGePay.
     */
    public function callback(Request $request): RedirectResponse
    {
        $callbackParams = $request->all();

        // If DGePay sends encrypted 'data' parameter in query or body
        if ($request->has('data')) {
            // Restore '+' signs that PHP/Laravel converts into spaces
            $rawData = str_replace(' ', '+', (string)$request->input('data'));
            $decrypted = $this->dgePayService->decryptCallbackData($rawData);

            if (is_array($decrypted)) {
                $callbackParams = array_merge($callbackParams, $decrypted);
            }
        }

        $parsed = $this->dgePayService->parseCallbackResult($callbackParams);
        $uniqueTxnId = (string) ($parsed['unique_txn_id'] ?? $request->input('unique_txn_id') ?? '');

        $donation = Donation::where('trx_id', $uniqueTxnId)->first();

        if (!$donation) {
            Log::warning('DGePay callback: donation not found for trx_id', ['trx_id' => $uniqueTxnId, 'params' => $callbackParams]);

            return redirect()->route('home')
                ->with('donation_result', 'failed')
                ->with('donation_message', 'অনুদানের তথ্য পাওয়া যায়নি। ট্রানজ্যাকশন আইডি: ' . $uniqueTxnId);
        }

        // Verify status server-to-server with DGePay API
        $statusCheck = $this->dgePayService->getTransactionStatus($uniqueTxnId);
        $checkData = ($statusCheck['success'] ?? false) ? ($statusCheck['data'] ?? []) : [];
        $statusCode = (string) ($checkData['status_code'] ?? $parsed['status_code'] ?? '');

        if (DgePayService::isSuccessStatus($statusCode) || ($parsed['is_success'] ?? false)) {
            $gatewayTrx = $checkData['txn_number'] ?? $parsed['txn_number'] ?? $checkData['third_party_txn_number'] ?? null;
            $paymentMethod = $checkData['payment_method'] ?? $parsed['payment_method'] ?? 'DgePay';

            $donation->update([
                'status'           => Donation::STATUS_SUCCESS,
                'gateway_trx_id'   => $gatewayTrx,
                'payment_method'   => $paymentMethod ?: 'DgePay',
                'paid_at'          => now(),
                'payment_response' => !empty($checkData) ? $checkData : $callbackParams,
            ]);

            return redirect()->route('home')
                ->with('donation_result', 'success')
                ->with('donation_data', [
                    'donor_name'     => $donation->donor_name,
                    'donor_phone'    => $donation->donor_phone,
                    'amount'         => $donation->amount,
                    'trx_id'         => $donation->trx_id,
                    'gateway_trx_id' => $donation->gateway_trx_id,
                    'payment_method' => $donation->payment_method,
                    'date'           => $donation->paid_at ? $donation->paid_at->format('d/m/Y h:i A') : now()->format('d/m/Y h:i A'),
                ]);
        }

        if (DgePayService::isCancelledStatus($statusCode) || ($parsed['is_cancelled'] ?? false)) {
            $donation->update([
                'status'           => Donation::STATUS_CANCELLED,
                'payment_response' => !empty($checkData) ? $checkData : $callbackParams,
                'notes'            => 'পেমেন্টটি ব্যবহারকারী কর্তৃক বাতিল করা হয়েছে।',
            ]);

            return redirect()->route('home')
                ->with('donation_result', 'failed')
                ->with('donation_message', 'পেমেন্ট বাতিল করা হয়েছে। আপনি চাইলে আবার চেষ্টা করতে পারেন।');
        }

        // Failed payment
        $donation->update([
            'status'           => Donation::STATUS_FAILED,
            'payment_response' => !empty($checkData) ? $checkData : $callbackParams,
            'notes'            => $parsed['message'] ?? 'পেমেন্ট ব্যর্থ হয়েছে।',
        ]);

        return redirect()->route('home')
            ->with('donation_result', 'failed')
            ->with('donation_message', 'পেমেন্ট সম্পন্ন হয়নি: ' . ($parsed['message'] ?? 'ব্যর্থ হয়েছে'));
    }
}

