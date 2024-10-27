<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CountryTranslation extends Model
{
    protected $table = 'country_translations';
    public $timestamps = false;
    protected $fillable = ['name'];
}
