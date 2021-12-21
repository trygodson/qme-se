<?php

namespace App\Models;

use App\Models\User;
use App\Models\Tenant;
use App\Models\TenantRole;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TenantMember extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function tenant(){
        return $this->belongsTo(Tenant::class);
    }
    
    public function tenant_role(){
        return $this->belongsTo(TenantRole::class);
    }
}
