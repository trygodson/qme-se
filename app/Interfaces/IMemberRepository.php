<?php

namespace App\Interfaces;

interface IMemberRepository
{
    public function getAll();

    public function querable();

    public function add(array $attributes);

    public function update($id, array $attributes);

    public function delete($id);
}
