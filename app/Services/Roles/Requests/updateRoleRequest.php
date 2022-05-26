<?php

namespace App\Services\Roles\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;

/**
 * Class updateRoleRequest
 * @package App\Services\Roles\Requests
 * @author Richard Guevara
 */

class updateRoleRequest extends FormRequest
{
    protected $id;

    public function __construct(Request $request)
    {
        $this->id = $request->route()->role;
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
            'name' => ['required', Rule::unique('roles', 'name')->ignore($this->id)],
            'permission' => ['required'],
        ];
    }
}
