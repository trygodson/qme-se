<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Labtest extends Model
{
    use HasFactory;

    protected $fillable = [
        'appointment_id',
        'title',
        'result',
        'description',
        'isexternallab',
        'isdoctorended'
    ];

    public function appointment()
    {
        return $this->belongsTo(Appointment::class,'appointment_id');
    }
}
