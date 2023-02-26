<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;
use App\Models\User;

class ForgotPasswordController extends Controller {
    /*
      |--------------------------------------------------------------------------
      | Password Reset Controller
      |--------------------------------------------------------------------------
      |
      | This controller is responsible for handling password reset emails and
      | includes a trait which assists in sending these notifications from
      | your application to your users. Feel free to explore this trait.
      |
     */

/**
     * Send a reset link to the given user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    use SendsPasswordResetEmails;

    public function sendResetLinkEmail(Request $request) {
        $this->validate($request, ['email' => 'required|email']);
        $user_check = User::where('email', $request->email)->first();

        if (!$user_check || !($user_check->status == User::STATUS_ENABLED)) {
            return back()->with('status', 'Your account is not activated. Please activate it first.');
        } else {
            $response = $this->broker()->sendResetLink(
                    $request->only('email')
            );

            if ($response === Password::RESET_LINK_SENT) {
                return back()->with('status', trans($response));
            }

            return back()->withErrors(
                            ['email' => trans($response)]
            );
        }
    }

}
