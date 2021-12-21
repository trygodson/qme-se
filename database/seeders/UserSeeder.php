<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('users')->insert([
            'firstname' => 'Hendricks',
            'lastname' => 'Dickson',
            'state_id' => 1,
            'phonenumber' => '03265978414',
            'facebook' => 'dickson.facebook.com',
            'instagram' => 'dickson.instagram.com',
            'linkedin' => 'dickson.linkedin.com',
            'email' => 'dickson@gmail.com',
            'statuses_id' => 1,
            'roles_id' => 1,
            'password' => bcrypt('123456789')
        ]);
    }
}
