<?php

namespace Modules\Database\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator; 
use App\Exceptions\MyValidationException;

class DatabaseNameRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
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
            'name' => 'required'
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
