<?php

namespace App\Services\Permissions\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;

/**
 * Class updatePermissionRequest
 * @package App\Services\Permissions\Requests
 * @author Bryan James Dela Luya
 */

class updatePermissionRequest extends FormRequest
{
    protected $id;

    public function __construct(Request $request)
    {
        $this->id = (integer) $request->route()->permission;
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
            'name' => ['required', 'max:75', Rule::unique('permissions', 'name')->ignore($this->id)],
            'permission_group_id' => ['required']
        ];
    }
}
