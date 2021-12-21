<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AppointmentDiagnosisSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('appointment_diagnoses')->insert([
            'appointment_id' => 1,
            'weight' => '3.4',
            'height' => '6.0',
            'BMI' => 'bmi',
            'healthchallenges' => 'none',
            'bloodgroup' => 'A+',
            'genotype' => 'none',
            'conclusion' => 'this is thus the conclusion'
        ]);
    }
}
