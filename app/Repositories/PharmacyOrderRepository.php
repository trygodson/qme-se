<?php

namespace App\Repositories;

use App\Models\PharmacyOrder;

use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Facades\Hash;
use App\Interfaces\IPharmacyOrderRepository;

class PharmacyOrderRepository implements IPharmacyOrderRepository
{

    private $pharmacyorder;


    public function __construct(Pharmacyorder $pharmacyorder) 
    {
        $this->pharmacyorder = $pharmacyorder;
    }

    public function getAll()
    {
        return app(Pipeline::class)
        ->send(PharmacyOrder::query())
        ->through([
            \App\QueryFilters\Iscompleted::class,
        ])
        ->thenReturn()
        ->paginate(8);
    }

    public function getById()
    {
    
    }

    public function getByName()
    {
        
    }

    public function querable()
    {
        return $this->model->query();
    }

    

    public function add(array $attributes)
    {

    
    }

    public function update_($id, array $data){
        $action = $this->pharmacyorder->where('id', $id)->first();
        return $action->update($data);
    }

    public function delete($id){

    } 

}