<?php

namespace App\Http\Controllers;

use App\Models\tag;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class tagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        if(request()->ajax()){
            $tags=tag::query();

            return DataTables::of($tags)->make(true);
        }
        return view('tags.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('tags.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'tag' => 'required|string|unique:tags,name',
        ]);

        $Tag=tag::create(
            [
                'name'=>$request->tag,
            ]
            );

            return redirect()->route('tags.index')->with('message','Tag created successfully!');
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
        $tag=tag::findOrFail($id);
        $data=compact('tag');
        return view('tags.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
     $request->validate([
            'tag' => 'required|string|unique:tags,name',
        ]);

        $tags=tag::findOrFail($id);
        $tags->update(
            [
                'name'=>$request->tag,
            ]
            );

            return redirect()->route('tags.index')->with('message','tag Update');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $tags=tag::find($id);
        $tags->delete();
            return redirect()->back()->with('message','Delete');
    }
}
