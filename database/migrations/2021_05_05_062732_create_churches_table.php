<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChurchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('churches', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
            $table->string('denomination')->nullable(true);
            $table->string('venue')->nullable(true);
            $table->date('days')->nullable(true);
            $table->string('language')->nullable(true);
            $table->string('Social')->nullable(true);
            $table->string('vision')->nullable(true);
            $table->string('leadership')->nullable(true);
            $table->string('ministries')->nullable(true);
            $table->string('event')->nullable(true);
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
        Schema::dropIfExists('churches');
    }
}
