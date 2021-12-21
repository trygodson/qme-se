<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TenantTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('tenant_types')->insert([
            'description' => 'Pharmacy is the clinical health science that links medical science with chemistry ',
            'name' => 'Pharmacy'
        ]);
    }
}
