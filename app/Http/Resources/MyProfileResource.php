<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MyProfileResource extends JsonResource
{
    protected $token;

    public function __construct($resource, $token)
    {
        // Ensure you call the parent constructor
        parent::__construct($resource);
        $this->resource = $resource;
        $this->token = $token;
    }

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'                  => $this['id'],
            'first_name'          => isset( $this['first_name'] ) ? $this['first_name'] : "" ,
            'last_name'           => isset( $this['last_name'] ) ? $this['last_name'] : "" ,
            'country_code'        => isset( $this['country_code'] ) ? $this['country_code'] : "" ,
            'phone'               => isset( $this['phone'] ) ? $this['phone'] : "" ,
            'work_mobile'         => isset( $this['work_mobile'] ) ? $this['work_mobile'] : "" ,
            'home_mobile'         => isset( $this['home_mobile'] ) ? $this['home_mobile'] : "" ,
            'share_data'          => isset( $this['share_data'] ) ? $this['share_data'] : "" ,
            'email'               => isset( $this['email'] ) ? $this['email'] : "" ,
            'company_name'        => isset( $this['company_name'] ) ? $this['company_name'] : "" ,
            'image'               => $this['image'],
            'lat'                 => $this['lat'],
            'lng'                 => $this['lng'],
            'mobile_id'           => $this['mobile_id'],
            'street_name'         => isset( $this['street_name'] ) ? $this['street_name'] : "" ,
            'building_no'         => isset( $this['building_no'] ) ? $this['building_no'] : "" ,
            'office_no'           => isset( $this['office_no'] ) ? $this['office_no'] : "" ,
            'other_details'       => isset( $this['other_details'] ) ? $this['other_details'] : "" ,
            'linkedin'            => isset( $this['linkedin'] ) ? $this['linkedin'] : "" ,
            'twitter'             => isset( $this['twitter'] ) ? $this['twitter'] : "" ,
            'instagram'           => isset( $this['instagram'] ) ? $this['instagram'] : "" ,
            'facebook'            => isset( $this['facebook'] ) ? $this['facebook'] : "" ,
            'office_country_code' => isset( $this['office_country_code'] ) ? $this['office_country_code'] : "" ,
            'office_phone'        => isset( $this['office_phone'] ) ? $this['office_phone'] : "" ,
            'office_fax'          => isset( $this['office_fax'] ) ? $this['office_fax'] : "" ,
            'p_o_pox'             => isset( $this['p_o_pox'] ) ? $this['p_o_pox'] : "" ,
            'zip_code'            => isset( $this['zip_code'] ) ? $this['zip_code'] : "" ,
            'details'             => isset( $this['details'] ) ? $this['details'] : "" ,
            'country_id'          => $this['country_id'],
            'country'             => isset( $this['country_id'] ) ? $this->country->name : "",
            'city_id'             => $this['city_id'],
            'city'                => isset( $this['city_id'] ) ? $this->city->name : "",
            'job_title_id'        => $this['job_title_id'],
            'job_title'           => isset( $this['job_title_id'] ) ? $this->jobTitle->name : "" ,
            'phones'              => $this->phones ?? [],
            'qr_code'             => $this['qr_code'],
            'token'               => $this->token,
            'website'             => $this['website'] ?? "",
            'biometrics_key'      => $this['biometrics_key'],
        ];
    }
}
