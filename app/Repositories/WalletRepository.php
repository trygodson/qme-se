<?php

namespace App\Repositories;


use App\Http\Resources\WalletResource;
use App\Interfaces\IWalletRepository;

use App\Models\Wallet;

use Illuminate\Support\Facades\Hash;

class WalletRepository implements IWalletRepository
{

    private $model;


    public function __construct(Wallet $model)
    {
        $this->model = $model;
    }
  
   public function create($id,$phone)
   {
    $action = $this->model->create(['user_id' => $id,
    'balance' => 0.0,
    'wallet_reference'=>$phone,
    'negative_balance'=>0.0,
     ]);
     return true;
   }
   public function debit($id,$amount)
   {

   }
   public function querable()
   {
       return $this->model->query();
   }
   public function credit($wallet,$amount)
   {
    
    $wallet ->update($amount);
    return $wallet;
   }
   public function get($id)
   {
     
   }
    
}  
