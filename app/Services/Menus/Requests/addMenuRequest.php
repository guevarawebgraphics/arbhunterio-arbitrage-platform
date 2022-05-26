<?php

namespace App\Services\Menus\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;

/**
 * Class addMenuRequest
 * @package App\Services\Menus\Requests
 * @author Richard Guevara
 */

class addMenuRequest extends FormRequest
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
            'name' => 'required',
            'page_id' => 'required_if:is_page,==,1',
            'link' => 'required_if:is_page,==,0',
            'order_number' => ['required', 'unique:menu,order_number'],
            'is_active' => 'required',
        ];
    }
}
