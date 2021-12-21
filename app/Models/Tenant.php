<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Tenant extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $guarded = [];
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
    public function tenanttype()
    {
        return $this->belongsTo(TenantType::class,'tenant_type_id');
    }

    public function tenantMember(){
        return $this->hasMany(TenantMember::class);
    }

}
