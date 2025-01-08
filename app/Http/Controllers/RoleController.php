<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoleRequest;
use App\Models\RoleModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Contracts\DataTable;
use Yajra\DataTables\Facades\DataTables;

class RoleController extends Controller
{

    public function __construct(){
        $this->middleware('permission:view_role',['only'=>['index']]);
        $this->middleware('permission:add_role',['only'=>['create','store']]);
        $this->middleware('permission:add_edit_permission_to_role',['only'=>['addPermissionToRole','givePermissionToRole']]);

        $this->middleware('permission:edit_role',['only'=>['update','edit']]);

        $this->middleware('permission:delete_role',['only'=>['destroy']]);


    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            $roles = RoleModel::query();
            return DataTables::of($roles)->make(true);
        }
        return view('roles.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('roles.create');

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RoleRequest $request)
    {

        RoleModel::create([
            'name' => $request->role,
            'guard_name' => 'web'
        ]);
        return redirect()->route('roles.index')->with('message', 'New Role added successfully!');
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $role = RoleModel::findOrFail($id);

        return view('roles.edit', compact('role'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RoleRequest $request, Role $role)
    {



        $role->Update([
            'name' => $request->role
        ]);
        return redirect()->route('roles.index')->with('message', 'Role Update successfully!');


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $roles = Role::find($id);
        $roles->delete();
        return redirect()->back()->with('message', 'Role deleted successfully!');
    }


    public function addPermissionToRole($roleId){

        $role=Role::findOrFail($roleId);
        $permission=Permission::get();
        $rolePermission=DB::table('role_has_permissions')
        ->where('role_id',$roleId)
        ->pluck('role_has_permissions.permission_id','role_has_permissions.permission_id')
        ->all();
        $data=compact('role','permission','rolePermission');
        return view('roles.role_permission',$data);
    }

    public function givePermissionToRole(Request $request, $roleId){
        $request->validate([
            'permission'=>'required'
        ]);
        $role=Role::findOrFail($roleId);
        $role->syncPermissions($request->permission);
        return redirect()->back()->with('status','permission Added to role');

    }

}
