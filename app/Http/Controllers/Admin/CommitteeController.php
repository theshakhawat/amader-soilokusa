<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Committee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CommitteeController extends Controller
{
    /**
     * Display a listing of committees.
     */
    public function index()
    {
        $committees = Committee::orderBy('order', 'asc')->orderBy('id', 'desc')->paginate(15);
        return view('admin.committees.index', compact('committees'));
    }

    /**
     * Show the form for creating a new committee.
     */
    public function create()
    {
        return view('admin.committees.create');
    }

    /**
     * Store a newly created committee in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'             => 'required|string|max:255',
            'slug'             => 'nullable|string|max:255|unique:committees,slug',
            'session_duration' => 'required|string|max:100',
            'subtitle'         => 'nullable|string|max:255',
            'second_row_count' => 'nullable|integer|in:2,3,4',
            'image'            => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'description'      => 'nullable|string',
            'is_active'        => 'nullable|boolean',
            'order'            => 'nullable|integer',
        ]);

        $slug = !empty($validated['slug']) ? Str::slug($validated['slug']) : Str::slug($validated['name']);
        if (empty($slug)) {
            $slug = 'committee-' . uniqid();
        }
        $baseSlug = $slug;
        $counter = 1;
        while (Committee::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $counter++;
        }

        $data = [
            'name'             => $validated['name'],
            'slug'             => $slug,
            'session_duration' => $validated['session_duration'],
            'subtitle'         => $validated['subtitle'] ?? 'আগামীর শৈলকুপা',
            'second_row_count' => (int)($validated['second_row_count'] ?? 2),
            'description'      => $validated['description'] ?? null,
            'is_active'        => $request->has('is_active') ? true : false,
            'order'            => (int)($validated['order'] ?? 0),
        ];

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('committees', 'public');
        }

        Committee::create($data);

        return redirect()->route('admin.committees.index')->with('success', 'কমিটির তথ্য সফলভাবে যুক্ত করা হয়েছে।');
    }

    /**
     * Show the form for editing the specified committee.
     */
    public function edit(Committee $committee)
    {
        return view('admin.committees.edit', compact('committee'));
    }

    /**
     * Update the specified committee in storage.
     */
    public function update(Request $request, Committee $committee)
    {
        $validated = $request->validate([
            'name'             => 'required|string|max:255',
            'slug'             => 'nullable|string|max:255|unique:committees,slug,' . $committee->id,
            'session_duration' => 'required|string|max:100',
            'subtitle'         => 'nullable|string|max:255',
            'second_row_count' => 'nullable|integer|in:2,3,4',
            'image'            => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'description'      => 'nullable|string',
            'is_active'        => 'nullable|boolean',
            'order'            => 'nullable|integer',
        ]);

        $slug = !empty($validated['slug']) ? Str::slug($validated['slug']) : ($committee->slug ?: Str::slug($validated['name']));
        if (empty($slug)) {
            $slug = 'committee-' . $committee->id;
        }
        $baseSlug = $slug;
        $counter = 1;
        while (Committee::where('slug', $slug)->where('id', '!=', $committee->id)->exists()) {
            $slug = $baseSlug . '-' . $counter++;
        }

        $data = [
            'name'             => $validated['name'],
            'slug'             => $slug,
            'session_duration' => $validated['session_duration'],
            'subtitle'         => $validated['subtitle'] ?? 'আগামীর শৈলকুপা',
            'second_row_count' => (int)($validated['second_row_count'] ?? 2),
            'description'      => $validated['description'] ?? null,
            'is_active'        => $request->has('is_active') ? true : false,
            'order'            => (int)($validated['order'] ?? 0),
        ];

        if ($request->hasFile('image')) {
            if ($committee->image && !str_starts_with($committee->image, 'assets/') && Storage::disk('public')->exists($committee->image)) {
                Storage::disk('public')->delete($committee->image);
            }
            $data['image'] = $request->file('image')->store('committees', 'public');
        }

        $committee->update($data);

        return redirect()->route('admin.committees.index')->with('success', 'কমিটির তথ্য সফলভাবে আপডেট করা হয়েছে।');
    }

    /**
     * Toggle active status.
     */
    public function toggleStatus(Committee $committee)
    {
        $committee->is_active = !$committee->is_active;
        $committee->save();

        return response()->json([
            'success' => true,
            'is_active' => $committee->is_active,
            'message' => 'কমিটির স্ট্যাটাস সফলভাবে পরিবর্তিত হয়েছে।',
        ]);
    }

    /**
     * Remove the specified committee from storage.
     */
    public function destroy(Committee $committee)
    {
        if ($committee->image && !str_starts_with($committee->image, 'assets/') && Storage::disk('public')->exists($committee->image)) {
            Storage::disk('public')->delete($committee->image);
        }

        $committee->delete();

        return redirect()->route('admin.committees.index')->with('success', 'কমিটির তথ্য সফলভাবে মুছে ফেলা হয়েছে।');
    }
}

