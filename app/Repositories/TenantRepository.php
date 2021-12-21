<?php

namespace App\Repositories;

use App\Interfaces\ITenantRepository;
use App\Models\Tenant;

class TenantRepository implements ITenantRepository

{
    private $model;

    public function __construct( Tenant $model)
    {
        $this->model = $model;


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

            $action = $this->model->create($attributes);
            return $action;

    }

    public function update($id, array $data){
        $ten = $this->model->findOrFail($id);

        return $ten->update($data);
    }

    public function delete($id){

        $ten = $this->model->findOrFail($id);

        return $ten->update(['IsActive' => 0]);

    }
}
