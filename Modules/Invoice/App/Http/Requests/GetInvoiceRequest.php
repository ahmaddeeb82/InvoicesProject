<?php

namespace Modules\Invoice\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator; 
use App\Exceptions\MyValidationException;

class GetInvoiceRequest extends FormRequest
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
            'GUID' => 'required||exists:sqlsrv_second.bu000,GUID',
            'page' => 'required|integer',
            'search' => 'integer'
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
