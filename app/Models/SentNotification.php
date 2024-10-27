<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class SentNotification extends Model
{
    protected $guarded = [];

    public function getCreatedAtAttribute($date)
    {
        
        return Carbon::parse($date)->format('Y-m-d H:i:s');
    }

    public function getUpdatedAtAttribute($date)
    {
       return Carbon::parse($date)->format('Y-m-d H:i:s');
    }
}
