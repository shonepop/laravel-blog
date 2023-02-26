<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Mail\ContactFormMail;
use App\Http\Requests\ContactRequest;

class ContactController extends Controller {

    /**
     * Display contact page.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post $post
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Post $post) {

        //get the 3 most visited blog posts in sidebar
        $latestPosts = $post->sidebarLatestPosts();

        return view("front.contact.index", [
            "latestPosts" => $latestPosts,
        ]);
    }

    /**
     * Send a message from the contact form.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post $post
     * @return \Illuminate\Http\Response
     * 
     * @throws \Illuminate\Validation\ValidationException
     */
    public function sendMessage(ContactRequest $request) {

        //validate inputs from contact form
        $formData = $request->validated();

        //send an email with validated inputs to the administrator of the website
        \Mail::to("popadic01@gmail.com")->send(new ContactFormMail(
                        $formData["name"],
                        $formData["email"],
                        $formData["message"],
        ));

        session()->flash("system_message", __("We have recieved your mesage, we will contact you soon!"));
        //redirect back with system message
        return redirect()->back();
    }

}
