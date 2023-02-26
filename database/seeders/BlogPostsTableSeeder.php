<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class BlogPostsTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        \DB::table("blog_posts")->truncate();

        $faker = \Faker\Factory::create();

        $postCategoryIds = \DB::table("post_categories")->get()->pluck("id");
        $postAuthors = \DB::table("users")->get();

        foreach ($postAuthors as $postAuthor) {
            for ($i = 1; $i <= 20; $i++) {

                \DB::table("blog_posts")->insert([
                    "post_category_id" => $postCategoryIds->random(),
                    "title" => $faker->sentence,
                    "description" => $faker->text(255),
                    "author_id" => $postAuthor->id,
                    "author_name" => $postAuthor->name,
                    "created_at" => date("Y-m-d H:i:s"),
                    "updated_at" => date("Y-m-d H:i:s"),
                ]);
            }
        }
    }

}
