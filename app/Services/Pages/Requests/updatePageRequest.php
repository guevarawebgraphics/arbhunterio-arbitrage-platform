<?php

namespace App\Services\Pages\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;

/**
 * Class updatePageRequest
 * @package App\Services\Pages\Requests
 * @author Richard Guevara
 */

class updatePageRequest extends FormRequest
{

    protected $id;

    public function __construct(Request $request)
    {
        $this->id = (integer) $request->route()->page;
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
            'name' => ['required', 'max:75',  Rule::unique('pages', 'name')->ignore($this->id)],
            'slug' => ['required', 'max:100',  Rule::unique('pages', 'slug')->ignore($this->id)],
            'banner_image' => 'mimes:jpg,jpeg,png',
        ];
    }
}
