<?php

namespace App\Http\Controllers;

use App\Models\services;
use App\Models\student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Contracts\DataTable;
use Yajra\DataTables\Facades\DataTables;

class studentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        if(request()->ajax()){
            $student=student::query();
            return DataTables::of($student)->make(true);
        }
        return view('students.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()

    {
        $services=services::all();
        return view('students.create',compact('services'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'email' => 'required|email|max:255|unique:students,email',
            'phone_2' => 'nullable|string|max:15',
            'emergency_contact' => 'required|string|max:15',
            'emergency_contact_2' => 'nullable|string|max:15',
            'enroll_date' => 'required|date',
            'status' => 'required|in:active,inactive',
            'service' => 'required|array',
            'service.*' => 'exists:services,id',
        ]);

            $total_amount=services::whereIn('id',$request->service)->sum('price');

            $studentData = $request->only(['name', 'phone', 'email', 'phone_2', 'emergency_contact', 'emergency_contact_2', 'enroll_date', 'status']);
            $studentData['balance'] = $total_amount;
        $student = student::create($studentData);



        // Attach the selected services
        // $student->$request->only(['service']);
        // $student['amount']=$total_amount;

        // $student->services()->attach($request->service);
        foreach ($request->service as $serviceId) {
            DB::table('service_render_history')->insert([
                'student_id' => $student->id,
                'service_id' => $serviceId,
                'amount' => services::find($serviceId)->price,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }


        return redirect()->back()->with('message', 'Student added successfully.');
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

        $student=student::findOrFail($id);
        return view('students.edit',compact('student'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:15',

            'phone_2' => 'nullable|string|max:15',
            'emergency_contact' => 'required|string|max:15',
            'emergency_contact_2' => 'nullable|string|max:15',
            'enroll_date' => 'required|date',
            'status' => 'required|in:active,inactive',

        ]);

        $student=student::findOrFail($id);
        $student->update($validatedData);
        return redirect()->route('students.index')->with('message', 'Students info updated successfully!');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $students = student::find($id);
        $students->delete();
        return redirect()->back()->with('message', 'student deleted successfully!');
    }
}
