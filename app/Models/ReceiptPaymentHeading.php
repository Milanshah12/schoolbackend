<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReceiptPaymentHeading extends Model
{
    use HasFactory;

    public function payments(){
        return $this->hasMany(Payment::class);

    }

    public function receipts(){
        return $this->has(Receipt::class);
    }
}
