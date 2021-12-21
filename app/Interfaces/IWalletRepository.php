<?php


namespace App\Interfaces;


interface IWalletRepository
{
    public function create($id,$phone);
    public function debit($id,$amount);
    public function credit($id,$amount);
    public function get($id);
    public function querable();
}