<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenuDropdownTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menu_dropdown', function (Blueprint $table) {
            $table->id();
            $table->integer('menu_id');
            $table->string('name', 75);
            $table->string('is_page')->default(1);
            $table->integer('page_id');
            $table->string('link')->nullable();
            $table->string('open_in_new_tab')->default(0);
            $table->integer('order_number');
            $table->string('is_active')->default(1);
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
        Schema::dropIfExists('menu_dropdown');
    }
}
