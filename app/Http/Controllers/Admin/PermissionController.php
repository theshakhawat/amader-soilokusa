<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    /**
     * Display a listing of system permissions categorized by module.
     * System permissions are protected and read-only (No delete option).
     */
    public function index()
    {
        $permissions = Permission::with('roles')->get()->keyBy('name');
        $modules = config('permission_modules.modules', []);

        return view('admin.permissions.index', compact('permissions', 'modules'));
    }
}
