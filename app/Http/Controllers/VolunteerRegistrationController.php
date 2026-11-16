<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Volunteer;
use App\Notifications\NewVolunteerRegisteredNotification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;
use Illuminate\View\View;

class VolunteerRegistrationController extends Controller
{
    /**
     * Show volunteer registration application form.
     */
    public function create(): View
    {
        return view('pages.volunteers.apply');
    }

    /**
     * Store new volunteer application submitted by public user.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:150',
            'phone'       => 'required|string|max:35|unique:volunteers,phone',
            'email'       => 'nullable|email|max:150|unique:volunteers,email',
            'photo'       => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
            'blood_group' => 'nullable|string|in:A+,A-,B+,B-,AB+,AB-,O+,O-',
            'address'     => 'required|string|max:500',
        ], [
            'name.required'    => 'আপনার পূর্ণ নাম লিখুন।',
            'phone.required'   => 'মোবাইল নম্বর লিখুন।',
            'phone.unique'     => 'এই মোবাইল নম্বরটি দিয়ে ইতিমধ্যে একটি আবেদন বা রেজিস্ট্রেশন করা হয়েছে। অন্য নম্বর ব্যবহার করুন।',
            'email.email'      => 'সঠিক ইমেইল অ্যাড্রেস লিখুন।',
            'email.unique'     => 'এই ইমেইল অ্যাড্রেসটি দিয়ে ইতিমধ্যে একটি আবেদন বা রেজিস্ট্রেশন করা হয়েছে। অন্য ইমেইল ব্যবহার করুন।',
            'photo.image'      => 'প্রোফাইল ছবি একটি বৈধ ইমেজ ফাইল (jpg, png, webp) হতে হবে।',
            'photo.max'        => 'ছবির সাইজ ৩ মেগাবাইটের (3MB) বেশি হতে পারবে না।',
            'address.required' => 'আপনার বর্তমান ঠিকানা লিখুন।',
        ]);

        // Upload photo if present
        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('volunteers', 'public');
        }

        // Generate unique slug in backend
        $baseSlug = Str::slug($validated['name']);
        if (empty($baseSlug)) {
            $baseSlug = 'volunteer';
        }
        $slug = $baseSlug . '-' . Str::lower(Str::random(6));
        while (Volunteer::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . Str::lower(Str::random(6));
        }

        // Create volunteer record with status = false (pending approval)
        $volunteer = Volunteer::create([
            'name'        => $validated['name'],
            'slug'        => $slug,
            'photo'       => $photoPath,
            'phone'       => $validated['phone'],
            'email'       => $validated['email'] ?? null,
            'blood_group' => $validated['blood_group'] ?? null,
            'address'     => $validated['address'],
            'status'      => false, // Always false by default until admin approves
            'created_by'  => null,
        ]);

        // Send notification to admin panel
        try {
            $admins = User::all();
            if ($admins->isNotEmpty()) {
                Notification::send($admins, new NewVolunteerRegisteredNotification($volunteer));
            }
        } catch (\Throwable $e) {
            Log::error('Volunteer registration admin notification error: ' . $e->getMessage());
        }

        return redirect()->route('volunteers.apply')
            ->with('success', 'ধন্যবাদ! আপনার স্বেচ্ছাসেবী হিসেবে যোগদানের আবেদনটি সফলভাবে জমা হয়েছে। অ্যাডমিন কর্তৃক যাচাই-বাছাই শেষে অনুমোদিত হলে আপনার সাথে যোগাযোগ করা হবে।');
    }

    /**
     * Display public volunteer profile & digital ID card with QR code (UUID supported).
     */
    public function showCard(string $identifier): View
    {
        $volunteer = Volunteer::where('uuid', $identifier)->orWhere('slug', $identifier)->firstOrFail();

        if (!$volunteer->status) {
            return view('pages.volunteers.pending-card', compact('volunteer'));
        }

        return view('pages.volunteers.id-card', compact('volunteer'));
    }
}
