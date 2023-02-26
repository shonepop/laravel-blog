<?php

use Illuminate\Support\Facades\Route;

/*
  |--------------------------------------------------------------------------
  | Web Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register web routes for your application. These
  | routes are loaded by the RouteServiceProvider within a group which
  | contains the "web" middleware group. Now create something great!
  |
 */

Route::get("/", "App\Http\Controllers\IndexController@index")->name("front.index.index");

Route::prefix("/blog")->group(function () {
    Route::get("/", "App\Http\Controllers\BlogController@index")->name("front.blog.index");
    Route::get("/post/{post}/{seoSlug?}", "App\Http\Controllers\BlogController@post")->name("front.blog.post");
    Route::get("/author/{post}/{seoSlug?}", "App\Http\Controllers\BlogController@author")->name("front.blog.author");
 
    Route::get("/category/{category}/{seoSlug?}", "App\Http\Controllers\BlogController@category")->name("front.blog.category");
    Route::get("/tag/{tag}/{seoSlug?}", "App\Http\Controllers\BlogController@tag")->name("front.blog.tag");

    Route::get("/search/{searchTerm}", "App\Http\Controllers\BlogController@searchPage")->name("front.blog.search_page");
    Route::post("/search", "App\Http\Controllers\BlogController@search")->name("front.blog.search");

    Route::get("/comments", "App\Http\Controllers\BlogController@comments")->name("front.blog.comments");
    Route::post("/add-comment", "App\Http\Controllers\BlogController@addComment")->name("front.blog.add_comment");
});

Route::prefix("/contact")->group(function () {

    Route::get("/", "App\Http\Controllers\ContactController@index")->name("front.contact.index");
    Route::post("/send-message", "App\Http\Controllers\ContactController@sendMessage")->name("front.contact.send_message");
});

Auth::routes();

