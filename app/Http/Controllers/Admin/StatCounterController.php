<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StatCounter;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StatCounterController extends Controller
{
    /**
     * Display a listing of the statistics counters.
     */
    public function index(): View
    {
        $stats = StatCounter::orderBy('order')->orderBy('id', 'asc')->get();
        return view('admin.stat-counter.index', compact('stats'));
    }

    /**
     * Show the form for creating a new stat counter.
     */
    public function create(): View
    {
        return view('admin.stat-counter.create');
    }

    /**
     * Store a newly created stat counter.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'count' => ['required', 'string', 'max:100'],
            'icon' => ['nullable', 'string', 'max:100'],
            'order' => ['nullable', 'integer', 'min:0'],
        ], [
            'title.required' => 'শিরোনাম প্রদান করুন (যেমন: সক্রিয় সদস্য)।',
            'count.required' => 'সংখ্যার পরিমাণ প্রদান করুন (যেমন: ৫০০+)।',
        ]);

        $validated['order'] = $validated['order'] ?? (StatCounter::max('order') + 1);
        $validated['status'] = $request->boolean('status', true);

        StatCounter::create($validated);

        return redirect()->route('admin.stat-counters.index')->with('success', 'নতুন পরিসংখ্যান সফলভাবে যোগ করা হয়েছে!');
    }

    /**
     * Show the form for editing the specified stat counter.
     */
    public function edit(StatCounter $statCounter): View
    {
        return view('admin.stat-counter.edit', compact('statCounter'));
    }

    /**
     * Update the specified stat counter.
     */
    public function update(Request $request, StatCounter $statCounter): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'count' => ['required', 'string', 'max:100'],
            'icon' => ['nullable', 'string', 'max:100'],
            'order' => ['nullable', 'integer', 'min:0'],
        ], [
            'title.required' => 'শিরোনাম প্রদান করুন।',
            'count.required' => 'সংখ্যার পরিমাণ প্রদান করুন।',
        ]);

        $validated['order'] = $validated['order'] ?? $statCounter->order;
        $validated['status'] = $request->boolean('status', true);

        $statCounter->update($validated);

        return redirect()->route('admin.stat-counters.index')->with('success', 'পরিসংখ্যানের তথ্য সফলভাবে আপডেট করা হয়েছে!');
    }

    /**
     * Remove the specified stat counter.
     */
    public function destroy(StatCounter $statCounter): RedirectResponse
    {
        $statCounter->delete();

        return redirect()->route('admin.stat-counters.index')->with('success', 'পরিসংখ্যানটি সফলভাবে মুছে ফেলা হয়েছে!');
    }

    /**
     * Toggle status On/Off via AJAX Switch.
     */
    public function toggleStatus(Request $request, StatCounter $statCounter): JsonResponse
    {
        $statCounter->status = $request->boolean('status');
        $statCounter->save();

        return response()->json([
            'status' => 'success',
            'message' => 'পরিসংখ্যানটির স্ট্যাটাস ' . ($statCounter->status ? 'সক্রিয় (ON)' : 'নিষ্ক্রিয় (OFF)') . ' করা হয়েছে।',
            'is_active' => $statCounter->status,
        ]);
    }
}

