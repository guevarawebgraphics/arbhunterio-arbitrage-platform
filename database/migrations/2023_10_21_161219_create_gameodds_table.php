<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGameOddsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gameodds', function (Blueprint $table) {
            
            $table->bigIncrements('id');
            $table->longtext('bet_name')->nullable();
            $table->decimal('bet_points', 8,2 )->default(0.00)->nullable();
            $table->integer('bet_price')->default(0.00)->nullable();
            $table->string('bet_type')->nullable();
            $table->string('game_id')->nullable();
            $table->string('uid')->nullable();
            $table->string('is_live')->default('false')->nullable();
            $table->string('is_main')->default('false')->nullable();
            $table->string('league')->nullable();
            $table->string('player_id')->nullable();
            $table->string('selection')->nullable();
            $table->string('selection_line')->nullable();
            $table->decimal('selection_points')->default(0.00)->nullable();
            $table->longtext('sport')->nullable();
            $table->longtext('sportsbook')->nullable();
            $table->string('timestamp')->nullable();
            $table->string('entry_id')->nullable();
            $table->string('type')->default(0);
            $table->string('market')->nullable();
            $table->string('team_type')->nullable()->comment('0=Home; 1=Away;');
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
        Schema::dropIfExists('gameodds');
    }
}