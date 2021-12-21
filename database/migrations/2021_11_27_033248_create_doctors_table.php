<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDoctorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doctors', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('folio_id',32);
            $table->boolean('isdeleted')->nullable()->default(false);
            $table->boolean('isverified')->nullable()->default(false);
            $table->boolean('isactivated')->nullable()->default(false);
            $table -> decimal('consultation_fee', 18, 2)->default(0.0);
            $table -> decimal('rating', 5, 1)->default(0.0);
            $table -> decimal('ratingcount', 7, 1)->default(0.0);
            $table -> integer('ratercount');
            $table->string('availability',16 );

            $table->string('proffessional_bio' );
            $table->integer('yearsofexperience');
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
        Schema::dropIfExists('doctors');
    }
}
