<?php

namespace App\Http\Requests;

use App\Traits\HandleApiJsonResponseTrait;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class GetProfileByQrCodeRequest extends FormRequest
{
    use HandleApiJsonResponseTrait;
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
            'qr_code'                     => [ 'required' , 'string' ],
        ];
    }
    public function failedValidation( Validator $validator )
    {
        throw new HttpResponseException( $this->errorValidate($validator) );
    }
}
