<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSaveFiltersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('savefilters', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('user_id');

            $table->string('name')->default('Filter')->nullable();

            $table->decimal('min_profit', 8,2 )->default(0.00);
            $table->decimal('max_profit', 8,2 )->default(0.00);

            $table->longtext('sportsbook')->nullable();
            $table->longtext('sports')->nullable();
            $table->longtext('markets')->nullable();

            $table->string('datetime')->default(0)->comment('0=current; 1=today; 2=Next24 hours');

            $table->string('is_alert')->default(0)->comment('0=false; 1=true; email alert');


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
        Schema::dropIfExists('savefilters');
    }
}