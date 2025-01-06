<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    use HasFactory;
    protected $table='banks';

    protected $fillable=['uuid','name','balance'];

    public function payments(){
        return $this->hasMany(Payment::class);

    }

    public function receipts(){
        return $this->has(Receipt::class);
    }
}
