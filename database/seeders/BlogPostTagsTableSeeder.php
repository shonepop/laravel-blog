<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class BlogPostTagsTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        \DB::table("post_tags")->truncate();

        $postIds = \DB::table("blog_posts")->get()->pluck("id");
        $postTags = \DB::table("tags")->get()->pluck("id");

        foreach ($postIds as $postId) {

            $randomPostTags = $postTags->random(3);

            foreach ($randomPostTags as $postTag) {
                \DB::table("post_tags")->insert([
                    "post_id" => $postId,
                    "tag_id" => $postTag,
                    "created_at" => date("Y-m-d H:i:s"),
                    "updated_at" => date("Y-m-d H:i:s"),
                ]);
            }
        }
    }

}
