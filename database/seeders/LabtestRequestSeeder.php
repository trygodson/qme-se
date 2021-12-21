<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LabtestRequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('labtest_requests')->insert([
            'tenant_id' => 2,
            'labtest_id' => 1,
            'iscompleted' => 1,
            'delivery_type' => 'physical',
            'amount' => 3.0
        ]);
    }
}
