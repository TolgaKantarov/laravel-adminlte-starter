<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{

    public function __construct()
    {
       $this->middleware(['can:user_management_access']);
    }

    public function index()
    {
        $roles = Role::with('users', 'permissions')->paginate(10);

        return view('admin.roles.index')->with([
            'roles' => $roles
        ]);
    }

    public function create()
    {
        $permissions = Permission::all()->pluck('name', 'id');

        return view('admin.roles.create')->with([
            'permissions' => $permissions
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => [
                'string',
                'required',
            ],
            'permissions.*' => [
                'integer',
            ],
            'permissions' => [
                'required',
                'array',
            ],
        ]);

        $role = Role::create(['name' => $request->name]);
        $role->permissions()->sync($request->input('permissions', []));

        return redirect()->route('admin.roles.index')->with('status', 'Successfully created role!');
    }

    public function show($id)
    {
        //
    }

    public function edit(Role $role)
    {
        $permissions = Permission::all()->pluck('name', 'id');
        $role->load('permissions');

        return view('admin.roles.edit')->with([
            'role' => $role,
            'permissions' => $permissions
        ]);
    }

    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => [
                'string',
                'required',
            ],
            'permissions.*' => [
                'integer',
            ],
            'permissions' => [
                'required',
                'array',
            ],
        ]);

        $role->update($request->all());
        $role->permissions()->sync($request->input('permissions', []));

        return redirect()->route('admin.roles.index')->with('status', 'Successfully updated role!');
    }

    public function destroy($id)
    {
        Role::find($id)->delete();
        return back();
    }
}
