<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('reference_id',64);
            $table->boolean('isverified')->default(true);
            $table->boolean('iswallet_transaction')->default(false);
            $table->boolean('isdebit');
            $table->string('payment_description',64);
            $table->string('thirdparty_transaction_code',32);
            $table ->decimal('amount', 18, 2)->default(0.0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}
