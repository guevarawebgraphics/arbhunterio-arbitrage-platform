<?php

namespace App\Services\Users\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;

/**
 * Class updateUserRequest
 * @package App\Services\Users\Requests
 * @author Bryan James Dela Luya
 */

class updateUserRequest extends FormRequest
{
    protected $id;

    public function __construct(Request $request)
    {
        $this->id = (integer) $request->route()->user;
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
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($this->id)],
            'password' => 'same:confirm-password',
            'roles' => 'required'
        ];
    }
}
