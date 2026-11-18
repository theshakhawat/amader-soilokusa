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
     * Show public list of active/approved volunteers (স্বেচ্ছাসেবী কর্মীগণ).
     */
    public function index(Request $request): View
    {
        $query = Volunteer::approved()->latest('approved_at')->latest('id');

        if ($request->filled('search')) {
            $searchTerm = trim($request->search);
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'like', "%{$searchTerm}%")
                  ->orWhere('phone', 'like', "%{$searchTerm}%")
                  ->orWhere('email', 'like', "%{$searchTerm}%")
                  ->orWhere('occupation', 'like', "%{$searchTerm}%")
                  ->orWhere('blood_group', 'like', "%{$searchTerm}%")
                  ->orWhere('address', 'like', "%{$searchTerm}%")
                  ->orWhere('permanent_address', 'like', "%{$searchTerm}%")
                  ->orWhere('id_card_number', 'like', "%{$searchTerm}%");
            });
        }

        if ($request->filled('blood_group')) {
            $query->where('blood_group', $request->blood_group);
        }

        $volunteers = $query->paginate(12)->withQueryString();
        $totalActive = Volunteer::approved()->count();

        return view('pages.volunteers.index', compact('volunteers', 'totalActive'));
    }

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
            'name'        => [
                'required',
                'string',
                'max:150',
                function ($attribute, $value, $fail) {
                    $words = preg_split('/\s+/u', trim($value), -1, PREG_SPLIT_NO_EMPTY);
                    if (count($words) < 2) {
                        $fail('পূর্ণ নামে কমপক্ষে ২টি শব্দ (যেমন: প্রথম নাম ও শেষ নাম) থাকতে হবে।');
                    }
                },
            ],
            'phone'       => [
                'required',
                'string',
                'regex:/^01[3-9]\d{8}$/',
                'unique:volunteers,phone',
            ],
            'email'       => [
                'nullable',
                'string',
                'lowercase',
                'email',
                'max:150',
                'unique:volunteers,email',
            ],
            'photo'             => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
            'blood_group'       => 'required|string|in:A+,A-,B+,B-,AB+,AB-,O+,O-',
            'occupation'        => 'nullable|string|max:150',
            'address'           => 'required|string|max:500',
            'permanent_address' => 'nullable|string|max:500',
        ], [
            'name.required'        => 'আপনার পূর্ণ নাম লিখুন।',
            'phone.required'       => 'মোবাইল নম্বর লিখুন।',
            'phone.regex'          => 'সঠিক ১১ ডিজিটের মোবাইল নম্বর (যেমন: 017XXXXXXXX) লিখুন।',
            'phone.unique'         => 'এই মোবাইল নম্বরটি দিয়ে ইতিমধ্যে একটি আবেদন বা রেজিস্ট্রেশন করা হয়েছে। অন্য নম্বর ব্যবহার করুন।',
            'email.email'          => 'সঠিক ফরম্যাটের ইমেইল অ্যাড্রেস লিখুন।',
            'email.unique'         => 'এই ইমেইল অ্যাড্রেসটি দিয়ে ইতিমধ্যে একটি আবেদন বা রেজিস্ট্রেশন করা হয়েছে। অন্য ইমেইল ব্যবহার করুন।',
            'photo.image'          => 'প্রোফাইল ছবি একটি বৈধ ইমেজ ফাইল (jpg, png, webp) হতে হবে।',
            'photo.max'            => 'ছবির সাইজ ৩ মেগাবাইটের (3MB) বেশি হতে পারবে না।',
            'blood_group.required' => 'রক্তের গ্রুপ নির্বাচন করা আবশ্যক।',
            'blood_group.in'       => 'একটি বৈধ রক্তের গ্রুপ নির্বাচন করুন।',
            'address.required'     => 'আপনার বর্তমান ঠিকানা লিখুন।',
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
            'name'              => $validated['name'],
            'slug'              => $slug,
            'photo'             => $photoPath,
            'phone'             => $validated['phone'],
            'email'             => $validated['email'] ?? null,
            'blood_group'       => $validated['blood_group'] ?? null,
            'occupation'        => $validated['occupation'] ?? null,
            'address'           => $validated['address'],
            'permanent_address' => $validated['permanent_address'] ?? null,
            'status'            => false, // Always false by default until admin approves
            'created_by'        => null,
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
     * Display public volunteer profile details page with table view.
     */
    public function showCard(string $identifier): View
    {
        $volunteer = Volunteer::where('uuid', $identifier)->orWhere('slug', $identifier)->firstOrFail();

        if (!$volunteer->status) {
            return view('pages.volunteers.pending-card', compact('volunteer'));
        }

        return view('pages.volunteers.profile', compact('volunteer'));
    }

    /**
     * Dedicated clean full-screen Volunteer ID Card for printing / downloading (without navbar, sidebar, footer).
     */
    public function printCard(string $identifier): View
    {
        $volunteer = Volunteer::where('uuid', $identifier)->orWhere('slug', $identifier)->firstOrFail();

        if (!$volunteer->status) {
            return view('pages.volunteers.pending-card', compact('volunteer'));
        }

        return view('pages.volunteers.print-card', compact('volunteer'));
    }
}
