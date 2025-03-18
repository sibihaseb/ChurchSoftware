<?php

namespace App\Http\Controllers\Dashboard;

use App\DataTables\RoleDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\RoleRequest;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;

class RolePermissionController extends Controller
{
    public function roletable(RoleDataTable $datatable)
    {
        return $datatable->render('dashboard.roles.roletable');
    }

    public function rolestore(RoleRequest $request)
    {
        $input = $request->validated();
        $role =  Role::create(['name' => $input['rolename']]);
        $role->givePermissionTo($input['permission']);
        return redirect('admin/roletable');
    }

    public function editrole($id)
    {

        if (request()->ajax()) {
            $data = Role::findOrFail($id);
            return response()->json(['result' => $data]);
        }
    }

    public function editafter($id)
    {

        $allPermission = [];
        $Permissioncheck = [];
        $roledetail = Role::whereId($id)->select()->get();
        $role = Role::findById($id);
        $permissions = $role->permissions()->get();
        $permissions1 = Permission::get();
        foreach ($permissions1 as $permission) {
            $allPermission[$permission->name] = $permission->name;
        }
        foreach ($permissions as $permission) {
            $Permissioncheck[$permission->name] = $permission->name;
        }
        // dd($Permissioncheck);
        return view('dashboard.roles.editrole', compact('role', 'allPermission', 'Permissioncheck', 'roledetail'));
    }

    public function createrole()
    {
        $allPermission = [];
        $permissions = Permission::get();
        foreach ($permissions as $permission) {
            $allPermission[$permission->name] = $permission->name;
        }
        // dd($allPermission);
        return view('dashboard.roles.createrole', compact('allPermission'));
    }

    public function roleupdate(Request $request)
    {
        $role = Role::findById($request->hidden_id);
        $input = $request->permission;
        $role->syncPermissions($input);

        return redirect('admin/roletable');
    }
    public function destroy($id)
    {
        $role = Role::findOrFail($id);

        DB::transaction(function () use ($role) {
            if ($role) {
                // Delete the role
                $role->delete();
            }
        }, 1);
        // Return a JSON response to indicate success
        return response()->json(['success' => __('Role Deleted Successfully')]);
    }
}
