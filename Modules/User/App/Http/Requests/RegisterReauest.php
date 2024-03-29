<?php

namespace Modules\User\app\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator; 
use App\Exceptions\MyValidationException;

class RegisterReauest extends FormRequest
{

    protected $stopOnFirstFailure = true;


    protected function failedValidation(Validator $validator) {
        throw new MyValidationException($validator);
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name' => 'required',
            'username' => 'required|unique:sqlsrv.users|regex:/^[A-Za-z][A-Za-z0-9_]{7,29}$/',
            'permissions' => 'present|array',
            'permissions.*' => 'string|in:export-pdf,export-excel',
            'password' => 'required|min:6',
            'confirm_password' => 'required|same:password',
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
}
