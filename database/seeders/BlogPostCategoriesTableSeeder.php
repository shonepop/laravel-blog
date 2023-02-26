<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class BlogPostCategoriesTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        \DB::table("post_categories")->truncate();

        for ($i = 1; $i <= 5; $i++) {
            \DB::table("post_categories")->insert([
                "priority" => $i,
                "name" => "Category " . $i,
                "description" => "Description about category",
                "created_at" => date("Y-m-d H:i:s"),
                "updated_at" => date("Y-m-d H:i:s"),
            ]);
        }
    }

}
