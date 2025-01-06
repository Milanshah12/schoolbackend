<?php

namespace App\Http\Controllers;

use App\Http\Requests\paymentRequest;
use App\Models\Bank;
use App\Models\Payment;
use App\Models\ReceiptPaymentHeading;
use Illuminate\Http\Request;
use Yajra\DataTables\Contracts\DataTable;
use Yajra\DataTables\Facades\DataTables;

class paymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        if(request()->ajax()){
            $payments=Payment::join('banks', 'payments.bank_id','=','banks.id')
             ->join('receipt_payment_headings', 'payments.receipt_payment_heading_id', '=', 'receipt_payment_headings.id')
            ->select(
                'payments.*',
                'banks.name as bank_name',
                 'receipt_payment_headings.heading as heading'
            )->get();

            return DataTables::of($payments)->make(true);

        }
            return view('payments.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $banks=Bank::all();

        $headings=ReceiptPaymentHeading::where('type','payment')->get();
        $data=compact('banks','headings');
return view('Payments.create',$data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(paymentRequest $request)
    {
            $bank=Bank::findOrFail($request->bank_id);
            $bank_balance=$bank->balance;
            $total_balance=$bank_balance-$request->amount;

            $payment=Payment::create([

                'date'=>$request->date,
                'bank_id'=>$request->bank_id,
                'receipt_payment_heading_id'=>$request->receipt_payment_heading_id,
                'amount'=>$request->amount
            ]);

            $updatebalance=$bank->update(
                [
                    'balance'=>$total_balance,
                ]
                );
                return redirect()->route('payments.index')->with('message', 'payment successfully!');

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
