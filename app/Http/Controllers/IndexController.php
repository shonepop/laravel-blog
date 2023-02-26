<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\PostSlider;

class IndexController extends Controller {

    /**
     * Display blog posts on the homepage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post $post
     * @param  \App\Models\PostSlider $postSlider
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {

        $sliderPosts = cache()->remember('sliderPosts', 60, function () {
            //get slider posts
            return PostSlider::getSliderPosts();
        });

        $posts = cache()->remember('posts', 60, function () {
            //get blog posts marked as important
            return Post::getImportantPosts();
        });

        $latestPosts = cache()->remember('latestPosts', 60, function () {
            //get the 12 latest blog posts 
            return Post::getLatestPosts();
        });

        return view("front.index.index", [
            "posts" => $posts,
            "latestPosts" => $latestPosts,
            "sliderPosts" => $sliderPosts,
        ]);
    }

}
