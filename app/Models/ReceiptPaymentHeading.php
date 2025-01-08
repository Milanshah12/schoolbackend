<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReceiptPaymentHeading extends Model
{
    use HasFactory;

    protected $table='receipt_payment_headings';

    protected $fillable=['uuid','heading','type'];

    public function payments(){
        return $this->hasMany(Payment::class);

    }

    public function receipts(){
        return $this->has(Receipt::class);
    }
}
