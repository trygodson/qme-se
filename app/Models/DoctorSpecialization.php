<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class DoctorSpecialization extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

public function filter()
{

 return [
    'firstname'=> $this->firstname
 ];
}
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'doctor_id',
        'specialization_id',
        'isverified',
        'isactivated',



    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [

        'isdeleted'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [

    ];



    public function doctors()
    {
        return $this->belongsTo(Doctor::class,'doctor_id');
    }

    public function specialization(){
        return $this->hasMany(Specialization::class);
    }

}
