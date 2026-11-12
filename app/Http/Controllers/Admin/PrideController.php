<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pride;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PrideController extends Controller
{
    /**
     * Display a listing of the prides.
     */
    public function index(Request $request)
    {
        $query = Pride::orderBy('order_index', 'asc')->orderBy('id', 'desc');

        if ($request->filled('status')) {
            $query->where('status', $request->status === '1' || $request->status === 'active');
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('designation', 'like', "%{$search}%");
            });
        }

        $prides = $query->paginate(12)->withQueryString();

        return view('admin.prides.index', compact('prides'));
    }

    /**
     * Show the form for creating a new pride.
     */
    public function create()
    {
        return view('admin.prides.create');
    }

    /**
     * Store a newly created pride in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'designation' => 'required|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096',
            'description' => 'nullable|string',
            'order_index' => 'nullable|integer',
            'status' => 'nullable|boolean',
        ]);

        $data = [
            'name' => $validated['name'],
            'designation' => $validated['designation'],
            'description' => $validated['description'] ?? null,
            'order_index' => $validated['order_index'] ?? 0,
            'status' => $request->has('status'),
        ];

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('prides', 'public');
        }

        Pride::create($data);

        return redirect()->route('admin.prides.index')->with('success', 'কৃতি সন্তানের তথ্য সফলভাবে যুক্ত করা হয়েছে!');
    }

    /**
     * Show the form for editing the specified pride.
     */
    public function edit(Pride $pride)
    {
        return view('admin.prides.edit', compact('pride'));
    }

    /**
     * Update the specified pride in storage.
     */
    public function update(Request $request, Pride $pride)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'designation' => 'required|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096',
            'description' => 'nullable|string',
            'order_index' => 'nullable|integer',
            'status' => 'nullable|boolean',
        ]);

        $data = [
            'name' => $validated['name'],
            'designation' => $validated['designation'],
            'description' => $validated['description'] ?? null,
            'order_index' => $validated['order_index'] ?? $pride->order_index,
            'status' => $request->has('status'),
        ];

        if ($request->hasFile('photo')) {
            if ($pride->photo && Storage::disk('public')->exists($pride->photo)) {
                Storage::disk('public')->delete($pride->photo);
            }
            $data['photo'] = $request->file('photo')->store('prides', 'public');
        }

        $pride->update($data);

        return redirect()->route('admin.prides.index')->with('success', 'কৃতি সন্তানের তথ্য সফলভাবে হালনাগাদ করা হয়েছে!');
    }

    /**
     * Remove the specified pride from storage.
     */
    public function destroy(Pride $pride)
    {
        if ($pride->photo && Storage::disk('public')->exists($pride->photo)) {
            Storage::disk('public')->delete($pride->photo);
        }

        $pride->delete();

        return redirect()->route('admin.prides.index')->with('success', 'কৃতি সন্তানের তথ্য মুছে ফেলা হয়েছে!');
    }

    /**
     * AJAX Toggle Status
     */
    public function toggleStatus(Request $request, Pride $pride)
    {
        $pride->status = !$pride->status;
        $pride->save();

        return response()->json([
            'success' => true,
            'status' => $pride->status,
            'message' => 'স্ট্যাটাস সফলভাবে পরিবর্তন করা হয়েছে!'
        ]);
    }
}

