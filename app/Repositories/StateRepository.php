<?php

namespace App\Repositories;

use App\Models\State;

use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Facades\Hash;
use App\Interfaces\IStateRepository;

class StateRepository implements IStateRepository
{

    private $state;


    public function __construct(State $state) 
    {
        $this->state = $state;
    }

    public function getAll()
    {
        return app(Pipeline::class)
        ->send(State::query())
        ->through([
            \App\QueryFilters\Isavailable::class,
        ])
        ->thenReturn()
        ->paginate(3);
    }

    public function getById()
    {
       
    }

    public function getByName()
    {
        
    }

    public function querable()
    {
        return $this->state->query();
    }

    

    public function add(array $attributes)
    {

        $action = $this->state->create($attributes);
        return $action;
 
    }

    public function update_($id, array $data){
        $status = $this->state->findOrFail($id);
        return $status->update($data);
    }

    public function delete($id){

        

    } 

}