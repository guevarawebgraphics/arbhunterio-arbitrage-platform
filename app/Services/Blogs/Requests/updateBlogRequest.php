<?php

namespace App\Services\Blogs\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;

/**
 * Class updateBlogRequest
 * @package App\Services\Blogs\Requests
 * @author Bryan James Dela Luya
 */

class updateBlogRequest extends FormRequest
{

    protected $id;

    public function __construct(Request $request)
    {
        $this->id = (integer) $request->route()->blog;
    }

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
            'title' => ['required', Rule::unique('blogs', 'title')->ignore($this->id)],
            'author' => 'required',
            'content' => 'required',
            // 'thumbnail' => 'required',
            // 'cover_image' => 'required',
        ];
    }
}
