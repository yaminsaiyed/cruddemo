<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTablename extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tablename', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('description',500)->nullable();
            $table->text('long_description')->nullable();
            $table->longText('very_long_description')->nullable();
            $table->date('date');
            $table->time('time');
            $table->dateTime('datetime');
            $table->float('price');
            $table->unsignedBigInteger('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->string('image',111)->nullable();
            $table->integer('status')->default(1);
            $table->integer('sort_order')->nullable();
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
        Schema::dropIfExists('tablename');
    }
}
