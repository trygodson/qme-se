<?php

namespace App\Repositories;

use App\Models\Activity;

use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Facades\Hash;
use App\Interfaces\IActivityRepository;

class ActivityRepository implements IActivityRepository
{

    private $activity;


    public function __construct(Activity $activity) 
    {
        $this->activity = $activity;
    }

    public function getAll()
    {
        //
    }

    public function querable()
    {
        return $this->model->query();
    }

    

    public function add(array $attributes)
    {

        $action = $this->activity->create($attributes);
        return $action;
 
    }

    public function update_($id, array $data){
        $ten = $this->model->findOrFail($id);
        return $ten->update($data);
    }

    public function delete($id){

        $ten = $this->model->findOrFail($id);

        return $ten->update(['IsActive' => 0]);

    }

} 