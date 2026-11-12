<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of all users or active members based on filter.
     */
    public function index(Request $request)
    {
        $filter = $request->query('filter', 'all'); // 'all', 'members', 'pending'

        $query = User::with('roles')->orderBy('id', 'desc');

        if ($filter === 'members') {
            // Active members: role is member, not admin or super-admin
            $query->whereHas('roles', function ($q) {
                $q->where('name', 'member');
            })->whereDoesntHave('roles', function ($q) {
                $q->whereIn('name', ['admin', 'super-admin']);
            });
        } elseif ($filter === 'pending') {
            $query->where('status', 'pending');
        }

        if ($request->filled('role')) {
            $query->whereHas('roles', function ($q) use ($request) {
                $q->where('name', $request->role);
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        $users = $query->paginate(15)->withQueryString();
        $roles = Role::all();

        $totalUsers = User::count();
        $activeMembers = User::whereHas('roles', function ($q) {
            $q->where('name', 'member');
        })->whereDoesntHave('roles', function ($q) {
            $q->whereIn('name', ['admin', 'super-admin']);
        })->count();
        $pendingUsers = User::where('status', 'pending')->count();

        return view('admin.users.index', compact('users', 'roles', 'filter', 'totalUsers', 'activeMembers', 'pendingUsers'));
    }

    /**
     * Show the form for creating a new user.
     */
    public function create()
    {
        $roles = Role::all();
        return view('admin.users.create', compact('roles'));
    }

    /**
     * Store a newly created user in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|max:255|unique:users,email',
            'phone'    => 'nullable|string|max:20',
            'password' => 'required|string|min:6',
            'role'     => 'required|exists:roles,name',
            'status'   => 'required|in:active,inactive,pending',
            'photo'    => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $data = [
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'phone'    => $validated['phone'] ?? null,
            'password' => Hash::make($validated['password']),
            'status'   => $validated['status'],
        ];

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('users', 'public');
        }

        $user = User::create($data);
        $user->assignRole($validated['role']);

        return redirect()->route('admin.users.index')->with('success', 'ব্যবহারকারী সফলভাবে তৈরি করা হয়েছে!');
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit(User $user)
    {
        $roles = Role::all();
        $user->load('roles');
        return view('admin.users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified user in storage.
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|max:255|unique:users,email,' . $user->id,
            'phone'    => 'nullable|string|max:20',
            'password' => 'nullable|string|min:6',
            'role'     => 'required|exists:roles,name',
            'status'   => 'required|in:active,inactive,pending',
            'photo'    => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $data = [
            'name'   => $validated['name'],
            'email'  => $validated['email'],
            'phone'  => $validated['phone'] ?? null,
            'status' => $validated['status'],
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($validated['password']);
        }

        if ($request->hasFile('photo')) {
            if ($user->photo && Storage::disk('public')->exists($user->photo)) {
                Storage::disk('public')->delete($user->photo);
            }
            $data['photo'] = $request->file('photo')->store('users', 'public');
        }

        $user->update($data);
        $user->syncRoles([$validated['role']]);

        return redirect()->route('admin.users.index')->with('success', 'ব্যবহারকারীর তথ্য সফলভাবে হালনাগাদ করা হয়েছে!');
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error', 'আপনি নিজের অ্যাকাউন্ট ডিলিট করতে পারবেন না!');
        }

        if ($user->photo && Storage::disk('public')->exists($user->photo)) {
            Storage::disk('public')->delete($user->photo);
        }

        $user->delete();

        return redirect()->back()->with('success', 'ব্যবহারকারী মুছে ফেলা হয়েছে!');
    }

    /**
     * AJAX Toggle status
     */
    public function toggleStatus(User $user)
    {
        $user->status = ($user->status === 'active') ? 'inactive' : 'active';
        $user->save();

        return response()->json([
            'success' => true,
            'status'  => $user->status,
            'message' => 'স্ট্যাটাস পরিবর্তিত হয়েছে!',
        ]);
    }
}

