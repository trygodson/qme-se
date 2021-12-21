<?php


namespace App\Interfaces;


interface IDoctorRepository
{
    public function getAll();

    public function getById($id);

    public function querable();

    public function add(array $attributes);

    public function update_($id, array $attributes);

    public function delete($id);
}