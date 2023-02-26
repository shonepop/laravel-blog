<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PostSlider;
use Illuminate\Validation\Rule;
use App\Http\Requests\StoreSliderRequest;
use App\Http\Requests\UpdateSliderRequest;

class SliderController extends Controller {

    /**
     * Display slider posts in the dashboard.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {

        //get all slider posts
        $posts = PostSlider::all();

        return view("admin.slider.index", [
            "posts" => $posts
        ]);
    }

    /**
     * Display form to add new slider post.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function add(Request $request) {
        return view("admin.slider.add");
    }

    /**
     * Add new slider post to the database.
     *
     * @param  \Illuminate\Http\StoreSliderRequest $request
     * @return \Illuminate\Support\Facades\Route
     * 
     * @throws \Illuminate\Validation\ValidationException
     */
    public function insert(StoreSliderRequest $request) {

        //validate inputs
        $formData = $request->validated();
        //new model in memory
        $newPostSlider = new PostSlider();
        //mass asignment
        $newPostSlider->fill($formData);

        //get slider post with highest priority
        $postSliderWithHighestPriority = PostSlider::getPostWithHighestPriority();

        //check if slider post with highest priority exist
        if ($postSliderWithHighestPriority) {
            //set new slider post priority plus 1 in relation to the already existing highest priority
            $newPostSlider->priority = $postSliderWithHighestPriority->priority + 1;
        } else {
            //set the priority to 1 for the new slider post
            $newPostSlider->priority = 1;
        }
        //an insert query is performed on the database
        $newPostSlider->save();
        //handle the upload cover photo for slider post
        $this->handlePhotoUpload($request, $newPostSlider);

        session()->flash("system_message", __("New post slider has been successfully added"));
        //redirect to route with system message
        return redirect()->route("admin.slider.index");
    }

    /**
     * Edit slider post.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PostSlider  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, PostSlider $post) {

        return view("admin.slider.edit", [
            "post" => $post
        ]);
    }

    /**
     * Update slider post.
     *
     * @param  \Illuminate\Http\UpdateSliderRequest $request
     * @param  \App\Models\PostSlider  $post
     * @return \Illuminate\Support\Facades\Route
     * 
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(UpdateSliderRequest $request, PostSlider $post) {

        //validate inputs
        $formData = $request->validated();
        //mass asignment
        $post->fill($formData);
        //an update query is performed on the database
        $post->save();

        //handle the upload for slider cover photo
        $this->handlePhotoUpload($request, $post);

        session()->flash("system_message", __("The post slider has been successfully edited"));
        //redirect to route with system message
        return redirect()->route("admin.slider.index");
    }

    /**
     * Delete the cover photo of the slider post.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PostSlider  $post
     * @return \Illuminate\Http\Response
     */
    public function deletePhoto(Request $request, PostSlider $post) {

        //delete a slider post photo
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
     * Reorder slider posts priority in the dashboard.
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
            //find slider post by id or throw ModelNotFoundException
            $postSlider = PostSlider::findOrFail($id);
            //set slider post priority plus 1 in relation to $key value
            $postSlider->priority = $key + 1;
            //an update query is performed on the database
            $postSlider->save();
        }

