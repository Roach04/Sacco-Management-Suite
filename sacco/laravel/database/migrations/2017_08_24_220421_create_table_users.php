<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('firstname');
            $table->string('lastname');
            $table->string('phoneNumber', 10)->unique();
            $table->string('idNumber', 8)->unique();
            $table->string('jobTitle');
            $table->string('userPic');
            $table->string('emailAddress')->unique();
            $table->string('username');
            $table->string('password', 60);
            $table->string('active',5)->default(0);
            $table->string('role',5)->default(0);
            $table->string('code',60);
            $table->string('passTemp',60);
            $table->rememberToken();
            $table->timestamps();
            $table->string('slug');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
    }
}
