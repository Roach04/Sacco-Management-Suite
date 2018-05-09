<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableInstallments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('installments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('loan_id')->index()->unsigned();
            $table->foreign('loan_id')->references('id')->on('loans')->onDelete('cascade');
            $table->integer('installment')->default(0);
            $table->string('firstname');
            $table->string('lastname');
            $table->string('accountNumber');
            $table->string('modeOfPayment');            
            $table->string('monthsLeft');
            $table->string('bank');
            $table->string('defaults');
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
        Schema::drop('installments');
    }
}
