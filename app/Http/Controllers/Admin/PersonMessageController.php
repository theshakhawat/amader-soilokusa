<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PersonMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PersonMessageController extends Controller
{
    /**
     * Display a listing of person messages.
     */
    public function index(Request $request)
    {
        $query = PersonMessage::query()->orderBy('order', 'asc')->orderBy('id', 'desc');

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status == '1');
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('designation', 'like', "%{$search}%")
                  ->orWhere('type', 'like', "%{$search}%")
                  ->orWhere('quote', 'like', "%{$search}%");
            });
        }

        $messages = $query->paginate(15)->withQueryString();
        $existingTypes = PersonMessage::distinct()->pluck('type')->filter()->values();

        return view('admin.person-messages.index', compact('messages', 'existingTypes'));
    }

    /**
     * Show the form for creating a new message.
     */
    public function create()
    {
        $existingTypes = PersonMessage::distinct()->pluck('type')->filter()->values();
        $suggestions = collect(PersonMessage::defaultTypes())->merge($existingTypes)->unique()->values();

        return view('admin.person-messages.create', compact('suggestions'));
    }

    /**
     * Store a newly created person message.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'type'        => 'required|string|max:100',
            'name'        => 'required|string|max:255',
            'designation' => 'required|string|max:255',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'quote'       => 'nullable|string|max:1000',
            'message'     => 'nullable|string',
            'order'       => 'nullable|integer',
            'status'      => 'nullable|boolean',
        ]);

        $data = [
            'type'        => trim($validated['type']),
            'name'        => $validated['name'],
            'designation' => $validated['designation'],
            'quote'       => $validated['quote'] ?? null,
            'message'     => $validated['message'] ?? null,
            'order'       => $validated['order'] ?? 0,
            'status'      => $request->boolean('status', true),
        ];

        // Slug creation
        $baseSlug = Str::slug($validated['type'] . '-' . $validated['name']);
        if (empty($baseSlug)) {
            $baseSlug = 'message-' . time();
        }
        $slug = $baseSlug;
        $counter = 1;
        while (PersonMessage::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $counter++;
        }
        $data['slug'] = $slug;

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('person_messages', 'public');
        }

        PersonMessage::create($data);

        return redirect()->route('admin.person-messages.index')->with('success', 'ব্যক্তির বাণী সফলভাবে যুক্ত করা হয়েছে!');
    }

    /**
     * Show the form for editing.
     */
    public function edit(PersonMessage $personMessage)
    {
        $existingTypes = PersonMessage::distinct()->pluck('type')->filter()->values();
        $suggestions = collect(PersonMessage::defaultTypes())->merge($existingTypes)->unique()->values();

        return view('admin.person-messages.edit', compact('personMessage', 'suggestions'));
    }

    /**
     * Update the specified person message.
     */
    public function update(Request $request, PersonMessage $personMessage)
    {
        $validated = $request->validate([
            'type'        => 'required|string|max:100',
            'name'        => 'required|string|max:255',
            'designation' => 'required|string|max:255',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'quote'       => 'nullable|string|max:1000',
            'message'     => 'nullable|string',
            'order'       => 'nullable|integer',
            'status'      => 'nullable|boolean',
        ]);

        $data = [
            'type'        => trim($validated['type']),
            'name'        => $validated['name'],
            'designation' => $validated['designation'],
            'quote'       => $validated['quote'] ?? null,
            'message'     => $validated['message'] ?? null,
            'order'       => $validated['order'] ?? 0,
            'status'      => $request->boolean('status', false),
        ];

        if ($request->hasFile('image')) {
            if ($personMessage->image && Storage::disk('public')->exists($personMessage->image)) {
                Storage::disk('public')->delete($personMessage->image);
            }
            $data['image'] = $request->file('image')->store('person_messages', 'public');
        }

        $personMessage->update($data);

        return redirect()->route('admin.person-messages.index')->with('success', 'বাণীর তথ্য সফলভাবে হালনাগাদ করা হয়েছে!');
    }

    /**
     * Remove the specified person message.
     */
    public function destroy(PersonMessage $personMessage)
    {
        if ($personMessage->image && Storage::disk('public')->exists($personMessage->image)) {
            Storage::disk('public')->delete($personMessage->image);
        }

        $personMessage->delete();

        return redirect()->route('admin.person-messages.index')->with('success', 'বাণী সফলভাবে মুছে ফেলা হয়েছে!');
    }

    /**
     * Toggle active status.
     */
    public function toggleStatus(PersonMessage $personMessage)
    {
        $personMessage->status = !$personMessage->status;
        $personMessage->save();

        return response()->json([
            'success' => true,
            'status'  => $personMessage->status,
            'message' => 'স্ট্যাটাস পরিবর্তিত হয়েছে!',
        ]);
    }
}
