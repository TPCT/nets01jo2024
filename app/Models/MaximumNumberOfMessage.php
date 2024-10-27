<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaximumNumberOfMessage extends Model
{
    use HasFactory;
    
    protected $table = 'maximum_number_of_messages';
    protected $guarded = [];
    protected $hidden  = [];

    
}
