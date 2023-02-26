<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blog_posts', function (Blueprint $table) {
            $table->bigIncrements("id");
            $table->tinyInteger("status")->default(1); 
            $table->string("photo")->nullable();
            $table->bigInteger("post_category_id");
            $table->string("title", 255);
            $table->bigInteger("author_id");
            $table->string("author_photo")->nullable();
            $table->string("author_name", 255);
            $table->bigInteger("visit_count")->default(0); 
            $table->text("description", 500);
            $table->longText("details")->nullable();
            $table->boolean("index_page")->default(0)->comment("If the post should be displayed on the index page"); 
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
        Schema::dropIfExists('blog_posts');
    }
}
