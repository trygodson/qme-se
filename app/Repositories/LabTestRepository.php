<?php

namespace App\Repositories;

use App\QueryFilters;
use App\Models\Labtest;
use Illuminate\Pipeline\Pipeline;
use App\QueryFilters\IsDoctorEnded;
use App\Interfaces\ILabTestRepository;

class LabTestRepository implements ILabTestRepository

{
private $labtest;

    public function __construct(Labtest $labtest)
    {
        $this->labtest = $labtest;
    }

    public function getAll()
    {
        return $this->labtest->all();
    }

    public function querable()
    {
        return $this->labtest->query();
    }



    public function getById($id)
    {
        return $this->labtest->findorfail($id);

    }

    public function add(array $attributes)
    {

            $action = $this->labtest->create($attributes);
            return $action;

    }

    public function update($id, array $data){
        // $ten = $this->model->findOrFail($id);
            $ten = $this->labtest->where('appointment_id', $id)->first();
            return $ten->update($data);
    }

    public function delete($id){

        $ten = $this->labtest->findOrFail($id);

        return $ten->update(['IsActive' => 0]);

    }



}


