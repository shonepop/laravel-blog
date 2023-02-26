<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Comment;

class CommentsController extends Controller {

    /**
     * Display comments in the dashboard.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        return view("admin.comments.index");
    }

    /**
     * Make datatable with specific columns and rows
     * search for comments by post id
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Yajra\DataTables\EloquentDataTable
     */
    public function datatable(Request $request) {

        //scope a query to include all comments
        $query = Comment::query()->latest();

        //conversion of Eloquent Model into a readable DataTable API response
        $dataTable = \DataTables::of($query);

        //add and edit columns in datatable
        $dataTable->addColumn('actions', function ($comment) {
                    return view('admin.comments.partials.actions', ['comment' => $comment]);
                })
                ->editColumn('status', function ($comment) {
                    return view('admin.comments.partials.status', ['comment' => $comment]);
                })
                ->editColumn('id', function ($comment) {
                    return '#' . $comment->id;
                });

        //the columns remain as they are, without passing through the datatable functions
        $dataTable->rawColumns(['actions']);

        //use of an anonymous function to filter comments
        $dataTable->filter(function ($query) use ($request) {

            //get a search post id from search form
            if ($request->has('search') && is_array($request->get('search')) && isset($request->get('search')['value'])) {
                $searchTerm = $request->get('search')['value'];
                $query->where('post_comments.post_id', '=', $searchTerm);
            }
        });

        //makes JSON according to the datatables specification
        return $dataTable->make(true);
    }

    /**
     * Find comment by id and change his status to enabled.
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
            "id" => ["required", "numeric", "exists:post_comments,id"]
        ]);

        //find comment by id and update status, or throw ModelNotFoundException
        Comment::findOrFail($formData["id"])->update(["status" => Comment::STATUS_ENABLED]);

        //return json response with system message
        return response()->json([
                    "system_message" => __("The comment has been enabled!"),
        ]);
    }

    /**
     * Find comment by id and change his status to disabled.
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
            "id" => ["required", "numeric", "exists:post_comments,id"]
        ]);

        //find comment by id and update status, or throw ModelNotFoundException
        Comment::findOrFail($formData["id"])->update(["status" => Comment::STATUS_DISABLED]);

        //return json response with system message
        return response()->json([
                    "system_message" => __("The comment has been disabled!"),
        ]);
    }

}
