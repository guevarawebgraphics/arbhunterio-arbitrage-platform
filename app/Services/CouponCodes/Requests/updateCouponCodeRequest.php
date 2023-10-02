<?php

namespace App\Services\CouponCodes\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;

/**
 * Class updateCouponCodeRequest
 * @package App\Services\CouponCodes\Requests
 * @author Guevara Web Graphics Studio
 */

class updateCouponCodeRequest extends FormRequest
{

    protected $id;

    public function __construct(Request $request)
    {
        $this->id = (integer) $request->route()->coupon_code;
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
            'name' => ['required', Rule::unique('coupon_codes', 'name')->ignore($this->id)],
            'code' => 'required',
            'value' => 'required',
            'type' => 'required',
            'date_start' => 'required',
            'date_end' => 'required',
        ];
    }
}
