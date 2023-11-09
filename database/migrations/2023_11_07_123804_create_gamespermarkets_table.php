<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGamesPerMarketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gamespermarkets', function (Blueprint $table) {
            $table->increments('id');

            $table->string('game_id')->nullable();
            $table->string('bet_type')->nullable();
            $table->decimal('best_odds_a', 8,2 )->nullable();
            $table->decimal('best_odds_b', 8,2 )->nullable();
            $table->string('selection_line_a')->nullable();
            $table->string('selection_line_b')->nullable();

            $table->decimal('profit_percentage', 8,2 )->nullable();
            $table->longtext('sportsbook_a')->nullable();
            $table->longtext('sportsbook_b')->nullable();

            $table->decimal('is_below_one', 8, 2)->default(0.00)->comment('computed using this formula ( 1 / $best_odds_a ) + ( 1 / $best_odds_b ) < 1 ');

            $table->tinyInteger('is_active')->default(1);
            
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
        Schema::dropIfExists('gamespermarkets');
    }
}