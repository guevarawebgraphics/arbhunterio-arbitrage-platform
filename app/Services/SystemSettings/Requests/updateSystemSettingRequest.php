<?php

namespace App\Services\SystemSettings\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;

/**
 * Class updateSystemSettingRequest
 * @package App\Services\SystemSettings\Requests
 * @author Bryan James Dela Luya
 */

class updateSystemSettingRequest extends FormRequest
{

    protected $id;

    public function __construct(Request $request)
    {
        $this->id = (integer) $request->route()->system_setting;
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
            'code' => 'required|max:25',
            'name' => ['required', Rule::unique('system_settings', 'name')->ignore($this->id)],
            //'value' => 'required',
        ];
    }
}
