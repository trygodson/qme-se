<?php

namespace App\Models;

use App\Models\Wallet;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
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
        'firstname',
        'lastname',
        'email',
        'password',
        'phonenumber',
        'roles_id',
        'statuses_id',
        'bio',
        'instagram',
        'facebook',
        'twitter',
        'linkedin',
        'isVerified',
        'state_id',
        'avatar',
        'city',
        'gender',
        'address'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'roles_id',
        'statuses_id',
        'isdeleted'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];



    public function roles()
    {
        return $this->belongsTo(Role::class);
    }
    public function statuses()
    {
        return $this->belongsTo(Status::class);
    }
    public function doctors()
    {
        return $this->hasMany(Doctor::class);
    }

    public function otp()
    {
        return $this->hasMany(Otp::class);
    }


    public function labtests(){
        return $this->hasManyThrough(Labtest::class, Appointment::class);
    }

    public function tenantMember(){
        return $this->hasOne(TenantMember::class);
    }

    public function wallet(){
        return $this->hasOne(Wallet::class);
    }

    public function withdrawals(){
        return $this->hasMany(Withdrawals::class);
    }

}
