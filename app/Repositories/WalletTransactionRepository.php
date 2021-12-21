<?php

namespace App\Repositories;

use App\QueryFilters\UserId;
use App\Models\WalletTransaction;
use Illuminate\Pipeline\Pipeline;
use App\Interfaces\IWalletTransactionRepository;



class WalletTransactionRepository implements IWalletTransactionRepository
{

    private $walletTx;  //wallet transaction

    public function __construct(WalletTransaction $walletTx)
    {
        $this->walletTx = $walletTx;
    }

    public function getAll()
    {
        return $this->walletTx->all();
    }

    public function querable()
    {
        return $this->walletTx->query();
    }

   

    public function getById()
    {
        return app(Pipeline::class)
        ->send(WalletTransaction::query())
        ->through([
            \App\QueryFilters\UserId::class,
        ])
        ->thenReturn()
        ->paginate(3);
        
    }

    public function add(array $attributes)
    {

            $action = $this->walletTx->create($attributes);
            return $action;

    }

    public function update($id, array $data){
        $ten = $this->walletTx->findOrFail($id);
        return $ten->update($data);
    }

    public function delete($id){

        $ten = $this->walletTx->findOrFail($id);

        return $ten->update(['IsActive' => 0]); 

    }

}