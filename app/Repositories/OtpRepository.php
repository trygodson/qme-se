<?php

namespace App\Repositories;



use App\Interfaces\IOtpRepository;

use App\Models\Otp;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class OtpRepository implements IOtpRepository
{

    private $model;
    private $user;

    public function __construct(Otp $model,User $user)
    {
        $this->model = $model;
        $this->user=$user;
        
    }


    public function generate($type,$code,$id)
    {
        $expires_at=Carbon::now()->addMinutes(5);
        
        $action = $this->model->create(['code' => $code,
        'type' => $type,
        'expires_at'=>$expires_at,
        'user_id'=>$id
    
    ]);
        return $action;
    }

          

    public function verify($id, $pin)
    {
        $current_time=Carbon::now();
        $action = $this->model->where('code', $pin)->where('user_id', $id)->where('expires_at','>=' ,$current_time)->first();
       if ($action !=null)
        {
          $fetch_user=$this->user->where('id',$id)->first();
          $fetch_user->update(['isVerified' => true]);
          $fetch_user->save();
          return true;
        }else
        {
          return false;
        }
       


    }

    public function verifyforgotpassword($id, $pin)
    {
        $current_time=Carbon::now();
        $action = $this->model->where('code', $pin)->where('user_id', $id)->where('expires_at','>=' ,$current_time)->first();
       if ($action !=null)
        {
          return true;
        }else
        {
          return false;
        }
       


    }

   
}
