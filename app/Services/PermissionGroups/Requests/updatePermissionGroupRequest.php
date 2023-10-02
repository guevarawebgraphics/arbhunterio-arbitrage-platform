<?php

namespace App\Services\PermissionGroups\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

/**
 * Class updatePermissionGroupRequest
 * @package App\Services\PermissionGroups\Requests
 * @author Guevara Web Graphics Studio
 */

class updatePermissionGroupRequest extends FormRequest
{
    protected $id;

    public function __construct(Request $request)
    {
        $this->id = (integer) $request->route()->permission_group;
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
            'name' => ['required', 'max:75', Rule::unique('permission_groups', 'name')->ignore($this->id)]
        ];
    }
}
