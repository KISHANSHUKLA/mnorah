<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeUserflagTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('appusers', function (Blueprint $table) {
            $table->string('Leadershipteam')->default(0);
            $table->string('medicallyverified')->default(0);
            $table->string('communityverified')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('appusers', function (Blueprint $table) {
            $table->string('Leadershipteam')->default(0);
            $table->string('medicallyverified')->default(0);
            $table->string('communityverified')->default(0);
        });
    }
}
