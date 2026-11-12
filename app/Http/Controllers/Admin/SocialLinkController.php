<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SocialLink;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SocialLinkController extends Controller
{
    /**
     * Display a listing of social media links.
     */
    public function index(): View
    {
        $socialLinks = SocialLink::orderBy('order')->orderBy('id')->get();
        return view('admin.social-media.index', compact('socialLinks'));
    }

    /**
     * Show the form for creating a new social link.
     */
    public function create(): View
    {
        return view('admin.social-media.create');
    }

    /**
     * Store a newly created social link.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'platform' => ['required', 'string', 'max:100'],
            'icon' => ['required', 'string', 'max:100'],
            'url' => ['required', 'url', 'max:500'],
            'target' => ['required', 'in:_blank,_self'],
            'order' => ['nullable', 'integer', 'min:0'],
        ], [
            'platform.required' => 'সোশ্যাল মিডিয়ার নাম/প্ল্যাটফর্ম প্রদান করুন।',
            'icon.required' => 'ফন্ট অসাম আইকন ক্লাস প্রদান করুন।',
            'url.required' => 'সঠিক সোশ্যাল মিডিয়া লিঙ্ক প্রদান করুন।',
            'url.url' => 'বৈধ URL লিঙ্ক দিন (যেমন: https://facebook.com/...)',
            'target.required' => 'টার্গেট উইন্ডো নির্বাচন করুন।',
        ]);

        $validated['order'] = $validated['order'] ?? (SocialLink::max('order') + 1);
        $validated['is_active'] = $request->has('is_active');

        SocialLink::create($validated);

        return redirect()->route('admin.social-media.index')->with('success', 'নতুন সোশ্যাল মিডিয়া লিঙ্ক সফলভাবে যোগ করা হয়েছে!');
    }

    /**
     * Show the form for editing the specified social link.
     */
    public function edit(SocialLink $socialMedium): View
    {
        return view('admin.social-media.edit', ['socialLink' => $socialMedium]);
    }

    /**
     * Update the specified social link.
     */
    public function update(Request $request, SocialLink $socialMedium): RedirectResponse
    {
        $validated = $request->validate([
            'platform' => ['required', 'string', 'max:100'],
            'icon' => ['required', 'string', 'max:100'],
            'url' => ['required', 'url', 'max:500'],
            'target' => ['required', 'in:_blank,_self'],
            'order' => ['nullable', 'integer', 'min:0'],
        ], [
            'platform.required' => 'সোশ্যাল মিডিয়ার নাম প্রদান করুন।',
            'icon.required' => 'আইকন ক্লাস প্রদান করুন।',
            'url.required' => 'সঠিক লিঙ্ক প্রদান করুন।',
            'url.url' => 'বৈধ URL লিঙ্ক দিন।',
            'target.required' => 'টার্গেট উইন্ডো নির্বাচন করুন।',
        ]);

        $validated['order'] = $validated['order'] ?? $socialMedium->order;
        $validated['is_active'] = $request->has('is_active');

        $socialMedium->update($validated);

        return redirect()->route('admin.social-media.index')->with('success', 'সোশ্যাল মিডিয়া লিঙ্ক সফলভাবে আপডেট করা হয়েছে!');
    }

    /**
     * Remove the specified social link.
     */
    public function destroy(SocialLink $socialMedium): RedirectResponse
    {
        $socialMedium->delete();

        return redirect()->route('admin.social-media.index')->with('success', 'সোশ্যাল মিডিয়া লিঙ্কটি সফলভাবে মুছে ফেলা হয়েছে!');
    }

    /**
     * Toggle status On/Off via AJAX Switch.
     */
    public function toggleStatus(Request $request, SocialLink $socialMedium): \Illuminate\Http\JsonResponse
    {
        $socialMedium->is_active = $request->boolean('status');
        $socialMedium->save();

        return response()->json([
            'status' => 'success',
            'message' => 'সোশ্যাল মিডিয়া লিংকের স্ট্যাটাস ' . ($socialMedium->is_active ? 'সক্রিয় (ON)' : 'নিষ্ক্রিয় (OFF)') . ' করা হয়েছে।',
            'is_active' => $socialMedium->is_active,
        ]);
    }
}
