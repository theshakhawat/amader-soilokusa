<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionController extends Controller
{
    /**
     * Display a listing of roles and their assigned permissions.
     */
    public function index()
    {
        $roles = Role::with('permissions')->withCount('users')->get();
        $permissions = Permission::all();

        return view('admin.roles.index', compact('roles', 'permissions'));
    }

    /**
     * Store a newly created role.
     */
    public function storeRole(Request $request)
    {
        $validated = $request->validate([
            'name'          => 'required|string|max:100|unique:roles,name',
            'permissions'   => 'nullable|array',
            'permissions.*' => 'exists:permissions,name',
        ]);

        $roleName = Str::slug($validated['name']);
        if (Role::where('name', $roleName)->exists()) {
            return redirect()->back()->with('error', 'এই নামের রোল ইতিমধ্যে বিদ্যমান!');
        }

        $role = Role::create([
            'name'       => $roleName,
            'guard_name' => 'web',
        ]);

        if (!empty($validated['permissions'])) {
            $role->syncPermissions($validated['permissions']);
        }

        return redirect()->route('admin.roles.index')->with('success', 'নতুন ভূমিকা (Role) সফলভাবে তৈরি করা হয়েছে!');
    }

    /**
     * Update permissions for a specified role.
     */
    public function updateRolePermissions(Request $request, Role $role)
    {
        $validated = $request->validate([
            'permissions'   => 'nullable|array',
            'permissions.*' => 'exists:permissions,name',
        ]);

        $role->syncPermissions($validated['permissions'] ?? []);

        return redirect()->route('admin.roles.index')->with('success', "'{$role->name}' রোলের পারমিশন সফলভাবে হালনাগাদ করা হয়েছে!");
    }

    /**
     * Delete a role.
     */
    public function destroyRole(Role $role)
    {
        if (in_array($role->name, ['super-admin', 'admin', 'member'])) {
            return redirect()->back()->with('error', 'সিস্টেমের ডিফল্ট রোল মুছে ফেলা যাবে না!');
        }

        if ($role->users()->count() > 0) {
            return redirect()->back()->with('error', 'এই রোলে ব্যবহারকারী থাকায় এটি মুছে ফেলা যাবে না! আগে ব্যবহারকারীদের রোল পরিবর্তন করুন।');
        }

        $role->delete();

        return redirect()->route('admin.roles.index')->with('success', 'ভূমিকা সফলভাবে মুছে ফেলা হয়েছে!');
    }
}

