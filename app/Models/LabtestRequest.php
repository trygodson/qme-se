<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LabtestRequest extends Model
{

    use HasFactory;

    protected $fillable = [
        'tenant_id',
        'labtest_id',
        'conclusion',
        'result',
        'delivery_type'
    ];
}
