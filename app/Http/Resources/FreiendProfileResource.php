<?php

namespace App\Http\Resources;

use App\Models\ClientFriend;
use App\Models\ClientJourney;
use App\Models\Journey;
use App\Models\Note;
use App\Models\VoiceNote;
use Illuminate\Http\Resources\Json\JsonResource;

class FreiendProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $journey = null;

        $notes  = Note::where([
            'client_id'       => auth('api')->id(),
            'friend_id'       => $this['id']
        ])->get();
        $voice_notes  = VoiceNote::where([
            'client_id'       => auth('api')->id(),
            'friend_id'       => $this['id']
        ])->get();
        $journeys_ids = Journey::where([
            'client_id'       => auth('api')->id()
        ])->pluck('id');
        if ( $journeys_ids ){
            $client_journey   = ClientJourney::where([
                'client_id'       =>   $this['id']
            ])->whereIntegerInRaw('journey_id' , $journeys_ids)->first();
            if ( $client_journey ){
                $journey      = Journey::find( $client_journey->journey_id );
            }
        }

        $client_friend  = ClientFriend::where([
            'client_id'       => auth('api')->id(),
            'friend_id'       => $this['id']
        ])->first();
        if ( $client_friend ){
            $my_friend = 1 ;
            $share_data = $client_friend['share_data'];
        }else{
            $my_friend = 0;
            $share_data = $this['share_data'];
        }


        return [
            'id'                  => $this['id'],
            'first_name'          => isset( $this['first_name'] ) ? $this['first_name'] : "" ,
            'last_name'           => isset( $this['last_name'] ) ? $this['last_name'] : "" ,
            'country_code'        => isset( $this['country_code'] ) ? $this['country_code'] : "" ,
            'phone'               => isset( $this['phone'] ) ? $this['phone'] : "" ,
            'work_mobile'         => isset( $this['work_mobile'] ) ? $this['work_mobile'] : "" ,
            'home_mobile'         => isset( $this['home_mobile'] ) ? $this['home_mobile'] : "" ,
            'share_data'          => $share_data,
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
            'linkedin'            => $this['linkedin'],
            'twitter'             => $this['twitter'],
            'instagram'           => $this['instagram'],
            'facebook'            => $this['facebook'],
            'office_country_code' => $this['office_country_code'],
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
            'website'             => $this['website'] ?? "",
            'notes'               => $notes,
            'voice_note'          => $voice_notes,
            'journey'             => $journey,
            'my_friend'           => $my_friend,
            'qr_code'             => $this['qr_code'],

        ];
    }
}
