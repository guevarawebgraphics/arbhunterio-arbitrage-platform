<?php

namespace App\Services\Blogs\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;

/**
 * Class addBlogRequest
 * @package App\Services\Blogs\Requests
 * @author Bryan James Dela Luya
 */

class addBlogRequest extends FormRequest
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
            'blog_category_id' => 'required',
            'title' => 'required|unique:blogs,title',
            'author' => 'required',
            'content' => 'required',
            'thumbnail' => 'required',
            'cover_image' => 'required',
        ];
    }
}