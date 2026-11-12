<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ContactSettingController extends Controller
{
    /**
     * Display the contact customization settings form.
     */
    public function index(): View
    {
        $contact = ContactSetting::getSettings();
        return view('admin.contact.index', compact('contact'));
    }

    /**
     * Update the contact customization settings.
     */
    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'location' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:50'],
            'email' => ['required', 'email', 'max:255'],
            'alt_phone' => ['nullable', 'string', 'max:50'],
            'address' => ['nullable', 'string', 'max:500'],
        ], [
            'location.required' => 'লোকেশন বা এলাকার নাম প্রদান করুন (যেমন: শৈলকুপা)।',
            'phone.required' => 'প্রধান যোগাযোগের ফোন নম্বর প্রদান করুন।',
            'email.required' => 'অফিসিয়াল ইমেইল ঠিকানা প্রদান করুন।',
            'email.email' => 'সঠিক ইমেইল ফরম্যাট প্রদান করুন।',
        ]);

        $contact = ContactSetting::getSettings();
        $contact->update($validated);

        return back()->with('success', 'যোগাযোগ সংক্রান্ত তথ্য সফলভাবে আপডেট করা হয়েছে!');
    }
}
