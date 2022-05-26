<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCouponCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupon_codes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 191);
            $table->integer('user_id');
            $table->string('code', 255);
            $table->decimal('value', 10, 2);
            $table->integer('type')->comment('1 - Percentage, 2 - Amount');
            $table->integer('times_of_use');
            $table->integer('used');
            $table->integer('once_per_customer');
            $table->string('apply_category')->nullable();
            $table->string('apply_product')->nullable();
            $table->string('is_no_time_limit');
            $table->timestamp('date_start')->nullable()->default(null);
            $table->timestamp('date_end')->nullable()->default(null);
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
        Schema::dropIfExists('coupon_codes');
    }
}
