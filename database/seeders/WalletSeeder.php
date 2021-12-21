<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WalletSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('wallets')->insert([
            'user_id' => 1,
            'balance' => 3,
            'wallet_reference' => 5,
            'negative_balance' => 4
        ]);
    }
}
