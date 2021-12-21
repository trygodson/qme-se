<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TenantsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('tenants')->insert([
            'name' => 'Doctor',
            'city' => 'FCT',
            'address' => 'Wuse 2',
            'state_id' => 1,
            'tenant_type_id' => 1
        ]);
    }
}
