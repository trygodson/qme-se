<?php

namespace App\Repositories;

use App\Models\TenantMember;
use App\Interfaces\IMemberRepository;

class MemberRepository implements IMemberRepository
{
    private $model;

    public function __construct( TenantMember $model)
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

        $action = $this->querable()->where('user_id',$attributes['user_id'])->first();
        if($action !=null)
        {
          return false;
        }else{
            $action = $this->model->create($attributes);
            return $action;
        }
    }

    public function update($id, array $data){
        $ten = $this->model->findOrFail($id);

        return $ten->update($data);
    }

    public function delete($id){

        $ten = $this->model->findOrFail($id);

        return $ten->update(['isremoved' => true]);

    }

}
