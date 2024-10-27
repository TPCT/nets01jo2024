<?php

namespace App\Models;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AboutUs extends Model implements TranslatableContract
{
    use Translatable;
    use HasFactory;
    protected $table = 'about_us';
    public $translatedAttributes = ['description'];
    protected $guarded = [];
    protected $hidden = ['translations'];
}
