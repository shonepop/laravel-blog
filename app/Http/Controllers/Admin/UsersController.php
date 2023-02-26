<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Validation\Rule;

class UsersController extends Controller {

    /**
     * Display users in the dashboard.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        return view("admin.users.index");
    }

    /**
     * Display form to add new user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function add(Request $request) {
        return view("admin.users.add");
    }

    /**
     * Add new user to the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Support\Facades\Route
     * 
     * @throws \Illuminate\Validation\ValidationException
     */
    public function insert(Request $request) {

        //validate inputs
        $formData = $request->validate([
            "email" => ["required", "email", "unique:users,email"],
            "name" => ["required", "string", "max:255"],
            "phone" => ["nullable", "string", "max:255"],
            "photo" => ["nullable", "file", "image"],
        ]);

        //set user status
        $formData["status"] = User::STATUS_ENABLED;
        //set user password
        $formData["password"] = \Hash::make("bloguser");

        //new model in memory
        $newUser = new User();
        //mass asignment
        $newUser->fill($formData);
        //an insert query is performed on the database
        $newUser->save();

        //handle the upload photo for user
        $this->handlePhotoUpload($request, $newUser);

        session()->flash("system_message", __("The new user has been successfully added!"));
        //redirect to route with system message
        return redirect()->route("admin.users.index");
    }

    /**
     * Edit user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, User $user) {

        //logged in user are not allowed to edit self account
        if (\Auth::user()->id == $user->id) {
            session()->flash("system_error", __("You are not allowed to edit your account!"));
            return redirect()->route("admin.users.index");
        }

        return view("admin.users.edit", [
            "user" => $user
        ]);
    }

    /**
     * Update user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Support\Facades\Route
     * 
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, User $user) {

        //logged in user are not allowed to update self account
        if (\Auth::user()->id == $user->id) {
            session()->flash("system_error", __("You are not allowed to update your account!"));
            return redirect()->route("admin.users.index");
        }

        //validate inputs
        $formData = $request->validate([
            "name" => ["required", "string", "max:255"],
            "phone" => ["nullable", "string", "max:255"],
            "photo" => ["nullable", "file", "image"],
        ]);

        //update author_name column in blog_posts table 
        \DB::table("blog_posts")
                ->where("author_id", $user->id)
                ->update(["author_name" => $formData["name"]]);

        //mass asignment
        $user->fill($formData);
        //an update query is performed on the database
        $user->save();

        //handle the update of user photo
        $this->handlePhotoUpdate($request, $user);

        session()->flash("system_message", __("The user has been successfully edited!"));
        //redirect to route with system message
        return redirect()->route("admin.users.index");
    }

    /**
     * Make datatable with specific columns and rows
     * search users by id, name, phone, email
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Yajra\DataTables\EloquentDataTable
     */
    public function datatable(Request $request) {

        //validate inputs from search form
        $searchFilters = $request->validate([
            "status" => ["nullable", "numeric", "in:0,1"],
            "name" => ["nullable", "string", "max:255"],
            "email" => ["nullable", "string", "max:255"],
            "phone" => ["nullable", "string", "max:255"],
        ]);

        //scope a query to include users
        $query = User::query();

        //conversion of Eloquent Model into a readable DataTable API response
        $dataTable = \DataTables::of($query);

        //add and edit columns in datatable
        $dataTable->addColumn('actions', function ($user) {
                    return view('admin.users.partials.actions', ['user' => $user]);
                })
                ->editColumn('photo', function ($user) {
                    return view('admin.users.partials.photo', ['user' => $user]);
                })
                ->editColumn('status', function ($user) {
                    return view('admin.users.partials.status', ['user' => $user]);
                })
                ->editColumn('id', function ($user) {
                    return '#' . $user->id;
                })
                ->editColumn('name', function ($user) {
                    return '<strong>' . e($user->name) . '</strong>';
                });

        //the columns remain as they are, without passing through the datatable functions
        $dataTable->rawColumns(['name', 'photo', 'actions']);

        //use of an anonymous function to filter datatable
        $dataTable->filter(function ($query) use ($request, $searchFilters) {

            //get a search term from search form
            if ($request->has('search') && is_array($request->get('search')) && isset($request->get('search')['value'])) {
                $searchTerm = $request->get('search')['value'];

                //use search term to filter datatable
                $query->where(function ($query) use ($searchTerm) {
                    $query->orWhere('users.name', 'LIKE', '%' . $searchTerm . '%')
                            ->orWhere('users.email', 'LIKE', '%' . $searchTerm . '%')
                            ->orWhere('users.phone', 'LIKE', '%' . $searchTerm . '%')
                            ->orWhere('users.id', '=', $searchTerm);
                });
            }

            //use search filters to filter datatable
            if (isset($searchFilters["status"])) {
                $query->where("users.status", '=', $searchFilters["status"]);
            }
            if (isset($searchFilters["name"])) {
                $query->where("users.name", 'LIKE', '%' . $searchFilters["name"] . '%');
            }
            if (isset($searchFilters["email"])) {
                $query->where("users.email", 'LIKE', '%' . $searchFilters["email"] . '%');
            }
            if (isset($searchFilters["phone"])) {
                $query->where("users.phone", 'LIKE', '%' . $searchFilters["phone"] . '%');
            }
        });

        //makes JSON according to the datatables specification
        return $dataTable->make(true);
    }

