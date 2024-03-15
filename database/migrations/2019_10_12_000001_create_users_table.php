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
            $table->bigIncrements('id');
            $table->string('firstname');
            $table->string('lastname');
            $table->string('username')->nullable();
            $table->unsignedInteger('role_id')->index();
            $table->foreign('role_id')->references('id')->on('roles');
            $table->string('mobile',15)->nullable();
            $table->string('email')->unique();
            $table->text('reset_token_hash')->nullable();
            $table->dateTime('reset_datetime')->nullable();
            $table->string('password');
            $table->smallInteger('status')->default('1');
            $table->string('image')->nullable();
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
