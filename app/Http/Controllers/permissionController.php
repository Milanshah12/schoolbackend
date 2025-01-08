<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Yajra\DataTables\Facades\DataTables;

class permissionController extends Controller
{

    public function __construct(){
        $this->middleware('permission:view_permission',['only'=>['index']]);
        $this->middleware('permission:add_permission',['only'=>['create','store']]);

        $this->middleware('permission:edit_permission',['only'=>['update','edit']]);

        $this->middleware('permission:delete_permission',['only'=>['destroy']]);


    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        if(request()->ajax()){
            $permission=Permission::query();
            return DataTables::of($permission)->make(true);
        }
        return view('Permissions.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Permissions.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        {
            $request->validate([
                'permission'=>[
                    'required',
                    'string',
                    'unique:permissions,name'
                ]
                ]);
                Permission::create([
                    'name'=>$request->permission
                ]);
               return redirect()->route('permissions.index')->with('message','permission added succesfully');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $permission=Permission::findOrFail($id);
        return view('Permissions.edit',compact('permission'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        {
            $request->validate([
                'permission' => 'required|string|max:255|unique:permissions,name',


                ]);

                $permission=Permission::findOrFail($id);
                $permission->update([
                    'name'=>$request->permission
                ]);
               return redirect()->route('permissions.index')->with('message','permission Update succesfully');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $permission=Permission::findOrFail($id);
        $permission->delete();
        return redirect()->route('permissions.index')->with('message','permission Delete successfully');
    }
}
