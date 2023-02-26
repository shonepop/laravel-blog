<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Tag;
use App\Models\PostCategory;
use Illuminate\Validation\Rule;
use App\Models\User;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;

class PostsController extends Controller {

    /**
     * Display blog posts in the dashboard.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {

        //get all post categories
        $postCategories = PostCategory::all();
        //get all authors 
        $authors = User::all();
        //get all tags
        $tags = Tag::all();

        return view("admin.posts.index", [
            "postCategories" => $postCategories,
            "authors" => $authors,
            "tags" => $tags,
        ]);
    }

    /**
     * Make datatable with specific columns and rows
     * search posts by id, title, category, author, status, description, tags
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Yajra\DataTables\EloquentDataTable
     */
    public function datatable(Request $request, Post $post) {

        //validate inputs from search form
        $searchFilters = $request->validate([
            "title" => ["nullable", "string", "max:255"],
            "post_category_id" => ["nullable", "numeric", "exists:post_categories,id"],
            "author_id" => ["nullable", "numeric", "exists:users,id"],
            "index_page" => ["nullable", "in:0,1"],
            "status" => ["nullable", "in:0,1"],
            "tags" => ["nullable", "array", "exists:tags,id"],
        ]);

        //scope a query to include blog posts
        $query = $post->getDatatablePosts();

        //conversion of Eloquent Model into a readable DataTable API response
        $dataTable = \DataTables::of($query);

        //add and edit columns in datatable
        $dataTable->editColumn("id", function ($post) {
                    return "#" . $post->id;
                })
                ->editColumn("photo", function ($post) {
                    return view("admin.posts.partials.photo", ["post" => $post]);
                })
                ->editColumn("title", function ($post) {
                    return "<strong>" . e($post->title) . "</strong>";
                })
                ->addColumn("status", function ($post) {
                    return view("admin.posts.partials.status", ["post" => $post]);
                })
                ->editColumn("index_page", function ($post) {
                    return view("admin.posts.partials.important", ["post" => $post]);
                })
                ->addColumn("tags", function ($post) {
                    return $post->tags->pluck("name")->join(", ");
                })
                ->addColumn("comments_count", function ($post) {
                    return $post->comments_count;
                })
                ->addColumn("actions", function ($post) {
                    return view("admin.posts.partials.actions", ["post" => $post]);
                });

        //the columns remain as they are, without passing through the datatable functions
        $dataTable->rawColumns(["title", "status", "photo", "actions"]);

        //use of an anonymous function to filter datatable
        $dataTable->filter(function ($query) use ($request, $searchFilters) {
            if (
            //get a search term from search form
                    $request->has("search") &&
                    is_array($request->get("search")) &&
                    isset($request->get("search")["value"])
            ) {
                $searchTerm = $request->get("search")["value"];

                //use search term to filter datatable
                $query->where(function ($query) use ($searchTerm) {
                    $query->orWhere("blog_posts.title", "LIKE", "%" . $searchTerm . "%")
                            ->orWhere("blog_posts.description", "LIKE", "%" . $searchTerm . "%")
                            ->orWhere("post_categories.name", "LIKE", "%" . $searchTerm . "%")
                            ->orWhere("blog_posts.id", "=", $searchTerm);
                });
            }

            //use search filters to filter datatable
            if (isset($searchFilters["title"])) {
                $query->where("blog_posts.title", "LIKE", "%" . $searchFilters["title"] . "%");
            }
            if (isset($searchFilters["post_category_id"])) {
                $query->where("blog_posts.post_category_id", "LIKE", "%" . $searchFilters["post_category_id"] . "%");
            }
            if (isset($searchFilters["author_id"])) {
                $query->where("blog_posts.author_id", "=", $searchFilters["author_id"]);
            }
            if (isset($searchFilters["index_page"])) {
                $query->where("blog_posts.index_page", "LIKE", "%" . $searchFilters["index_page"] . "%");
            }
            if (isset($searchFilters["status"])) {
                $query->where("blog_posts.status", "LIKE", "%" . $searchFilters["status"] . "%");
            }
            if (isset($searchFilters["tags"])) {
                $query->whereHas("tags", function ($subquery) use ($searchFilters) {
                    $subquery->whereIn("tag_id", $searchFilters["tags"]);
                });
            }
        });

        //makes JSON according to the datatables specification
        return $dataTable->make(true);
    }

