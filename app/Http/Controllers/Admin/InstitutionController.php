<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Institution;
use App\Models\InstitutionCategory;
use App\Models\InstitutionImage;
use App\Models\InstitutionMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class InstitutionController extends Controller
{
    /**
     * Display a listing of institutions.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $categoryId = $request->input('category_id');

        $institutions = Institution::with(['category', 'images'])
            ->withCount(['images', 'members'])
            ->when($search, function ($query, $search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('location', 'like', "%{$search}%")
                      ->orWhere('description', 'like', "%{$search}%");
                });
            })
            ->when($categoryId, function ($query, $categoryId) {
                return $query->where('institution_category_id', $categoryId);
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $categories = InstitutionCategory::where('status', true)->get();

        return view('admin.institutions.index', compact('institutions', 'categories', 'search', 'categoryId'));
    }

    /**
     * Show form for creating a new institution.
     */
    public function create()
    {
        $categories = InstitutionCategory::where('status', true)->get();

        return view('admin.institutions.create', compact('categories'));
    }

    /**
     * Store a newly created institution.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'institution_category_id' => 'required|exists:institution_categories,id',
            'name'                    => 'required|string|max:255',
            'slug'                    => 'nullable|string|max:255|unique:institutions,slug',
            'location'                => 'nullable|string|max:255',
            'description'             => 'nullable|string',
            'status'                  => 'nullable|boolean',
            'images.*'                => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:4096',
            'members'                 => 'nullable|array',
            'members.*.name'          => 'required|string|max:255',
            'members.*.designation'   => 'required|string|max:255',
            'members.*.phone'         => 'nullable|string|max:50',
            'members.*.email'         => 'nullable|email|max:100',
            'members.*.qualification' => 'nullable|string|max:255',
            'members.*.photo'         => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        DB::beginTransaction();
        try {
            if (empty($validated['slug'])) {
                $baseSlug = Str::slug($validated['name']);
                if (empty($baseSlug)) {
                    $baseSlug = 'inst-' . uniqid();
                }
                $slug = $baseSlug;
                $count = 1;
                while (Institution::where('slug', $slug)->exists()) {
                    $slug = $baseSlug . '-' . $count++;
                }
                $validated['slug'] = $slug;
            } else {
                $validated['slug'] = Str::slug($validated['slug']);
            }

            $institution = Institution::create([
                'institution_category_id' => $validated['institution_category_id'],
                'name'                    => $validated['name'],
                'slug'                    => $validated['slug'],
                'location'                => $validated['location'] ?? null,
                'description'             => $validated['description'] ?? null,
                'status'                  => $request->boolean('status', true),
            ]);

            // Save Multiple Images (Slider)
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $idx => $image) {
                    if ($image->isValid()) {
                        $path = $image->store('institutions/sliders', 'public');
                        InstitutionImage::create([
                            'institution_id' => $institution->id,
                            'image_path'     => $path,
                            'order'          => $idx + 1,
                        ]);
                    }
                }
            }

            // Save Members (প্রধান শিক্ষক, সহকারী শিক্ষক ইত্যাদি)
            if ($request->has('members') && is_array($request->members)) {
                foreach ($request->members as $idx => $memberData) {
                    if (empty($memberData['name']) || empty($memberData['designation'])) {
                        continue;
                    }

                    $photoPath = null;
                    if (isset($memberData['photo']) && $memberData['photo'] instanceof \Illuminate\Http\UploadedFile && $memberData['photo']->isValid()) {
                        $photoPath = $memberData['photo']->store('institutions/members', 'public');
                    }

                    InstitutionMember::create([
                        'institution_id' => $institution->id,
                        'name'           => $memberData['name'],
                        'designation'    => $memberData['designation'],
                        'photo'          => $photoPath,
                        'phone'          => $memberData['phone'] ?? null,
                        'email'          => $memberData['email'] ?? null,
                        'qualification'  => $memberData['qualification'] ?? null,
                        'order'          => $idx + 1,
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('admin.institutions.index')
                ->with('success', 'প্রতিষ্ঠান সফলভাবে যুক্ত করা হয়েছে!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'প্রতিষ্ঠান যুক্ত করতে সমস্যা হয়েছে: ' . $e->getMessage());
        }
    }

    /**
     * Show form for editing an institution.
     */
    public function edit(Institution $institution)
    {
        $institution->load(['category', 'images', 'members']);
        $categories = InstitutionCategory::where('status', true)->get();

        return view('admin.institutions.edit', compact('institution', 'categories'));
    }

    /**
     * Update the specified institution.
     */
    public function update(Request $request, Institution $institution)
    {
        $validated = $request->validate([
            'institution_category_id' => 'required|exists:institution_categories,id',
            'name'                    => 'required|string|max:255',
            'slug'                    => 'nullable|string|max:255|unique:institutions,slug,' . $institution->id,
            'location'                => 'nullable|string|max:255',
            'description'             => 'nullable|string',
            'status'                  => 'nullable|boolean',
            'images.*'                => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:4096',
            'members'                 => 'nullable|array',
            'members.*.id'            => 'nullable|integer',
            'members.*.name'          => 'required|string|max:255',
            'members.*.designation'   => 'required|string|max:255',
            'members.*.phone'         => 'nullable|string|max:50',
            'members.*.email'         => 'nullable|email|max:100',
            'members.*.qualification' => 'nullable|string|max:255',
            'members.*.photo'         => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'delete_images'           => 'nullable|array',
            'delete_images.*'         => 'integer',
        ]);

        DB::beginTransaction();
        try {
            if (empty($validated['slug'])) {
                $baseSlug = Str::slug($validated['name']);
                if (empty($baseSlug)) {
                    $baseSlug = 'inst-' . uniqid();
                }
                $slug = $baseSlug;
                $count = 1;
                while (Institution::where('slug', $slug)->where('id', '!=', $institution->id)->exists()) {
                    $slug = $baseSlug . '-' . $count++;
                }
                $validated['slug'] = $slug;
            } else {
                $validated['slug'] = Str::slug($validated['slug']);
            }

            $institution->update([
                'institution_category_id' => $validated['institution_category_id'],
                'name'                    => $validated['name'],
                'slug'                    => $validated['slug'],
                'location'                => $validated['location'] ?? null,
                'description'             => $validated['description'] ?? null,
                'status'                  => $request->boolean('status', true),
            ]);

            // Handle deleted existing images
            if ($request->has('delete_images') && is_array($request->delete_images)) {
                $imagesToDelete = InstitutionImage::where('institution_id', $institution->id)
                    ->whereIn('id', $request->delete_images)
                    ->get();

                foreach ($imagesToDelete as $img) {
                    if (Storage::disk('public')->exists($img->image_path)) {
                        Storage::disk('public')->delete($img->image_path);
                    }
                    $img->delete();
                }
            }

            // Upload new images
            if ($request->hasFile('images')) {
                $maxOrder = InstitutionImage::where('institution_id', $institution->id)->max('order') ?? 0;
                foreach ($request->file('images') as $image) {
                    if ($image->isValid()) {
                        $maxOrder++;
                        $path = $image->store('institutions/sliders', 'public');
                        InstitutionImage::create([
                            'institution_id' => $institution->id,
                            'image_path'     => $path,
                            'order'          => $maxOrder,
                        ]);
                    }
                }
            }

            // Sync Members
            $submittedMemberIds = [];
            if ($request->has('members') && is_array($request->members)) {
                foreach ($request->members as $idx => $memberData) {
                    if (empty($memberData['name']) || empty($memberData['designation'])) {
                        continue;
                    }

                    $memberId = $memberData['id'] ?? null;
                    $existingMember = $memberId ? InstitutionMember::where('institution_id', $institution->id)->find($memberId) : null;

                    $photoPath = $existingMember ? $existingMember->photo : null;
                    if (isset($memberData['photo']) && $memberData['photo'] instanceof \Illuminate\Http\UploadedFile && $memberData['photo']->isValid()) {
                        // Delete previous photo if exists
                        if ($existingMember && $existingMember->photo && Storage::disk('public')->exists($existingMember->photo)) {
                            Storage::disk('public')->delete($existingMember->photo);
                        }
                        $photoPath = $memberData['photo']->store('institutions/members', 'public');
                    }

                    if ($existingMember) {
                        $existingMember->update([
                            'name'          => $memberData['name'],
                            'designation'   => $memberData['designation'],
                            'photo'         => $photoPath,
                            'phone'         => $memberData['phone'] ?? null,
                            'email'         => $memberData['email'] ?? null,
                            'qualification' => $memberData['qualification'] ?? null,
                            'order'         => $idx + 1,
                        ]);
                        $submittedMemberIds[] = $existingMember->id;
                    } else {
                        $newMember = InstitutionMember::create([
                            'institution_id' => $institution->id,
                            'name'           => $memberData['name'],
                            'designation'    => $memberData['designation'],
                            'photo'          => $photoPath,
                            'phone'          => $memberData['phone'] ?? null,
                            'email'          => $memberData['email'] ?? null,
                            'qualification'  => $memberData['qualification'] ?? null,
                            'order'          => $idx + 1,
                        ]);
                        $submittedMemberIds[] = $newMember->id;
                    }
                }
            }

            // Delete removed members
            $removedMembers = InstitutionMember::where('institution_id', $institution->id)
                ->whereNotIn('id', $submittedMemberIds)
                ->get();

            foreach ($removedMembers as $rm) {
                if ($rm->photo && Storage::disk('public')->exists($rm->photo)) {
                    Storage::disk('public')->delete($rm->photo);
                }
                $rm->delete();
            }

            DB::commit();

            return redirect()->route('admin.institutions.index')
                ->with('success', 'প্রতিষ্ঠান সফলভাবে আপডেট করা হয়েছে!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'প্রতিষ্ঠান আপডেট করতে সমস্যা হয়েছে: ' . $e->getMessage());
        }
    }

    /**
     * Toggle status via AJAX.
     */
    public function toggleStatus(Institution $institution)
    {
        $institution->status = !$institution->status;
        $institution->save();

        return response()->json([
            'success' => true,
            'status'  => (bool) $institution->status,
            'message' => 'প্রতিষ্ঠানের স্ট্যাটাস পরিবর্তন হয়েছে!',
        ]);
    }

    /**
     * Remove the specified institution.
     */
    public function destroy(Institution $institution)
    {
        DB::beginTransaction();
        try {
            foreach ($institution->images as $img) {
                if (Storage::disk('public')->exists($img->image_path)) {
                    Storage::disk('public')->delete($img->image_path);
                }
            }
            foreach ($institution->members as $mem) {
                if ($mem->photo && Storage::disk('public')->exists($mem->photo)) {
                    Storage::disk('public')->delete($mem->photo);
                }
            }

            $institution->delete();
            DB::commit();

            return redirect()->route('admin.institutions.index')
                ->with('success', 'প্রতিষ্ঠান মুছে ফেলা হয়েছে!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'প্রতিষ্ঠান মুছতে সমস্যা হয়েছে: ' . $e->getMessage());
        }
    }
}