Route::middleware("auth")->prefix("/admin")->group(function () {

    Route::get("/", "App\Http\Controllers\Admin\IndexController@index")->name("admin.index.index");

    Route::prefix("/posts")->group(function () {
        Route::get("/", "App\Http\Controllers\Admin\PostsController@index")->name("admin.posts.index");

        Route::get("/add", "App\Http\Controllers\Admin\PostsController@add")->name("admin.posts.add");
        Route::post("/insert", "App\Http\Controllers\Admin\PostsController@insert")->name("admin.posts.insert");

        Route::get("/edit/{post}", "App\Http\Controllers\Admin\PostsController@edit")->name("admin.posts.edit");
        Route::post("/update/{post}", "App\Http\Controllers\Admin\PostsController@update")->name("admin.posts.update");

        Route::post("/delete", "App\Http\Controllers\Admin\PostsController@delete")->name("admin.posts.delete");
        Route::post("/delete-photo/{post}", "App\Http\Controllers\Admin\PostsController@deletePhoto")->name("admin.posts.delete_photo");
        Route::post("/datatable", "App\Http\Controllers\Admin\PostsController@datatable")->name("admin.posts.datatable");

        Route::post("/enable", "App\Http\Controllers\Admin\PostsController@enable")->name("admin.posts.enable");
        Route::post("/disable", "App\Http\Controllers\Admin\PostsController@disable")->name("admin.posts.disable");
        Route::post("/important", "App\Http\Controllers\Admin\PostsController@important")->name("admin.posts.important");
        Route::post("/regular", "App\Http\Controllers\Admin\PostsController@regular")->name("admin.posts.regular");
    });
    Route::prefix("/post-categories")->group(function () {
        Route::get("/", "App\Http\Controllers\Admin\PostCategoriesController@index")->name("admin.post_categories.index");

        Route::get("/add", "App\Http\Controllers\Admin\PostCategoriesController@add")->name("admin.post_categories.add");
        Route::post("/insert", "App\Http\Controllers\Admin\PostCategoriesController@insert")->name("admin.post_categories.insert");

        Route::get("/edit/{postCategory}", "App\Http\Controllers\Admin\PostCategoriesController@edit")->name("admin.post_categories.edit");
        Route::post("/update/{postCategory}", "App\Http\Controllers\Admin\PostCategoriesController@update")->name("admin.post_categories.update");

        Route::post("/delete", "App\Http\Controllers\Admin\PostCategoriesController@delete")->name("admin.post_categories.delete");

        Route::post("/change-priorities", "App\Http\Controllers\Admin\PostCategoriesController@changePriorities")->name("admin.post_categories.change_priorities");
    });
    Route::prefix("/tags")->group(function () {
        Route::get("/", "App\Http\Controllers\Admin\TagsController@index")->name("admin.tags.index");

        Route::get("/add", "App\Http\Controllers\Admin\TagsController@add")->name("admin.tags.add");
        Route::post("/insert", "App\Http\Controllers\Admin\TagsController@insert")->name("admin.tags.insert");

        Route::get("/edit/{tag}", "App\Http\Controllers\Admin\TagsController@edit")->name("admin.tags.edit");
        Route::post("/update/{tag}", "App\Http\Controllers\Admin\TagsController@update")->name("admin.tags.update");

        Route::post("/delete", "App\Http\Controllers\Admin\TagsController@delete")->name("admin.tags.delete");
    });
    Route::prefix("/slider")->group(function () {
        Route::get("/", "App\Http\Controllers\Admin\SliderController@index")->name("admin.slider.index");

        Route::get("/add", "App\Http\Controllers\Admin\SliderController@add")->name("admin.slider.add");
        Route::post("/insert", "App\Http\Controllers\Admin\SliderController@insert")->name("admin.slider.insert");

        Route::get("/edit/{post}", "App\Http\Controllers\Admin\SliderController@edit")->name("admin.slider.edit");
        Route::post("/update/{post}", "App\Http\Controllers\Admin\SliderController@update")->name("admin.slider.update");

        Route::post("/enable", "App\Http\Controllers\Admin\SliderController@enable")->name("admin.slider.enable");
        Route::post("/disable", "App\Http\Controllers\Admin\SliderController@disable")->name("admin.slider.disable");

        Route::post("/delete", "App\Http\Controllers\Admin\SliderController@delete")->name("admin.slider.delete");
        Route::post("/delete-photo/{post}", "App\Http\Controllers\Admin\SliderController@deletePhoto")->name("admin.slider.delete_photo");
        Route::post("/change-priorities", "App\Http\Controllers\Admin\SliderController@changePriorities")->name("admin.slider.change_priorities");
        Route::post("/datatable", "App\Http\Controllers\Admin\SliderController@datatable")->name("admin.slider.datatable");
    });
    Route::prefix("/comments")->group(function () {
        Route::get("/", "App\Http\Controllers\Admin\CommentsController@index")->name("admin.comments.index");

        Route::post("/datatable", "App\Http\Controllers\Admin\CommentsController@datatable")->name("admin.comments.datatable");

        Route::post("/enable", "App\Http\Controllers\Admin\CommentsController@enable")->name("admin.comments.enable");
        Route::post("/disable", "App\Http\Controllers\Admin\CommentsController@disable")->name("admin.comments.disable");
    });
    Route::prefix("/users")->group(function () {
        Route::get("/", "App\Http\Controllers\Admin\UsersController@index")->name("admin.users.index");

        Route::get("/add", "App\Http\Controllers\Admin\UsersController@add")->name("admin.users.add");
        Route::post("/insert", "App\Http\Controllers\Admin\UsersController@insert")->name("admin.users.insert");

        Route::get("/edit/{user}", "App\Http\Controllers\Admin\UsersController@edit")->name("admin.users.edit");
        Route::post("/update/{user}", "App\Http\Controllers\Admin\UsersController@update")->name("admin.users.update");

        Route::post("/delete-photo/{user}", "App\Http\Controllers\Admin\UsersController@deletePhoto")->name("admin.users.delete_photo");
        Route::post("/datatable", "App\Http\Controllers\Admin\UsersController@datatable")->name("admin.users.datatable");

        Route::post("/enable", "App\Http\Controllers\Admin\UsersController@enable")->name("admin.users.enable");
        Route::post("/disable", "App\Http\Controllers\Admin\UsersController@disable")->name("admin.users.disable");
    });
    Route::prefix("/profile")->group(function () {

        Route::get("/edit", "App\Http\Controllers\Admin\ProfileController@edit")->name("admin.profile.edit");
        Route::post("/update", "App\Http\Controllers\Admin\ProfileController@update")->name("admin.profile.update");

        Route::post("/delete-photo", "App\Http\Controllers\Admin\ProfileController@deletePhoto")->name("admin.profile.delete_photo");

        Route::get("/change-password", "App\Http\Controllers\Admin\ProfileController@changePassword")->name("admin.profile.change_password");
        Route::post("/change-password", "App\Http\Controllers\Admin\ProfileController@changePasswordConfirm")->name("admin.profile.change_password_confirm");
    });
});

