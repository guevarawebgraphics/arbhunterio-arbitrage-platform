<?php

namespace App\Services\MenuDropdowns\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;

/**
 * Class addMenuDropdownRequest
 * @package App\Services\MenuDropdowns\Requests
 * @author Guevara Web Graphics Studio
 */

class addMenuDropdownRequest extends FormRequest
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
            'menu_id' => 'required',
            'name' => 'required',
            'is_page' => 'required',
            'page_id' => 'required',
            'link' => 'required',
            'open_in_new_tab' => 'required',
            'order_number' => 'required',
            'is_active' => 'required',
        ];
    }
}
