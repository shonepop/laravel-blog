<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         $this->call(UsersTableSeeder::class);
         $this->call(BlogPostCategoriesTableSeeder::class);
         $this->call(BlogPostCommentsSeeder::class);
         $this->call(BlogPostsTableSeeder::class);
         $this->call(TagsTableSeeder::class);
         $this->call(BlogPostTagsTableSeeder::class);
         $this->call(BlogPostSliderSeeder::class);
     
    }
}
