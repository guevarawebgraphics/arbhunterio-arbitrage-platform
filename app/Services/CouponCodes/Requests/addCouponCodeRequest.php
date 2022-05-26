<?php

namespace App\Services\CouponCodes\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;

/**
 * Class addCouponCodeRequest
 * @package App\Services\CouponCodes\Requests
 * @author Richard Guevara
 */

class addCouponCodeRequest extends FormRequest
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
            'name' => 'required|unique:coupon_codes,name',
            'code' => 'required',
            'value' => 'required',
            'type' => 'required',
            'date_start' => 'required',
            'date_end' => 'required',
        ];
    }
}