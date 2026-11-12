<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HeroBanner;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class HeroBannerController extends Controller
{
    /**
     * Display a listing of the hero banners.
     */
    public function index(): View
    {
        $banners = HeroBanner::orderBy('order')->orderBy('id', 'desc')->get();
        return view('admin.hero-banner.index', compact('banners'));
    }

    /**
     * Show the form for creating a new banner.
     */
    public function create(): View
    {
        return view('admin.hero-banner.create');
    }

    /**
     * Store a newly created banner.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'subtitle' => ['nullable', 'string', 'max:500'],
            'badge' => ['nullable', 'string', 'max:100'],
            'primary_button_text' => ['required', 'string', 'max:100'],
            'primary_button_link' => ['nullable', 'string', 'max:255'],
            'secondary_button_text' => ['nullable', 'string', 'max:100'],
            'secondary_button_link' => ['nullable', 'string', 'max:500'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:4096'],
            'order' => ['nullable', 'integer', 'min:0'],
        ], [
            'title.required' => 'ব্যানারের শিরোনাম (Title) প্রদান করুন।',
            'primary_button_text.required' => 'প্রাইমারি বাটনের টেক্সট দিন।',
            'image.image' => 'আপলোডকৃত ফাইলটি ছবি হতে হবে।',
            'image.max' => 'ছবির সাইজ সর্বোচ্চ ৪ মেগাবাইট (4MB) হতে পারবে।',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('banners', 'public');
        }

        $validated['image'] = $imagePath;
        $validated['order'] = $validated['order'] ?? (HeroBanner::max('order') + 1);
        $validated['status'] = $request->boolean('status', true);

        HeroBanner::create($validated);

        return redirect()->route('admin.hero-banners.index')->with('success', 'নতুন ব্যানার সফলভাবে তৈরি করা হয়েছে!');
    }

    /**
     * Show the form for editing the specified banner.
     */
    public function edit(HeroBanner $heroBanner): View
    {
        return view('admin.hero-banner.edit', compact('heroBanner'));
    }

    /**
     * Update the specified banner.
     */
    public function update(Request $request, HeroBanner $heroBanner): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'subtitle' => ['nullable', 'string', 'max:500'],
            'badge' => ['nullable', 'string', 'max:100'],
            'primary_button_text' => ['required', 'string', 'max:100'],
            'primary_button_link' => ['nullable', 'string', 'max:255'],
            'secondary_button_text' => ['nullable', 'string', 'max:100'],
            'secondary_button_link' => ['nullable', 'string', 'max:500'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:4096'],
            'order' => ['nullable', 'integer', 'min:0'],
        ], [
            'title.required' => 'ব্যানারের শিরোনাম প্রদান করুন।',
            'primary_button_text.required' => 'প্রাইমারি বাটনের টেক্সট দিন।',
            'image.image' => 'আপলোডকৃত ফাইলটি ছবি হতে হবে।',
            'image.max' => 'ছবির সাইজ সর্বোচ্চ ৪ মেগাবাইট হতে পারবে।',
        ]);

        if ($request->hasFile('image')) {
            if ($heroBanner->image && Storage::disk('public')->exists($heroBanner->image)) {
                Storage::disk('public')->delete($heroBanner->image);
            }
            $validated['image'] = $request->file('image')->store('banners', 'public');
        } else {
            unset($validated['image']);
        }

        $validated['order'] = $validated['order'] ?? $heroBanner->order;
        $validated['status'] = $request->boolean('status', true);

        $heroBanner->update($validated);

        return redirect()->route('admin.hero-banners.index')->with('success', 'ব্যানার তথ্য সফলভাবে আপডেট করা হয়েছে!');
    }

    /**
     * Remove the specified banner.
     */
    public function destroy(HeroBanner $heroBanner): RedirectResponse
    {
        if ($heroBanner->image && Storage::disk('public')->exists($heroBanner->image)) {
            Storage::disk('public')->delete($heroBanner->image);
        }

        $heroBanner->delete();

        return redirect()->route('admin.hero-banners.index')->with('success', 'ব্যানারটি সফলভাবে মুছে ফেলা হয়েছে!');
    }

    /**
     * Toggle status On/Off via AJAX Switch.
     */
    public function toggleStatus(Request $request, HeroBanner $heroBanner): JsonResponse
    {
        $heroBanner->status = $request->boolean('status');
        $heroBanner->save();

        return response()->json([
            'status' => 'success',
            'message' => 'ব্যানারের স্ট্যাটাস ' . ($heroBanner->status ? 'সক্রিয় (ON)' : 'নিষ্ক্রিয় (OFF)') . ' করা হয়েছে।',
            'is_active' => $heroBanner->status,
        ]);
    }
}

