<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableJournals extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('journals', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->index()->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('details', 60);
            $table->string('accountName', 60);
            $table->integer('actualFigure')->default(0);
            $table->integer('overpay')->default(0);
            $table->integer('duration')->default(0);
            $table->string('bank', 60);
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
        Schema::drop('journals');
    }
}
