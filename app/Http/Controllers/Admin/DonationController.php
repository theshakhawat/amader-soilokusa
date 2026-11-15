<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Donation;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DonationController extends Controller
{
    /**
     * Display a listing of donations with search, filters and metrics.
     */
    public function index(Request $request): View
    {
        $query = Donation::with('creator')->latest();

        // Search filter
        if ($search = trim((string)$request->input('search'))) {
            $query->where(function ($q) use ($search) {
                $q->where('donor_name', 'like', "%{$search}%")
                  ->orWhere('donor_phone', 'like', "%{$search}%")
                  ->orWhere('donor_email', 'like', "%{$search}%")
                  ->orWhere('trx_id', 'like', "%{$search}%")
                  ->orWhere('gateway_trx_id', 'like', "%{$search}%");
            });
        }

        // Status filter
        if ($status = $request->input('status')) {
            if ($status !== 'all') {
                $query->where('status', $status);
            }
        }

        // Type filter (online vs manual)
        if ($type = $request->input('type')) {
            if ($type === 'manual') {
                $query->where('is_manual', true);
            } elseif ($type === 'online') {
                $query->where('is_manual', false);
            }
        }

        $donations = $query->paginate(20)->withQueryString();

        // Metrics
        $totalCollected = Donation::where('status', Donation::STATUS_SUCCESS)->sum('amount');
        $totalSuccessCount = Donation::where('status', Donation::STATUS_SUCCESS)->count();
        $totalPendingCount = Donation::where('status', Donation::STATUS_PENDING)->count();
        $totalManualCount = Donation::where('is_manual', true)->count();

        return view('admin.donations.index', compact(
            'donations',
            'totalCollected',
            'totalSuccessCount',
            'totalPendingCount',
            'totalManualCount'
        ));
    }

    /**
     * Show form to manually add an offline/manual donation.
     */
    public function create(): View
    {
        return view('admin.donations.create');
    }

    /**
     * Store a manually created donation.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'donor_name'     => 'required|string|max:120',
            'donor_phone'    => 'required|string|max:30',
            'donor_email'    => 'nullable|email|max:120',
            'amount'         => 'required|numeric|min:1',
            'payment_method' => 'required|string|max:60',
            'receipt_no'     => 'nullable|string|max:100',
            'status'         => 'required|in:success,pending,failed',
            'paid_at'        => 'nullable|date',
            'notes'          => 'nullable|string|max:1000',
        ], [
            'donor_name.required'     => 'দাতার নাম আবশ্যক।',
            'donor_phone.required'    => 'মোবাইল নম্বর আবশ্যক।',
            'amount.required'         => 'অনুদানের পরিমাণ আবশ্যক।',
            'amount.numeric'          => 'পরিমাণ সঠিক সংখ্যা হতে হবে।',
            'payment_method.required' => 'অনুদানের মাধ্যম নির্বাচন করুন।',
            'status.required'         => 'অনুদানের স্ট্যাটাস নির্বাচন করুন।',
        ]);

        $trxId = 'MN' . strtoupper(substr(md5(uniqid((string)mt_rand(), true)), 0, 8));

        Donation::create([
            'trx_id'         => $trxId,
            'donor_name'     => $validated['donor_name'],
            'donor_phone'    => $validated['donor_phone'],
            'donor_email'    => $validated['donor_email'] ?? null,
            'amount'         => (float) $validated['amount'],
            'currency'       => 'BDT',
            'payment_method' => $validated['payment_method'],
            'gateway_trx_id' => $validated['receipt_no'] ?? null,
            'status'         => $validated['status'],
            'paid_at'        => !empty($validated['paid_at']) ? Carbon::parse($validated['paid_at']) : now(),
            'is_manual'      => true,
            'notes'          => $validated['notes'] ?? null,
            'created_by'     => auth()->id(),
        ]);

        return redirect()->route('admin.donations.index')
            ->with('success', 'নতুন অনুদানের তথ্য সফলভাবে এন্ট্রি করা হয়েছে।');
    }

    /**
     * Show donation details.
     */
    public function show(Donation $donation): View
    {
        return view('admin.donations.show', compact('donation'));
    }

    /**
     * Delete a donation record.
     */
    public function destroy(Donation $donation): RedirectResponse
    {
        $donation->delete();

        return redirect()->route('admin.donations.index')
            ->with('success', 'অনুদানের রেকর্ডটি সফলভাবে মুছে ফেলা হয়েছে।');
    }
}

