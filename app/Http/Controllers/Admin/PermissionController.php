<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{

    public function index()
    {
        $permissions = Permission::with('roles')->paginate(10);

        return view('admin.permissions.index')->with([
            'permissions' => $permissions
        ]);
    }

    public function create()
    {
        return view('admin.permissions.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => [
                'string',
                'required',
            ],
        ]);

        Permission::create(['name' => $request->name]);
        
        return redirect()->route('admin.permissions.index')->with('status', 'Successfully created permission!');
    }

    public function show($id)
    {
        //
    }

    public function edit(Permission $permission)
    {
        return view('admin.permissions.edit')->with([
            'permission' => $permission
        ]);
    }

    public function update(Request $request, Permission $permission)
    {
        $request->validate([
            'name' => [
                'string',
                'required',
            ],
        ]);

        $permission->update($request->all());

        return redirect()->route('admin.permissions.index')->with('status', 'Successfully updated permission!');
    }

    public function destroy($id)
    {
        Permission::find($id)->delete();
        return back();
    }
}
