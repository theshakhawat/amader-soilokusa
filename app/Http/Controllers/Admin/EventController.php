<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventPhoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    /**
     * Display a listing of the events.
     */
    public function index(Request $request)
    {
        $query = Event::with('photos')->orderBy('order_index', 'asc')->orderBy('id', 'desc');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%");
            });
        }

        $events = $query->paginate(10)->withQueryString();

        return view('admin.events.index', compact('events'));
    }

    /**
     * Show the form for creating a new event.
     */
    public function create()
    {
        return view('admin.events.create');
    }

    /**
     * Store a newly created event in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:4096',
            'date' => 'nullable|date',
            'time' => 'nullable|string|max:100',
            'location' => 'nullable|string|max:255',
            'status' => 'required|in:active,inactive,upcoming,ongoing,completed',
            'description' => 'nullable|string',
            'order_index' => 'nullable|integer',
            'photos.*' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:5120',
        ]);

        $data = [
            'title' => $validated['title'],
            'date' => $validated['date'] ?? null,
            'time' => $validated['time'] ?? null,
            'location' => $validated['location'] ?? null,
            'status' => $validated['status'],
            'description' => $validated['description'] ?? null,
            'order_index' => $validated['order_index'] ?? 0,
        ];

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')->store('events', 'public');
        }

        $event = Event::create($data);

        // Upload Multiple Photos if provided
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photoFile) {
                if ($photoFile && $photoFile->isValid()) {
                    $path = $photoFile->store('events/photos', 'public');
                    $event->photos()->create([
                        'photo' => $path,
                    ]);
                }
            }
        }

        return redirect()->route('admin.events.index')->with('success', 'নতুন ইভেন্ট সফলভাবে যুক্ত করা হয়েছে!');
    }

    /**
     * Display the specified event.
     */
    public function show(Event $event)
    {
        $event->load('photos');
        return view('admin.events.show', compact('event'));
    }

    /**
     * Show the form for editing the specified event.
     */
    public function edit(Event $event)
    {
        $event->load('photos');
        return view('admin.events.edit', compact('event'));
    }

    /**
     * Update the specified event in storage.
     */
    public function update(Request $request, Event $event)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:4096',
            'date' => 'nullable|date',
            'time' => 'nullable|string|max:100',
            'location' => 'nullable|string|max:255',
            'status' => 'required|in:active,inactive,upcoming,ongoing,completed',
            'description' => 'nullable|string',
            'order_index' => 'nullable|integer',
            'photos.*' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:5120',
        ]);

        $data = [
            'title' => $validated['title'],
            'date' => $validated['date'] ?? null,
            'time' => $validated['time'] ?? null,
            'location' => $validated['location'] ?? null,
            'status' => $validated['status'],
            'description' => $validated['description'] ?? null,
            'order_index' => $validated['order_index'] ?? $event->order_index,
        ];

        if ($request->hasFile('thumbnail')) {
            if ($event->thumbnail && Storage::disk('public')->exists($event->thumbnail)) {
                Storage::disk('public')->delete($event->thumbnail);
            }
            $data['thumbnail'] = $request->file('thumbnail')->store('events', 'public');
        }

        $event->update($data);

        // Upload Additional Photos if provided
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photoFile) {
                if ($photoFile && $photoFile->isValid()) {
                    $path = $photoFile->store('events/photos', 'public');
                    $event->photos()->create([
                        'photo' => $path,
                    ]);
                }
            }
        }

        return redirect()->route('admin.events.index')->with('success', 'ইভেন্টের তথ্য সফলভাবে হালনাগাদ করা হয়েছে!');
    }

    /**
     * Remove the specified event from storage.
     */
    public function destroy(Event $event)
    {
        // Delete all photo files
        foreach ($event->photos as $photo) {
            if ($photo->photo && Storage::disk('public')->exists($photo->photo)) {
                Storage::disk('public')->delete($photo->photo);
            }
        }

        // Delete thumbnail
        if ($event->thumbnail && Storage::disk('public')->exists($event->thumbnail)) {
            Storage::disk('public')->delete($event->thumbnail);
        }

        $event->delete();

        return redirect()->route('admin.events.index')->with('success', 'ইভেন্ট সফলভাবে মুছে ফেলা হয়েছে!');
    }

    /**
     * AJAX status toggle (active / inactive)
     */
    public function toggleStatus(Request $request, Event $event)
    {
        $newStatus = $request->input('status');
        if (!in_array($newStatus, ['active', 'inactive', 'upcoming', 'ongoing', 'completed'])) {
            $newStatus = ($event->status === 'active' || $event->status === 'upcoming' || $event->status === 'ongoing') ? 'inactive' : 'active';
        }

        $event->status = $newStatus;
        $event->save();

        return response()->json([
            'success' => true,
            'status' => $event->status,
            'message' => 'ইভেন্টের স্ট্যাটাস সফলভাবে পরিবর্তন করা হয়েছে!'
        ]);
    }

    /**
     * Delete individual photo from gallery
     */
    public function destroyPhoto(EventPhoto $photo)
    {
        if ($photo->photo && Storage::disk('public')->exists($photo->photo)) {
            Storage::disk('public')->delete($photo->photo);
        }
        $photo->delete();

        return back()->with('success', 'ছবিটি সফলভাবে মুছে ফেলা হয়েছে!');
    }
}
