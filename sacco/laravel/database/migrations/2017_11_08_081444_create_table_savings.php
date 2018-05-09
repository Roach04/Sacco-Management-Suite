<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableSavings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('savings', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->index()->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('credit')->default(0);
            $table->integer('debit')->default(0);
            $table->string('details',50);
            $table->string('accounts',50);
            $table->string('bank',50);
            $table->string('action',50);
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
        Schema::drop('savings');
    }
}
