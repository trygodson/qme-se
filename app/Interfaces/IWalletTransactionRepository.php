<?php

namespace App\Interfaces;

interface IWalletTransactionRepository
{
    public function getAll();

    public function querable();

    public function add(array $attributes);

    public function getById();

    public function update($id, array $attributes);

    public function delete($id);
}
