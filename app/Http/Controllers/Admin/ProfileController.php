<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the admin profile edit form.
     */
    public function index(): View
    {
        $user = Auth::user();
        return view('admin.profile.index', compact('user'));
    }

    /**
     * Update the admin profile information (Name, Email, Phone, Photo).
     */
    public function update(Request $request): RedirectResponse
    {
        /** @var User $user */
        $user = Auth::user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'phone' => ['required', 'string', 'regex:/^(?:\+8801|01)[3-9]\d{8}$/', Rule::unique('users')->ignore($user->id)],
            'photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
        ], [
            'name.required' => 'আপনার পূর্ণ নাম প্রদান করুন।',
            'email.required' => 'ইমেইল ঠিকানা প্রদান করুন।',
            'email.unique' => 'এই ইমেইলটি ইতিমধ্যে ব্যবহৃত হচ্ছে।',
            'phone.required' => 'মোবাইল নম্বর প্রদান করুন।',
            'phone.regex' => 'সঠিক বাংলাদেশি মোবাইল নম্বর প্রদান করুন (যেমন: 017XXXXXXXX)।',
            'phone.unique' => 'এই মোবাইল নম্বরটি ইতিমধ্যে ব্যবহৃত হচ্ছে।',
            'photo.image' => 'ফাইলটি অবশ্যই একটি ছবি হতে হবে।',
            'photo.mimes' => 'ছবিটি অবশ্যই jpeg, png, jpg বা webp ফরম্যাটে হতে হবে।',
            'photo.max' => 'ছবির সাইজ সর্বোচ্চ ২ মেগাবাইট (2MB) হতে পারবে।',
        ]);

        if ($request->hasFile('photo')) {
            // Delete old photo from public disk if exists
            if ($user->photo && Storage::disk('public')->exists($user->photo)) {
                Storage::disk('public')->delete($user->photo);
            }
            $validated['photo'] = $request->file('photo')->store('users', 'public');
        } else {
            // Keep existing photo if no new file uploaded
            unset($validated['photo']);
        }

        $user->fill($validated);
        $user->save();

        return back()->with('success', 'আপনার প্রোফাইল তথ্য সফলভাবে আপডেট করা হয়েছে!');
    }

    /**
     * Display the change password view.
     */
    public function showChangePassword(): View
    {
        return view('admin.profile.change-password');
    }

    /**
     * Update the admin's password.
     */
    public function updatePassword(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', Password::defaults()->min(6), 'confirmed'],
        ], [
            'current_password.required' => 'বর্তমান পাসওয়ার্ড প্রদান করুন।',
            'current_password.current_password' => 'বর্তমান পাসওয়ার্ডটি সঠিক নয়।',
            'password.required' => 'নতুন পাসওয়ার্ড প্রদান করুন।',
            'password.min' => 'নতুন পাসওয়ার্ড কমপক্ষে ৬ অক্ষরের হতে হবে।',
            'password.confirmed' => 'নতুন পাসওয়ার্ড ও নিশ্চিতকরণ পাসওয়ার্ড মিলছে না।',
        ]);

        /** @var User $user */
        $user = Auth::user();
        $user->password = Hash::make($validated['password']);
        $user->save();

        return back()->with('success', 'আপনার পাসওয়ার্ড সফলভাবে পরিবর্তন করা হয়েছে!');
    }
}
