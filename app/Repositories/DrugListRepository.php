<?php

namespace App\Repositories;

use App\Models\DrugList;

use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Facades\Hash;
use App\Interfaces\IDrugListRepository;

class DrugListRepository implements IDrugListRepository
{

    private $druglist;


    public function __construct(DrugList $druglist) 
    {
        $this->druglist = $druglist;
    }

    public function getAll()
    {
        return app(Pipeline::class)
        ->send(DrugList::query())
        ->through([
            \App\QueryFilters\Isavailable::class,
        ])
        ->thenReturn()
        ->paginate(3);
    }

    public function getById()
    {
        return app(Pipeline::class)
        ->send(DrugList::query())
        ->through([
            \App\QueryFilters\Id::class,
        ])
        ->thenReturn()
        ->paginate(3);
    }

    public function getByName()
    {
        return app(Pipeline::class)
        ->send(DrugList::query())
        ->through([
            \App\QueryFilters\Name::class,
        ])
        ->thenReturn()
        ->paginate(3);
    }

    public function querable()
    {
        return $this->druglist->query();
    }

    

    public function add(array $attributes)
    {

        $action = $this->druglist->create($attributes);
        return $action;
 
    }

    public function update_($id, array $data){
        $status = $this->druglist->findOrFail($id);
        return $status->update($data);
    }

    public function delete($id){

        $ten = $this->druglist->findOrFail($id);

        return $ten->update(['IsActive' => 0]);

    } 

}