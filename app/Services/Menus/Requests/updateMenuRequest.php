<?php

namespace App\Services\Menus\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;

/**
 * Class updateMenuRequest
 * @package App\Services\Menus\Requests
 * @author Guevara Web Graphics Studio
 */

class updateMenuRequest extends FormRequest
{

    protected $id;

    public function __construct(Request $request)
    {
        $this->id = (integer) $request->route()->menu;
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
            'name' => ['required', Rule::unique('menu', 'name')->ignore($this->id)],
            'page_id' => 'required_if:is_page,==,1',
            'link' => 'required_if:is_page,==,0',
            'order_number' => ['required', 'unique:menu,order_number'],
            'is_active' => 'required',
        ];
    }
}
