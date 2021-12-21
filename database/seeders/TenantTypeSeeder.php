<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TenantTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tenant_types')->insert([
            [
                'name' => 'Pharmacy',
                'description'=>'Where customers can purchase goods and services',
                
            ],
            [
                'name' => 'Labs',
                'description'=>'Where customers get tests done',
                
            ],
            
            
          
        ]);
    }
}
