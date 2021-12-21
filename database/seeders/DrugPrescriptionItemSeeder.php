<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DrugPrescriptionItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('drugprescription_items')->insert([
            'drug_prescription_id' => 1,
            'name' => 'Panadol',
            'dosage_description' => '2 each day',
            'amount' => 3.0
        ]);
    }
}
