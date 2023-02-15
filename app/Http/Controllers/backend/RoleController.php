<?php

namespace App\Http\Controllers\backend;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    public function addRole()
    {
        $roles = Role::where('name', '!=', 'admin')->get();

        return view('backend.roles.addRoles', compact('roles'));
    }

    public function storeRole(Request $request)
    {
        $request->validate([
            'role' => 'unique:roles,name'
        ]);
        $role = Role::create(['name' => $request->role]);
        return back();
    }

    public function editRole($id)
    {
        $role = Role::with('permissions')->find($id);
        $permissions = Permission::get();
        $hasPermissions = $role->permissions->pluck('id');
        // dd($hasPermissions);
        return view('backend.roles.editRole', compact('role', 'permissions','hasPermissions'));
    }

    public function updateRole(Request $request, $id)
    {
        $role = Role::find($id);
        $role->name = $request->role;
        $role->save();
        $role->syncPermissions($request->permissions);
        return back();
    }
}
