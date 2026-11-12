<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\ProjectPhoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProjectController extends Controller
{
    /**
     * Display a listing of projects.
     */
    public function index(Request $request)
    {
        $query = Project::withCount('photos')->orderBy('order_index', 'asc')->orderBy('id', 'desc');

        if ($request->filled('project_status')) {
            $query->where('project_status', $request->project_status);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status === '1' || $request->status === 'active');
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('title', 'like', "%{$search}%");
        }

        $projects = $query->paginate(12)->withQueryString();

        return view('admin.projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new project.
     */
    public function create()
    {
        return view('admin.projects.create');
    }

    /**
     * Store a newly created project in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'project_status' => 'required|in:running,completed,upcoming',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096',
            'photos.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096',
            'description' => 'nullable|string',
            'order_index' => 'nullable|integer',
            'status' => 'nullable|boolean',
        ]);

        $data = [
            'title' => $validated['title'],
            'slug' => Str::slug($validated['title']) . '-' . rand(100, 999),
            'project_status' => $validated['project_status'],
            'description' => $validated['description'] ?? null,
            'order_index' => $validated['order_index'] ?? 0,
            'status' => $request->has('status'),
        ];

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')->store('projects/thumbnails', 'public');
        }

        $project = Project::create($data);

        // Upload Gallery / Slide photos
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $idx => $photoFile) {
                $path = $photoFile->store('projects/photos', 'public');
                ProjectPhoto::create([
                    'project_id' => $project->id,
                    'image_path' => $path,
                    'caption' => $project->title . ' - ছবি ' . ($idx + 1),
                    'order_index' => $idx + 1,
                ]);
            }
        }

        return redirect()->route('admin.projects.index')->with('success', 'প্রকল্প সফলভাবে তৈরি করা হয়েছে!');
    }

    /**
     * Show the form for editing the specified project.
     */
    public function edit(Project $project)
    {
        $project->load('photos');
        return view('admin.projects.edit', compact('project'));
    }

    /**
     * Update the specified project in storage.
     */
    public function update(Request $request, Project $project)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'project_status' => 'required|in:running,completed,upcoming',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096',
            'photos.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096',
            'description' => 'nullable|string',
            'order_index' => 'nullable|integer',
            'status' => 'nullable|boolean',
        ]);

        $data = [
            'title' => $validated['title'],
            'project_status' => $validated['project_status'],
            'description' => $validated['description'] ?? null,
            'order_index' => $validated['order_index'] ?? $project->order_index,
            'status' => $request->has('status'),
        ];

        if ($request->hasFile('thumbnail')) {
            if ($project->thumbnail && Storage::disk('public')->exists($project->thumbnail)) {
                Storage::disk('public')->delete($project->thumbnail);
            }
            $data['thumbnail'] = $request->file('thumbnail')->store('projects/thumbnails', 'public');
        }

        $project->update($data);

        // Add additional photos if uploaded
        if ($request->hasFile('photos')) {
            $lastIndex = $project->photos()->max('order_index') ?? 0;
            foreach ($request->file('photos') as $idx => $photoFile) {
                $path = $photoFile->store('projects/photos', 'public');
                ProjectPhoto::create([
                    'project_id' => $project->id,
                    'image_path' => $path,
                    'caption' => $project->title,
                    'order_index' => $lastIndex + $idx + 1,
                ]);
            }
        }

        return redirect()->route('admin.projects.index')->with('success', 'প্রকল্প সফলভাবে হালনাগাদ করা হয়েছে!');
    }

    /**
     * Remove the specified project from storage.
     */
    public function destroy(Project $project)
    {
        if ($project->thumbnail && Storage::disk('public')->exists($project->thumbnail)) {
            Storage::disk('public')->delete($project->thumbnail);
        }

        foreach ($project->photos as $photo) {
            if ($photo->image_path && Storage::disk('public')->exists($photo->image_path)) {
                Storage::disk('public')->delete($photo->image_path);
            }
        }

        $project->delete();

        return redirect()->route('admin.projects.index')->with('success', 'প্রকল্প মুছে ফেলা হয়েছে!');
    }

    /**
     * Remove an individual photo from a project.
     */
    public function deletePhoto(ProjectPhoto $photo)
    {
        if ($photo->image_path && Storage::disk('public')->exists($photo->image_path)) {
            Storage::disk('public')->delete($photo->image_path);
        }

        $photo->delete();

        return response()->json([
            'success' => true,
            'message' => 'ছবি সফলভাবে মুছে ফেলা হয়েছে!'
        ]);
    }

    /**
     * AJAX Toggle Status
     */
    public function toggleStatus(Project $project)
    {
        $project->status = !$project->status;
        $project->save();

        return response()->json([
            'success' => true,
            'status' => $project->status,
            'message' => 'স্ট্যাটাস সফলভাবে পরিবর্তন করা হয়েছে!'
        ]);
    }
}

