<?php

namespace App\Services\GalleryImages\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;

/**
 * Class updateGalleryImageRequest
 * @package App\Services\GalleryImages\Requests
 * @author Bryan James Dela Luya
 */

class updateGalleryImageRequest extends FormRequest
{

    protected $id;

    public function __construct(Request $request)
    {
        $this->id = (integer) $request->route()->gallery_image;
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
            'gallery_group_id' => 'required',
            'title' => ['required', Rule::unique('image_gallery', 'title')->ignore($this->id)],
            'content' => 'required',
            //'background_image' => 'required',
        ];
    }
}
