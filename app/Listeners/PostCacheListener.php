<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Cache;
use App\Models\Post;
use App\Models\PostSlider;

class PostCacheListener {

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct() {
//
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event) {

//        Cache::forget('sliderPosts');
//        Cache::forget('posts');
//        Cache::forget('latestPosts');
//        
//        Cache::forever('sliderPosts', PostSlider::getSliderPosts());
//        Cache::forever('posts', Post::getImportantPosts());
//        Cache::forever('latestPosts', Post::getLatestPosts());
    }

}
