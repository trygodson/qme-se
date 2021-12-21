<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLabtestRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('labtest_requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tenant_id');
            $table->foreign('tenant_id')->references('id')->on('tenants');
            $table->unsignedBigInteger('labtest_id');
            $table->foreign('labtest_id')->references('id')->on('labtests');
            $table->string('conclusion',128)->nullable(true);
            $table->string('result')->nullable(true);
            $table->boolean('iscompleted')->default(true);
            $table->boolean('ispaid')->default(true);
            $table->boolean('isrecieved')->default(false);
            $table->string('delivery_type');
            $table->decimal('amount', 18, 2)->default(0.0);
            
           

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('labtest_requests');
    }
}
