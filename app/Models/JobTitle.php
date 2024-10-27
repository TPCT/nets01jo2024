<?php

namespace App\Models;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class JobTitle extends Model implements TranslatableContract
{
    use HasFactory;
    use Translatable;

    protected $table = 'job_titles';
    public $translatedAttributes = ['name'];
    protected $fillable = ['status'];
    protected $hidden = ['translations'];

    use HasFactory;

    protected function clients(){
        return $this->hasMany(Client::class , 'job_title_id' , 'id');
    }

    public static function getJobTitles()
    {
        return JobTitle::select('id')->whereHas('translations', function ($query) {
            $query->select('name');
        })->get();
    }
}
