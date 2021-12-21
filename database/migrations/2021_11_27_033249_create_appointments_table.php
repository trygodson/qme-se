<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppointmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table ->decimal('amount', 18, 2)->default(0.0);
            $table->unsignedBigInteger('doctor_id');
            $table->foreign('doctor_id')->references('id')->on('doctors');
            $table->string('status',64)->default('processing');
            $table->timestamp('starts_at'); 
            $table->timestamp('ends_at')->useCurrent();
            $table->integer('appointment_step');
            $table->boolean('isclosed')->default(false);
            $table->string('meetingid',64);
            $table->string('meetingpassword',64);
            $table->string('note',);
            $table->string('rejection_note');
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
        Schema::dropIfExists('appointments');
    }
}
