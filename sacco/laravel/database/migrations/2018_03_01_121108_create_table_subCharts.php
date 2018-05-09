<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableSubCharts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subCharts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('chart_id')->default(0)->unsigned();
            $table->foreign('chart_id')->references('id')->on('charts')->onDelete('cascade');
            $table->string('subAccountName');
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
        Schema::drop('subCharts');
    }
}
