<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientPhone extends Model
{
    use HasFactory;
    protected $table = 'client_phones';
    protected $guarded = [];
    protected $hidden  = [];

    public function client(){
        $this->belongsTo(Client::class ,'client_id', 'id');
    }

}
