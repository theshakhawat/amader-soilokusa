<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Place;
use App\Models\PlacePhoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PlaceController extends Controller
{
    /**
     * Display a listing of places.
     */
    public function index(Request $request)
    {
        $query = Place::withCount('photos')->orderBy('order_index', 'asc')->orderBy('id', 'desc');

        if ($request->filled('status')) {
            $query->where('status', filter_var($request->status, FILTER_VALIDATE_BOOLEAN));
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('subtitle', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%");
            });
        }

        $places = $query->paginate(12)->withQueryString();

        return view('admin.places.index', compact('places'));
    }

    /**
     * Show the form for creating a new place.
     */
    public function create()
    {
        return view('admin.places.create');
    }

    /**
     * Store a newly created place in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'        => 'required|string|max:255',
            'subtitle'     => 'nullable|string|max:255',
            'thumbnail'    => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096',
            'location'     => 'nullable|string|max:255',
            'descriptions' => 'nullable|string',
            'order_index'  => 'nullable|integer',
            'status'       => 'nullable|boolean',
            'photos.*'     => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096',
        ]);

        $data = [
            'title'        => $validated['title'],
            'subtitle'     => $validated['subtitle'] ?? null,
            'location'     => $validated['location'] ?? null,
            'descriptions' => $validated['descriptions'] ?? null,
            'order_index'  => $validated['order_index'] ?? 0,
            'status'       => $request->has('status'),
        ];

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')->store('places/thumbnails', 'public');
        }

        $place = Place::create($data);

        // Upload Gallery / Slide photos
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $idx => $photoFile) {
                $path = $photoFile->store('places/photos', 'public');
                PlacePhoto::create([
                    'place_id'    => $place->id,
                    'image'       => $path,
                    'order_index' => $idx + 1,
                ]);
            }
        }

        return redirect()->route('admin.places.index')->with('success', 'দর্শনীয় স্থান সফলভাবে তৈরি করা হয়েছে!');
    }

    /**
     * Show the form for editing the specified place.
     */
    public function edit(Place $place)
    {
        $place->load('photos');
        return view('admin.places.edit', compact('place'));
    }

    /**
     * Update the specified place in storage.
     */
    public function update(Request $request, Place $place)
    {
        $validated = $request->validate([
            'title'        => 'required|string|max:255',
            'subtitle'     => 'nullable|string|max:255',
            'thumbnail'    => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096',
            'location'     => 'nullable|string|max:255',
            'descriptions' => 'nullable|string',
            'order_index'  => 'nullable|integer',
            'status'       => 'nullable|boolean',
            'photos.*'     => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096',
        ]);

        $data = [
            'title'        => $validated['title'],
            'subtitle'     => $validated['subtitle'] ?? null,
            'location'     => $validated['location'] ?? null,
            'descriptions' => $validated['descriptions'] ?? null,
            'order_index'  => $validated['order_index'] ?? $place->order_index,
            'status'       => $request->has('status'),
        ];

        if ($request->hasFile('thumbnail')) {
            if ($place->thumbnail && Storage::disk('public')->exists($place->thumbnail)) {
                Storage::disk('public')->delete($place->thumbnail);
            }
            $data['thumbnail'] = $request->file('thumbnail')->store('places/thumbnails', 'public');
        }

        $place->update($data);

        // Add additional photos if uploaded
        if ($request->hasFile('photos')) {
            $lastIndex = $place->photos()->max('order_index') ?? 0;
            foreach ($request->file('photos') as $idx => $photoFile) {
                $path = $photoFile->store('places/photos', 'public');
                PlacePhoto::create([
                    'place_id'    => $place->id,
                    'image'       => $path,
                    'order_index' => $lastIndex + $idx + 1,
                ]);
            }
        }

        return redirect()->route('admin.places.index')->with('success', 'দর্শনীয় স্থান সফলভাবে হালনাগাদ করা হয়েছে!');
    }

    /**
     * Remove the specified place from storage.
     */
    public function destroy(Place $place)
    {
        if ($place->thumbnail && Storage::disk('public')->exists($place->thumbnail)) {
            Storage::disk('public')->delete($place->thumbnail);
        }

        foreach ($place->photos as $photo) {
            if ($photo->image && Storage::disk('public')->exists($photo->image)) {
                Storage::disk('public')->delete($photo->image);
            }
        }

        $place->delete();

        return redirect()->route('admin.places.index')->with('success', 'দর্শনীয় স্থান মুছে ফেলা হয়েছে!');
    }

    /**
     * Remove an individual photo from a place.
     */
    public function deletePhoto(PlacePhoto $photo)
    {
        if ($photo->image && Storage::disk('public')->exists($photo->image)) {
            Storage::disk('public')->delete($photo->image);
        }

        $photo->delete();

        return response()->json([
            'success' => true,
            'message' => 'ছবি সফলভাবে মুছে ফেলা হয়েছে!',
        ]);
    }

    /**
     * AJAX Toggle Status
     */
    public function toggleStatus(Place $place)
    {
        $place->status = !$place->status;
        $place->save();

        return response()->json([
            'success' => true,
            'status'  => $place->status,
            'message' => 'স্ট্যাটাস সফলভাবে পরিবর্তন করা হয়েছে!',
        ]);
    }
}

