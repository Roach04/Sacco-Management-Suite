<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableMembers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('members', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->index()->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('accountNumber');
            $table->integer('loanStatus')->default(0);
            $table->integer('guaranteeStatus')->default(0);
            $table->integer('totals')->default(0);
            $table->integer('guarantorMoney')->default(0);
            $table->string('firstname');
            $table->string('surname');
            $table->string('lastname');
            $table->string('maritalStatus');
            $table->string('occupation');
            $table->string('gender');
            $table->string('bankName');
            $table->string('bankAccountName');
            $table->string('bankAccountNumber');
            $table->string('phoneNumber', 10);
            $table->string('idNumber', 8);
            $table->string('dateOfBirth');
            $table->string('emailAddress');
            $table->string('poBox');
            $table->string('county');
            $table->string('nationality');
            $table->string('accountType');
            $table->string('memberPic');
            $table->string('slug');
            $table->softDeletes();
            $table->string('firstnameKin');
            $table->string('surnameKin');
            $table->string('lastnameKin');
            $table->string('maritalStatusKin');
            $table->string('occupationKin');
            $table->string('genderKin');
            $table->string('phoneNumberKin', 10);
            $table->string('idNumberKin', 8);
            $table->string('dateOfBirthKin');
            $table->string('relationshipKin');
            $table->string('emailAddressKin');
            $table->string('poBoxKin');
            $table->string('countyKin');
            $table->string('nationalityKin');
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
        Schema::drop('members');
    }
}
