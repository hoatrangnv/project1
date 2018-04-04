<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserCoinsUsdsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('user_coin_usds')) {
            return false;
        }
        Schema::create('user_coin_usds', function (Blueprint $table) {
            $table->integer('userId')->unsigned()->unique();
            $table->double('usdAmountFree')->default(0)->nullable();
            $table->double('usdAmountHold')->default(0)->nullable();
        });        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_coin_usds');
    }
}
