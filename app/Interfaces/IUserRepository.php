<?php


namespace App\Interfaces;


interface IUserRepository
{
    public function getAll();
    public function getById($id);
    public function changepassword($id,array $attributes);
    public function login(array $attributes);
    public function querable();
    public function add(array $attributes);
    public function update_($id, array $attributes);
    public function delete($id);
}