<?php

namespace App\Repositories;

use App\Models\DrugPrescription;

use Illuminate\Pipeline\Pipeline;
use App\QueryFilters\AppointmentId;
use App\Models\DrugprescriptionItem;
use Illuminate\Support\Facades\Hash;
use App\Interfaces\IDrugPrescriptionRepository;

class DrugPrescriptionRepository implements IDrugPrescriptionRepository
{

    private $drug_prescription;
    private $drug_prescription_item;


    public function __construct(DrugPrescription $drug_prescription, DrugprescriptionItem $drug_prescription_item) 
    {
        $this->$drug_prescription = $drug_prescription;
        $this->$drug_prescription_item = $drug_prescription_item;
    }


    public function add($prescription, array $items)
    {
        $action = $this->$drug_prescription->create($prescription);
        return $action;

        $action = $this->$drug_prescription_item->create($items);
        return $action;
    }

    public function getByAppointmentId(){
        return app(Pipeline::class)
        ->send(DrugPrescription::query())
        ->through([
            \App\QueryFilters\AppointmentId::class,
        ])
        ->thenReturn()
        ->paginate(3);
    }

    public function delete($id){

    }

}