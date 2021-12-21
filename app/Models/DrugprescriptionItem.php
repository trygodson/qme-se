<?php

namespace App\Models;

use App\Models\DrugPrescription;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DrugprescriptionItem extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function prescription() {
        return $this->belongsTo(DrugPrescription::class);
    }
}
