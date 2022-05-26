<?php

namespace App\Services\GalleryImages\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;

/**
 * Class addGalleryImageRequest
 * @package App\Services\GalleryImages\Requests
 * @author Bryan James Dela Luya
 */

class addGalleryImageRequest extends FormRequest
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
            'gallery_group_id' => 'required',
            'title' => 'required|unique:image_gallery,title',
            'content' => 'required',
            'background_image' => 'required',
        ];
    }
}
