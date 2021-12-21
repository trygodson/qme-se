<?php

namespace App\Repositories;

use App\Interfaces\IDoctorSpecializationRepository;

use App\Models\DoctorSpecialization;

class DoctorSpecializationRepository implements IDoctorSpecializationRepository
{

    private $model;


    public function __construct(DoctorSpecialization $model)
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
      
        $action = $this->querable()->where('doctor_id',$attributes['doctor_id'])->first();
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
