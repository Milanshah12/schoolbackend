<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoleRequest;
use App\Models\RoleModel;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Contracts\DataTable;
use Yajra\DataTables\Facades\DataTables;

class RoleController extends Controller
{
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

}
