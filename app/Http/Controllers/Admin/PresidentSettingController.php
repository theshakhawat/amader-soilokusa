<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PresidentMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class PresidentSettingController extends Controller
{
    /**
     * Show the President message customization form.
     */
    public function index(): View
    {
        $president = PresidentMessage::firstOrCreate([], [
            'title' => 'সভাপতির বাণী',
            'name' => 'মোঃ আব্দুল করিম',
            'designation' => 'সভাপতি, আগামীর শৈলকুপা',
            'quote' => 'শৈলকুপাকে একটি আধুনিক, শিক্ষিত, সমৃদ্ধ ও মানবিক জনপদে রূপ দিতে আমরা সবাই একসাথে কাজ করছি।',
            'message' => '<p>একটি সুন্দর, আলোকিত ও টেকসই আগামী গড়ার দৃঢ় প্রত্যয় নিয়ে আমরা <strong>আগামীর শৈলকুপা</strong> সামাজিক প্ল্যাটফর্মটির সূচনা করেছি।</p>',
        ]);

        return view('admin.president.index', compact('president'));
    }

    /**
     * Update the President message data.
     */
    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
            'designation' => ['required', 'string', 'max:255'],
            'quote' => ['required', 'string', 'max:1000'],
            'message' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:4096'],
        ], [
            'title.required' => 'শিরোনাম (যেমন: সভাপতির বাণী) প্রদান করুন।',
            'name.required' => 'সভাপতির পূর্ণ নাম প্রদান করুন।',
            'designation.required' => 'পদবী বা পরিচয় প্রদান করুন।',
            'quote.required' => 'বাণী বা বক্তব্য প্রদান করুন।',
            'image.image' => 'আপলোডকৃত ফাইলটি ছবি হতে হবে।',
            'image.max' => 'ছবির সাইজ সর্বোচ্চ ৪ মেগাবাইট হতে পারবে।',
        ]);

        $president = PresidentMessage::firstOrCreate([]);

        if ($request->hasFile('image')) {
            if ($president->image && Storage::disk('public')->exists($president->image)) {
                Storage::disk('public')->delete($president->image);
            }
            $validated['image'] = $request->file('image')->store('president', 'public');
        } else {
            unset($validated['image']);
        }

        $president->update($validated);

        return redirect()->back()->with('success', 'সভাপতির বাণীর তথ্য সফলভাবে আপডেট করা হয়েছে!');
    }
}

