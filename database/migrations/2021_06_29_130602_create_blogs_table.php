<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('blog_category_id')->unsigned();
            $table->string('slug');
            $table->string('title');
            $table->string('author');
            $table->text('content');
            $table->string('thumbnail');
            $table->string('cover_image');
            $table->integer('seo_meta_id');
            $table->string('is_active')->default(1);
            $table->string('is_featured')->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('blog_category_id')->references('id')->on('blogs');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('blogs');
    }
}
