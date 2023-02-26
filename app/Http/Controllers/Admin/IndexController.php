<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IndexController extends Controller {

    /**
     * Display the homepage in the dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        return view("admin.index.index");
    }

}
