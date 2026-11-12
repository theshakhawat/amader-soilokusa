<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactSetting;
use App\Models\FooterSetting;
use App\Models\SocialLink;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FooterSettingController extends Controller
{
    /**
     * Show the footer customization page.
     */
    public function index(): View
    {
        $footer = FooterSetting::firstOrCreate([], [
            'brand_title' => 'আগামীর শৈলকুপা',
            'brand_subtitle' => 'শৈলকুপার উন্নয়নে আমরা এক পরিবার',
            'about_text' => 'শৈলকুপার সার্বিক উন্নয়ন, ঐতিহ্য সংরক্ষণ ও মানুষের কল্যাণে নিবেদিত একটি সামাজিক উদ্যোগ।',
            'show_social_links' => true,
            'quick_links_title' => 'দ্রুত লিংক',
            'quick_links' => [
                ['label' => 'হোম', 'url' => '#hero-section'],
                ['label' => 'আমাদের সম্পর্কে', 'url' => '/page/aboutus'],
                ['label' => 'নোটিশ', 'url' => '#notice-section'],
                ['label' => 'কার্যক্রম', 'url' => '#events-section'],
                ['label' => 'গ্যালারি', 'url' => '#gallery-section'],
            ],
            'important_links_title' => 'গুরুত্বপূর্ণ লিংক',
            'important_links' => [
                ['label' => 'কমিটি', 'url' => '#committee-section'],
                ['label' => 'উন্নয়ন প্রকল্পসমূহ', 'url' => '#projects-section'],
                ['label' => 'দর্শনীয় স্থান', 'url' => '#projects-section'],
                ['label' => 'ব্লগ', 'url' => '#blog-section'],
                ['label' => 'যোগাযোগ', 'url' => '#contact-section'],
            ],
            'contact_title' => 'যোগাযোগ',
            'copyright_text' => '© ২০২৬ আগামীর শৈলকুপা। সর্বস্বত্ব সংরক্ষিত।',
            'privacy_policy_text' => 'গোপনীয়তা নীতি',
            'privacy_policy_link' => '#',
            'terms_text' => 'ব্যবহারের শর্তাবলী',
            'terms_link' => '#',
        ]);

        $contact = ContactSetting::first();
        $socialLinks = SocialLink::where('is_active', true)->orderBy('order')->get();

        return view('admin.footer.index', compact('footer', 'contact', 'socialLinks'));
    }

    /**
     * Update the footer customization settings.
     */
    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'brand_title' => ['required', 'string', 'max:255'],
            'brand_subtitle' => ['nullable', 'string', 'max:255'],
            'about_text' => ['nullable', 'string', 'max:1000'],
            'quick_links_title' => ['required', 'string', 'max:255'],
            'important_links_title' => ['required', 'string', 'max:255'],
            'contact_title' => ['required', 'string', 'max:255'],
            'copyright_text' => ['required', 'string', 'max:500'],
            'privacy_policy_text' => ['nullable', 'string', 'max:100'],
            'privacy_policy_link' => ['nullable', 'string', 'max:255'],
            'terms_text' => ['nullable', 'string', 'max:100'],
            'terms_link' => ['nullable', 'string', 'max:255'],
        ]);

        // Process Quick Links
        $quickLinks = [];
        if ($request->has('quick_links_labels') && is_array($request->quick_links_labels)) {
            foreach ($request->quick_links_labels as $index => $label) {
                $label = trim($label);
                $url = trim($request->quick_links_urls[$index] ?? '#');
                if (!empty($label)) {
                    $quickLinks[] = ['label' => $label, 'url' => $url];
                }
            }
        }
        $validated['quick_links'] = $quickLinks;

        // Process Important Links
        $importantLinks = [];
        if ($request->has('important_links_labels') && is_array($request->important_links_labels)) {
            foreach ($request->important_links_labels as $index => $label) {
                $label = trim($label);
                $url = trim($request->important_links_urls[$index] ?? '#');
                if (!empty($label)) {
                    $importantLinks[] = ['label' => $label, 'url' => $url];
                }
            }
        }
        $validated['important_links'] = $importantLinks;

        $validated['show_social_links'] = $request->has('show_social_links');

        $footer = FooterSetting::firstOrCreate([]);
        $footer->update($validated);

        return redirect()->back()->with('success', 'ফুটার কন্টেন্ট ও কপিরাইট সফলভাবে আপডেট করা হয়েছে!');
    }
}

