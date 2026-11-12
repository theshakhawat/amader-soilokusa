<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use App\Models\ContactSetting;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ContactController extends Controller
{
    /**
     * Show the public contact page.
     */
    public function index(): View
    {
        $contact = ContactSetting::getSettings();
        return view('pages.contact', compact('contact'));
    }

    /**
     * Store incoming contact message via AJAX.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:50',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string|max:5000',
        ], [
            'name.required' => 'আপনার নাম প্রদান করুন।',
            'email.required' => 'আপনার ইমেইল ঠিকানা প্রদান করুন।',
            'email.email' => 'সঠিক ইমেইল ফরম্যাট দিন।',
            'message.required' => 'আপনার বার্তা বা মেসেজটি লিখুন।',
        ]);

        $validated['ip_address'] = $request->ip();

        $message = ContactMessage::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'ধন্যবাদ! আপনার বার্তাটি সফলভাবে পাঠানো হয়েছে। আমরা দ্রুত আপনার সাথে যোগাযোগ করব।',
            'data' => [
                'id' => $message->id,
            ],
        ]);
    }
}

