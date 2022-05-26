<?php

namespace App\Services\Users\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;

/**
 * Class addUserRequest
 * @package App\Services\Users\Requests
 * @author Richard Guevara
 */

class addUserRequest extends FormRequest
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
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:users,email',
            'user_name' => 'required|string|unique:users,user_name',
            'password' => 'required|same:confirm-password',
            'roles' => 'required'
        ];
    }
}
