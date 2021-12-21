<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('firstname',32);
            $table->string('lastname',32);
            $table->unsignedBigInteger('state_id');
            $table->foreign('state_id')->references('id')->on('states');
            $table->boolean('isdeleted')->nullable()->default(false);
            $table->string('phonenumber',32)->unique();
            $table->string('facebook',64)->nullable(true);
            $table->string('instagram',64)->nullable(true);
            $table->string('linkedin',64)->nullable(true);
            $table->string('bio',255)->nullable(true);
            $table->string('avatar',64)->nullable(true);
            $table->string('email',100)->unique();
            $table->string('gender',16 )->nullable();
            $table->string('city',16 )->nullable();
            $table->string('address',128)->nullable();
            $table->boolean('isVerified')->default(0);
            $table->bigInteger('statuses_id')->unsigned();
            $table->foreign('statuses_id')->references('id')->on('statuses');
            $table->bigInteger('roles_id')->unsigned();
            $table->foreign('roles_id')->references('id')->on('roles');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');



            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
