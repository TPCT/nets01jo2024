<?php

namespace App\Http\Controllers\Api\VoiceNote;

use App\Http\Controllers\Controller;
use App\Http\Requests\VoiceNoteRequest;
use App\Models\VoiceNote;
use App\Traits\HandleApiJsonResponseTrait;
use Illuminate\Http\Request;

class VoiceNoteController extends Controller
{
    use HandleApiJsonResponseTrait;
    ###################################### START ADD #######################################
    protected function add( VoiceNoteRequest $request )
    {
        try {
            $voice = uploadImage( $request['voice_note'] , 'uploads/voice_notes/');
            VoiceNote::create([
                'client_id'         => auth('api')->id(),
                'friend_id'         => $request['friend_id'],
                'voice_note'        => $voice
            ]);

            $this->logResponse($this->success( __('api.successfully') ));
            return $this->success( __('api.successfully') );
//            return "لا حول ولا قوة الا بالله العلى العظيم";

        } catch (\Exception $ex) {
            $this->logResponse($ex);
            return $this->errorUnExpected($ex);
        }
    }
    ###################################### END ADD   #######################################
    ################################### START DELETE #######################################
    protected function delete( $friend_id , $voice_note_id )
    {
        try {
            $old_voice_note = VoiceNote::where([
                'client_id'         => auth('api')->id(),
                'friend_id'         => $friend_id,
            ])->find( $voice_note_id );
            if ( ! $old_voice_note ){
                $this->logResponse($this->error( "not_found" ));
                return $this->error( "not_found" );
            }
            deleteFile( substr( $old_voice_note['voice_note'] , 42  ) , 'uploads/voice_notes/');
            $old_voice_note->delete();
            $this->logResponse($this->success( __('api.successfully') ));

            return $this->success( __('api.successfully') );
//            return "لا حول ولا قوة الا بالله العلى العظيم";

        } catch (\Exception $ex) {
            $this->logResponse($ex);
            return $this->errorUnExpected($ex);
        }
    }
    ################################### END DELETE   #######################################

}
