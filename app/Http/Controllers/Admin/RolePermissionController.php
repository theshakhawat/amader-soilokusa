<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionController extends Controller
{
    /**
     * Display a listing of roles in a clean, modern table.
     */
    public function index()
    {
        // Hide super-admin from table, keep all operational roles
        $roles = Role::where('name', '!=', 'super-admin')
            ->withCount(['permissions', 'users'])
            ->orderBy('id', 'asc')
            ->get();

        $modules = config('permission_modules.modules', []);

        return view('admin.roles.index', compact('roles', 'modules'));
    }

    /**
     * Dedicated Role Permission Assignment Matrix view.
     */
    public function editRolePermissions(Role $role)
    {
        if ($role->name === 'super-admin') {
            return redirect()->route('admin.roles.index')->with('error', 'সুপার-এডমিন রোলে ডিফল্টভাবে সকল পারমিশন কার্যকর থাকে।');
        }

        $allRoles = Role::where('name', '!=', 'super-admin')
            ->orderBy('id', 'asc')
            ->get();

        $modules = config('permission_modules.modules', []);
        $rolePermissions = $role->permissions->pluck('name')->toArray();

        return view('admin.roles.permissions', compact('role', 'allRoles', 'modules', 'rolePermissions'));
    }

    /**
     * Store a newly created role.
     */
    public function storeRole(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
        ]);

        $rawName = trim($validated['name']);
        $roleSlug = Str::slug($rawName);

        if (empty($roleSlug)) {
            $roleSlug = 'role-' . time();
        }

        // Prevent spoofing system names
        if (in_array($roleSlug, ['super-admin'])) {
            return redirect()->back()->with('error', 'এই নামের রোল তৈরি করার অনুমতি নেই!');
        }

        if (Role::where('name', $roleSlug)->exists()) {
            return redirect()->back()->with('error', 'এই নামের রোল ইতিমধ্যে বিদ্যমান! অন্য নাম দিন।');
        }

        $role = Role::create([
            'name'       => $roleSlug,
            'guard_name' => 'web',
        ]);

        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Redirect directly to permission assignment page for the new role
        return redirect()->route('admin.roles.permissions', $role)
            ->with('success', "নতুন রোল '{$rawName}' সফলভাবে তৈরি হয়েছে! এখন এর জন্য প্রয়োজনীয় পারমিশন সিলেক্ট করে সংরক্ষণ করুন।");
    }

    /**
     * Update role name.
     */
    public function updateRole(Request $request, Role $role)
    {
        if (in_array($role->name, ['super-admin', 'admin', 'member'])) {
            return redirect()->back()->with('error', 'সিস্টেমের ডিফল্ট রোল পরিবর্তন করা যাবে না!');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:100',
        ]);

        $roleSlug = Str::slug(trim($validated['name']));

        if (Role::where('name', $roleSlug)->where('id', '!=', $role->id)->exists()) {
            return redirect()->back()->with('error', 'এই নামের অন্য একটি রোল ইতিমধ্যে বিদ্যমান!');
        }

        $role->name = $roleSlug;
        $role->save();

        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        return redirect()->route('admin.roles.index')->with('success', 'রোলের নাম সফলভাবে আপডেট করা হয়েছে!');
    }

    /**
     * Update permissions for a specified role.
     */
    public function updateRolePermissions(Request $request, Role $role)
    {
        if ($role->name === 'super-admin') {
            abort(403, 'সুপার-এডমিন রোলের পারমিশন পরিবর্তন করা যাবে না।');
        }

        $validated = $request->validate([
            'permissions'   => 'nullable|array',
            'permissions.*' => 'string|exists:permissions,name',
        ]);

        $permissions = $validated['permissions'] ?? [];
        $role->syncPermissions($permissions);

        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $count = count($permissions);
        return redirect()->route('admin.roles.permissions', $role)
            ->with('success', "'{$role->name}' রোলের জন্য মোট {$count}টি পারমিশন সফলভাবে বরাদ্দ ও সংরক্ষিত হয়েছে!");
    }

    /**
     * Delete a role.
     */
    public function destroyRole(Role $role)
    {
        if (in_array($role->name, ['super-admin', 'admin', 'member', 'manager'])) {
            return redirect()->back()->with('error', 'সিস্টেমের প্রাথমিক বা ডিফল্ট রোল মুছে ফেলা যাবে না!');
        }

        if ($role->users()->count() > 0) {
            return redirect()->back()->with('error', 'এই রোলে ব্যবহারকারী নিবন্ধিত থাকায় এটি মুছে ফেলা যাবে না! আগে সংশ্লিষ্ট ব্যবহারকারীদের রোল পরিবর্তন করুন।');
        }

        $role->delete();

        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        return redirect()->route('admin.roles.index')->with('success', 'রোলটি সফলভাবে মুছে ফেলা হয়েছে!');
    }
}
