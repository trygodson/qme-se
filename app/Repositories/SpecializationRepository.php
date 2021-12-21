<?php

namespace App\Repositories;

use App\Interfaces\ISpecializationRepository;
use App\Models\Specialization;


class SpecializationRepository implements ISpecializationRepository
{

    private $model;


    public function __construct(Specialization $model)
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
        return $this->model->with('users')->findorfail($id);
    }

    public function add(array $attributes)
    {
      
        $action = $this->model->create($attributes);
        return $action;
       
    }

    public function update_($id, array $attributes)
    {
        $action = $this->getById($id);

        $action->update($attributes);

        return $action;
    }


    public function delete($id)
    {
        $this->getById($id)->delete();

        return true;
    }
}
