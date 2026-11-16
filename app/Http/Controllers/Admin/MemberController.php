<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\SendMemberApprovedEmail;
use App\Models\Member;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class MemberController extends Controller
{
    /**
     * Build filtered query for members.
     */
    protected function buildFilteredQuery(Request $request): Builder
    {
        $query = Member::with(['approver', 'creator'])->latest('id');

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
     * Display a listing of members with tabs, filters, and metrics.
     */
    public function index(Request $request): View
    {
        $filteredQuery = $this->buildFilteredQuery($request);
        $members = (clone $filteredQuery)->paginate(15)->withQueryString();

        // High-level Metrics
        $totalMembers = Member::count();
        $approvedMembers = Member::where('status', true)->count();
        $pendingMembers = Member::where('status', false)->count();
        $thisMonthMembers = Member::whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()])->count();

        return view('admin.members.index', compact(
            'members',
            'totalMembers',
            'approvedMembers',
            'pendingMembers',
            'thisMonthMembers'
        ));
    }

    /**
     * Show form for admin to manually add a member.
     */
    public function create(): View
    {
        return view('admin.members.create');
    }

    /**
     * Store a manually created member.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name'           => 'required|string|max:150',
            'id_card_number' => 'nullable|string|max:50',
            'phone'          => [
                'required',
                'string',
                'regex:/^(?:\+8801|01)[3-9]\d{8}$/',
                'unique:members,phone',
            ],
            'email'          => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:150',
                'unique:members,email',
            ],
            'photo'          => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
            'signature'      => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'blood_group'    => 'nullable|string|in:A+,A-,B+,B-,AB+,AB-,O+,O-',
            'address'        => 'required|string|max:500',
            'status'         => 'required|boolean',
            'notes'          => 'nullable|string|max:1000',
        ], [
            'name.required'    => 'সদস্যের নাম আবশ্যক।',
            'phone.required'   => 'মোবাইল নম্বর আবশ্যক।',
            'phone.regex'      => 'সঠিক ১১ ডিজিটের বাংলাদেশী মোবাইল নম্বর প্রদান করুন।',
            'phone.unique'     => 'এই মোবাইল নম্বর দিয়ে ইতিমধ্যে একজন সদস্য নিবন্ধিত আছেন।',
            'email.required'   => 'ইমেইল ঠিকানা আবশ্যক।',
            'email.email'      => 'সঠিক ইমেইল ফরম্যাট প্রদান করুন।',
            'email.unique'     => 'এই ইমেইল ঠিকানা দিয়ে ইতিমধ্যে একজন সদস্য নিবন্ধিত আছেন।',
            'address.required' => 'ঠিকানা আবশ্যক।',
        ]);

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('members', 'public');
        }

        $signaturePath = null;
        if ($request->hasFile('signature')) {
            $signaturePath = $request->file('signature')->store('signatures', 'public');
        }

        $baseSlug = Str::slug($validated['name']);
        if (empty($baseSlug)) {
            $baseSlug = 'member';
        }
        $slug = $baseSlug . '-' . Str::lower(Str::random(6));
        while (Member::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . Str::lower(Str::random(6));
        }

        $isApproved = (bool) $validated['status'];

        $member = Member::create([
            'uuid'           => (string) Str::uuid(),
            'name'           => $validated['name'],
            'slug'           => $slug,
            'id_card_number' => !empty($validated['id_card_number']) ? trim($validated['id_card_number']) : null,
            'photo'          => $photoPath,
            'signature'      => $signaturePath,
            'phone'          => $validated['phone'],
            'email'          => $validated['email'],
            'blood_group'    => $validated['blood_group'] ?? null,
            'address'        => $validated['address'],
            'status'         => $isApproved,
            'approved_at'    => $isApproved ? now() : null,
            'approved_by'    => $isApproved ? auth()->id() : null,
            'created_by'     => auth()->id(),
            'notes'          => $validated['notes'] ?? null,
        ]);

        // Dispatch queued email if created as approved
        if ($isApproved && !empty($member->email)) {
            SendMemberApprovedEmail::dispatch($member);
        }

        return redirect()->route('admin.members.index')
            ->with('success', 'নতুন সদস্য সফলভাবে যুক্ত করা হয়েছে।');
    }

    /**
     * Show member profile details.
     */
    public function show(Member $member): View
    {
        $member->load(['approver', 'creator']);
        return view('admin.members.show', compact('member'));
    }

    /**
     * Show form to edit member information.
     */
    public function edit(Member $member): View
    {
        return view('admin.members.edit', compact('member'));
    }

    /**
     * Update member information.
     */
    public function update(Request $request, Member $member): RedirectResponse
    {
        $validated = $request->validate([
            'name'           => 'required|string|max:150',
            'id_card_number' => 'nullable|string|max:50',
            'phone'          => [
                'required',
                'string',
                'regex:/^(?:\+8801|01)[3-9]\d{8}$/',
                Rule::unique('members', 'phone')->ignore($member->id),
            ],
            'email'          => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:150',
                Rule::unique('members', 'email')->ignore($member->id),
            ],
            'photo'          => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
            'signature'      => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'blood_group'    => 'nullable|string|in:A+,A-,B+,B-,AB+,AB-,O+,O-',
            'address'        => 'required|string|max:500',
            'status'         => 'required|boolean',
            'notes'          => 'nullable|string|max:1000',
        ], [
            'name.required'    => 'সদস্যের নাম আবশ্যক।',
            'phone.required'   => 'মোবাইল নম্বর আবশ্যক।',
            'phone.regex'      => 'সঠিক ১১ ডিজিটের বাংলাদেশী মোবাইল নম্বর প্রদান করুন।',
            'phone.unique'     => 'এই মোবাইল নম্বরটি ইতিমধ্যে অন্য একজন সদস্য ব্যবহার করেছেন।',
            'email.required'   => 'ইমেইল ঠিকানা আবশ্যক।',
            'email.email'      => 'সঠিক ইমেইল ফরম্যাট প্রদান করুন।',
            'email.unique'     => 'এই ইমেইল ঠিকানাটি ইতিমধ্যে অন্য একজন সদস্য ব্যবহার করেছেন।',
            'address.required' => 'ঠিকানা আবশ্যক।',
        ]);

        if ($request->hasFile('photo')) {
            if ($member->photo && Storage::disk('public')->exists($member->photo)) {
                Storage::disk('public')->delete($member->photo);
            }
            $member->photo = $request->file('photo')->store('members', 'public');
        }

        if ($request->hasFile('signature')) {
            if ($member->signature && Storage::disk('public')->exists($member->signature)) {
                Storage::disk('public')->delete($member->signature);
            }
            $member->signature = $request->file('signature')->store('signatures', 'public');
        }

        $wasApproved = $member->status;
        $isNowApproved = (bool) $validated['status'];

        $member->name = $validated['name'];
        if ($request->has('id_card_number')) {
            $member->id_card_number = !empty($validated['id_card_number']) ? trim($validated['id_card_number']) : null;
        }
        $member->phone = $validated['phone'];
        $member->email = $validated['email'];
        $member->blood_group = $validated['blood_group'] ?? null;
        $member->address = $validated['address'];
        $member->status = $isNowApproved;
        $member->notes = $validated['notes'] ?? null;

        if (!$wasApproved && $isNowApproved) {
            $member->approved_at = now();
            $member->approved_by = auth()->id();
        } elseif (!$isNowApproved) {
            $member->approved_at = null;
            $member->approved_by = null;
        }

        $member->save();

        if (!$wasApproved && $isNowApproved && !empty($member->email)) {
            SendMemberApprovedEmail::dispatch($member);
        }

        return redirect()->route('admin.members.index')
            ->with('success', 'সদস্যের তথ্য সফলভাবে আপডেট করা হয়েছে।');
    }

    /**
     * Toggle status or approve a member application.
     */
    public function toggleStatus(Member $member): RedirectResponse
    {
        $newStatus = !$member->status;
        $member->status = $newStatus;

        if ($newStatus) {
            $member->approved_at = now();
            $member->approved_by = auth()->id();
            $member->save();

            if (!empty($member->email)) {
                SendMemberApprovedEmail::dispatch($member);
            }

            return back()->with('success', "'{$member->name}'-এর সদস্যপদ সফলভাবে অনুমোদিত হয়েছে এবং কনফার্মেশন ইমেইল পাঠানো হয়েছে।");
        } else {
            $member->status = false;
            $member->save();

            return back()->with('success', "'{$member->name}'-এর সদস্যপদ নিষ্ক্রিয় (Inactive) করা হয়েছে।");
        }
    }

    /**
     * Explicit approve action.
     */
    public function approve(Member $member): RedirectResponse
    {
        $member->status = true;
        $member->approved_at = now();
        $member->approved_by = auth()->id();
        $member->save();

        if (!empty($member->email)) {
            SendMemberApprovedEmail::dispatch($member);
        }

        return back()->with('success', "'{$member->name}'-এর সদস্যপদ সফলভাবে অনুমোদিত হয়েছে এবং কনফার্মেশন ইমেইল পাঠানো হয়েছে।");
    }

    /**
     * Export members list to CSV with UTF-8 BOM.
     */
    public function export(Request $request): StreamedResponse
    {
        $members = $this->buildFilteredQuery($request)->get();
        $filename = 'members_export_' . now()->format('Y-m-d_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        return response()->stream(function () use ($members) {
            $handle = fopen('php://output', 'w');

            // UTF-8 BOM for Excel support
            fprintf($handle, chr(0xEF) . chr(0xBB) . chr(0xBF));

            fputcsv($handle, [
                'ক্রমিক',
                'সদস্য আইডি',
                'সদস্যের নাম',
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
            foreach ($members as $m) {
                fputcsv($handle, [
                    $sl++,
                    $m->card_id_number,
                    $m->name,
                    $m->phone,
                    $m->email,
                    $m->blood_group ?? '',
                    $m->address ?? '',
                    $m->status ? 'Active' : 'Inactive',
                    $m->created_at ? $m->created_at->format('d/m/Y h:i A') : '',
                    $m->approved_at ? Carbon::parse($m->approved_at)->format('d/m/Y h:i A') : '',
                    $m->approver->name ?? '',
                    $m->notes ?? '',
                ]);
            }

            fclose($handle);
        }, 200, $headers);
    }

    /**
     * Delete a member record.
     */
    public function destroy(Member $member): RedirectResponse
    {
        if ($member->photo && Storage::disk('public')->exists($member->photo)) {
            Storage::disk('public')->delete($member->photo);
        }

        $member->delete();

        return redirect()->route('admin.members.index')
            ->with('success', 'সদস্যের রেকর্ডটি সফলভাবে মুছে ফেলা হয়েছে।');
    }
}
