<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission; // Use our custom Permission model
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function __construct()
    {
        // Optional: Add middleware for permission checking here, e.g.:
        // $this->middleware('can:view permissions')->only('index');
        // $this->middleware('can:create permissions')->only(['create', 'store']);
        // $this->middleware('can:edit permissions')->only(['edit', 'update']);
        // $this->middleware('can:delete permissions')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $permissions = Permission::latest()->paginate(10);
        return view('admin.permissions.index', compact('permissions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.permissions.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:permissions,name',
            // 'guard_name' => 'sometimes|string|max:255' // Only if you want to allow changing guard
        ]);

        Permission::create([
            'name' => $request->name,
            'guard_name' => $request->input('guard_name', 'web') // Default to 'web' if not provided
        ]);

        return redirect()->route('admin.permissions.index')->with('success', 'Permission created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Permission $permission)
    {
        return view('admin.permissions.show', compact('permission'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Permission $permission)
    {
        return view('admin.permissions.edit', compact('permission'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Permission $permission)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:permissions,name,' . $permission->uuid, // Use uuid here for unique check
            // 'guard_name' => 'sometimes|string|max:255'
        ]);

        $permission->name = $request->name;
        if ($request->filled('guard_name')) {
            $permission->guard_name = $request->guard_name;
        }
        $permission->save();

        return redirect()->route('admin.permissions.index')->with('success', 'Permission updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Permission $permission)
    {
        // Optional: Add checks here, e.g., prevent deletion of critical permissions
        // Be careful when deleting permissions, as it might affect roles and user access.
        $permission->delete();
        return redirect()->route('admin.permissions.index')->with('success', 'Permission deleted successfully.');
    }
}
