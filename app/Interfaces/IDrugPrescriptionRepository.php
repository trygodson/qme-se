<?php


namespace App\Interfaces;


interface IDrugPrescriptionRepository
{
    public function add($prescription, array $attributes);

    public function getByAppointmentId();

    public function delete($id);
}