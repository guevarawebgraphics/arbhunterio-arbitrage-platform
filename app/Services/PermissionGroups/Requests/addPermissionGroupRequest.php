<?php

namespace App\Services\PermissionGroups\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;

/**
 * Class addPermissionGroupRequest
 * @package App\Services\PermissionGroups\Requests
 * @author Guevara Web Graphics Studio
 */

class addPermissionGroupRequest extends FormRequest
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
            'name' => 'required|unique:permission_groups,name|max:75',
        ];
    }
}
