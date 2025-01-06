<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Receipt extends Model
{
    use HasFactory;

    protected $table='receipts';

    protected $fillable=['date','bank_id','student_id','receipt_payment_heading_id','amount'];



    public function bank()
    {
        return $this->belongsTo(Bank::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function heading()
    {
        return $this->belongsTo(ReceiptPaymentHeading::class, 'receipt_payment_heading_id');
    }


}
