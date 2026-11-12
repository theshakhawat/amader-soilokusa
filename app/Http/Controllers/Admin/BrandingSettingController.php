<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class BrandingSettingController extends Controller
{
    /**
     * Display the logo, favicon & site title branding settings form.
     */
    public function index(): View
    {
        $setting = SiteSetting::firstOrCreate([], [
            'site_title'   => 'আগামীর শৈলকুপা',
            'site_tagline' => 'শৈলকুপার উন্নয়নে আমরা এক পরিবার',
            'header_logo'  => 'assets/images/logo-icon.png',
            'footer_logo'  => 'assets/images/logo-icon.png',
            'favicon'      => 'assets/images/logo-icon.png',
        ]);

        return view('admin.customization.branding', compact('setting'));
    }

    /**
     * Update branding settings.
     */
    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'site_title'   => ['required', 'string', 'max:255'],
            'site_tagline' => ['nullable', 'string', 'max:255'],
            'header_logo'  => ['nullable', 'image', 'mimes:jpeg,png,jpg,svg,webp', 'max:3072'],
            'footer_logo'  => ['nullable', 'image', 'mimes:jpeg,png,jpg,svg,webp', 'max:3072'],
            'favicon'      => ['nullable', 'image', 'mimes:jpeg,png,jpg,ico,svg,webp', 'max:2048'],
        ]);

        $setting = SiteSetting::firstOrCreate([]);

        $data = [
            'site_title'   => $validated['site_title'],
            'site_tagline' => $validated['site_tagline'] ?? null,
        ];

        // Handle Header Logo
        if ($request->hasFile('header_logo')) {
            if ($setting->header_logo && Storage::disk('public')->exists($setting->header_logo)) {
                Storage::disk('public')->delete($setting->header_logo);
            }
            $data['header_logo'] = $request->file('header_logo')->store('branding', 'public');
        }

        // Handle Footer Logo
        if ($request->hasFile('footer_logo')) {
            if ($setting->footer_logo && Storage::disk('public')->exists($setting->footer_logo)) {
                Storage::disk('public')->delete($setting->footer_logo);
            }
            $data['footer_logo'] = $request->file('footer_logo')->store('branding', 'public');
        }

        // Handle Favicon
        if ($request->hasFile('favicon')) {
            if ($setting->favicon && Storage::disk('public')->exists($setting->favicon)) {
                Storage::disk('public')->delete($setting->favicon);
            }
            $data['favicon'] = $request->file('favicon')->store('branding', 'public');
        }

        $setting->update($data);

        return redirect()->back()->with('success', 'লোগো ও ব্র্যান্ডিং তথ্য সফলভাবে হালনাগাদ করা হয়েছে!');
    }
}

