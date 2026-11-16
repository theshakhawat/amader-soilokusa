<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\SendVolunteerApprovedEmail;
use App\Models\Volunteer;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class VolunteerController extends Controller
{
    /**
     * Build filtered query for volunteers.
     */
    protected function buildFilteredQuery(Request $request): Builder
    {
        $query = Volunteer::with(['approver', 'creator'])->latest('id');

        // Search filter (Name, Phone, Email, Address)
        if ($search = trim((string)$request->input('search'))) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('address', 'like', "%{$search}%");
            });
        }

        // Status filter (all, pending, approved)
        if ($status = $request->input('status')) {
            if ($status === 'approved') {
                $query->where('status', true);
            } elseif ($status === 'pending') {
                $query->where('status', false);
            }
        }

        // Blood group filter
        if ($bloodGroup = $request->input('blood_group')) {
            if ($bloodGroup !== 'all') {
                $query->where('blood_group', $bloodGroup);
            }
        }

        return $query;
    }

    /**
     * Display a listing of volunteers with tabs, filters, and metrics.
     */
    public function index(Request $request): View
    {
        $filteredQuery = $this->buildFilteredQuery($request);
        $volunteers = (clone $filteredQuery)->paginate(15)->withQueryString();

        // High-level Metrics
        $totalVolunteers = Volunteer::count();
        $approvedVolunteers = Volunteer::where('status', true)->count();
        $pendingVolunteers = Volunteer::where('status', false)->count();
        $thisMonthVolunteers = Volunteer::whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()])->count();

        return view('admin.volunteers.index', compact(
            'volunteers',
            'totalVolunteers',
            'approvedVolunteers',
            'pendingVolunteers',
            'thisMonthVolunteers'
        ));
    }

    /**
     * Show form for admin to manually add a volunteer.
     */
    public function create(): View
    {
        return view('admin.volunteers.create');
    }

    /**
     * Store a manually created volunteer.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name'           => 'required|string|max:150',
            'id_card_number' => 'nullable|string|max:50',
            'phone'          => 'required|string|max:35|unique:volunteers,phone',
            'email'          => 'nullable|email|max:150|unique:volunteers,email',
            'photo'          => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
            'signature'      => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'blood_group'    => 'nullable|string|in:A+,A-,B+,B-,AB+,AB-,O+,O-',
            'address'        => 'required|string|max:500',
            'status'         => 'required|boolean',
            'notes'          => 'nullable|string|max:1000',
        ], [
            'name.required'    => 'স্বেচ্ছাসেবীর নাম আবশ্যক।',
            'phone.required'   => 'মোবাইল নম্বর আবশ্যক।',
            'phone.unique'     => 'এই মোবাইল নম্বর দিয়ে ইতিমধ্যে একজন স্বেচ্ছাসেবী নিবন্ধিত আছেন।',
            'email.email'      => 'সঠিক ইমেইল ঠিকানা প্রদান করুন।',
            'email.unique'     => 'এই ইমেইল ঠিকানা দিয়ে ইতিমধ্যে একজন স্বেচ্ছাসেবী নিবন্ধিত আছেন।',
            'address.required' => 'ঠিকানা আবশ্যক।',
        ]);

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('volunteers', 'public');
        }

        $signaturePath = null;
        if ($request->hasFile('signature')) {
            $signaturePath = $request->file('signature')->store('signatures', 'public');
        }

        $baseSlug = Str::slug($validated['name']);
        if (empty($baseSlug)) {
            $baseSlug = 'volunteer';
        }
        $slug = $baseSlug . '-' . Str::lower(Str::random(6));
        while (Volunteer::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . Str::lower(Str::random(6));
        }

        $isApproved = (bool) $validated['status'];

        $volunteer = Volunteer::create([
            'uuid'           => (string) Str::uuid(),
            'name'           => $validated['name'],
            'slug'           => $slug,
            'id_card_number' => !empty($validated['id_card_number']) ? trim($validated['id_card_number']) : null,
            'photo'          => $photoPath,
            'signature'      => $signaturePath,
            'phone'          => $validated['phone'],
            'email'          => $validated['email'] ?? null,
            'blood_group'    => $validated['blood_group'] ?? null,
            'address'        => $validated['address'],
            'status'         => $isApproved,
            'approved_at'    => $isApproved ? now() : null,
            'approved_by'    => $isApproved ? auth()->id() : null,
            'created_by'     => auth()->id(),
            'notes'          => $validated['notes'] ?? null,
        ]);

        // If admin created directly as approved and email is present, dispatch confirmation email job
        if ($isApproved && !empty($volunteer->email)) {
            SendVolunteerApprovedEmail::dispatch($volunteer);
        }

        return redirect()->route('admin.volunteers.index')
            ->with('success', 'নতুন স্বেচ্ছাসেবী কর্মী সফলভাবে যুক্ত করা হয়েছে।');
    }

    /**
     * Show volunteer profile details.
     */
    public function show(Volunteer $volunteer): View
    {
        $volunteer->load(['approver', 'creator']);
        return view('admin.volunteers.show', compact('volunteer'));
    }

    /**
     * Show form to edit volunteer information.
     */
    public function edit(Volunteer $volunteer): View
    {
        return view('admin.volunteers.edit', compact('volunteer'));
    }

    /**
     * Update volunteer information.
     */
    public function update(Request $request, Volunteer $volunteer): RedirectResponse
    {
        $validated = $request->validate([
            'name'           => 'required|string|max:150',
            'id_card_number' => 'nullable|string|max:50',
            'phone'          => ['required', 'string', 'max:35', \Illuminate\Validation\Rule::unique('volunteers', 'phone')->ignore($volunteer->id)],
            'email'          => ['nullable', 'email', 'max:150', \Illuminate\Validation\Rule::unique('volunteers', 'email')->ignore($volunteer->id)],
            'photo'          => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
            'signature'      => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'blood_group'    => 'nullable|string|in:A+,A-,B+,B-,AB+,AB-,O+,O-',
            'address'        => 'required|string|max:500',
            'status'         => 'required|boolean',
            'notes'          => 'nullable|string|max:1000',
        ], [
            'name.required'    => 'স্বেচ্ছাসেবীর নাম আবশ্যক।',
            'phone.required'   => 'মোবাইল নম্বর আবশ্যক।',
            'phone.unique'     => 'এই মোবাইল নম্বরটি ইতিমধ্যে অন্য একজন স্বেচ্ছাসেবী ব্যবহার করেছেন।',
            'email.email'      => 'সঠিক ইমেইল ঠিকানা প্রদান করুন।',
            'email.unique'     => 'এই ইমেইল ঠিকানাটি ইতিমধ্যে অন্য একজন স্বেচ্ছাসেবী ব্যবহার করেছেন।',
            'address.required' => 'ঠিকানা আবশ্যক।',
        ]);

        if ($request->hasFile('photo')) {
            if ($volunteer->photo && Storage::disk('public')->exists($volunteer->photo)) {
                Storage::disk('public')->delete($volunteer->photo);
            }
            $volunteer->photo = $request->file('photo')->store('volunteers', 'public');
        }

        if ($request->hasFile('signature')) {
            if ($volunteer->signature && Storage::disk('public')->exists($volunteer->signature)) {
                Storage::disk('public')->delete($volunteer->signature);
            }
            $volunteer->signature = $request->file('signature')->store('signatures', 'public');
        }

        $wasApproved = $volunteer->status;
        $isNowApproved = (bool) $validated['status'];

        $volunteer->name = $validated['name'];
        if ($request->has('id_card_number')) {
            $volunteer->id_card_number = !empty($validated['id_card_number']) ? trim($validated['id_card_number']) : null;
        }
        $volunteer->phone = $validated['phone'];
        $volunteer->email = $validated['email'] ?? null;
        $volunteer->blood_group = $validated['blood_group'] ?? null;
        $volunteer->address = $validated['address'];
        $volunteer->status = $isNowApproved;
        $volunteer->notes = $validated['notes'] ?? null;

        // If status changed from pending to approved
        if (!$wasApproved && $isNowApproved) {
            $volunteer->approved_at = now();
            $volunteer->approved_by = auth()->id();
        } elseif (!$isNowApproved) {
            $volunteer->approved_at = null;
            $volunteer->approved_by = null;
        }

        $volunteer->save();

        // Dispatch queued email if approved newly
        if (!$wasApproved && $isNowApproved && !empty($volunteer->email)) {
            SendVolunteerApprovedEmail::dispatch($volunteer);
        }

        return redirect()->route('admin.volunteers.index')
            ->with('success', 'স্বেচ্ছাসেবীর তথ্য সফলভাবে আপডেট করা হয়েছে।');
    }

    /**
     * Toggle status or approve a volunteer application.
     */
    public function toggleStatus(Volunteer $volunteer): RedirectResponse
    {
        $newStatus = !$volunteer->status;
        $volunteer->status = $newStatus;

        if ($newStatus) {
            $volunteer->approved_at = now();
            $volunteer->approved_by = auth()->id();
            $volunteer->save();

            // Dispatch queued approval email if volunteer has email
            if (!empty($volunteer->email)) {
                SendVolunteerApprovedEmail::dispatch($volunteer);
            }

            return back()->with('success', "'{$volunteer->name}'-এর আবেদনটি সফলভাবে অনুমোদিত হয়েছে এবং অভিনন্দন ইমেইল পাঠানো হয়েছে।");
        } else {
            $volunteer->status = false;
            $volunteer->save();

            return back()->with('success', "'{$volunteer->name}'-এর স্ট্যাটাস নিষ্ক্রিয় (Inactive) করা হয়েছে।");
        }
    }

    /**
     * Explicit approve action.
     */
    public function approve(Volunteer $volunteer): RedirectResponse
    {
        $volunteer->status = true;
        $volunteer->approved_at = now();
        $volunteer->approved_by = auth()->id();
        $volunteer->save();

        if (!empty($volunteer->email)) {
            SendVolunteerApprovedEmail::dispatch($volunteer);
        }

        return back()->with('success', "'{$volunteer->name}'-এর আবেদন সফলভাবে অনুমোদিত হয়েছে এবং অভিনন্দন ইমেইল পাঠানো হয়েছে।");
    }

    /**
     * Export volunteers list to CSV with UTF-8 BOM.
     */
    public function export(Request $request): StreamedResponse
    {
        $volunteers = $this->buildFilteredQuery($request)->get();
        $filename = 'volunteers_export_' . now()->format('Y-m-d_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        return response()->stream(function () use ($volunteers) {
            $handle = fopen('php://output', 'w');

            // UTF-8 BOM for Excel support
            fprintf($handle, chr(0xEF) . chr(0xBB) . chr(0xBF));

            fputcsv($handle, [
                'ক্রমিক',
                'স্বেচ্ছাসেবীর নাম',
                'মোবাইল নম্বর',
                'ইমেইল',
                'রক্তের গ্রুপ',
                'ঠিকানা',
                'স্ট্যাটাস',
                'আবেদনের তারিখ',
                'অনুমোদনের তারিখ',
                'অনুমোদনকারী অ্যাডমিন',
                'মন্তব্য',
            ]);

            $sl = 1;
            foreach ($volunteers as $v) {
                fputcsv($handle, [
                    $sl++,
                    $v->name,
                    $v->phone,
                    $v->email ?? '',
                    $v->blood_group ?? '',
                    $v->address ?? '',
                    $v->status ? 'Active' : 'Inactive',
                    $v->created_at ? $v->created_at->format('d/m/Y h:i A') : '',
                    $v->approved_at ? Carbon::parse($v->approved_at)->format('d/m/Y h:i A') : '',
                    $v->approver->name ?? '',
                    $v->notes ?? '',
                ]);
            }

            fclose($handle);
        }, 200, $headers);
    }

    /**
     * Delete a volunteer record.
     */
    public function destroy(Volunteer $volunteer): RedirectResponse
    {
        if ($volunteer->photo && Storage::disk('public')->exists($volunteer->photo)) {
            Storage::disk('public')->delete($volunteer->photo);
        }

        $volunteer->delete();

        return redirect()->route('admin.volunteers.index')
            ->with('success', 'স্বেচ্ছাসেবীর রেকর্ডটি সফলভাবে মুছে ফেলা হয়েছে।');
    }
}
