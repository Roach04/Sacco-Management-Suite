<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableLoans extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loans', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('member_id')->index()->unsigned();
            $table->foreign('member_id')->references('id')->on('members')->onDelete('cascade');
            $table->integer('loan')->default(0);
            $table->integer('interest')->default(0);
            $table->integer('amount')->default(0);
            $table->string('modeOfPayment');
            $table->string('loanEntity');
            $table->string('loanType');
            $table->integer('monthlyInstallment')->default(0);
            $table->integer('totalInstallments')->default(0);
            $table->string('guaranteeOne');
            $table->string('guaranteeTwo');
            $table->string('guaranteeThree');
            $table->string('moneyOne');
            $table->string('moneyTwo');
            $table->string('moneyThree');
            $table->string('percentOne');
            $table->string('percentTwo');
            $table->string('percentThree');
            $table->string('loanDuration');
            $table->integer('gracePeriod')->default(0);
            $table->integer('state')->default(0);
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
        Schema::drop('loans');
    }
}
