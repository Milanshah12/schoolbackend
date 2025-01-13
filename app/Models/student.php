<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class student extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'phone',
        'email',
        'phone_2',
        'emergency_contact',
        'emergency_contact_2',
        'enroll_date',
        'balance',
        'status',
    ];

    public function services(){
        return $this->belongsToMany(services::class, 'service_render_history', 'student_id', 'service_id');

    }
    public function tags()
{
    return $this->belongsToMany(tag::class);
}

public function receipt(){
    return $this->hasMany(receipt::class);
}

}
