<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFollowersTableTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    Schema::create('followers', function (Blueprint $table) {
        $table->increments('id');
        $table->integer('follower_id')->unsigned();
        $table->integer('church_id')->unsigned();
        $table->foreign('follower_id')->references('id')->on('users')->onDelete('cascade');
        $table->foreign('church_id')->references('id')->on('churches')->onDelete('cascade');
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
    Schema::drop('followers');
}
}
