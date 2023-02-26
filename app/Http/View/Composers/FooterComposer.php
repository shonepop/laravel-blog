<?php

namespace App\Http\View\Composers;

use Illuminate\View\View;
use App\Models\Post;
use App\Models\PostCategory;

class FooterComposer {

    public function compose(View $view) {

        /**
         * Scope a query only to include the last 4 created post categories.
         * @return Illuminate\Database\Eloquent\Collection
         */
        $view->with("footerPostCategories", cache()->remember('footerPostCategories', 60, function () {
                    //get footer blog posts
                    return PostCategory::footerPostCategories();
                }));
        /**
         * Scope a query only to include the last 3 created blog posts.
         * @return Illuminate\Database\Eloquent\Collection
         */
        $view->with("footerBlogPosts", cache()->remember('footerBlogPosts', 60, function () {
                    //get footer blog posts
                    return Post::footerBlogPosts();
                }));
    }

}
