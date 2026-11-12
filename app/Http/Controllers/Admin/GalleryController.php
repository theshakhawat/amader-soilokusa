<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GalleryItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    /**
     * Display a listing of gallery items (photos & videos).
     */
    public function index(Request $request)
    {
        $query = GalleryItem::orderBy('order_index', 'asc')->orderBy('id', 'desc');

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status === '1' || $request->status === 'active');
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('title', 'like', "%{$search}%");
        }

        $items = $query->paginate(12)->withQueryString();

        return view('admin.gallery.index', compact('items'));
    }

    /**
     * Show the form for creating a new gallery item.
     */
    public function create()
    {
        return view('admin.gallery.create');
    }

    /**
     * Store a newly created gallery item in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:photo,video',
            'video_source_type' => 'nullable|in:url,upload',
            'title' => 'required|string|max:255',
            'file' => 'nullable|file|max:102400', // max 100MB for video/photos
            'video_file' => 'nullable|file|mimes:mp4,mov,ogg,webm,mkv|max:102400', // 100MB video
            'video_url' => 'nullable|url|max:500',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096',
            'order_index' => 'nullable|integer',
            'status' => 'nullable|boolean',
        ]);

        $data = [
            'type' => $validated['type'],
            'title' => $validated['title'],
            'video_url' => null,
            'order_index' => $validated['order_index'] ?? 0,
            'status' => $request->has('status'),
        ];

        if ($validated['type'] === 'photo') {
            // Upload photo
            if ($request->hasFile('file')) {
                $data['file_path'] = $request->file('file')->store('gallery/photos', 'public');
            }
        } else {
            // Video: check if URL or uploaded file
            $sourceType = $request->input('video_source_type', 'url');
            if ($sourceType === 'upload' && $request->hasFile('video_file')) {
                $data['file_path'] = $request->file('video_file')->store('gallery/videos', 'public');
                $data['video_url'] = null;
            } elseif ($request->filled('video_url')) {
                $data['video_url'] = $validated['video_url'];
                $data['file_path'] = null;
            }
        }

        // Upload custom thumbnail
        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')->store('gallery/thumbnails', 'public');
        }

        GalleryItem::create($data);

        return redirect()->route('admin.gallery.index')->with('success', 'গ্যালারি আইটেম সফলভাবে যোগ করা হয়েছে!');
    }

    /**
     * Show the form for editing the specified gallery item.
     */
    public function edit(GalleryItem $gallery)
    {
        return view('admin.gallery.edit', compact('gallery'));
    }

    /**
     * Update the specified gallery item in storage.
     */
    public function update(Request $request, GalleryItem $gallery)
    {
        $validated = $request->validate([
            'type' => 'required|in:photo,video',
            'video_source_type' => 'nullable|in:url,upload',
            'title' => 'required|string|max:255',
            'file' => 'nullable|file|max:102400',
            'video_file' => 'nullable|file|mimes:mp4,mov,ogg,webm,mkv|max:102400',
            'video_url' => 'nullable|url|max:500',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096',
            'order_index' => 'nullable|integer',
            'status' => 'nullable|boolean',
        ]);

        $data = [
            'type' => $validated['type'],
            'title' => $validated['title'],
            'order_index' => $validated['order_index'] ?? $gallery->order_index,
            'status' => $request->has('status'),
        ];

        if ($validated['type'] === 'photo') {
            $data['video_url'] = null;
            if ($request->hasFile('file')) {
                if ($gallery->file_path && Storage::disk('public')->exists($gallery->file_path)) {
                    Storage::disk('public')->delete($gallery->file_path);
                }
                $data['file_path'] = $request->file('file')->store('gallery/photos', 'public');
            }
        } else {
            // Video
            $sourceType = $request->input('video_source_type', 'url');
            if ($sourceType === 'upload') {
                $data['video_url'] = null;
                if ($request->hasFile('video_file')) {
                    if ($gallery->file_path && Storage::disk('public')->exists($gallery->file_path)) {
                        Storage::disk('public')->delete($gallery->file_path);
                    }
                    $data['file_path'] = $request->file('video_file')->store('gallery/videos', 'public');
                }
            } else {
                // URL
                $data['video_url'] = $validated['video_url'] ?? $gallery->video_url;
                if ($request->filled('video_url') && $gallery->file_path) {
                    // if switching from upload to url, can clean file_path
                    if (Storage::disk('public')->exists($gallery->file_path)) {
                        Storage::disk('public')->delete($gallery->file_path);
                    }
                    $data['file_path'] = null;
                }
            }
        }

        // Upload new thumbnail if provided
        if ($request->hasFile('thumbnail')) {
            if ($gallery->thumbnail && Storage::disk('public')->exists($gallery->thumbnail)) {
                Storage::disk('public')->delete($gallery->thumbnail);
            }
            $data['thumbnail'] = $request->file('thumbnail')->store('gallery/thumbnails', 'public');
        }

        $gallery->update($data);

        return redirect()->route('admin.gallery.index')->with('success', 'গ্যালারি আইটেম সফলভাবে হালনাগাদ করা হয়েছে!');
    }

    /**
     * Remove the specified gallery item from storage.
     */
    public function destroy(GalleryItem $gallery)
    {
        if ($gallery->file_path && Storage::disk('public')->exists($gallery->file_path)) {
            Storage::disk('public')->delete($gallery->file_path);
        }

        if ($gallery->thumbnail && Storage::disk('public')->exists($gallery->thumbnail)) {
            Storage::disk('public')->delete($gallery->thumbnail);
        }

        $gallery->delete();

        return redirect()->route('admin.gallery.index')->with('success', 'গ্যালারি আইটেম মুছে ফেলা হয়েছে!');
    }

    /**
     * AJAX Toggle Status
     */
    public function toggleStatus(Request $request, GalleryItem $gallery)
    {
        $gallery->status = !$gallery->status;
        $gallery->save();

        return response()->json([
            'success' => true,
            'status' => $gallery->status,
            'message' => 'স্ট্যাটাস সফলভাবে পরিবর্তন করা হয়েছে!'
        ]);
    }
}

