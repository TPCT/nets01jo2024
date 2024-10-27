<?php

namespace App\Http\Requests;

use App\Traits\HandleApiJsonResponseTrait;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class VoiceNoteRequest extends FormRequest
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
            'friend_id'                => [ 'required' , 'exists:clients,id' ],
            'voice_note'               => [ 'required' , 'max:25000' ]
            ];
    }
    public function failedValidation( Validator $validator )
    {
        throw new HttpResponseException( $this->errorValidate($validator) );
    }

}
