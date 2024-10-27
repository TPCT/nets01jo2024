<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VoiceNote extends Model
{
    use HasFactory;
    protected $table = 'voice_notes';
    protected $guarded = [];
    protected $hidden  = [];

    public function getVoiceNoteAttribute( $value ){
        return $value ? asset('uploads/voice_notes/'. $value) :  null ;
    }

}
