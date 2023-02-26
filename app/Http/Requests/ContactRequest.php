<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest {

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        return [
            "name" => ["required", "string", "max:255"],
            "email" => ["required", "email", "max:255"],
            "message" => ["required", "string", "max:2500"],
            "g-recaptcha-response" => ['required', 'string', function ($attribute, $value, $fail) {
                    $secretKey = "6LcCYYgjAAAAABViBtCJY2lmVBhhZ0uhQRMh2Ckq";
                    $response = $value;
                    $userIP = $_SERVER["REMOTE_ADDR"];
                    $url = "https://www.google.com/recaptcha/api/siteverify?secret=$secretKey&response=$response&remoteip=$userIP";
                    $response = \file_get_contents($url);
                    $response = json_decode($response);

                    if (!$response->success) {
                        $fail("reCaptcha must be checked!");
                    }
                }],
        ];
    }

}
