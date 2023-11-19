<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnGamesPerMarketIsHidden extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
    */
    public function up()
    {
        Schema::table('gamespermarkets', function (Blueprint $table) {
            $table->string('is_hidden')->default(0)->comment('0=Visible; 1=hidden');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('gamespermarkets', function (Blueprint $table) {
            $table->dropColumn('is_hidden');
        });
    }
}
