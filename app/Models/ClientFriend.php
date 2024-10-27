<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientFriend extends Model
{
    use HasFactory;
    protected $table = 'client_friends';
    protected $guarded = [];
    protected $hidden  = [];
}
