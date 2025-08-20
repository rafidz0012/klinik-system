<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesController extends Controller
{
    public function __construct()
    {
        // Sesuaikan dengan permission yang Anda miliki
        $this->middleware('permission:manage roles and permissions'); 
    }

    // Metode untuk menambah Role baru
    public function store(Request $request)
    {
        $request->validate(['name' => 'required|unique:roles,name']);

        $role = Role::create(['name' => $request->name]);
        $role->syncPermissions($request->input('permissions', []));

        return redirect()->route('user.index')->with('success', 'Role berhasil ditambahkan!');
    }

    // Metode untuk memperbarui Role
    public function update(Request $request, Role $role)
    {
        $request->validate(['name' => 'required|unique:roles,name,' . $role->id]);
        
        $role->update(['name' => $request->name]);
        $role->syncPermissions($request->input('permissions', []));

        return redirect()->route('user.index')->with('success', 'Role berhasil diperbarui!');
    }

    // Metode untuk menghapus Role
    public function destroy(Role $role)
    {
        $role->delete();
        return redirect()->route('user.index')->with('success', 'Role berhasil dihapus!');
    }
}