<?php

namespace App\Models;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model implements TranslatableContract
{
    use Translatable;
    use HasFactory;
    protected $table = 'cities';
    public $translatedAttributes = ['name'];
    protected $fillable = ['status' , 'country_id'];
    protected $hidden = ['translations'];

    public function country(){
        return $this->belongsTo(Country::class , 'country_id' , 'id');
    }
    public function clients(){
        return $this->hasMany(Client::class , 'city_id' , 'id');
    }
}
