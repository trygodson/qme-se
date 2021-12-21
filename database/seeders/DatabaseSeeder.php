<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
           RoleSeeder::class,
           StatusSeeder::class,
            StateSeeder::class,
            SpecializationSeeder::class,
            TenantRoleSeeder::class,
            PaymentMethodSeeder::class,
            TenantTypeSeeder::class,
                system_settings_seeder::class,
        ]);
    }
}
