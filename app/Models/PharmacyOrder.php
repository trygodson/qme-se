<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PharmacyOrder extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function drugprescription(){
        return $this->hasOne(DrugPrescription::class);
    }
}
