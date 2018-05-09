<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use Carbon\Carbon;

class CreateTableAccounts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('member_id')->index()->unsigned();
            $table->foreign('member_id')->references('id')->on('members')->onDelete('cascade')->onUpdate('cascade');
            $table->string('bank',50);
            $table->integer('money')->default(0);
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
        Schema::drop('accounts');
    }
}
