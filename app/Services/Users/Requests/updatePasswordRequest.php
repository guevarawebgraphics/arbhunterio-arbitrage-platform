<?php

namespace App\Services\Users\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use App\Rules\MatchOldPassword;

/**
 * Class updatePasswordRequest
 * @package App\Services\Users\Requests
 * @author Bryan James Dela Luya
 */

class updatePasswordRequest extends FormRequest
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
            'old_password' => ['required', new MatchOldPassword],
            'password' => 'same:confirm-password',
        ];
    }
}