    /**
     * Display form to add new blog post.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PostCategory  $postCategory
     * @return \Illuminate\Http\Response
     */
    public function add(Request $request, PostCategory $postCategory) {

        //get all post categories
        $postCategories = $postCategory->getPostCategories();
        //get all post tags
        $tags = Tag::all();

        return view("admin.posts.add", [
            "postCategories" => $postCategories,
            "tags" => $tags,
        ]);
    }

    /**
     * Add new blog post to the database.
     *
     * @param  \Illuminate\Http\StorePostRequest $request
     * @return \Illuminate\Support\Facades\Route
     * 
     * @throws \Illuminate\Validation\ValidationException
     */
    public function insert(StorePostRequest $request) {

        //validate inputs
        $formData = $request->validated();
        //set author id
        $formData["author_id"] = \Auth::user()->id;
        //set author photo
        $formData["author_photo"] = \Auth::user()->photo;

        //check if author id is data from current logged in user
        if ($formData["author_id"] != \Auth::user()->id) {
            $formData["author_id"] = \Auth::user()->id;
            //check if author name is data from current logged in user
        } else if ($formData["author_name"] != \Auth::user()->name) {
            $formData["author_name"] = \Auth::user()->name;
            //check if author photo is data from current logged in user
        } else if ($formData["author_photo"] != \Auth::user()->photo) {
            $formData["author_photo"] = \Auth::user()->photo;
        }

        //new model in memory
        $newPost = new Post();
        //mass asignment
        $newPost->fill($formData);
        //an insert query is performed on the database
        $newPost->save();

        //the sync function over the relation, serves to maintain the relation many to many
        $newPost->tags()->sync($formData["tag_id"]);

        //handle the upload cover photo for blog post
        $this->handlePhotoUpload("photo", $request, $newPost);

        session()->flash("system_message", __("New post has been successfully added!"));
        //redirect to route with system message
        return redirect()->route("admin.posts.index");
    }

    /**
     * Edit blog post.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @param  \App\Models\PostCategory  $postCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Post $post, PostCategory $postCategory) {

        //get all post categories
        $postCategories = $postCategory->getPostCategories();
        //get all tags
        $tags = Tag::all();

        return view("admin.posts.edit", [
            "post" => $post,
            "postCategories" => $postCategories,
            "tags" => $tags,
        ]);
    }

    /**
     * Update blog post.
     *
     * @param  \Illuminate\Http\UpdatePostRequest  $request
     * @param  \App\Models\PostCategory  $postCategory
     * @return \Illuminate\Support\Facades\Route
     * 
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(UpdatePostRequest $request, Post $post) {

        //validate inputs
        $formData = $request->validated();
        //set author id
        $formData["author_id"] = \Auth::user()->id;
        //set author photo
        $formData["author_photo"] = \Auth::user()->photo;

        //check if author id is data from current logged in user
        if ($formData["author_id"] != \Auth::user()->id) {
            $formData["author_id"] = \Auth::user()->id;
            //check if author name is data from current logged in user
        } else if ($formData["author_name"] != \Auth::user()->name) {
            $formData["author_name"] = \Auth::user()->name;
            //check if author photo is data from current logged in user
        } else if ($formData["author_photo"] != \Auth::user()->photo) {
            $formData["author_photo"] = \Auth::user()->photo;
        }

        //mass asignment
        $post->fill($formData);
        //an update query is performed on the database
        $post->save();

        //the sync function over the relation, serves to maintain the relation many to many
        $post->tags()->sync($formData["tag_id"]);

        //handle the upload for post cover photo
        $this->handlePhotoUpload("photo", $request, $post);

        session()->flash("system_message", __("The post has been edited!"));
        //redirect to route with system message
        return redirect()->route("admin.posts.index");
    }

    /**
     * Delete the cover photo of the blog post.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function deletePhoto(Request $request, Post $post) {

        //delete a post photo
        $post->deletePhoto();
        //set photo value to null
        $post->photo = null;
        //save to the DB
        $post->save();

        return response()->json([
                    "system_message" => __("The post photo has been deleted!"),
                    "photo_url" => $post->getPhotoUrl()
        ]);
    }

    /**
     * Delete the blog post.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * 
     * @throws \Illuminate\Validation\ValidationException
     * @throws \ModelNotFoundException
     */
    public function delete(Request $request) {

        //validate input
        $formData = $request->validate([
            "id" => ["required", "numeric", "exists:blog_posts,id"]
        ]);

        //find post by id or throw ModelNotFoundException
        $post = Post::findOrFail($formData["id"]);
        //deleting a row from the database
        $post->delete();

        //maintenance of relations, delete post_id in table post_tags
        \DB::table("post_tags")
                ->where("post_id", $formData["id"])
                ->delete();

        //delete a post photo
        $post->deletePhoto();

        //return json response with system message
        return response()->json([
                    "system_message" => __("The post has been deleted!"),
        ]);
    }

