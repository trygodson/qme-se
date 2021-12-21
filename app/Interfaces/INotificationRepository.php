<?php


namespace App\Interfaces;


interface INotificationRepository
{
    public function getAll();
    public function querable();
    public function getById($id);
    public function add(array $attributes);
    public function update($id, array $data);
    public function delete($id);
}