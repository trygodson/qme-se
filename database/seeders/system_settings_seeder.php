<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class system_settings_seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('system_settings')->insert([
            [
                'id'=>1,
                'key' => 'appointment_percentage',
                'value'=>'10',
            ],




            ]);

    }
}
