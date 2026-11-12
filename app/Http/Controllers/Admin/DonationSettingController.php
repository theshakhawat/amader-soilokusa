<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DonationSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class DonationSettingController extends Controller
{
    /**
     * Display the Donation banner customization form.
     */
    public function index(): View
    {
        $donation = DonationSetting::firstOrCreate([], [
            'title'             => "শৈলকুপার উন্নয়নে\nআপনিও অংশ নিন",
            'description'       => 'শিক্ষা, স্বাস্থ্য, সামাজিক উন্নয়ন ও মানবকল্যাণমূলক কার্যক্রমে আপনার অনুদান আমাদের প্রেরণা।',
            'button_text'       => 'অনুদান দিন এখনই',
            'button_link'       => null,
            'image'             => 'assets/images/donate-sapling.jpg',
            'icon'              => 'fa-solid fa-hand-holding-heart',
            'bg_color_start'    => '#d92638',
            'bg_color_end'      => '#7d0615',
            'text_color'        => '#ffffff',
            'button_bg_color'   => '#ffffff',
            'button_text_color' => '#111827',
            'status'            => true,
        ]);

        return view('admin.customization.donation', compact('donation'));
    }

    /**
     * Update the Donation banner customization data.
     */
    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title'             => ['required', 'string', 'max:255'],
            'description'       => ['nullable', 'string'],
            'button_text'       => ['required', 'string', 'max:100'],
            'button_link'       => ['nullable', 'string', 'max:255'],
            'icon'              => ['nullable', 'string', 'max:100'],
            'bg_color_start'    => ['nullable', 'string', 'max:50'],
            'bg_color_end'      => ['nullable', 'string', 'max:50'],
            'text_color'        => ['nullable', 'string', 'max:50'],
            'button_bg_color'   => ['nullable', 'string', 'max:50'],
            'button_text_color' => ['nullable', 'string', 'max:50'],
            'image'             => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:4096'],
            'status'            => ['nullable', 'boolean'],
        ]);

        $donation = DonationSetting::firstOrCreate([]);

        $data = [
            'title'             => $validated['title'],
            'description'       => $validated['description'] ?? null,
            'button_text'       => $validated['button_text'],
            'button_link'       => $validated['button_link'] ?? null,
            'icon'              => $validated['icon'] ?? 'fa-solid fa-hand-holding-heart',
            'bg_color_start'    => $validated['bg_color_start'] ?? '#d92638',
            'bg_color_end'      => $validated['bg_color_end'] ?? '#7d0615',
            'text_color'        => $validated['text_color'] ?? '#ffffff',
            'button_bg_color'   => $validated['button_bg_color'] ?? '#ffffff',
            'button_text_color' => $validated['button_text_color'] ?? '#111827',
            'status'            => $request->has('status'),
        ];

        if ($request->hasFile('image')) {
            if ($donation->image && Storage::disk('public')->exists($donation->image)) {
                Storage::disk('public')->delete($donation->image);
            }
            $data['image'] = $request->file('image')->store('customization/donation', 'public');
        }

        $donation->update($data);

        return redirect()->back()->with('success', 'অনুদান ব্যানার সেকশন সফলভাবে হালনাগাদ করা হয়েছে!');
    }
}
