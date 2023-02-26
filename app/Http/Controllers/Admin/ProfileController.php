<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class ProfileController extends Controller {

    /**
     * Edit profile for logged in user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request) {

        //get auth user
        $user = \Auth::user();

        return view("admin.profile.edit", [
            "user" => $user
        ]);
    }

    /**
     * Update profile for logged in user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Support\Facades\Route
     * 
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request) {

        //get auth user
        $user = \Auth::user();

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

        //handle the upload for logged in user photo
        $this->handlePhotoUpdate($request, $user);

        session()->flash("system_message", __("Your profile has been saved!"));
        //redirect to route with system message
        return redirect()->route("admin.profile.edit");
    }

    /**
     * Delete the photo of the logged in user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function deletePhoto(Request $request) {

        //get auth user
        $user = \Auth::user();
        //delete a user photo
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
     * Display a form for change password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function changePassword(Request $request) {
        return view("admin.profile.change_password");
    }

    /**
     * Change password for logged in user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Support\Facades\Route
     */
    public function changePasswordConfirm(Request $request) {

        //get auth user
        $user = \Auth::user();

        //validate inputs
        $formData = $request->validate([
            "old_password" => [
                "required",
                function ($attribute, $value, $fail) use ($user) {
                    if (!\Hash::check($value, $user->password)) {
                        $fail("Your old password is not correct!");
                    }
                }
            ],
            "new_password" => ["required", "string", "min:8"],
            "new_password_confirm" => ["required", "same:new_password"]
        ]);

        //set new user password
        $user->password = \Hash::make($formData["new_password"]);
        //save to the DB
        $user->save();

        session()->flash("system_message", __("Your passsword has been changed!"));
        //redirect to route with system message
        return redirect()->route("admin.profile.edit");
    }

    /**
     * Handle the upload of logged in user photo.
     * 
     * @param string $photoFieldName
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
            //move photo to /storage/user/
            $photoFile->move(
                    public_path('/storage/users/'), $newPhotoFileName
            );
            //set user photo
            $user->photo = $newPhotoFileName;
            //save post photo to the DB
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
