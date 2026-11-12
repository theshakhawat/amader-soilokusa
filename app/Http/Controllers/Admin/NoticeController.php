<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notice;
use App\Models\NoticeFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class NoticeController extends Controller
{
    /**
     * Display a listing of the notices.
     */
    public function index(Request $request)
    {
        $query = Notice::with('files')->orderBy('order_index', 'asc')->orderBy('date', 'desc')->orderBy('id', 'desc');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('title', 'like', "%{$search}%");
        }

        $notices = $query->paginate(10)->withQueryString();

        return view('admin.notices.index', compact('notices'));
    }

    /**
     * Show the form for creating a new notice.
     */
    public function create()
    {
        return view('admin.notices.create');
    }

    /**
     * Store a newly created notice in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'date' => 'nullable|date',
            'status' => 'required|in:active,inactive,pinned',
            'description' => 'nullable|string',
            'order_index' => 'nullable|integer',
            'files.*' => 'nullable|file|max:10240', // 10MB per file
        ]);

        $notice = Notice::create([
            'title' => $validated['title'],
            'date' => $validated['date'] ?? now()->toDateString(),
            'status' => $validated['status'],
            'description' => $validated['description'] ?? null,
            'order_index' => $validated['order_index'] ?? 0,
        ]);

        // Upload multiple attached documents/files
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                if ($file && $file->isValid()) {
                    $originalName = $file->getClientOriginalName();
                    $extension = $file->getClientOriginalExtension();
                    $size = $file->getSize();
                    $path = $file->store('notices/files', 'public');

                    $notice->files()->create([
                        'file_path' => $path,
                        'file_name' => $originalName,
                        'file_type' => $extension,
                        'file_size' => $size,
                    ]);
                }
            }
        }

        return redirect()->route('admin.notices.index')->with('success', 'নতুন নোটিশ সফলভাবে প্রকাশ করা হয়েছে!');
    }

    /**
     * Show the form for editing the specified notice.
     */
    public function edit(Notice $notice)
    {
        $notice->load('files');
        return view('admin.notices.edit', compact('notice'));
    }

    /**
     * Update the specified notice in storage.
     */
    public function update(Request $request, Notice $notice)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'date' => 'nullable|date',
            'status' => 'required|in:active,inactive,pinned',
            'description' => 'nullable|string',
            'order_index' => 'nullable|integer',
            'files.*' => 'nullable|file|max:10240',
        ]);

        $notice->update([
            'title' => $validated['title'],
            'date' => $validated['date'] ?? $notice->date,
            'status' => $validated['status'],
            'description' => $validated['description'] ?? null,
            'order_index' => $validated['order_index'] ?? $notice->order_index,
        ]);

        // Upload additional attached files
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                if ($file && $file->isValid()) {
                    $originalName = $file->getClientOriginalName();
                    $extension = $file->getClientOriginalExtension();
                    $size = $file->getSize();
                    $path = $file->store('notices/files', 'public');

                    $notice->files()->create([
                        'file_path' => $path,
                        'file_name' => $originalName,
                        'file_type' => $extension,
                        'file_size' => $size,
                    ]);
                }
            }
        }

        return redirect()->route('admin.notices.index')->with('success', 'নোটিশ সফলভাবে হালনাগাদ করা হয়েছে!');
    }

    /**
     * Remove the specified notice from storage.
     */
    public function destroy(Notice $notice)
    {
        foreach ($notice->files as $file) {
            if ($file->file_path && Storage::disk('public')->exists($file->file_path)) {
                Storage::disk('public')->delete($file->file_path);
            }
        }

        $notice->delete();

        return redirect()->route('admin.notices.index')->with('success', 'নোটিশ সফলভাবে মুছে ফেলা হয়েছে!');
    }

    /**
     * AJAX Toggle Status
     */
    public function toggleStatus(Request $request, Notice $notice)
    {
        $newStatus = $request->input('status');
        if (!in_array($newStatus, ['active', 'inactive', 'pinned'])) {
            $newStatus = ($notice->status === 'active' || $notice->status === 'pinned') ? 'inactive' : 'active';
        }

        $notice->status = $newStatus;
        $notice->save();

        return response()->json([
            'success' => true,
            'status' => $notice->status,
            'message' => 'নোটিশের স্ট্যাটাস সফলভাবে পরিবর্তন করা হয়েছে!'
        ]);
    }

    /**
     * Delete individual attached file
     */
    public function destroyFile(NoticeFile $file)
    {
        if ($file->file_path && Storage::disk('public')->exists($file->file_path)) {
            Storage::disk('public')->delete($file->file_path);
        }
        $file->delete();

        return back()->with('success', 'ফাইলটি সফলভাবে মুছে ফেলা হয়েছে!');
    }
}

