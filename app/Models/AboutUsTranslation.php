<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AboutUsTranslation extends Model
{
    use HasFactory;
    protected $table = 'about_us_translations';
    public $timestamps = false;
    protected $fillable = ['description'];
}
