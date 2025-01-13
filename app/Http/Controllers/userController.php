<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\RoleModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTable;
use Yajra\DataTables\Facades\DataTables;

class userController extends Controller
{

    public function __construct(){
        $this->middleware('permission:view_staff',['only'=>['index']]);
        $this->middleware('permission:add_staff',['only'=>['create','store']]);

        $this->middleware('permission:edit_staff',['only'=>['update','edit']]);

        $this->middleware('permission:delete_staff',['only'=>['destroy']]);


    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
{
    if (request()->ajax()) {

        if($request->type==='soft_deleted'){
            $users=User::onlyTrashed()->with('roles')->get()
            ->map(function ($user) {
                $user->role = $user->roles->pluck('name')->join(', '); // Add the role attribute
                return $user;
            });
        }else{
            $users = User::where('id', '!=', Auth::id())
            ->with('roles')
            ->get()
            ->map(function ($user) {
                $user->role = $user->roles->pluck('name')->join(', '); // Add the role attribute
                return $user;
            });
        }



        return DataTables::of($users)->make(true);
    }

    return view('users.index');
}


// if (request()->ajax()) {
//     $users = User::where('id', '!=', Auth::id())
//         ->with('roles')
//         ->get()
//         ->map(function ($user) {
//             $user->role = $user->roles->pluck('name')->join(', '); // Add the role attribute
//             return $user;
//         });

//     return DataTables::of($users)->make(true);
// }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles=Role::all();

      return view('users.create',compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        // Create the user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Fetch role IDs based on role names provided in the request
        $roleIds = RoleModel::whereIn('name', $request->role)->pluck('id')->toArray();

        // Attach roles to the user via the pivot table
        foreach ($roleIds as $roleId) {
            DB::table('model_has_roles')->insert([
                'model_id' => $user->id,
                'role_id' => $roleId,
                'model_type' => 'App\Models\User',
            ]);
        }

        return redirect()->route('users.index')->with('message', 'User created successfully!');
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
        $roles=Role::all();
        $user=User::findOrFail($id);
        return view('users.edit',compact('user','roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
{
    // Validate the request data
    $request->validate([
        'name' => 'required|string|max:255',
        'password' => 'nullable|string|min:6|max:255',
        'confirm_password' => 'same:password',
        'role' => 'required|array|',

    ]);

    // Update user details
    $user->update([
        'name' => $request->name,
        'password' => $request->password ? Hash::make($request->password) : $user->password,
    ]);


    $role = RoleModel::whereIn('name', $request->role)->pluck('id')->toArray();

    // Fetch the role

    foreach ($role as $roleId) {
        DB::table('model_has_roles')->updateOrInsert([
            'model_id' => $user->id,
            'role_id' => $roleId,
            'model_type' => 'App\Models\User',
        ]);
    }

    // Redirect with a success message
    return redirect()->route('users.index')->with('message', 'User Info updated successfully!');
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $users = User::find($id);
        $users->delete();
        return redirect()->back()->with('message', 'user deleted successfully!');
    }
}
