<?php

namespace App\Http\Controllers;

use App\Models\services;
use App\Models\student;
use App\Models\tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Contracts\DataTable;
use Yajra\DataTables\Facades\DataTables;

class studentController extends Controller
{

    public function __construct(){
        $this->middleware('permission:view_student',['only'=>['index']]);
        $this->middleware('permission:add_student',['only'=>['create','store']]);

        $this->middleware('permission:edit_student',['only'=>['update','edit']]);

        $this->middleware('permission:delete_student',['only'=>['destroy']]);
        $this->middleware('permission:add_service_to_student',['only'=>['insertservice','addservice']]);


    }
    /**
     * Display a listing of the resource.
     */
   public function index()
{
    if (request()->ajax()) {
        $students = Student::with(['services', 'tags'])
        ->orderBy('created_at', 'desc') // Replace 'column_name' with the column you want to sort by
        ->get();



        $studentsData = $students->map(function ($student) {

            $services = $student->services->pluck('name')->join(', ');
            $tags=$student->tags->pluck('name')->join(', ');

            // Return the transformed data
            return [
                'id' => $student->id,
                'name' => $student->name,
                'phone' => $student->phone,
                'email' => $student->email,
                'phone_2' => $student->phone_2,
                'emergency_contact' => $student->emergency_contact,
                'emergency_contact_2' => $student->emergency_contact_2,
                'enroll_date' => $student->enroll_date,
                'balance' => $student->balance,
                'status' => $student->status,
                'services' => $services,  // Add the comma-separated services
                'tags'=>$tags
            ];
        });

        // Return the transformed data to DataTables
        return DataTables::of($studentsData)->make(true);
    }

    return view('students.index');
}


    /**
     * Show the form for creating a new resource.
     */
    public function create()

    {
        $tags=tag::get();
        $services=services::where('status','active')->get();
        return view('students.create',compact('services','tags'));
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
            'tags'=>'required|array',
            'tags.*' => 'exists:tags,id',
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
        foreach ($request->tags as $tagId) {
            $tag = Tag::find($tagId);
            if ($tag) {
                $tag->student()->attach($student->id);
            }
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
        $student = Student::with(['services', 'tags'])->findOrFail($id); // Eager load services and tags
        $tags = Tag::all(); // Fetch all tags
        $data = compact('student', 'tags'); // Pass student and tags to the view
        return view('students.edit', $data);
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
            'tags' => 'required|array',
            'tags.*' => 'exists:tags,id',

        ]);

        $student=student::findOrFail($id);
        $student->update($validatedData);

        $student->tags()->sync($request->tags);

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

    public function addservice(string $id){

        $services=services::all();

        return view('students.addservice',compact('id','services'));

    }

    public function insertservice(Request $request, string $id ){


        $validatedData = $request->validate([

            'service' => 'required|array',
            'service.*' => 'exists:services,id',
        ]);

        $student_id=$id;

        $new_amount=services::where('id',$request->service)->sum('price');
        $student=student::findOrFail($id);
        $student_balance=$student->balance;


        $total_balance=$new_amount + $student_balance;

        $student->update([
            'balance'=>$total_balance,
        ]);
        foreach($request->service as $serviceId){
            DB::table('service_render_history')->insert([
                'student_id'=>$student_id,
                'service_id'=>$serviceId,
                'amount'=>services::find($serviceId)->price,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        return redirect()->route('students.index')->with('message', 'Service added successfully!');

    }


}
