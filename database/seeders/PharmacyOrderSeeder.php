<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PharmacyOrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('pharmacy_orders')->insert([
            'tenant_id' => 2,
            'drug_prescription_id' => 1,
            'deliverychannel' => 'courier'
        ]);
    }
}
