<?php

namespace App\Repositories;

use App\Interfaces\IScheduleRepository;
use App\Models\Schedule;

class ScheduleRepository implements IScheduleRepository
{
    private $model;


    public function __construct(Schedule $model)
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
