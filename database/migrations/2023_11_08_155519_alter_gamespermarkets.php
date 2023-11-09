<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterGamespermarkets extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('gamespermarkets', function (Blueprint $table) {
            $table->index('game_id');
            $table->index('bet_type');
            $table->index('best_odds_a');
            $table->index('best_odds_b');
            $table->index('selection_line_a');
            $table->index('selection_line_b');
            $table->index('profit_percentage');
            // $table->index('sportsbook_a');
            // $table->index('sportsbook_b');
            $table->index(['sportsbook_a'], 'sportsbook_a_index')->length(9000000); 
            $table->index(['sportsbook_b'], 'sportsbook_b_index')->length(9000000); 
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
        Schema::table('gamespermarkets', function (Blueprint $table) {
            $table->dropIndex('game_id');
            $table->dropIndex('bet_type');
            $table->dropIndex('best_odds_a');
            $table->dropIndex('best_odds_b');
            $table->dropIndex('selection_line_a');
            $table->dropIndex('selection_line_b');
            $table->dropIndex('profit_percentage');
            $table->dropIndex('sportsbook_a');
            $table->dropIndex('sportsbook_b');

        });
    }
}
