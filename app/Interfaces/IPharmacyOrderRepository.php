<?php


namespace App\Interfaces;


interface IPharmacyOrderRepository
{
    public function getAll();

    public function getById();

    public function getByName();

    public function querable();

    public function add(array $attributes);

    public function update_($id, array $attributes);

    public function delete($id);
}