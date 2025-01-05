<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class services extends Model
{
    use HasFactory;


    protected $table='services';

    protected $fillable=['name','price','status'];

    public function student(){
        return $this->belongsToMany(student::class,'service_render_history');
    }
}
