<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImageGalleryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('image_gallery', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('gallery_group_id')->unsigned();
            $table->string('title');
            $table->text('content');
            $table->string('background_image');
            $table->text('json_contents')->nullable();
            $table->string('is_active')->default(1);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('gallery_group_id')->references('id')->on('gallery_group');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('image_gallery');
    }
}
