<?php

namespace App\Repositories;

use App\Models\Bankdetail;
use Illuminate\Pipeline\Pipeline;
use App\Interfaces\IBankdetailRepository;

class BankdetailRepository implements IBankdetailRepository

{
    private $bankdetail;

    public function __construct(Bankdetail $bankdetail)
    {
        $this->bankdetail = $bankdetail;
    }

    public function getAll()
    {
        return $this->bankdetail->all();
    }

    public function querable()
    {
        return $this->bankdetail->query();
    }


    public function getById()
    {
        // return $this->bankdetail->where('user_id', $id)->get();
        return app(Pipeline::class)
        ->send(Bankdetail::query())
        ->through([
            \App\QueryFilters\UserId::class,
        ])
        ->thenReturn()
        ->paginate(3);
    }

    public function add(array $attributes)
    {

            $action = $this->bankdetail->create($attributes);
            return $action;

    }

    public function update_($id, array $data){
        $ten = $this->bankdetail->where('user_id', $id)->first();

        $ten->update($data);

        return $ten;
    }

    public function delete($id){

        $ten = $this->bankdetail->findOrFail($id);

        return $ten->update(['IsActive' => 0]);

    }
}
