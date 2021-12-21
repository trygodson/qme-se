<?php

namespace App\Repositories;

use App\Models\AppointmentDiagnosis;
use App\Interfaces\IAppointmentDiagnosisRepository;

class AppointmentDiagnosisRepository implements IAppointmentDiagnosisRepository
{

    private $model;

    public function __construct(AppointmentDiagnosis $labtest)
    {
        $this->model = $labtest;
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

    public function update_($id, array $data){
        // $ten = $this->model->findOrFail($id);
            $ten = $this->model->where('appointment_id', $id)->first();
            return $ten->update($data);
    }

    public function delete($id){

        $ten = $this->model->findOrFail($id);

        return $ten->update(['IsActive' => 0]);

    }
}
