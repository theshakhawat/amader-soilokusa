<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Office;
use App\Models\OfficeMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class OfficeController extends Controller
{
    /**
     * Display a listing of offices.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $offices = Office::withCount('members')
            ->when($search, function ($query, $search) {
                return $query->where('name', 'like', "%{$search}%")
                    ->orWhere('location', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            })
            ->orderBy('order', 'asc')
            ->latest('id')
            ->paginate(15)
            ->withQueryString();

        return view('admin.offices.index', compact('offices', 'search'));
    }

    /**
     * Show form for creating a new office.
     */
    public function create()
    {
        return view('admin.offices.create');
    }

    /**
     * Store a newly created office.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'                    => 'required|string|max:255',
            'slug'                    => 'nullable|string|max:255|unique:offices,slug',
            'location'                => 'nullable|string|max:255',
            'image'                   => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:4096',
            'description'             => 'nullable|string',
            'status'                  => 'nullable|boolean',
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
                    $baseSlug = 'office-' . uniqid();
                }
                $slug = $baseSlug;
                $count = 1;
                while (Office::where('slug', $slug)->exists()) {
                    $slug = $baseSlug . '-' . $count++;
                }
                $validated['slug'] = $slug;
            } else {
                $validated['slug'] = Str::slug($validated['slug']);
            }

            $imagePath = null;
            if ($request->hasFile('image') && $request->file('image')->isValid()) {
                $imagePath = $request->file('image')->store('offices', 'public');
            }

            $office = Office::create([
                'name'        => $validated['name'],
                'slug'        => $validated['slug'],
                'location'    => $validated['location'] ?? null,
                'image'       => $imagePath,
                'description' => $validated['description'] ?? null,
                'status'      => $request->boolean('status', true),
            ]);

            // Save Members (কর্মকর্তাবৃন্দ)
            if ($request->has('members') && is_array($request->members)) {
                foreach ($request->members as $idx => $memberData) {
                    if (empty($memberData['name']) || empty($memberData['designation'])) {
                        continue;
                    }

                    $photoPath = null;
                    if (isset($memberData['photo']) && $memberData['photo'] instanceof \Illuminate\Http\UploadedFile && $memberData['photo']->isValid()) {
                        $photoPath = $memberData['photo']->store('offices/members', 'public');
                    }

                    OfficeMember::create([
                        'office_id'     => $office->id,
                        'name'          => $memberData['name'],
                        'designation'   => $memberData['designation'],
                        'photo'         => $photoPath,
                        'phone'         => $memberData['phone'] ?? null,
                        'email'         => $memberData['email'] ?? null,
                        'qualification' => $memberData['qualification'] ?? null,
                        'order'         => $idx + 1,
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('admin.offices.index')
                ->with('success', 'অফিস সফলভাবে যুক্ত করা হয়েছে!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'অফিস যুক্ত করতে সমস্যা হয়েছে: ' . $e->getMessage());
        }
    }

    /**
     * Show form for editing an office.
     */
    public function edit(Office $office)
    {
        $office->load('members');

        return view('admin.offices.edit', compact('office'));
    }

    /**
     * Update the specified office.
     */
    public function update(Request $request, Office $office)
    {
        $validated = $request->validate([
            'name'                    => 'required|string|max:255',
            'slug'                    => 'nullable|string|max:255|unique:offices,slug,' . $office->id,
            'location'                => 'nullable|string|max:255',
            'image'                   => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:4096',
            'description'             => 'nullable|string',
            'status'                  => 'nullable|boolean',
            'members'                 => 'nullable|array',
            'members.*.id'            => 'nullable|integer',
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
                    $baseSlug = 'office-' . uniqid();
                }
                $slug = $baseSlug;
                $count = 1;
                while (Office::where('slug', $slug)->where('id', '!=', $office->id)->exists()) {
                    $slug = $baseSlug . '-' . $count++;
                }
                $validated['slug'] = $slug;
            } else {
                $validated['slug'] = Str::slug($validated['slug']);
            }

            $imagePath = $office->image;
            if ($request->hasFile('image') && $request->file('image')->isValid()) {
                if ($office->image && Storage::disk('public')->exists($office->image)) {
                    Storage::disk('public')->delete($office->image);
                }
                $imagePath = $request->file('image')->store('offices', 'public');
            }

            $office->update([
                'name'        => $validated['name'],
                'slug'        => $validated['slug'],
                'location'    => $validated['location'] ?? null,
                'image'       => $imagePath,
                'description' => $validated['description'] ?? null,
                'status'      => $request->boolean('status', true),
            ]);

            // Sync Members
            $submittedMemberIds = [];
            if ($request->has('members') && is_array($request->members)) {
                foreach ($request->members as $idx => $memberData) {
                    if (empty($memberData['name']) || empty($memberData['designation'])) {
                        continue;
                    }

                    $memberId = $memberData['id'] ?? null;
                    $existingMember = $memberId ? OfficeMember::where('office_id', $office->id)->find($memberId) : null;

                    $photoPath = $existingMember ? $existingMember->photo : null;
                    if (isset($memberData['photo']) && $memberData['photo'] instanceof \Illuminate\Http\UploadedFile && $memberData['photo']->isValid()) {
                        if ($existingMember && $existingMember->photo && Storage::disk('public')->exists($existingMember->photo)) {
                            Storage::disk('public')->delete($existingMember->photo);
                        }
                        $photoPath = $memberData['photo']->store('offices/members', 'public');
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
                        $newMember = OfficeMember::create([
                            'office_id'     => $office->id,
                            'name'          => $memberData['name'],
                            'designation'   => $memberData['designation'],
                            'photo'         => $photoPath,
                            'phone'         => $memberData['phone'] ?? null,
                            'email'         => $memberData['email'] ?? null,
                            'qualification' => $memberData['qualification'] ?? null,
                            'order'         => $idx + 1,
                        ]);
                        $submittedMemberIds[] = $newMember->id;
                    }
                }
            }

            // Delete removed members
            $removedMembers = OfficeMember::where('office_id', $office->id)
                ->whereNotIn('id', $submittedMemberIds)
                ->get();

            foreach ($removedMembers as $rm) {
                if ($rm->photo && Storage::disk('public')->exists($rm->photo)) {
                    Storage::disk('public')->delete($rm->photo);
                }
                $rm->delete();
            }

            DB::commit();

            return redirect()->route('admin.offices.index')
                ->with('success', 'অফিস সফলভাবে আপডেট করা হয়েছে!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'অফিস আপডেট করতে সমস্যা হয়েছে: ' . $e->getMessage());
        }
    }

    /**
     * Toggle status via AJAX.
     */
    public function toggleStatus(Office $office)
    {
        $office->status = !$office->status;
        $office->save();

        return response()->json([
            'success' => true,
            'status'  => (bool) $office->status,
            'message' => 'অফিসের স্ট্যাটাস পরিবর্তন হয়েছে!',
        ]);
    }

    /**
     * Remove the specified office.
     */
    public function destroy(Office $office)
    {
        DB::beginTransaction();
        try {
            if ($office->image && Storage::disk('public')->exists($office->image)) {
                Storage::disk('public')->delete($office->image);
            }
            foreach ($office->members as $mem) {
                if ($mem->photo && Storage::disk('public')->exists($mem->photo)) {
                    Storage::disk('public')->delete($mem->photo);
                }
            }

            $office->delete();
            DB::commit();

            return redirect()->route('admin.offices.index')
                ->with('success', 'অফিস মুছে ফেলা হয়েছে!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'অফিস মুছতে সমস্যা হয়েছে: ' . $e->getMessage());
        }
    }
}

