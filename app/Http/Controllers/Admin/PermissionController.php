<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    /**
     * Display a listing of permissions.
     */
    public function index()
    {
        $permissions = Permission::with('roles')->get();

        return view('admin.permissions.index', compact('permissions'));
    }

    /**
     * Store a newly created permission.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:permissions,name',
        ]);

        Permission::create([
            'name'       => $validated['name'],
            'guard_name' => 'web',
        ]);

        return redirect()->route('admin.permissions.index')->with('success', 'নতুন পারমিশন সফলভাবে তৈরি করা হয়েছে!');
    }

    /**
     * Delete a permission.
     */
    public function destroy(Permission $permission)
    {
        $permission->delete();

        return redirect()->route('admin.permissions.index')->with('success', 'পারমিশন সফলভাবে মুছে ফেলা হয়েছে!');
    }
}
