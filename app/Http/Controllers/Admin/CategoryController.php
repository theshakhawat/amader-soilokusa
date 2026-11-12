<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of categories.
     */
    public function index(Request $request)
    {
        $query = Category::withCount('posts')->orderBy('id', 'desc');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('slug', 'like', "%{$search}%");
        }

        if ($request->filled('status')) {
            $query->where('status', filter_var($request->status, FILTER_VALIDATE_BOOLEAN));
        }

        $categories = $query->paginate(15)->withQueryString();

        return view('admin.blogs.categories.index', compact('categories'));
    }

    /**
     * Store a newly created category in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'   => 'required|string|max:255',
            'slug'   => 'nullable|string|max:255|unique:categories,slug',
            'status' => 'nullable|boolean',
        ]);

        $slug = !empty($validated['slug'])
            ? Str::slug($validated['slug'])
            : (Str::slug($validated['name']) ?: 'cat-' . time());

        // Ensure uniqueness if auto-generated
        $originalSlug = $slug;
        $counter = 1;
        while (Category::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter++;
        }

        Category::create([
            'name'   => $validated['name'],
            'slug'   => $slug,
            'status' => $request->has('status'),
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'ক্যাটাগরি সফলভাবে তৈরি করা হয়েছে!');
    }

    /**
     * Update the specified category in storage.
     */
    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name'   => 'required|string|max:255',
            'slug'   => 'nullable|string|max:255|unique:categories,slug,' . $category->id,
            'status' => 'nullable|boolean',
        ]);

        $slug = !empty($validated['slug'])
            ? Str::slug($validated['slug'])
            : (Str::slug($validated['name']) ?: 'cat-' . time());

        $category->update([
            'name'   => $validated['name'],
            'slug'   => $slug,
            'status' => $request->has('status'),
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'ক্যাটাগরি সফলভাবে হালনাগাদ করা হয়েছে!');
    }

    /**
     * Remove the specified category from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->route('admin.categories.index')->with('success', 'ক্যাটাগরি মুছে ফেলা হয়েছে!');
    }

    /**
     * AJAX toggle category status.
     */
    public function toggleStatus(Category $category)
    {
        $category->status = !$category->status;
        $category->save();

        return response()->json([
            'success' => true,
            'status'  => $category->status,
            'message' => 'ক্যাটাগরি স্ট্যাটাস পরিবর্তিত হয়েছে!',
        ]);
    }
}

