<?php

namespace App\Services\Games\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;

/**
 * Class updateKGameRequest
 * @package App\Services\Games\Requests
 * @author Richard Guevara
 */

class updateGameRequest extends FormRequest
{

    protected $id;

    public function __construct(Request $request)
    {
        $this->id = (integer) $request->route()->games;
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
            'name' => ['required', Rule::unique('games', 'name')->ignore($this->game)],
        ];
    }
}
