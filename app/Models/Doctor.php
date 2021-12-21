<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Doctor extends Authenticatable
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
    protected $primaryKey = 'id';
    protected $fillable = [
        'user_id',
        'folio_id',
        'isverified',
        'isactivated',
        'consultation_fee',
        'rating',
        'ratingcount',
        'ratercount',
        'availability',
        'proffessional_bio',
        'yearsofexperience'


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



    public function users()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function labtests(){
        return $this->hasManyThrough(Labtest::class, Appointment::class);
    }
   
    public function specialization()
    {
        return $this->belongsToMany(Specialization::class, 'Doctor_specializations');
    }


}
