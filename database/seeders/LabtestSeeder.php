<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LabtestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('labtests')->insert([
            'appointment_id' => 1,
            'title' => 'Test for LSD Lysergic acid diethylamide',
            'isdoctorended' => 1,
            'description' => 'Lysergic acid diethylamide, also known colloquially as acid, is a psychedelic drug.'
        ]);
    }
}
