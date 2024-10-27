<?php

namespace App\Http\Requests;

use App\Traits\HandleApiJsonResponseTrait;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class AddFriendRequest extends FormRequest
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
            'share_data'               => [ 'required' , Rule::in(0,1)],
            'notes'                    => [ 'nullable' , 'array' ],
            'notes.*'                  => [ 'nullable' , 'string' , 'max:2000' ],
            'voice_notes'              => [ 'nullable' , 'array' ],
            'voice_notes.*'            => [ 'nullable' , 'max:25000' ],
            'journey_name'             => [ 'nullable' , 'string' , 'max:255' ],
            'lat'                      => [ 'nullable' , 'numeric' , 'between:-90,90' ],
            'lng'                      => [ 'nullable' , 'numeric' , 'between:-90,90' ],
            'date'                     => [ 'nullable' , 'date' ],
            'address'                  => [ 'nullable' , 'string' , 'max:255' ],
        ];
    }
    public function failedValidation( Validator $validator )
    {
        throw new HttpResponseException( $this->errorValidate($validator) );
    }
}
