<?php

namespace App\Repositories;

use App\Models\Doctor;
use App\Models\Rating;
use App\Interfaces\IRatingRepository;

class RatingRepository implements IRatingRepository

{
    private $rating;
    private $doctor;

    public function __construct( Rating $rating, Doctor $doctor)
    {
        $this->rating = $rating;
        $this->doctor = $doctor;


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

            $action = $this->rating->create($attributes);
            return $action;

    }

    public function update($id, array $data){
        $ten = $this->doctor->where('user_id', $id);

        return $ten->update($data);
    }

    public function delete($id){

        $ten = $this->model->findOrFail($id);

        return $ten->update(['IsActive' => 0]);

    }
}
