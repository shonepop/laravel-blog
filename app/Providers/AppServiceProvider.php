<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use App\Http\View\Composers\BlogComposer;
use App\Http\View\Composers\FooterComposer;

class AppServiceProvider extends ServiceProvider {

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register() {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot() {
        Paginator::useBootstrap();
        
        View::composer(["front.blog.index", "front.blog.post", "front.blog.category", "front.blog.tag", "front.blog.author", "front.blog.search_page", "errors::*", "errors.*"], BlogComposer::class);
        View::composer(["front.index.index","front.blog.index", "front.blog.post", "front.blog.category", "front.blog.tag", "front.blog.author", "front.blog.search_page", "front.contact.index", "errors::*", "errors.*"], FooterComposer::class);
    }

}
