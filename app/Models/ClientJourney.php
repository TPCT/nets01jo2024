<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientJourney extends Model
{
    use HasFactory;
    protected $table = 'client_journeys';
    protected $guarded = [];
    protected $hidden  = [];
}
