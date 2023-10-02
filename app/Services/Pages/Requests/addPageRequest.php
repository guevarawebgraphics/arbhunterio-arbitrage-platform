<?php

namespace App\Services\Pages\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;

/**
 * Class addPageRequest
 * @package App\Services\Pages\Requests
 * @author Guevara Web Graphics Studio
 */

class addPageRequest extends FormRequest
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
            'name' => 'required|unique:pages,name|max:75',
            'slug' => 'required|max:100',
            'banner_image' => 'mimes:jpg,jpeg,png',
        ];
    }
}