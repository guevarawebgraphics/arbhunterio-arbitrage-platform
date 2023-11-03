<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterGameoddsAddIndexing extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('gameodds', function (Blueprint $table) {
            $table->index('bet_type');
            $table->index('game_id');
            $table->index('selection');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::table('gameodds', function (Blueprint $table) {
            $table->dropIndex('bet_type');
            $table->dropIndex('game_id');
            $table->dropIndex('selection');
        });
    }
}
