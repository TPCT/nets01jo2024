<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\ClientFriend;
use App\Models\Note;

class FriendResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $notes  = Note::where([
            'client_id'       => auth('api')->id(),
            'friend_id'       => $this['id']
        ])->get();

        $client_friend  = ClientFriend::where([
            'client_id'       => auth('api')->id(),
            'friend_id'       => $this['id']
        ])->first();
        if ( $client_friend ){
            $share_data = $client_friend['share_data'];
        }else{
            $share_data = $this['share_data'];
        }
        return [
            'id'                  => $this['id'],
            'first_name'          => $this['first_name'] ??  "",
            'last_name'           => $this['last_name'] ?? "",
            'country_code'        => $this['country_code'],
            'phone'               => $this['phone'],
            'work_mobile'         => $this['work_mobile'],
            'home_mobile'         => $this['home_mobile'],
            'share_data'          => $share_data,
            'email'               => $this['email'],
            'qr_code'             => $this['qr_code'],
            'image'               => $this['image'],

            'job_title_id'        => $this['job_title_id'],
            'job_title'           => isset( $this['job_title_id'] ) ? $this->jobTitle->name : "" ,
            'company_name'        => isset( $this['company_name'] ) ? $this['company_name'] : "" ,
            'website'             => $this['website'] ?? "",
            'lat'                 => $this['lat'],
            'lng'                 => $this['lng'],
            'street_name'         => isset( $this['street_name'] ) ? $this['street_name'] : "" ,
            'building_no'         => isset( $this['building_no'] ) ? $this['building_no'] : "" ,
            'notes'               => $notes,


        ];
    }
}