        session()->flash("system_message", __("Post slider have been reorder"));
        //redirect to route with system message
        return redirect()->route("admin.slider.index");
    }

    /**
     * Find slider post by id and change his status to enabled.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * 
     * @throws \Illuminate\Validation\ValidationException
     * @throws \ModelNotFoundException
     */
    public function enable(Request $request) {

        //validate inputs
        $formData = $request->validate([
            "id" => ["required", "numeric", "exists:blog_post_slider,id"]
        ]);

        //find post by id and update status, or throw ModelNotFoundException
        PostSlider::findOrFail($formData["id"])->update(["status" => PostSlider::STATUS_ENABLED]);

        return response()->json([
                    "system_message" => __("The post has been enabled!"),
        ]);
    }

    /**
     * Find slider post by id and change his status to disabled.
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
            "id" => ["required", "numeric", "exists:blog_post_slider,id"]
        ]);

        //find post by id and update status, or throw ModelNotFoundException
        PostSlider::findOrFail($formData["id"])->update(["status" => PostSlider::STATUS_DISABLED]);

        return response()->json([
                    "system_message" => __("The post has been disabled!"),
        ]);
    }

    /**
     * Delete the slider post.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Support\Facades\Route
     * 
     * @throws \Illuminate\Validation\ValidationException
     * @throws \ModelNotFoundException
     */
    public function delete(Request $request) {

        $formData = $request->validate([
            "id" => ["required", "numeric", "exists:blog_post_slider,id"]
        ]);

        $postSlider = PostSlider::findOrFail($formData["id"]);
        $postSlider->delete();

        PostSlider::query()
                ->where("priority", ">", $postSlider->priority)
                ->decrement("priority");

        return response()->json([
                    "system_message" => __("The post has been deleted!"),
        ]);
    }

    /**
     * Make datatable with specific columns and rows
     * search slider posts by id, title
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Yajra\DataTables\EloquentDataTable
     */
    public function datatable(Request $request) {

        //scope a query to include slider posts
        $query = PostSlider::query()
                ->orderBy("priority");

        //conversion of Eloquent Model into a readable DataTable API response
        $dataTable = \DataTables::of($query);

        //add and edit columns in datatable
        $dataTable->editColumn("id", function ($post) {
                    return view("admin.slider.partials.id_handle", ["post" => $post]);
                })
                ->editColumn("photo", function ($post) {
                    return view("admin.slider.partials.photo", ["post" => $post]);
                })
                ->editColumn("title", function ($post) {
                    return "<strong>" . e($post->title) . "</strong>";
                })
                ->editColumn("status", function ($post) {
                    return view("admin.slider.partials.status", ["post" => $post]);
                })
                ->addColumn("actions", function ($post) {
                    return view("admin.slider.partials.actions", ["post" => $post]);
                })
                ->addColumn("data_id", function ($post) {
                    return $post->id;
                });

        //the columns remain as they are, without passing through the datatable functions
        $dataTable->rawColumns(["id", "title", "status", "photo", "actions"]);

        //use of an anonymous function to filter datatable
        $dataTable->filter(function ($query) use ($request) {
            if (
            //get a search term from search form
                    $request->has("search") &&
                    is_array($request->get("search")) &&
                    isset($request->get("search")["value"])
            ) {
                $searchTerm = $request->get("search")["value"];

                //use search term to filter datatable
                $query->where(function ($query) use ($searchTerm) {
                    $query->orWhere("blog_post_slider.title", "LIKE", "%" . $searchTerm . "%")
                            ->orWhere("blog_post_slider.id", "=", $searchTerm);
                });
            }
        });

        //makes JSON according to the datatables specification
        return $dataTable->make(true);
    }

    /**
     * Handle the upload of slider post cover photo.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PostSlider  $post
     * @return void
     */
    protected function handlePhotoUpload(Request $request, PostSlider $post) {

        //check if photo has been uploaded
        if ($request->hasFile('photo')) {

            //delete existing photo
            $post->deletePhoto();
            //get a uploaded photo
            $photoFile = $request->file('photo');
            //set a photo file name
            $newPhotoFileName = $post->id . '_' . $photoFile->getClientOriginalName();
            //move photo to /storage/postSlider/
            $photoFile->move(
                    public_path('/storage/postSlider/'), $newPhotoFileName
            );
            //set post photo
            $post->photo = $newPhotoFileName;
            //save post photo to the DB
            $post->save();

            //use of Intervention\Image\Facades\Image to fit and save slider post photo
            \Image::make(public_path('/storage/postSlider/' . $post->photo))
                    ->fit(1903, 549)
                    ->save();
        }
    }

}
