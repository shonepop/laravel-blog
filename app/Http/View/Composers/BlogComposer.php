<?php

namespace App\Http\View\Composers;

use Illuminate\View\View;
use App\Models\Post;
use App\Models\PostCategory;
use App\Models\Tag;

class BlogComposer {

    public function compose(View $view) {

        /**
         * Scope a query only to include the 3 most visited blog posts in sidebar.
         * @return Illuminate\Database\Eloquent\Collection
         */
        $view->with("latestPosts", Post::sidebarLatestPosts());
        
        /**
         * Scope a query to include all blog post categories in sidebar.
         * @return Illuminate\Database\Eloquent\Collection
         */
        $view->with("postCategories", PostCategory::sidebarPostCategories());

        /**
         * Scope a query to include all blog post tags in sidebar.
         * @return Illuminate\Database\Eloquent\Collection
         */
        $view->with("postTags", Tag::sidebarTags());
    }
}