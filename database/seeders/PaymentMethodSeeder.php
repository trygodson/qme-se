<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('payment_methods')->insert([
        [  
            'id'=>1,
            'name' => 'PayStack',
            
            
        ],
        [  
            'id'=>2,
            'name' => 'Flutterwave',
            
            
        ],
        [  
            'id'=>3,
            'name' => 'Cash On Delivery',
            
        ],
        [  
            'id'=>4,
            'name' => 'Wallet',
            
        ],
      
        ]);
    
    }
}
