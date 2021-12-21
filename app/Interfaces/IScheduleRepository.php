<?php

namespace App\Interfaces;

interface IScheduleRepository
{
    public function getAll();

    public function querable();

    public function getById($id);

    public function add(array $attributes);

    public function update_($id, array $data);

    public function delete($id);
}
