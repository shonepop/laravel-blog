<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class BlogPostSliderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table("blog_post_slider")->truncate();

        for ($i = 1; $i <= 3; $i++) {
            \DB::table("blog_post_slider")->insert([
                "title" => "Title for blog post slider " . $i,
                "priority" => $i,
                "button_name" => "Button " .$i,
                "button_url" => "#",
                "created_at" => date("Y-m-d H:i:s"),
                "updated_at" => date("Y-m-d H:i:s"),
            ]);
        }
    }
}
