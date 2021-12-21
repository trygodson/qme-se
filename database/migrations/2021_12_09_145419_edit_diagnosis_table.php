<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EditDiagnosisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('appointment_diagnoses', function (Blueprint $table) {
            $table->decimal('weight')->change();
            $table->decimal('height')->change();
            $table->decimal('bmi')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('appointment_diagnoses', function (Blueprint $table) {
            //
        });
    }
}
