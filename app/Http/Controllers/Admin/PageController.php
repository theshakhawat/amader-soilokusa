<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PageController extends Controller
{
    /**
     * Display a listing of custom pages.
     */
    public function index(Request $request)
    {
        $query = Page::query()->orderBy('id', 'desc');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('slug', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status == '1');
        }

        $pages = $query->paginate(15)->withQueryString();

        return view('admin.pages.index', compact('pages'));
    }

    /**
     * Show the form for creating a new page.
     */
    public function create()
    {
        return view('admin.pages.create');
    }

    /**
     * Store a newly created page in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'   => 'required|string|max:255',
            'content' => 'nullable|string',
            'status'  => 'nullable|boolean',
        ]);

        $baseSlug = Str::slug($validated['title']);
        if (empty($baseSlug)) {
            $baseSlug = 'page-' . time();
        }
        $slug = $baseSlug;
        $counter = 1;
        while (Page::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $counter++;
        }

        Page::create([
            'title'   => $validated['title'],
            'slug'    => $slug,
            'content' => $validated['content'] ?? null,
            'status'  => $request->boolean('status', true),
        ]);

        return redirect()->route('admin.pages.index')->with('success', 'নতুন পেজ সফলভাবে তৈরি হয়েছে!');
    }

    /**
     * Show the form for editing the specified page.
     */
    public function edit(Page $page)
    {
        return view('admin.pages.edit', compact('page'));
    }

    /**
     * Update the specified page in storage.
     */
    public function update(Request $request, Page $page)
    {
        $validated = $request->validate([
            'title'   => 'required|string|max:255',
            'content' => 'nullable|string',
            'status'  => 'nullable|boolean',
        ]);

        $data = [
            'title'   => $validated['title'],
            'content' => $validated['content'] ?? null,
            'status'  => $request->boolean('status', false),
        ];

        // If title changed, update slug automatically
        if ($page->title !== $validated['title']) {
            $baseSlug = Str::slug($validated['title']);
            if (empty($baseSlug)) {
                $baseSlug = 'page-' . time();
            }
            $slug = $baseSlug;
            $counter = 1;
            while (Page::where('slug', $slug)->where('id', '!=', $page->id)->exists()) {
                $slug = $baseSlug . '-' . $counter++;
            }
            $data['slug'] = $slug;
        }

        $page->update($data);

        return redirect()->route('admin.pages.index')->with('success', 'পেজ সফলভাবে হালনাগাদ করা হয়েছে!');
    }

    /**
     * Remove the specified page from storage.
     */
    public function destroy(Page $page)
    {
        $page->delete();

        return redirect()->route('admin.pages.index')->with('success', 'পেজ সফলভাবে মুছে ফেলা হয়েছে!');
    }

    /**
     * AJAX Toggle Page Status.
     */
    public function toggleStatus(Page $page)
    {
        $page->status = !$page->status;
        $page->save();

        return response()->json([
            'success' => true,
            'status'  => $page->status,
            'message' => 'পেজের স্ট্যাটাস সফলভাবে পরিবর্তিত হয়েছে!',
        ]);
    }
}

