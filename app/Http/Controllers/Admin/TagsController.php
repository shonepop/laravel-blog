<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tag;
use Illuminate\Validation\Rule;

class TagsController extends Controller {

    /**
     * Display post tags in the dashboard.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {

        //get all post tags
        $tags = Tag::all();

        return view("admin.tags.index", [
            "tags" => $tags
        ]);
    }

    /**
     * Display form to add new blog post tag.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function add(Request $request) {
        return view("admin.tags.add");
    }

    /**
     * Add new blog post tag to the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Support\Facades\Route
     * 
     * @throws \Illuminate\Validation\ValidationException
     */
    public function insert(Request $request) {

        //validate input
        $formData = $request->validate([
            "name" => ["required", "string", "min:2", "max:255", "unique:tags,name"],
        ]);

        //new model in memory
        $newPostTag = new Tag();
        //mass asignment
        $newPostTag->fill($formData);
        //an insert query is performed on the database
        $newPostTag->save();

        session()->flash("system_message", __("New post tag has been successfully added"));
        //redirect to route with system message
        return redirect()->route("admin.tags.index");
    }

    /**
     * Edit blog post tag.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Tag $tag) {

        return view("admin.tags.edit", [
            "tag" => $tag
        ]);
    }

    /**
     * Update blog post tag.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Support\Facades\Route
     * 
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, Tag $tag) {

        //validate input
        $formData = $request->validate([
            "name" => ["required", "string", "min:2", "max:255", Rule::unique("tags")->ignore($tag->id)],
        ]);

        //mass asignment
        $tag->fill($formData);
        //an update query is performed on the database
        $tag->save();

        session()->flash("system_message", __("The post tag has been successfully edited"));
        //redirect to route with system message
        return redirect()->route("admin.tags.index");
    }

    /**
     * Delete the blog post tag.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Support\Facades\Route
     * 
     * @throws \Illuminate\Validation\ValidationException
     * @throws \ModelNotFoundException
     */
    public function delete(Request $request) {

        //validate input
        $formData = $request->validate([
            "id" => ["required", "numeric", "exists:tags,id"]
        ]);

        //find post tag by id or throw ModelNotFoundException
        $postTag = Tag::findOrFail($formData["id"]);
        //deleting a row from the database
        $postTag->delete();

        //maintenance of relations, delete tag_id in table post_tags
        \DB::table("post_tags")
                ->where("tag_id", "=", $postTag->id)
                ->delete();

        session()->flash("system_message", __("The post tag has been deleted"));
        //redirect to route with system message
        return redirect()->route("admin.tags.index");
    }

}
