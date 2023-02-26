<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePostRequest extends FormRequest
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
            "post_category_id" => ["nullable", "numeric", "exists:post_categories,id"],
            "title" => ["required", "string", "min:20", "max:255", Rule::unique("blog_posts")->ignore($this->post->id)],
            "author_name" => ["required", "string", "max:255"],
            "description" => ["nullable", "string", "min:50", "max:500"],
            "details" => ["nullable", "string"],
            "tag_id" => ["required", "array", "exists:tags,id"],
            "photo" => ["nullable", "file", "image"]
        ];
    }
}
