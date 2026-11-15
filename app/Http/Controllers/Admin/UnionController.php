<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NavItem;
use App\Models\Union;
use App\Models\UnionImage;
use App\Models\UnionMember;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class UnionController extends Controller
{
    /**
     * Display a listing of unions.
     */
    public function index(Request $request): View
    {
        $search = trim((string)$request->input('search'));

        $unions = Union::withCount(['images', 'members'])
            ->with(['members' => function ($q) {
                $q->orderBy('order', 'asc');
            }])
            ->when($search, function ($query, $search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('location', 'like', "%{$search}%")
                      ->orWhere('description', 'like', "%{$search}%");
                });
            })
            ->orderBy('order', 'asc')
            ->orderBy('id', 'asc')
            ->paginate(15)
            ->withQueryString();

        $totalUnions = Union::count();
        $activeUnions = Union::where('status', true)->count();
        $totalMembers = UnionMember::count();

        return view('admin.unions.index', compact('unions', 'totalUnions', 'activeUnions', 'totalMembers', 'search'));
    }

    /**
     * Show form for creating a new union.
     */
    public function create(): View
    {
        return view('admin.unions.create');
    }

    /**
     * Store a newly created union.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name'              => 'required|string|max:255',
            'slug'              => 'nullable|string|max:255|unique:unions,slug',
            'short_description' => 'nullable|string|max:500',
            'description'       => 'nullable|string',
            'location'          => 'nullable|string|max:255',
            'map_url'           => 'nullable|string|max:1000',
            'phone'             => 'nullable|string|max:64',
            'email'             => 'nullable|email|max:128',
            'area_sq_km'        => 'nullable|string|max:32',
            'population'        => 'nullable|string|max:64',
            'voter_count'       => 'nullable|string|max:64',
            'village_count'     => 'nullable|string|max:32',
            'mouza_count'       => 'nullable|string|max:32',
            'literacy_rate'     => 'nullable|string|max:32',
            'status'            => 'nullable|boolean',
            'order'             => 'nullable|integer',
            'images.*'          => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:4096',
            'members'           => 'nullable|array',
            'members.*.name'          => 'required|string|max:255',
            'members.*.designation'   => 'required|string|max:255',
            'members.*.member_type'   => 'nullable|string|in:chairman,member,female_member',
            'members.*.qualification' => 'nullable|string|max:255',
            'members.*.phone'         => 'nullable|string|max:64',
            'members.*.email'         => 'nullable|email|max:128',
            'members.*.photo'         => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ], [
            'name.required' => 'ইউনিয়নের নাম আবশ্যক।',
        ]);

        DB::beginTransaction();
        try {
            if (empty($validated['slug'])) {
                $baseSlug = Str::slug($validated['name']);
                if (empty($baseSlug)) {
                    $baseSlug = 'union-' . uniqid();
                }
                $slug = $baseSlug;
                $count = 1;
                while (Union::where('slug', $slug)->exists()) {
                    $slug = $baseSlug . '-' . $count++;
                }
                $validated['slug'] = $slug;
            } else {
                $validated['slug'] = Str::slug($validated['slug']);
            }

            $union = Union::create([
                'name'              => $validated['name'],
                'slug'              => $validated['slug'],
                'short_description' => $validated['short_description'] ?? null,
                'description'       => $validated['description'] ?? null,
                'location'          => $validated['location'] ?? null,
                'map_url'           => $validated['map_url'] ?? null,
                'phone'             => $validated['phone'] ?? null,
                'email'             => $validated['email'] ?? null,
                'area_sq_km'        => $validated['area_sq_km'] ?? null,
                'population'        => $validated['population'] ?? null,
                'voter_count'       => $validated['voter_count'] ?? null,
                'village_count'     => $validated['village_count'] ?? null,
                'mouza_count'       => $validated['mouza_count'] ?? null,
                'literacy_rate'     => $validated['literacy_rate'] ?? null,
                'status'            => $request->boolean('status', true),
                'order'             => (int) ($validated['order'] ?? 0),
            ]);

            // Handle slider images
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $idx => $imageFile) {
                    $path = $imageFile->store('unions/gallery', 'public');
                    UnionImage::create([
                        'union_id'   => $union->id,
                        'image_path' => $path,
                        'order'      => $idx,
                    ]);
                }
            }

            // Handle members
            if (!empty($validated['members'])) {
                foreach ($validated['members'] as $mIdx => $m) {
                    $photoPath = null;
                    if (isset($m['photo']) && $m['photo'] instanceof \Illuminate\Http\UploadedFile) {
                        $photoPath = $m['photo']->store('unions/members', 'public');
                    }

                    UnionMember::create([
                        'union_id'      => $union->id,
                        'name'          => $m['name'],
                        'designation'   => $m['designation'],
                        'member_type'   => $m['member_type'] ?? (str_contains($m['designation'], 'চেয়ারম্যান') ? 'chairman' : 'member'),
                        'qualification' => $m['qualification'] ?? null,
                        'phone'         => $m['phone'] ?? null,
                        'email'         => $m['email'] ?? null,
                        'photo'         => $photoPath,
                        'order'         => $mIdx,
                    ]);
                }
            }

            // Sync NavItem
            $unionParent = NavItem::where('title', 'ইউনিয়ন পরিচিতি')->first();
            if ($unionParent) {
                NavItem::updateOrCreate(
                    ['url' => '/unions/' . $union->slug],
                    [
                        'parent_id' => $unionParent->id,
                        'title'     => str_replace([' ইউনিয়ন পরিষদ', ' ইউনিয়ন পরিষদ'], '', $union->name),
                        'order'     => (int) ($union->order ?: 0),
                        'status'    => (bool) $union->status,
                    ]
                );
            }

            DB::commit();

            return redirect()->route('admin.unions.index')
                ->with('success', 'ইউনিয়ন সফলভাবে যুক্ত করা হয়েছে।');
        } catch (\Throwable $e) {
            DB::rollBack();

            return back()->withInput()->with('error', 'ইউনিয়ন সংরক্ষণে ত্রুটি: ' . $e->getMessage());
        }
    }

    /**
     * Show form for editing union.
     */
    public function edit(Union $union): View
    {
        $union->load(['images', 'members']);

        return view('admin.unions.edit', compact('union'));
    }

    /**
     * Update union.
     */
    public function update(Request $request, Union $union): RedirectResponse
    {
        $validated = $request->validate([
            'name'              => 'required|string|max:255',
            'slug'              => 'nullable|string|max:255|unique:unions,slug,' . $union->id,
            'short_description' => 'nullable|string|max:500',
            'description'       => 'nullable|string',
            'location'          => 'nullable|string|max:255',
            'map_url'           => 'nullable|string|max:1000',
            'phone'             => 'nullable|string|max:64',
            'email'             => 'nullable|email|max:128',
            'area_sq_km'        => 'nullable|string|max:32',
            'population'        => 'nullable|string|max:64',
            'voter_count'       => 'nullable|string|max:64',
            'village_count'     => 'nullable|string|max:32',
            'mouza_count'       => 'nullable|string|max:32',
            'literacy_rate'     => 'nullable|string|max:32',
            'status'            => 'nullable|boolean',
            'order'             => 'nullable|integer',
            'images.*'          => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:4096',
            'delete_images'     => 'nullable|array',
            'delete_images.*'   => 'integer|exists:union_images,id',
            'members'           => 'nullable|array',
            'members.*.id'            => 'nullable|integer',
            'members.*.name'          => 'required|string|max:255',
            'members.*.designation'   => 'required|string|max:255',
            'members.*.member_type'   => 'nullable|string|in:chairman,member,female_member',
            'members.*.qualification' => 'nullable|string|max:255',
            'members.*.phone'         => 'nullable|string|max:64',
            'members.*.email'         => 'nullable|email|max:128',
            'members.*.photo'         => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'delete_members'          => 'nullable|array',
            'delete_members.*'        => 'integer|exists:union_members,id',
        ], [
            'name.required' => 'ইউনিয়নের নাম আবশ্যক।',
        ]);

        DB::beginTransaction();
        try {
            if (empty($validated['slug'])) {
                $baseSlug = Str::slug($validated['name']);
                if (empty($baseSlug)) {
                    $baseSlug = 'union-' . uniqid();
                }
                $slug = $baseSlug;
                $count = 1;
                while (Union::where('slug', $slug)->where('id', '!=', $union->id)->exists()) {
                    $slug = $baseSlug . '-' . $count++;
                }
                $validated['slug'] = $slug;
            } else {
                $validated['slug'] = Str::slug($validated['slug']);
            }

            $union->update([
                'name'              => $validated['name'],
                'slug'              => $validated['slug'],
                'short_description' => $validated['short_description'] ?? null,
                'description'       => $validated['description'] ?? null,
                'location'          => $validated['location'] ?? null,
                'map_url'           => $validated['map_url'] ?? null,
                'phone'             => $validated['phone'] ?? null,
                'email'             => $validated['email'] ?? null,
                'area_sq_km'        => $validated['area_sq_km'] ?? null,
                'population'        => $validated['population'] ?? null,
                'voter_count'       => $validated['voter_count'] ?? null,
                'village_count'     => $validated['village_count'] ?? null,
                'mouza_count'       => $validated['mouza_count'] ?? null,
                'literacy_rate'     => $validated['literacy_rate'] ?? null,
                'status'            => $request->boolean('status', true),
                'order'             => (int) ($validated['order'] ?? 0),
            ]);

            // Handle deleted images
            if (!empty($validated['delete_images'])) {
                $imagesToDelete = UnionImage::where('union_id', $union->id)
                    ->whereIn('id', $validated['delete_images'])
                    ->get();
                foreach ($imagesToDelete as $delImg) {
                    if ($delImg->image_path && Storage::disk('public')->exists($delImg->image_path)) {
                        Storage::disk('public')->delete($delImg->image_path);
                    }
                    $delImg->delete();
                }
            }

            // Handle newly uploaded images
            if ($request->hasFile('images')) {
                $currentMaxOrder = (int) UnionImage::where('union_id', $union->id)->max('order');
                foreach ($request->file('images') as $idx => $imageFile) {
                    $path = $imageFile->store('unions/gallery', 'public');
                    UnionImage::create([
                        'union_id'   => $union->id,
                        'image_path' => $path,
                        'order'      => $currentMaxOrder + $idx + 1,
                    ]);
                }
            }

            // Handle deleted members
            if (!empty($validated['delete_members'])) {
                $membersToDelete = UnionMember::where('union_id', $union->id)
                    ->whereIn('id', $validated['delete_members'])
                    ->get();
                foreach ($membersToDelete as $delMember) {
                    if ($delMember->photo && Storage::disk('public')->exists($delMember->photo)) {
                        Storage::disk('public')->delete($delMember->photo);
                    }
                    $delMember->delete();
                }
            }

            // Handle updated or created members
            if (!empty($validated['members'])) {
                foreach ($validated['members'] as $mIdx => $m) {
                    $memberId = $m['id'] ?? null;
                    $existingMember = $memberId ? UnionMember::where('union_id', $union->id)->find($memberId) : null;

                    $photoPath = $existingMember ? $existingMember->photo : null;
                    if (isset($m['photo']) && $m['photo'] instanceof \Illuminate\Http\UploadedFile) {
                        if ($existingMember && $existingMember->photo && Storage::disk('public')->exists($existingMember->photo)) {
                            Storage::disk('public')->delete($existingMember->photo);
                        }
                        $photoPath = $m['photo']->store('unions/members', 'public');
                    }

                    $memberData = [
                        'union_id'      => $union->id,
                        'name'          => $m['name'],
                        'designation'   => $m['designation'],
                        'member_type'   => $m['member_type'] ?? (str_contains($m['designation'], 'চেয়ারম্যান') ? 'chairman' : 'member'),
                        'qualification' => $m['qualification'] ?? null,
                        'phone'         => $m['phone'] ?? null,
                        'email'         => $m['email'] ?? null,
                        'photo'         => $photoPath,
                        'order'         => $mIdx,
                    ];

                    if ($existingMember) {
                        $existingMember->update($memberData);
                    } else {
                        UnionMember::create($memberData);
                    }
                }
            }

            // Sync NavItem
            $unionParent = NavItem::where('title', 'ইউনিয়ন পরিচিতি')->first();
            if ($unionParent) {
                NavItem::updateOrCreate(
                    ['url' => '/unions/' . $union->slug],
                    [
                        'parent_id' => $unionParent->id,
                        'title'     => str_replace([' ইউনিয়ন পরিষদ', ' ইউনিয়ন পরিষদ'], '', $union->name),
                        'order'     => (int) ($union->order ?: 0),
                        'status'    => (bool) $union->status,
                    ]
                );
            }

            DB::commit();

            return redirect()->route('admin.unions.index')
                ->with('success', 'ইউনিয়ন সফলভাবে আপডেট করা হয়েছে।');
        } catch (\Throwable $e) {
            DB::rollBack();

            return back()->withInput()->with('error', 'ইউনিয়ন আপডেটে ত্রুটি: ' . $e->getMessage());
        }
    }

    /**
     * Delete union.
     */
    public function destroy(Union $union): RedirectResponse
    {
        NavItem::where('url', '/unions/' . $union->slug)->delete();

        foreach ($union->images as $img) {
            if ($img->image_path && Storage::disk('public')->exists($img->image_path)) {
                Storage::disk('public')->delete($img->image_path);
            }
        }

        foreach ($union->members as $mem) {
            if ($mem->photo && Storage::disk('public')->exists($mem->photo)) {
                Storage::disk('public')->delete($mem->photo);
            }
        }

        $union->delete();

        return redirect()->route('admin.unions.index')
            ->with('success', 'ইউনিয়ন সফলভাবে মুছে ফেলা হয়েছে।');
    }

    /**
     * Toggle union active status.
     */
    public function toggleStatus(Union $union): RedirectResponse
    {
        $union->update(['status' => !$union->status]);

        // Keep NavItem in sync if exists
        NavItem::where('url', '/unions/' . $union->slug)
            ->update(['status' => (bool)$union->status]);

        return back()->with('success', 'ইউনিয়নের স্ট্যাটাস পরিবর্তন করা হয়েছে।');
    }
}

