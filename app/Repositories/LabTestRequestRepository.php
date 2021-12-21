<?php

namespace App\Repositories;

use App\Interfaces\ILabTestRequestRepository;
use App\Models\LabtestRequest;

class LabtestRequestRepository implements ILabTestRequestRepository

{
    private $model;

    public function __construct(LabtestRequest $labTestRequest)
    {
        $this->model = $labTestRequest;
    }

    public function getAll()
    {
        return $this->model->all();
    }

    public function querable()
    {
        return $this->model->query();
    }


    public function getById($id)
    {
        return $this->model->findorfail($id);
    }

    public function add(array $attributes)
    {

            $action = $this->labTestRequest->create($attributes);
            return $action;

    }

    public function update($id, array $data){
        $ten = $this->model->where('labtest_id', $id);

        return $ten->update($data);
    }

    public function delete($id){

        $ten = $this->model->findOrFail($id);

        return $ten->update(['IsActive' => 0]);

    }
} 
