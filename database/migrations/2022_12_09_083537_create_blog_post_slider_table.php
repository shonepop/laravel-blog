<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogPostSliderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blog_post_slider', function (Blueprint $table) {
            $table->bigIncrements("id");
            $table->tinyInteger('status')->default(1);
            $table->integer('priority');
            $table->string("photo")->nullable();
            $table->string("title");
            $table->string("button_name");
            $table->string("button_url");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('blog_post_slider');
    }
}
