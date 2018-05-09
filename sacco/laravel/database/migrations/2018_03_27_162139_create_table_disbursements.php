<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableDisbursements extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('disbursements', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('loan_id')->index()->unsigned();
            $table->foreign('loan_id')->references('id')->on('loans')->onDelete('cascade');
            $table->string('disburseMoney');
            $table->string('chequeNumber');
            $table->string('firstname');
            $table->string('lastname');
            $table->string('accountNumber');
            $table->string('bank');
            $table->string('loanDuration');
            $table->integer('gracePeriod')->default(0);
            $table->integer('status')->default(0);
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
        Schema::drop('disbursements');
    }
}
