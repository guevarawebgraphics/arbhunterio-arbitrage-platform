<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('games', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('uid')->nullable();
            $table->string('start_date')->nullable();
            $table->string('home_team')->nullable();
            $table->string('away_team')->nullable();
            $table->string('is_live')->nullable();
            $table->string('is_popular')->nullable();
            $table->string('tournament')->nullable();
            $table->string('status')->nullable();
            $table->longtext('sport')->nullable();
            $table->string('league')->nullable();
            $table->longtext('home_team_info')->nullable();
            $table->longtext('away_team_info')->nullable();
            $table->longtext('markets')->nullable();
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
        Schema::dropIfExists('games');
    }
}