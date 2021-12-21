<?php

namespace App\Repositories;

use App\Models\Transaction;
use App\QueryFilters\UserId;
use Illuminate\Pipeline\Pipeline;
use App\Interfaces\ITransactionRepository;

class TransactionRepository implements ITransactionRepository
{
    private $transaction;

    public function __construct(Transaction $transaction)
    {
        $this->transaction = $transaction;
    }

    public function getAll()
    {
        return $this->transaction->all();
    }

    public function querable()
    {
        return $this->transaction->query();
    }



    public function getById($id)
    {
        return $this->transaction->where('user_id', $id)->paginate(3);
        
    }

    public function add(array $attributes)
    {

            $action = $this->transaction->create($attributes);
            return $action;

    }

    public function update($id, array $data){
        // $ten = $this->transaction->findOrFail($id);
            $ten = $this->transaction->where('appointment_id', $id)->first();
            return $ten->update($data);
    }

    public function delete($id){

        $ten = $this->transaction->findOrFail($id);

        return $ten->update(['IsActive' => 0]);

    }
}
