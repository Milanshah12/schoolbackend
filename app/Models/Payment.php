<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;


    protected $table='payments';

    protected $fillable=['date','bank_id','amount','receipt_payment_heading_id'];

    public function bank()
    {
        return $this->belongsTo(Bank::class);
    }



    public function heading()
    {
        return $this->belongsTo(ReceiptPaymentHeading::class, 'receipt_payment_heading_id');
    }
}
