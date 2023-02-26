<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class BlogPostCommentsSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        \DB::table("post_comments")->truncate();

        for ($i = 1; $i <=100; $i++) {
            \DB::table("post_comments")->insert([
                "post_id" => $i,
                "author_name" => "John Doe" . $i,
                "author_email" => "johndoe@gmail.com",
                "description" => "Some comment description " . $i,
                "created_at" => date("Y-m-d H:i:s"),
                "updated_at" => date("Y-m-d H:i:s"),
            ]);
        }
    }

}
