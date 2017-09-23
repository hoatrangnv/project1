<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('news')) {
            return false;
        }
        Schema::create('news', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->smallInteger('category_id')->nullable();
            $table->string('image')->nullable();
            $table->text('short_desc')->nullable();
            $table->text('desc')->nullable();
            $table->dateTime('public_at')->nullable();
            $table->integer('created_by')->unsigned();
            $table->integer('priority')->unsigned()->default(0);
            $table->bigInteger('views')->nullable();
            $table->timestamps();
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
        Schema::drop('news');
    }
}
