<?php

namespace App\Http\Controllers;

use App\Http\Requests\serviceRequest;
use App\Models\services;
use Illuminate\Http\Request;
use Yajra\DataTables\Contracts\DataTable;
use Yajra\DataTables\Facades\DataTables;

class servicesController extends Controller
{

    public function __construct(){
        $this->middleware('permission:view_services',['only'=>['index']]);
        $this->middleware('permission:add_services',['only'=>['create','store']]);

        $this->middleware('permission:edit_services',['only'=>['update','edit']]);

        $this->middleware('permission:delete_services',['only'=>['destroy']]);


    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(request()->ajax()){
            $service=services::query()
            ->orderBy('created_at', 'asc') // Replace 'column_name' with the column you want to sort by
            ->get();;
            return DataTables::of($service)->make(true);
        }
        return view('services.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('services.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(serviceRequest $request)
    {
        services::create([
            'name'=>$request->service,
            'price'=>$request->price,
            'status'=>$request->status
        ]);

        return redirect()->route('services.index')->with('message', 'New Services added successfully!');

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
        $service=services::findOrFail($id);
        return view('services.edit', compact('service'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $request->validate([
            'service' => "required|string|unique:services,name,$id",
            'price'=>"required|numeric"

        ]);
        $service=services::findOrFail($id);
        $service->update([
            'name'=>$request->service,
            'price'=>$request->price,
            'status'=>$request->status
        ]);
        return redirect()->route('services.index')->with('message', 'Services updated successfully!');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $services = services::find($id);
        $services->delete();
        return redirect()->back()->with('message', 'service deleted successfully!');
    }
}
