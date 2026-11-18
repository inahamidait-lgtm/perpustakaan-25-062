<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionController extends Controller
{
    public function index()
    {
        $roles = Role::with('permissions')
            ->where('guard_name', 'web')
            ->get();

        $permissions = Permission::where('guard_name', 'web')
            ->get();

        return view('admin.role-permission.index', compact(
            'roles',
            'permissions'
        ));
    }

    public function update(Request $request, Role $role)
    {
        $validated = $request->validate([
            'permissions' => ['nullable', 'array'],
            'permissions.*' => ['exists:permissions,name'],
        ]);

        $role->syncPermissions($validated['permissions'] ?? []);

        return redirect()
            ->route('admin.role-permission.index')
            ->with('success', 'Hak akses berhasil diperbarui.');
    }
}