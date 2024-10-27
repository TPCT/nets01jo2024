<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Journey extends Model
{
    use HasFactory;
    protected $table = 'journeys';
    protected $guarded = [];
    protected $hidden  = [];

    public function clients(){
        return $this->belongsToMany(Client::class , 'client_journeys' , 'journey_id' , 'client_id' , 'id' , 'id');
    }
}


