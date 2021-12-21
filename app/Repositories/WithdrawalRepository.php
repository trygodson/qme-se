<?php

namespace App\Repositories;

use App\Interfaces\IWithdrawalRepository;
use App\Models\Withdrawals;

class WithdrawalRepository implements IWithdrawalRepository
{
    private $model;

    public function __construct(Withdrawals $transaction)
    {
        $this->model = $transaction;
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

            $action = $this->model->create($attributes);
            return $action;

    }

    public function update_($id, array $data){
        // $ten = $this->model->findOrFail($id);
            $ten = $this->getById($id);
            return $ten->update($data);
    }

    public function delete($id){

        $ten = $this->model->findOrFail($id);

        return $ten->update(['isdeleted' => 0]);

    }
}
