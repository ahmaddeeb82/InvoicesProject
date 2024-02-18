<?php

namespace Modules\Sales\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use App\Exceptions\MyValidationException;

class GetBranchSaleRequest extends FormRequest{
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
            'id' => 'required|
            guid_format|
            exists:sqlsrv_second.br000,GUID|
            unique_guid:4930B23A-B1E9-42F7-B4BD-80B28C371009|
            unique_guid:71D497C7-3817-449D-A914-E49F87383ECB'
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
