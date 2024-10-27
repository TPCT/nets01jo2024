<?php

namespace App\Models;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model implements TranslatableContract
{
    use Translatable;
    protected $table = 'countries';
    public $translatedAttributes = ['name'];
    protected $guarded = [];
    protected $hidden = ['translations'];

    protected function cities(){
        return $this->hasMany(City::class , 'country_id' , 'id');
    }
    protected function clients(){
        return $this->hasMany(Client::class , 'country_id' , 'id');
    }
}