    /**
     * Find post by id and change his status to enabled.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * 
     * @throws \Illuminate\Validation\ValidationException
     * @throws \ModelNotFoundException
     */
    public function enable(Request $request) {

        //validate input
        $formData = $request->validate([
            "id" => ["required", "numeric", "exists:blog_posts,id"]
        ]);

        //find post by id and update status, or throw ModelNotFoundException
        Post::findOrFail($formData["id"])->update(["status" => Post::STATUS_ENABLED]);

        return response()->json([
                    "system_message" => __("The post has been enabled!"),
        ]);
    }

    /**
     * Find post by id and change his status to disabled.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * 
     * @throws \Illuminate\Validation\ValidationException
     * @throws \ModelNotFoundException
     */
    public function disable(Request $request) {

        //validate inputs
        $formData = $request->validate([
            "id" => ["required", "numeric", "exists:blog_posts,id"]
        ]);

        //find post by id and update status, or throw ModelNotFoundException
        Post::findOrFail($formData["id"])->update(["status" => Post::STATUS_DISABLED]);

        return response()->json([
                    "system_message" => __("The post has been disabled!"),
        ]);
    }

    /**
     * Find post by id and change his index page to important.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * 
     * @throws \Illuminate\Validation\ValidationException
     * @throws \ModelNotFoundException
     */
    public function important(Request $request) {

        //validate inputs
        $formData = $request->validate([
            "id" => ["required", "numeric", "exists:blog_posts,id"]
        ]);

        //find post by id and update index page status, or throw ModelNotFoundException
        Post::findOrFail($formData["id"])->update(["index_page" => Post::POST_IMPORTANT]);

        //return json response with system message
        return response()->json([
                    "system_message" => __("The post has been mark as important!"),
        ]);
    }

    /**
     * Find post by id and change his index page to regular.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * 
     * @throws \Illuminate\Validation\ValidationException
     * @throws \ModelNotFoundException
     */
    public function regular(Request $request) {

        //validate inputs
        $formData = $request->validate([
            "id" => ["required", "numeric", "exists:blog_posts,id"]
        ]);

        //find post by id and update index page status, or throw ModelNotFoundException
        Post::findOrFail($formData["id"])->update(["index_page" => Post::POST_REGULAR]);

        //return json response with system message
        return response()->json([
                    "system_message" => __("The post has been mark as regular!"),
        ]);
    }

    /**
     * Handle the upload of post cover photo.
     * 
     * @param string $photoFieldName
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return void
     */
    protected function handlePhotoUpload(string $photoFieldName, Request $request, Post $post) {

        //check if photo has been uploaded
        if ($request->hasFile($photoFieldName)) {

            //delete existing photo
            $post->deletePhoto();
            //get a uploaded photo
            $photoFile = $request->file($photoFieldName);
            //set a photo file name
            $photoFileName = $post->id . "_" . $photoFieldName . "_" . $photoFile->getClientOriginalName();
            //move photo to /storage/posts/
            $photoFile->move(
                    public_path("/storage/posts/"),
                    $photoFileName
            );
            //set post photo
            $post->$photoFieldName = $photoFileName;
            //save post photo to the DB
            $post->save();

            //use of Intervention\Image\Facades\Image to fit and save post photo
            \Image::make(public_path("/storage/posts/" . $post->$photoFieldName))
                    ->fit(730, 486)
                    ->save();

            //use of Intervention\Image\Facades\Image to fit and save thumb post photo
            \Image::make(public_path("/storage/posts/" . $post->$photoFieldName))
                    ->fit(256, 256)
                    ->save(public_path("/storage/posts/thumbs/" . $post->$photoFieldName));
        }
    }

}
