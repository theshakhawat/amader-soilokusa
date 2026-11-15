<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InstitutionCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class InstitutionCategoryController extends Controller
{
    /**
     * Display a listing of categories.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $categories = InstitutionCategory::withCount('institutions')
            ->when($search, function ($query, $search) {
                return $query->where('name', 'like', "%{$search}%")
                    ->orWhere('slug', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.institutions.categories.index', compact('categories', 'search'));
    }

    /**
     * Store a newly created category.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'   => 'required|string|max:255',
            'slug'   => 'nullable|string|max:255|unique:institution_categories,slug',
            'status' => 'nullable|boolean',
        ]);

        $validated['status'] = $request->boolean('status');

        if (empty($validated['slug'])) {
            $baseSlug = Str::slug($validated['name']);
            if (empty($baseSlug)) {
                $baseSlug = 'cat-' . uniqid();
            }
            $slug = $baseSlug;
            $count = 1;
            while (InstitutionCategory::where('slug', $slug)->exists()) {
                $slug = $baseSlug . '-' . $count++;
            }
            $validated['slug'] = $slug;
        } else {
            $validated['slug'] = Str::slug($validated['slug']);
        }

        InstitutionCategory::create($validated);

        return redirect()->route('admin.institutions.categories.index')
            ->with('success', 'ক্যাটাগরি সফলভাবে তৈরি করা হয়েছে!');
    }

    /**
     * Update the specified category.
     */
    public function update(Request $request, InstitutionCategory $category)
    {
        $validated = $request->validate([
            'name'   => 'required|string|max:255',
            'slug'   => 'nullable|string|max:255|unique:institution_categories,slug,' . $category->id,
            'status' => 'nullable|boolean',
        ]);

        $validated['status'] = $request->boolean('status');

        if (empty($validated['slug'])) {
            $baseSlug = Str::slug($validated['name']);
            if (empty($baseSlug)) {
                $baseSlug = 'cat-' . uniqid();
            }
            $slug = $baseSlug;
            $count = 1;
            while (InstitutionCategory::where('slug', $slug)->where('id', '!=', $category->id)->exists()) {
                $slug = $baseSlug . '-' . $count++;
            }
            $validated['slug'] = $slug;
        } else {
            $validated['slug'] = Str::slug($validated['slug']);
        }

        $category->update($validated);

        return redirect()->route('admin.institutions.categories.index')
            ->with('success', 'ক্যাটাগরি সফলভাবে আপডেট করা হয়েছে!');
    }

    /**
     * Toggle category status via AJAX.
     */
    public function toggleStatus(InstitutionCategory $category)
    {
        $category->status = !$category->status;
        $category->save();

        return response()->json([
            'success' => true,
            'status'  => (bool) $category->status,
            'message' => 'ক্যাটাগরির স্ট্যাটাস পরিবর্তন হয়েছে!',
        ]);
    }

    /**
     * Remove the specified category.
     */
    public function destroy(InstitutionCategory $category)
    {
        $category->delete();

        return redirect()->route('admin.institutions.categories.index')
            ->with('success', 'ক্যাটাগরি মুছে ফেলা হয়েছে!');
    }
}

