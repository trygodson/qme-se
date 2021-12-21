<?php

namespace App\Repositories;

use App\Interfaces\IDoctorRepository;
use App\Models\Doctor;


class DoctorRepository implements IDoctorRepository
{

    private $model;


    public function __construct(Doctor $model)
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
        return $this->model->with('users')->findOrFail($id);
    }

    public function add(array $attributes)
    {

        $action = $this->querable()->where('user_id',$attributes['user_id'])->first();
        if($action !=null)
        {
          return false;
        }else{
            $action = $this->model->create($attributes);
            return $action;
        }

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
