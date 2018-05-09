<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableCharts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('charts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->default(0)->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('accountName');
            $table->string('category');
            $table->string('description');
            $table->string('money');
            $table->integer('detail')->default(0)->unsigned();
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
        Schema::drop('charts');
    }
}
