<?php

namespace App\Repositories;
use Illuminate\Pipeline\Pipeline;
use App\Models\DrugprescriptionItem;
use App\QueryFilters\PrescriptionId;
use Illuminate\Support\Facades\Hash;
use App\Interfaces\IDrugPrescriptionItemRepository;

class DrugPrescriptionItemRepository implements IDrugPrescriptionItemRepository
{

    private $drug_prescription_item;


    public function __construct(DrugprescriptionItem $drug_prescription_item) 
    {
        $this->drug_prescription_item = $drug_prescription_item;
    }


    public function add(array $attributes)
    {
 
    }

    public function getById($id)
    {
        return $this->drug_prescription_item->findOrFail($id);

    }

    public function delete($id){
        $item = $this->drug_prescription_item->findOrFail($id);

        $item->delete();

        return $item;
    }

    public function getByPrescriptionId(){
        return app(Pipeline::class)
        ->send(DrugprescriptionItem::query())
        ->through([
            \App\QueryFilters\PrescriptionId::class,
        ])
        ->thenReturn()
        ->paginate(4);
    }

}