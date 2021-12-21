<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTenantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tenants', function (Blueprint $table) {
            $table->id();
            $table->string('name',32);
            $table->string('city',32);
            $table->string('address',128);
            $table->unsignedBigInteger('state_id');
            $table -> decimal('longitude', 18, 6)->default(0.0);
            $table -> decimal('latitude', 18, 6)->default(0.0);
            $table->foreign('state_id')->references('id')->on('states');
            $table->unsignedBigInteger('tenant_type_id');
            $table->foreign('tenant_type_id')->references('id')->on('tenant_types');
            $table->integer('IsActive')->default(1);
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
        Schema::dropIfExists('tenants');
    }
}
