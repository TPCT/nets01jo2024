<?php

namespace App\Http\Requests;

use App\Traits\HandleApiJsonResponseTrait;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class ClientRegisterByLinkedinRequest extends FormRequest
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
            'first_name'       => ['nullable' , 'min:2' ,'max:255'],
            'last_name'        => ['nullable' , 'min:2' ,'max:255'],
            'country_code'     => ['nullable' , 'max:5'],
            'phone'            => ['nullable' , 'max:25' , 'unique:clients,phone' ],
            'work_mobile'      => ['nullable' , 'max:25'],
            'home_mobile'      => ['nullable' , 'max:25'],
            'email'            => ['nullable' ,'max:255' , 'email' , 'unique:clients,email' ],
            'linkedin_id'      => ['nullable' ,'max:255' , 'string' , 'unique:clients,linkedin_id' ],
            'website'          => ['nullable' ,'max:255', 'string'],
            'company_name'     => ['nullable' , 'max:3000'],
            'image'            => ['nullable' , 'image'],
            'lat'              => ['nullable'],
            'lng'              => ['nullable'],
            'mobile_id'        => ['nullable' , Rule::in(0, 1)],
            'street_name'      => ['nullable' , 'max:255'],
            'building_no'      => ['nullable' , 'max:255'],
            'office_no'        => ['nullable' , 'max:255'],
            'other_details'    => ['nullable' , 'max:3000'],
            'linkedin'         => ['nullable' , 'max:255'],
            'twitter'          => ['nullable' , 'max:255'],
            'instagram'        => ['nullable' , 'max:255'],
            'facebook'         => ['nullable' , 'max:255'],
            'office_country_code' => ['nullable' , 'max:5'],
            'office_phone'     => ['nullable' , 'max:25'],
            'office_fax'       => ['nullable' , 'max:255'],
            'p_o_pox'          => ['nullable' , 'max:255'],
            'zip_code'         => ['nullable' , 'max:25'],
            'details'          => ['nullable' , 'max:3000'],
            'country_id'       => ['nullable'],
            'city_id'          => ['nullable'],
            'job_title_id'     => ['nullable'],
            'phones'           => ['nullable' , 'array'],
        ];
    }
    public function failedValidation( Validator $validator )
    {
        throw new HttpResponseException( $this->errorValidate($validator) );
    }
}
