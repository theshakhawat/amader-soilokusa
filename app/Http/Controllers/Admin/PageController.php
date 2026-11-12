<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * Display a listing of pages.
     */
    public function index(Request $request)
    {
        $query = Page::orderBy('id', 'desc');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('slug', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
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
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'status' => 'nullable|boolean',
        ], [
            'title.required' => 'পেজের শিরোনাম বা নাম প্রদান করুন।',
        ]);

        $data = [
            'title' => $validated['title'],
            'content' => $validated['content'] ?? null,
            'status' => $request->has('status') ? true : false,
        ];

        Page::create($data);

        return redirect()->route('admin.pages.index')->with('success', 'নতুন পেজ সফলভাবে তৈরি করা হয়েছে।');
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
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'status' => 'nullable|boolean',
        ], [
            'title.required' => 'পেজের শিরোনাম বা নাম প্রদান করুন।',
        ]);

        $data = [
            'title' => $validated['title'],
            'content' => $validated['content'] ?? null,
            'status' => $request->has('status') ? true : false,
        ];

        $page->update($data);

        return redirect()->route('admin.pages.index')->with('success', 'পেজ সফলভাবে আপডেট করা হয়েছে।');
    }

    /**
     * Toggle active status.
     */
    public function toggleStatus(Page $page)
    {
        $page->status = !$page->status;
        $page->save();

        return response()->json([
            'success' => true,
            'status' => $page->status,
            'message' => 'পেজের স্ট্যাটাস পরিবর্তিত হয়েছে।',
        ]);
    }

    /**
     * Remove the specified page from storage.
     */
    public function destroy(Page $page)
    {
        $page->delete();
        return redirect()->route('admin.pages.index')->with('success', 'পেজটি সফলভাবে মুছে ফেলা হয়েছে।');
    }
}

