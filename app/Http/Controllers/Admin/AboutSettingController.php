<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AboutSection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class AboutSettingController extends Controller
{
    /**
     * Display the About Us customization form.
     */
    public function index(): View
    {
        $about = AboutSection::firstOrCreate([], [
            'title' => 'আমাদের সম্পর্কে',
            'subtitle' => 'ঐতিহ্য, উন্নয়ন ও মানবিক শৈলকুপা',
            'short_description' => 'আগামীর শৈলকুপা একটি অরাজনৈতিক সামাজিক উদ্যোগ, যা শৈলকুপার সার্বিক উন্নয়ন, শিক্ষা, স্বাস্থ্য, সামাজিক কল্যাণ ও ঐতিহ্য সংরক্ষণে কাজ করে যাচ্ছে।',
            'description' => '<p><strong>আগামীর শৈলকুপা</strong> একটি সম্পূর্ণ অরাজনৈতিক, জনকল্যাণমুখী ও স্বেচ্ছাসেবী সামাজিক সংগঠন। শৈলকুপা উপজেলার গৌরবময় ইতিহাস, সমৃদ্ধ ঐতিহ্য ও সংস্কৃতির বিকাশ এবং মানবতার সেবায় তরুণ প্রজন্ম ও সর্বস্তরের জনগণকে ঐক্যবদ্ধ করাই আমাদের মূল লক্ষ্য।</p>',
            'button_text' => 'বিস্তারিত পড়ুন',
        ]);

        return view('admin.about.index', compact('about'));
    }

    /**
     * Update the About Us section data.
     */
    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'subtitle' => ['nullable', 'string', 'max:255'],
            'short_description' => ['required', 'string'],
            'description' => ['nullable', 'string'],
            'button_text' => ['required', 'string', 'max:100'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:4096'],
        ], [
            'title.required' => 'শিরোনাম (Title) প্রদান করুন।',
            'short_description.required' => 'সংক্ষিপ্ত বিবরণ (Short Description) প্রদান করুন।',
            'button_text.required' => 'বাটনের টেক্সট দিন।',
            'image.image' => 'আপলোডকৃত ফাইলটি ছবি হতে হবে।',
            'image.max' => 'ছবির সাইজ সর্বোচ্চ ৪ মেগাবাইট (4MB) হতে পারবে।',
        ]);

        $about = AboutSection::firstOrCreate([]);

        if ($request->hasFile('image')) {
            if ($about->image && Storage::disk('public')->exists($about->image)) {
                Storage::disk('public')->delete($about->image);
            }
            $validated['image'] = $request->file('image')->store('about', 'public');
        } else {
            unset($validated['image']);
        }

        $about->update($validated);

        return redirect()->back()->with('success', 'আমাদের সম্পর্কে সেকশনের তথ্য সফলভাবে আপডেট করা হয়েছে!');
    }
}

