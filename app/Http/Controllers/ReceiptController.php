<?php

namespace App\Http\Controllers;

use App\Http\Requests\receiptRequest;
use App\Models\Bank;
use App\Models\Receipt;
use App\Models\ReceiptPaymentHeading;
use App\Models\student;
use Illuminate\Http\Request;
use Yajra\DataTables\Contracts\DataTable;
use Yajra\DataTables\Facades\DataTables;

class ReceiptController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        if(request()->ajax()){
            $receipts = Receipt::join('students', 'receipts.student_id', '=', 'students.id')
            ->join('banks', 'receipts.bank_id', '=', 'banks.id')
            ->join('receipt_payment_headings', 'receipts.receipt_payment_heading_id', '=', 'receipt_payment_headings.id')
            ->select(
                'receipts.*',
                'students.name as student_name',
                'banks.name as bank_name',
                'receipt_payment_headings.heading as heading'
            )
            ->get();

        return DataTables::of($receipts)->make(true);
    }
    return view('Receipts.index');
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $banks=Bank::all();
        $students=student::all();
        $headings=ReceiptPaymentHeading::where('type','receipt')->get();
        $data=compact('banks','students','headings');
return view('Receipts.create',$data);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(receiptRequest $request)
    {
            $student=student::findOrFail($request->student_id);
            $student_balance=$student->balance;
            $total_student_balance=$student_balance-$request->amount;

            $bank=Bank::findOrFail($request->bank_id);
            $bank_balance=$bank->balance;
            $total_bank_balance=$bank_balance + $request->amount;


            $receipt=Receipt::create([
                 'date'=>$request->date,
                 'bank_id'=>$request->bank_id,
                 'student_id'=>$request->student_id,
                 'receipt_payment_heading_id'=>$request->receipt_payment_heading_id,
                 'amount'=>$request->amount,
            ]);

            $updatestudentBalance=$student->update([
                'balance'=>$total_student_balance,
            ]);
            $updateBankBalance=$bank->update([
                'balance'=>$total_bank_balance,
            ]);

            return redirect()->route('receipts.index')->with('message', 'student payment successfully!');


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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
