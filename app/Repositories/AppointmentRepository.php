<?php

namespace App\Repositories;

use App\Interfaces\IAppointmentRepository;
use App\Models\Appointment;
use App\Models\Doctor;


class AppointmentRepository implements IAppointmentRepository
{

    private $model;


    public function __construct(Appointment $model)
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

        $action = $this->querable()->where('user_id',$attributes['user_id'])->where('status','processing')->first();
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
