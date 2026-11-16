<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\User;
use App\Notifications\NewMemberRegisteredNotification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;
use Illuminate\View\View;

class MemberRegistrationController extends Controller
{
    /**
     * Show member registration application form.
     */
    public function create(): View
    {
        return view('pages.members.apply');
    }

    /**
     * Store new member application submitted by public user.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:150',
            'phone'       => [
                'required',
                'string',
                'regex:/^(?:\+8801|01)[3-9]\d{8}$/',
                'unique:members,phone',
            ],
            'email'       => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:150',
                'unique:members,email',
            ],
            'photo'       => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
            'blood_group' => 'nullable|string|in:A+,A-,B+,B-,AB+,AB-,O+,O-',
            'address'     => 'required|string|max:500',
        ], [
            'name.required'    => 'আপনার পূর্ণ নাম লিখুন।',
            'phone.required'   => 'মোবাইল নম্বর প্রদান করুন।',
            'phone.regex'      => 'সঠিক ১১ ডিজিটের বাংলাদেশী মোবাইল নম্বর (যেমন: 017XXXXXXXX) লিখুন।',
            'phone.unique'     => 'এই মোবাইল নম্বরটি দিয়ে ইতিমধ্যে একজন সদস্য নিবন্ধিত আছেন। অন্য নম্বর ব্যবহার করুন।',
            'email.required'   => 'বৈধ ইমেইল ঠিকানা প্রদান করুন।',
            'email.email'      => 'সঠিক ইমেইল ফরম্যাট প্রদান করুন।',
            'email.unique'     => 'এই ইমেইল ঠিকানাটি ইতিমধ্যে ব্যবহৃত হয়েছে। অন্য ইমেইল ব্যবহার করুন।',
            'photo.image'      => 'প্রোফাইল ছবি একটি বৈধ ইমেজ ফাইল (jpg, png, webp) হতে হবে।',
            'photo.max'        => 'ছবির সাইজ সর্বোচ্চ ৩ মেগাবাইট (3MB) হতে পারবে।',
            'address.required' => 'আপনার বর্তমান ঠিকানা লিখুন।',
        ]);

        // Upload photo if present
        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('members', 'public');
        }

        // Auto-generate unique slug in backend
        $baseSlug = Str::slug($validated['name']);
        if (empty($baseSlug)) {
            $baseSlug = 'member';
        }
        $slug = $baseSlug . '-' . Str::lower(Str::random(6));
        while (Member::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . Str::lower(Str::random(6));
        }

        // Create member record with status = false (pending approval)
        $member = Member::create([
            'name'        => $validated['name'],
            'slug'        => $slug,
            'photo'       => $photoPath,
            'phone'       => $validated['phone'],
            'email'       => $validated['email'],
            'blood_group' => $validated['blood_group'] ?? null,
            'address'     => $validated['address'],
            'status'      => false, // By default false until approved by admin
            'created_by'  => null,
        ]);

        // Send notification to admin panel
        try {
            $admins = User::all();
            if ($admins->isNotEmpty()) {
                Notification::send($admins, new NewMemberRegisteredNotification($member));
            }
        } catch (\Throwable $e) {
            Log::error('Member registration admin notification error: ' . $e->getMessage());
        }

        return redirect()->route('members.apply')
            ->with('success', 'ধন্যবাদ! সদস্য হিসেবে যোগদানের আপনার আবেদনটি সফলভাবে জমা হয়েছে। অ্যাডমিন কর্তৃক যাচাই-বাছাই শেষে অনুমোদিত হলে আপনার ইমেইলে কনফার্মেশন ও ডিজিটাল সদস্য আইডি কার্ড পাঠানো হবে।');
    }

    /**
     * Display public member profile & digital member ID card with QR code (UUID supported).
     */
    public function showCard(string $identifier): View
    {
        $member = Member::where('uuid', $identifier)->orWhere('slug', $identifier)->firstOrFail();

        if (!$member->status) {
            return view('pages.members.pending-card', compact('member'));
        }

        return view('pages.members.id-card', compact('member'));
    }
}
