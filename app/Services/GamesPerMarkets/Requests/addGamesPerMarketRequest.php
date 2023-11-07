<?php

namespace App\Services\GamesPerMarkets\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;

/**
 * Class addGamesPerMarketRequest
 * @package App\Services\GamesPerMarkets\Requests
 * @author Richard Guevara
 */

class addGamesPerMarketRequest extends FormRequest
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
            'name' => 'required|unique:gamespermarkets,name'
        ];
    }
}
