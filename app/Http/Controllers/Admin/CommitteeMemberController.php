<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Committee;
use App\Models\CommitteeMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CommitteeMemberController extends Controller
{
    /**
     * Display a listing of committee members.
     */
    public function index(Request $request)
    {
        $query = CommitteeMember::with('committee')->orderBy('order', 'asc')->orderBy('id', 'asc');

        if ($request->filled('committee_id')) {
            $query->where('committee_id', $request->committee_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('title', 'like', "%{$search}%");
            });
        }

        $members = $query->paginate(20)->withQueryString();
        $committees = Committee::all();

        return view('admin.committees.members.index', compact('members', 'committees'));
    }

    /**
     * Show the form for creating a new committee member.
     */
    public function create()
    {
        $committees = Committee::all();
        $nextOrder = (CommitteeMember::max('order') ?? 0) + 1;
        return view('admin.committees.members.create', compact('committees', 'nextOrder'));
    }

    /**
     * Store a newly created committee member in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'committee_id' => 'nullable|exists:committees,id',
            'name' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'order' => 'required|integer',
            'status' => 'nullable|boolean',
        ]);

        $data = [
            'committee_id' => $validated['committee_id'] ?? null,
            'name' => $validated['name'],
            'title' => $validated['title'],
            'order' => $validated['order'],
            'status' => $request->has('status') ? true : false,
        ];

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('committee_members', 'public');
        }

        CommitteeMember::create($data);

        return redirect()->route('admin.committee-members.index')->with('success', 'সদস্য সফলভাবে যুক্ত করা হয়েছে।');
    }

    /**
     * Show the form for editing the specified committee member.
     */
    public function edit(CommitteeMember $committeeMember)
    {
        $committees = Committee::all();
        return view('admin.committees.members.edit', compact('committeeMember', 'committees'));
    }

    /**
     * Update the specified committee member in storage.
     */
    public function update(Request $request, CommitteeMember $committeeMember)
    {
        $validated = $request->validate([
            'committee_id' => 'nullable|exists:committees,id',
            'name' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'order' => 'required|integer',
            'status' => 'nullable|boolean',
        ]);

        $data = [
            'committee_id' => $validated['committee_id'] ?? null,
            'name' => $validated['name'],
            'title' => $validated['title'],
            'order' => $validated['order'],
            'status' => $request->has('status') ? true : false,
        ];

        if ($request->hasFile('photo')) {
            if ($committeeMember->photo && !str_starts_with($committeeMember->photo, 'assets/') && Storage::disk('public')->exists($committeeMember->photo)) {
                Storage::disk('public')->delete($committeeMember->photo);
            }
            $data['photo'] = $request->file('photo')->store('committee_members', 'public');
        }

        $committeeMember->update($data);

        return redirect()->route('admin.committee-members.index')->with('success', 'সদস্যের তথ্য সফলভাবে আপডেট করা হয়েছে।');
    }

    /**
     * Toggle active status.
     */
    public function toggleStatus(CommitteeMember $committeeMember)
    {
        $committeeMember->status = !$committeeMember->status;
        $committeeMember->save();

        return response()->json([
            'success' => true,
            'status' => $committeeMember->status,
            'message' => 'স্ট্যাটাস সফলভাবে পরিবর্তিত হয়েছে।',
        ]);
    }

    /**
     * Remove the specified committee member from storage.
     */
    public function destroy(CommitteeMember $committeeMember)
    {
        if ($committeeMember->photo && !str_starts_with($committeeMember->photo, 'assets/') && Storage::disk('public')->exists($committeeMember->photo)) {
            Storage::disk('public')->delete($committeeMember->photo);
        }

        $committeeMember->delete();

        return redirect()->route('admin.committee-members.index')->with('success', 'সদস্যের তথ্য সফলভাবে মুছে ফেলা হয়েছে।');
    }
}

