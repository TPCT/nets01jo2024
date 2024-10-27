<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobTitleTranslation extends Model
{
    use HasFactory;

    protected $table = 'job_title_translations';
    public $timestamps = false;
    protected $fillable = ['name'];
}
