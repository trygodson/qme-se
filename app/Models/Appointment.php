<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;
    protected $guarded = [];
    // protected $fillable = [
    //     'doctor_id',
    //     'user_id',
    //     'status',
    //     'starts_at',
    //     'ends_at',
    //     'note',
    //     'specialization_id',
    //     'rejection_note',
    //     'appointment_step',
    //     'isclosed',
    //     'link',
    //     'amount'

    // ];
       /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [

        'isdeleted'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function labtest()
    {
        return $this->hasOne(Labtest::class,'id');
    }

    public function doctorLabtestRequest()
    {
        return $this->hasMany(Doctor::class,'id');
    }

    public function doctor(){
        return $this->belongsTo(Doctor::class);
    }

    public function appointmentdiagnosis(){
        return $this->hasOne(AppointmentDiagnosis::class);
    }

    public function drugPrescriptionItem()
    {
        return $this->hasManyThrough(DrugprescriptionItem::class, DrugPrescription::class);
    }
}
