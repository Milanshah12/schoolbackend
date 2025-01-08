<?php

namespace App\Http\Controllers;

use App\Models\ReceiptPaymentHeading;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class headingController extends Controller
{

    public function __construct(){
        $this->middleware('permission:view_heading',['only'=>['index']]);
        $this->middleware('permission:add_heading',['only'=>['create','store']]);

        $this->middleware('permission:edit_heading',['only'=>['update','edit']]);

        $this->middleware('permission:delete_heading',['only'=>['destroy']]);


    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            $headings = ReceiptPaymentHeading::query();

            return DataTables::of($headings)->make(true);
        }

        return view('Receipt_payment_headings.index');
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       return view('Receipt_payment_headings.create');

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate=validator([
            'heading'=>'required|string',
            'type'=>'required'
        ]);

        $uuid = str::uuid();

        $headings=ReceiptPaymentHeading::create([
            'uuid'=>$uuid,
            'heading'=>$request->heading,
            'type'=>$request->type
        ]
        );
        return redirect()->route('headings.index')->with('message','Heading added Successfully');
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
        $headings=ReceiptPaymentHeading::findOrFail($id);
        return view('Receipt_payment_headings.edit',compact('headings'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validate=validator([
            'heading'=>'required|string',
            'type'=>'required'
        ]);

        $heading=ReceiptPaymentHeading::findOrFail($id);

        $heading->update([

            'heading'=>$request->heading,
            'type'=>$request->type
        ]
        );
        return redirect()->route('headings.index')->with('message','Heading update Successfully');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $heading=ReceiptPaymentHeading::findOrFail($id);
        $heading->delete();
        return redirect()->back()->with('message','Heading Delete');
    }
}