    /**
     * Find user by id and change his status to enabled.
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
            "id" => ["required", "numeric", "exists:users,id"]
        ]);

        //find user by id or throw ModelNotFoundException
        $user = User::findOrFail($formData["id"]);

        //logged in user are not allowed to enable self account
        if (\Auth::user()->id == $user->id) {
            return response()->json([
                        'system_error' => __('You are not allowed to enable your account'),
                            ], 403);
        }
        //change user status
        $user->status = User::STATUS_ENABLED;
        //an update query is performed on the database
        $user->save();

        return response()->json([
                    "system_message" => __("The user has been enabled!"),
        ]);
    }

    /**
     * Find user by id and change his status to disabled.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * 
     * @throws \Illuminate\Validation\ValidationException
     * @throws \ModelNotFoundException
     */
    public function disable(Request $request) {

        //validate input
        $formData = $request->validate([
            "id" => ["required", "numeric", "exists:users,id"]
        ]);

        //find user by id or throw ModelNotFoundException
        $user = User::findOrFail($formData["id"]);

        //logged in user are not allowed to enable self account
        if (\Auth::user()->id == $user->id) {
            return response()->json([
                        'system_error' => __('You are not allowed to disable your account'),
                            ], 403);
        }

        //change user status
        $user->status = User::STATUS_DISABLED;
        //an update query is performed on the database
        $user->save();

        return response()->json([
                    "system_message" => __("The user has been disabled!"),
        ]);
    }

    /**
     * Delete user photo.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function deletePhoto(Request $request, User $user) {

        //delete user photo
        $user->deletePhoto();
        //set photo value to null
        $user->photo = null;
        //save to the DB
        $user->save();

        //update author_photo column in blog_posts table
        \DB::table("blog_posts")
                ->where("author_id", $user->id)
                ->update(["author_photo" => $user->photo]);

        return response()->json([
                    "system_message" => __("The user photo has been deleted!"),
                    "photo_url" => $user->getPhotoUrl()
        ]);
    }

    /**
     * Handle the upload of user photo.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return void
     */
    protected function handlePhotoUpload(Request $request, User $user) {

        //check if photo has been uploaded
        if ($request->hasFile('photo')) {

            //delete existing photo
            $user->deletePhoto();
            //get a uploaded photo
            $photoFile = $request->file('photo');
            //set a photo file name
            $newPhotoFileName = $user->id . '_' . $photoFile->getClientOriginalName();
            //move photo to /storage/users/
            $photoFile->move(
                    public_path('/storage/users/'), $newPhotoFileName
            );
            //set user photo
            $user->photo = $newPhotoFileName;
            //save user photo to the DB
            $user->save();

            //use of Intervention\Image\Facades\Image to fit and save user photo
            \Image::make(public_path('/storage/users/' . $user->photo))
                    ->fit(256, 256)
                    ->save();
        }
    }

    /**
     * Handle the update of user photo.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return void
     */
    protected function handlePhotoUpdate(Request $request, User $user) {

        //check if photo has been uploaded
        if ($request->hasFile('photo')) {

            //delete existing photo
            $user->deletePhoto();
            //get a uploaded photo
            $photoFile = $request->file('photo');
            //set a photo file name
            $newPhotoFileName = $user->id . '_' . $photoFile->getClientOriginalName();
            //move photo to /storage/users/
            $photoFile->move(
                    public_path('/storage/users/'), $newPhotoFileName
            );

            //set user photo
            $user->photo = $newPhotoFileName;
            //save user photo to the DB
            $user->save();

            //update author_photo column in blog_posts table
            \DB::table("blog_posts")
                    ->where("author_id", $user->id)
                    ->update(["author_photo" => $user->photo]);

            //use of Intervention\Image\Facades\Image to fit and save user photo
            \Image::make(public_path('/storage/users/' . $user->photo))
                    ->fit(256, 256)
                    ->save();
        }
    }

}
