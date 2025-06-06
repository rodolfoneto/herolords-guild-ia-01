<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{
    Role,
    Permission,
};
use Illuminate\Http\Request;
use Inertia\Inertia;

class RoleController extends Controller
{
    public function __construct()
    {
        // Optional: Add middleware for permission checking here, e.g.:
        // $this->middleware('can:view roles')->only('index');
        // $this->middleware('can:create roles')->only(['create', 'store']);
        // $this->middleware('can:edit roles')->only(['edit', 'update']);
        // $this->middleware('can:delete roles')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::latest()->with('permissions')->paginate(10);
        return Inertia::render('Admin/Role/RoleIndex', compact('roles'));
        // return view('admin.roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $permissions = Permission::select('uuid', 'name')->get();
        return Inertia::render('Admin/Role/RoleCreate', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name',
            'permissions' => 'array',
            'permissions.*' => 'string|exists:permissions,name'
        ]);

        $role = Role::create(['name' => $request->name, 'guard_name' => 'web']);

        if ($request->has('permissions')) {
            $role->givePermissionTo($request->permissions);
        }

        // return redirect()->route('admin.roles.index')->with('success', 'Role created successfully.');
        return to_route('admin.roles.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        $permissions = Permission::query()->select('name')->get();//->pluck('name', 'uuid');
        $rolePermissions = $role->permissions->pluck('name')->toArray();
        // return view('admin.roles.edit', compact('role', 'permissions', 'rolePermissions'));
        return Inertia::render('Admin/Role/RoleEdit', compact('role', 'permissions', 'rolePermissions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name,' . $role->uuid . ',uuid',
            'permissions' => 'array',
            'permissions.*' => 'string|exists:permissions,name'
        ]);

        $role->name = $request->name;
        $role->save();

        if ($request->has('permissions')) {
            $role->syncPermissions($request->permissions);
        } else {
            $role->syncPermissions([]);
        }

        //  return redirect()->route('admin.roles.index')->with('success', 'Role updated successfully.');
        return to_route('admin.roles.index')->with('success', 'Role updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        if ($role->name === 'Super Admin') {
            return redirect()->route('admin.roles.index')->with('error', 'Cannot delete the Super Admin role.');
        }
        $role->delete();
        return redirect()->route('admin.roles.index')->with('success', 'Role deleted successfully.');
    }
}
