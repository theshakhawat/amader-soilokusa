<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Donation;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class DonationController extends Controller
{
    /**
     * Build the filtered query based on request parameters.
     */
    protected function buildFilteredQuery(Request $request): Builder
    {
        $query = Donation::with('creator')->latest('id');

        // Search filter (Donor Name, Phone, Email, Trx ID, Gateway Trx ID)
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

        // Period filter (today, this_week, this_month, last_month, this_year, custom)
        $period = $request->input('period');
        if ($period === 'today') {
            $query->whereBetween('created_at', [now()->startOfDay(), now()->endOfDay()]);
        } elseif ($period === 'this_week') {
            $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
        } elseif ($period === 'this_month') {
            $query->whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()]);
        } elseif ($period === 'last_month') {
            $query->whereBetween('created_at', [now()->subMonth()->startOfMonth(), now()->subMonth()->endOfMonth()]);
        } elseif ($period === 'this_year') {
            $query->whereBetween('created_at', [now()->startOfYear(), now()->endOfYear()]);
        } elseif ($period === 'custom' || $request->filled('start_date') || $request->filled('end_date')) {
            if ($startDate = $request->input('start_date')) {
                $query->where('created_at', '>=', Carbon::parse($startDate)->startOfDay());
            }
            if ($endDate = $request->input('end_date')) {
                $query->where('created_at', '<=', Carbon::parse($endDate)->endOfDay());
            }
        }

        return $query;
    }

    /**
     * Display a listing of donations with search, filters and metrics.
     */
    public function index(Request $request): View
    {
        $filteredQuery = $this->buildFilteredQuery($request);
        $donations = (clone $filteredQuery)->paginate(20)->withQueryString();

        // Overall All-time Metrics
        $totalCollected = (float) Donation::where('status', Donation::STATUS_SUCCESS)->sum('amount');
        $totalSuccessCount = Donation::where('status', Donation::STATUS_SUCCESS)->count();
        $totalPendingCount = Donation::where('status', Donation::STATUS_PENDING)->count();
        $totalManualCount = Donation::where('is_manual', true)->count();

        // Monthly Tracking Metrics
        $thisMonthStart = now()->startOfMonth();
        $thisMonthEnd = now()->endOfMonth();
        $thisMonthCollected = (float) Donation::where('status', Donation::STATUS_SUCCESS)
            ->whereBetween('created_at', [$thisMonthStart, $thisMonthEnd])
            ->sum('amount');
        $thisMonthCount = Donation::where('status', Donation::STATUS_SUCCESS)
            ->whereBetween('created_at', [$thisMonthStart, $thisMonthEnd])
            ->count();

        // Weekly Tracking Metrics
        $thisWeekStart = now()->startOfWeek();
        $thisWeekEnd = now()->endOfWeek();
        $thisWeekCollected = (float) Donation::where('status', Donation::STATUS_SUCCESS)
            ->whereBetween('created_at', [$thisWeekStart, $thisWeekEnd])
            ->sum('amount');
        $thisWeekCount = Donation::where('status', Donation::STATUS_SUCCESS)
            ->whereBetween('created_at', [$thisWeekStart, $thisWeekEnd])
            ->count();

        // Today Tracking Metrics
        $todayStart = now()->startOfDay();
        $todayEnd = now()->endOfDay();
        $todayCollected = (float) Donation::where('status', Donation::STATUS_SUCCESS)
            ->whereBetween('created_at', [$todayStart, $todayEnd])
            ->sum('amount');
        $todayCount = Donation::where('status', Donation::STATUS_SUCCESS)
            ->whereBetween('created_at', [$todayStart, $todayEnd])
            ->count();

        // Check if any filter is actively applied
        $activePeriod = $request->input('period');
        $hasActiveFilter = (
            $request->filled('search') ||
            ($request->filled('status') && $request->input('status') !== 'all') ||
            ($request->filled('type') && $request->input('type') !== 'all') ||
            ($request->filled('period') && $request->input('period') !== 'all') ||
            $request->filled('start_date') ||
            $request->filled('end_date')
        );

        $filteredTotalAmount = $hasActiveFilter ? (float) (clone $filteredQuery)->where('status', Donation::STATUS_SUCCESS)->sum('amount') : null;
        $filteredTotalCount = $hasFilterTotalCount = $hasActiveFilter ? (clone $filteredQuery)->count() : null;

        return view('admin.donations.index', compact(
            'donations',
            'totalCollected',
            'totalSuccessCount',
            'totalPendingCount',
            'totalManualCount',
            'thisMonthCollected',
            'thisMonthCount',
            'thisWeekCollected',
            'thisWeekCount',
            'todayCollected',
            'todayCount',
            'hasActiveFilter',
            'activePeriod',
            'filteredTotalAmount',
            'filteredTotalCount'
        ));
    }

    /**
     * Export donations as CSV (with UTF-8 BOM for Bengali excel compatibility).
     */
    public function export(Request $request): StreamedResponse
    {
        $donations = $this->buildFilteredQuery($request)->get();

        $filename = 'donations_export_' . now()->format('Y-m-d_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        return response()->stream(function () use ($donations) {
            $handle = fopen('php://output', 'w');

            // UTF-8 BOM so Microsoft Excel and Google Sheets render Bengali characters correctly
            fprintf($handle, chr(0xEF) . chr(0xBB) . chr(0xBF));

            // Column Headers in Bengali
            fputcsv($handle, [
                'ক্রমিক',
                'ট্রানজ্যাকশন আইডি',
                'রসিদ / গেটওয়ে Trx ID',
                'দাতার নাম',
                'মোবাইল নম্বর',
                'ইমেইল',
                'অনুদানের পরিমাণ (টাকা)',
                'কারেন্সি',
                'অনুদানের মাধ্যম',
                'অনুদানের ধরন',
                'স্ট্যাটাস',
                'পরিশোধের সময়',
                'রেকর্ড তৈরির তারিখ ও সময়',
                'নোট / বিবরণ',
            ]);

            $sl = 1;
            foreach ($donations as $donation) {
                $statusBengali = match ($donation->status) {
                    'success'   => 'সফল (Success)',
                    'pending'   => 'পেন্ডিং (Pending)',
                    'cancelled' => 'বাতিল (Cancelled)',
                    'failed'    => 'ব্যর্থ (Failed)',
                    default     => $donation->status,
                };

                $typeBengali = $donation->is_manual ? 'অফলাইন / ম্যানুয়াল' : 'অনলাইন (DGePay)';

                fputcsv($handle, [
                    $sl++,
                    $donation->trx_id,
                    $donation->gateway_trx_id ?? '',
                    $donation->donor_name,
                    $donation->donor_phone,
                    $donation->donor_email ?? '',
                    number_format((float)$donation->amount, 2, '.', ''),
                    $donation->currency ?? 'BDT',
                    $donation->payment_method ?? ($donation->is_manual ? 'অফলাইন' : 'DGePay'),
                    $typeBengali,
                    $statusBengali,
                    $donation->paid_at ? Carbon::parse($donation->paid_at)->format('d/m/Y h:i A') : '',
                    $donation->created_at ? $donation->created_at->format('d/m/Y h:i A') : '',
                    $donation->notes ?? '',
                ]);
            }

            fclose($handle);
        }, 200, $headers);
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
