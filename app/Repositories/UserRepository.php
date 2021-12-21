<?php

namespace App\Repositories;


use App\Http\Resources\UserResource;
use App\Interfaces\IUserRepository;

use App\Models\User;

use Illuminate\Support\Facades\Hash;

class UserRepository implements IUserRepository
{

    private $model;


    public function __construct(User $model)
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
        return $this->model->with('roles','statuses')->findorfail($id);
    }

    public function add(array $attributes)
    {
        $attributes['password'] = Hash::make($attributes['password']);
        $attributes['statuses_id'] = 1;
        $action = $this->model->create($attributes);
        return $action;
    }
    public function changepassword($id, array $attributes)
    {
        $action = $this->getById($id);
        $attributes['password'] = Hash::make($attributes['password']);
        $action->update($attributes);
        return $action; 
    }

    
   
      
    


     public function login (array $attributes){
            
      $action = $this->querable();
     $check = $action->where('email', '=', $attributes['email'])->first();
    
      if ($check==true&&$check->password == Hash::check($attributes['password'], $check->password)) {
     $token = $check->createToken('myapptoken')->plainTextToken;
     $response = [
    
      'token' => $token,
     'user'=>$check
            ];
                return  $response;
            } else {
               return false;
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


