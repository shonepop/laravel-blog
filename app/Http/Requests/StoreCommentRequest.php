<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCommentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "post_id" => ["required", "numeric", "exists:blog_posts,id"],
            "author_name" => ["required", "string", "max:255"],
            "author_email" => ["required", "email"],
            "description" => ["required", "string", "max:2500"],
        ];
    }
}
