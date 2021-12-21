<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DoctorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('doctors')->insert([
            'user_id' => 1,
            'folio_id' => 'demofolio_id',
            'consultation_fee' => 2.0,
            'ratercount' => 1,
            'availability' => 'true',
            'proffessional_bio' => 'I am a doctor',
            'yearsofexperience' => 4
        ]);
    }
}
