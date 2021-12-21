<?php


namespace App\Interfaces;


interface IDrugPrescriptionItemRepository
{

    public function add(array $attributes);

    public function delete($id);

    public function getByPrescriptionId();
}