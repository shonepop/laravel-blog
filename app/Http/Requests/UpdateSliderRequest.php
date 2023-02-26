<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateSliderRequest extends FormRequest {

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
            "title" => ["required", "string", "min:5", "max:255", Rule::unique("blog_post_slider")->ignore($this->post->id)],
            "button_name" => ["required", "string", "min:2", "max:255"],
            "button_url" => ["required", "url"],
            "photo" => ["nullable", "file", "image"]
        ];
    }

}
