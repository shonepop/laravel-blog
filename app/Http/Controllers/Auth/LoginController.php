<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class LoginController extends Controller {
    /*
      |--------------------------------------------------------------------------
      | Login Controller
      |--------------------------------------------------------------------------
      |
      | This controller handles authenticating users for the application and
      | redirecting them to your home screen. The controller uses a trait
      | to conveniently provide its functionality to your applications.
      |
     */

use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = "/admin";

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Redirect to the login route when the user logs out.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Support\Facades\Route
     */
    protected function loggedOut(Request $request) {
        return redirect()->route("login");
    }

    /**
     * Get the needed authorization credentials from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function credentials(Request $request) {

        $credentials = $request->only($this->username(), 'password');
        $credentials["status"] = \App\Models\User::STATUS_ENABLED;

        return $credentials;
    }

    /**
     * Validate the user login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function validateLogin(Request $request) {

        $this->validate($request, [
            $this->username() => Rule::exists('users')->where(function ($query) {
                $query->where('status', \App\Models\User::STATUS_ENABLED);
            }),
            'password' => 'required|string'
                ]
                , [
            $this->username() . '.exists' => 'The selected email is invalid or the account has been disabled.'
        ]);
    }

}
