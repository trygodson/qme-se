<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDrugprescriptionItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('drugprescription_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('drug_prescription_id');
            $table->foreign('drug_prescription_id')->references('id')->on('drug_prescriptions');
            $table->string('name',64);
            $table->string('dosage_description',64);
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
        Schema::dropIfExists('drugprescription_items');
    }
} 
