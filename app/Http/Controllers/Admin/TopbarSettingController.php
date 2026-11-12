<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactSetting;
use App\Models\SocialLink;
use App\Models\TopbarSetting;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TopbarSettingController extends Controller
{
    /**
     * Show the topbar header customization page.
     */
    public function index(): View
    {
        $topbar = TopbarSetting::firstOrCreate([], [
            'is_active' => true,
            'show_contact' => true,
            'show_social' => true,
        ]);

        $contact = ContactSetting::firstOrCreate([], [
            'location' => 'শৈলকুপা, ঝিনাইদহ',
            'phone' => '+880 1700-123456',
            'email' => 'info@agamirshailkupa.org',
        ]);

        $socialLinks = SocialLink::where('is_active', true)->orderBy('order')->get();

        return view('admin.topbar.index', compact('topbar', 'contact', 'socialLinks'));
    }

    /**
     * Update the topbar settings via form.
     */
    public function update(Request $request): RedirectResponse
    {
        $topbar = TopbarSetting::firstOrCreate([]);

        $topbar->update([
            'is_active' => $request->has('is_active'),
            'show_contact' => $request->has('show_contact'),
            'show_social' => $request->has('show_social'),
        ]);

        return redirect()->back()->with('success', 'টপবার হেডার সেটিংস সফলভাবে আপডেট করা হয়েছে!');
    }

    /**
     * Toggle status via AJAX Switch.
     */
    public function toggleStatus(Request $request): JsonResponse
    {
        $topbar = TopbarSetting::firstOrCreate([]);
        $topbar->is_active = $request->boolean('status');
        $topbar->save();

        return response()->json([
            'status' => 'success',
            'message' => 'টপবার হেডার ' . ($topbar->is_active ? 'সক্রিয় (ON)' : 'লুকায়িত (OFF)') . ' করা হয়েছে।',
            'is_active' => $topbar->is_active,
        ]);
    }
}

