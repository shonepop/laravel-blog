<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\PostCategory;
use Illuminate\Validation\Rule;

class PostCategoriesController extends Controller {

    /**
     * Display blog post categories in the dashboard.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PostCategory  $postCategory
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, PostCategory $postCategory) {

        //get all post categories
        $postCategories = $postCategory->getPostCategories();

        return view("admin.post_categories.index", [
            "postCategories" => $postCategories
        ]);
    }

    /**
     * Display form to add new post category.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function add(Request $request) {
        return view("admin.post_categories.add");
    }

    /**
     * Add new blog post category to the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PostCategory  $postCategory
     * @return \Illuminate\Support\Facades\Route
     * 
     * @throws \Illuminate\Validation\ValidationException
     */
    public function insert(Request $request, PostCategory $postCategory) {

        //validate inputs
        $formData = $request->validate([
            "name" => ["required", "string", "min:2", "max:255", "unique:post_categories,name"],
            "description" => ["nullable", "string", "min:10", "max:255"],
        ]);

        //new model in memory
        $newPostCategory = new PostCategory();
        //mass asignment
        $newPostCategory->fill($formData);

        //get post category with highest priority
        $postCategoryWithHighestPriority = $postCategory->getCategoryWithHighestPriority();

        //check if post category with highest priority exist
        if ($postCategoryWithHighestPriority) {
            //set new category priority plus 1 in relation to the already existing highest priority
            $newPostCategory->priority = $postCategoryWithHighestPriority->priority + 1;
        } else {
            //set the priority to 1 for the new post category
            $newPostCategory->priority = 1;
        }
        //an insert query is performed on the database
        $newPostCategory->save();

        session()->flash("system_message", __("New post category has been successfully added"));
        //redirect to route with system message
        return redirect()->route("admin.post_categories.index");
    }

    /**
     * Edit blog post category.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PostCategory  $postCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, PostCategory $postCategory) {
        return view("admin.post_categories.edit", [
            "postCategory" => $postCategory
        ]);
    }

    /**
     * Update blog post category.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PostCategory  $postCategory
     * @return \Illuminate\Support\Facades\Route
     * 
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, PostCategory $postCategory) {

        //validate inputs
        $formData = $request->validate([
            "name" => ["required", "string", "min:2", "max:255", Rule::unique("post_categories")->ignore($postCategory->id)],
            "description" => ["nullable", "string", "min:10", "max:255"],
        ]);

        //mass asignment
        $postCategory->fill($formData);
        //an update query is performed on the database
        $postCategory->save();

        session()->flash("system_message", __("The post category has been successfully edited"));
        //redirect to route with system message
        return redirect()->route("admin.post_categories.index");
    }

    /**
     * Reorder blog post categories priority in the dashboard.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Support\Facades\Route
     * 
     * @throws \Illuminate\Validation\ValidationException
     * @throws \ModelNotFoundException
     */
    public function changePriorities(Request $request) {

        //validate inputs
        $formData = $request->validate([
            "priorities" => ["required", "string"]
        ]);

        //breaks a string 'priorities' into an array
        $priorities = explode(",", $formData["priorities"]);

        foreach ($priorities as $key => $id) {
            //find post category by id or throw ModelNotFoundException
            $postCategory = PostCategory::findOrFail($id);
            //set post category priority plus 1 in relation to $key value
            $postCategory->priority = $key + 1;
            //an update query is performed on the database
            $postCategory->save();
        }

        session()->flash("system_message", __("Post categories have been reorder"));
        //redirect to route with system message
        return redirect()->route("admin.post_categories.index");
    }

    /**
     * Delete the blog post category.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Support\Facades\Route
     * 
     * @throws \Illuminate\Validation\ValidationException
     * @throws \ModelNotFoundException
     */
    public function delete(Request $request, Post $post) {

        //validate inputs
        $formData = $request->validate([
            "id" => ["required", "numeric", "exists:post_categories,id"]
        ]);

        //find post category by id or throw ModelNotFoundException
        $postCategory = PostCategory::findOrFail($formData["id"]);
        //deleting a row from the database
        $postCategory->delete();

        //decrement the priority value of post categories 
        PostCategory::query()
                ->where("priority", ">", $postCategory->priority)
                ->decrement("priority");

        //set the post_category_id to 1 for blog posts that don't have a category
        $post->setPostCategoryId($formData["id"]);

        session()->flash("system_message", __("The post category has been deleted"));
        //redirect to route with system message
        return redirect()->route("admin.post_categories.index");
    }

}
