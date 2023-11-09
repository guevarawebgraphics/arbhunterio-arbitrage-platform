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
            $table->index('selection_line');
            $table->index(['sportsbook'], 'sportsbook_index')->length(9000000); 
            $table->index('bet_price');
            $table->index('selection_points');
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

            $table->dropIndex('selection_line');
            $table->dropIndex('sportsbook_index');
            $table->dropIndex('bet_price');
            $table->dropIndex('selection_points');

        });
    }
}
