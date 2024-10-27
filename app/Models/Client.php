<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Client extends Authenticatable implements JWTSubject
{
    use Notifiable,HasFactory;
    protected $table = 'clients';
    protected $guarded = [];
    protected $hidden  = ['otp_code'];


    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function clients(){
        return $this->belongsToMany(Client::class, 'client_friends','friend_id','client_id');
    }
    public function friends(){
        return $this->belongsToMany(Client::class, 'client_friends','client_id','friend_id');
    }
    public function phones(){
        return $this->hasMany(ClientPhone::class , 'client_id' , 'id');
    }

//    protected function journeys(){
//        return $this->belongsToMany(Journey::class , 'client_journeys' , 'client_id' , 'journey_id' , 'id' , 'id');
//    }
    public function journeys(){
        return $this->hasMany(Journey::class ,'client_id' , 'id');
    }
    public function jobTitle(){
        return $this->belongsTo(JobTitle::class , 'job_title_id' , 'id');
    }
    public function country(){
        return $this->belongsTo(Country::class , 'country_id' , 'id');
    }
    public function city(){
        return $this->belongsTo(City::class , 'city_id' , 'id');
    }

    public function getImagePathAttribute(){
        return $this['image'] ? asset('uploads/clients/'.$this->image) :  asset('uploads/clients/default.png') ;
    }
    public function getImageAttribute( $value ){
        return $value ? asset('uploads/clients/'. $value) :  "" ;
    }

}
