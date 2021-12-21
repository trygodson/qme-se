<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AppointmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('appointments')->insert([
            'user_id' => 1,
            'amount' => 2.0,
            'doctor_id' => 1,
            'appointment_step' => 1,
            'link' => 'yet_another_link',
            'note' => 'yet_another_note',
            'rejection_note' => 'demo3_note',
            'specialization_id' => 1
        ]);
    }
}
