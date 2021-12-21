<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Otp extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $fillable = [
        'code',
        'expires_at',
        'type',
        'user_id'
       
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
