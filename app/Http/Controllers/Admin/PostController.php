<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PostController extends Controller
{
    /**
     * Display a listing of posts.
     */
    public function index(Request $request)
    {
        $query = Post::with('category')->orderBy('id', 'desc');

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('status')) {
            $query->where('status', filter_var($request->status, FILTER_VALIDATE_BOOLEAN));
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }

        $posts = $query->paginate(12)->withQueryString();
        $categories = Category::where('status', true)->orderBy('name')->get();

        return view('admin.blogs.posts.index', compact('posts', 'categories'));
    }

    /**
     * Show the form for creating a new post.
     */
    public function create()
    {
        $categories = Category::where('status', true)->orderBy('name')->get();
        return view('admin.blogs.posts.create', compact('categories'));
    }

    /**
     * Store a newly created post in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title'       => 'required|string|max:255',
            'slug'        => 'nullable|string|max:255|unique:posts,slug',
            'thumbnail'   => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096',
            'content'     => 'nullable|string',
            'status'      => 'nullable|boolean',
            'published'   => 'nullable|date',
        ]);

        $slug = !empty($validated['slug'])
            ? Str::slug($validated['slug'])
            : (Str::slug($validated['title']) . '-' . rand(100, 999));

        $data = [
            'category_id' => $validated['category_id'],
            'title'       => $validated['title'],
            'slug'        => $slug,
            'content'     => $validated['content'] ?? null,
            'status'      => $request->has('status'),
            'published'   => !empty($validated['published']) ? $validated['published'] : now(),
        ];

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')->store('blogs/thumbnails', 'public');
        }

        Post::create($data);

        return redirect()->route('admin.posts.index')->with('success', 'ব্লগ পোস্ট সফলভাবে তৈরি করা হয়েছে!');
    }

    /**
     * Show the form for editing the specified post.
     */
    public function edit(Post $post)
    {
        $categories = Category::where('status', true)->orderBy('name')->get();
        return view('admin.blogs.posts.edit', compact('post', 'categories'));
    }

    /**
     * Update the specified post in storage.
     */
    public function update(Request $request, Post $post)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title'       => 'required|string|max:255',
            'slug'        => 'nullable|string|max:255|unique:posts,slug,' . $post->id,
            'thumbnail'   => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096',
            'content'     => 'nullable|string',
            'status'      => 'nullable|boolean',
            'published'   => 'nullable|date',
        ]);

        $slug = !empty($validated['slug'])
            ? Str::slug($validated['slug'])
            : (Str::slug($validated['title']) . '-' . rand(100, 999));

        $data = [
            'category_id' => $validated['category_id'],
            'title'       => $validated['title'],
            'slug'        => $slug,
            'content'     => $validated['content'] ?? null,
            'status'      => $request->has('status'),
            'published'   => !empty($validated['published']) ? $validated['published'] : $post->published,
        ];

        if ($request->hasFile('thumbnail')) {
            if ($post->thumbnail && Storage::disk('public')->exists($post->thumbnail)) {
                Storage::disk('public')->delete($post->thumbnail);
            }
            $data['thumbnail'] = $request->file('thumbnail')->store('blogs/thumbnails', 'public');
        }

        $post->update($data);

        return redirect()->route('admin.posts.index')->with('success', 'ব্লগ পোস্ট সফলভাবে হালনাগাদ করা হয়েছে!');
    }

    /**
     * Remove the specified post from storage.
     */
    public function destroy(Post $post)
    {
        if ($post->thumbnail && Storage::disk('public')->exists($post->thumbnail)) {
            Storage::disk('public')->delete($post->thumbnail);
        }

        $post->delete();

        return redirect()->route('admin.posts.index')->with('success', 'ব্লগ পোস্ট মুছে ফেলা হয়েছে!');
    }

    /**
     * AJAX toggle post status.
     */
    public function toggleStatus(Post $post)
    {
        $post->status = !$post->status;
        $post->save();

        return response()->json([
            'success' => true,
            'status'  => $post->status,
            'message' => 'ব্লগ পোস্টের স্ট্যাটাস পরিবর্তিত হয়েছে!',
        ]);
    }
}

