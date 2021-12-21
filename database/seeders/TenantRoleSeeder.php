<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TenantRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tenant_roles')->insert([
        [  
            'id'=>1,
            'name' => 'admin',
            'description'=>'Admins if the tenant',
        ],
        [
            'id'=>2,
            'name' => 'member',
            'description'=>'Worker or sub admins',
        ],
       
      
       
        ]);
    
    }
}
