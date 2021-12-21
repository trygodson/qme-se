<?php

namespace App\Repositories;

use App\Models\Biodata;

use App\QueryFilters\UserId;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Facades\Hash;
use App\Interfaces\IBiodataRepository;

class BiodataRepository implements IBiodataRepository
{

    private $biodata;


    public function __construct(Biodata $biodata)
    {
        $this->biodata = $biodata;
    }

    public function getAll()
    {
        return app(Pipeline::class)
        ->send(Biodata::query())
        ->through([
            \App\QueryFilters\Isavailable::class,
        ])
        ->thenReturn()
        ->paginate(3);
    }

    public function getById()
    {
        return app(Pipeline::class)
        ->send(Biodata::query())
        ->through([
            \App\QueryFilters\UserId::class,
        ])
        ->thenReturn();
    }

    public function querable()
    {
        return $this->biodata->query();
    }



    public function add(array $attributes)
    {

        $action = $this->biodata->create($attributes);
        return $action;


    }

    public function update_($id, array $data){
        $status = $this->biodata->where('user_id', $data['user_id'])->get();
        return $status->update($data);
    }

    public function delete($id){

        $record = $this->biodata->findOrFail($id);

        return $record->update(['isdeleted' => 1]);

    }

}
