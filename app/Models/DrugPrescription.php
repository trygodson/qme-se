<?php

namespace App\Models;

use App\Models\DrugprescriptionItem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DrugPrescription extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function prescriptionItems() {
        return $this->hasMany(DrugprescriptionItem::class);
    }

    
}
