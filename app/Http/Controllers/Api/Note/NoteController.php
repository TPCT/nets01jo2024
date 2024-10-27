<?php

namespace App\Http\Controllers\Api\Note;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Note;
use App\Traits\HandleApiJsonResponseTrait;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    use HandleApiJsonResponseTrait;
    ###################################### START ADD #######################################
    protected function add( $friend_id , $note)
    {
        try {
            $client = Client::find( $friend_id );
            if ( ! $client ){
                $this->logResponse( $this->error( "not_found" ) );
                return $this->error( "not_found" );
            }
            Note::create([
                'client_id'         => auth('api')->id(),
                'friend_id'         => $friend_id,
                'note'              => $note
            ]);
            $this->logResponse( $this->success( __('api.successfully') ) );
            return $this->success( __('api.successfully') );
//            return "لا حول ولا قوة الا بالله العلى العظيم";

        } catch (\Exception $ex) {
            $this->logResponse($ex);
            return $this->errorUnExpected($ex);
        }
    }
    ###################################### END ADD   #######################################
    ################################### START UPDATE #######################################
    protected function update( $friend_id , $note , $note_id )
    {
        try {
            $old_note = Note::where([
                'client_id'         => auth('api')->id(),
                'friend_id'         => $friend_id,
            ])->find( $note_id );
            if ( ! $old_note ){
                return $this->error( "not_found" );
            }
            $old_note->update([
                'note'              => $note
            ]);
            $this->logResponse($this->success( __('api.successfully') ));
            return $this->success( __('api.successfully') );
//            return "لا حول ولا قوة الا بالله العلى العظيم";

        } catch (\Exception $ex) {
            $this->logResponse($ex);
            return $this->errorUnExpected($ex);
        }
    }
    ################################### END UPDATE   #######################################
    ################################### START DELETE #######################################
    protected function delete( $friend_id , $note_id )
    {
        try {
            $old_note = Note::where([
                'client_id'         => auth('api')->id(),
                'friend_id'         => $friend_id,
            ])->find( $note_id );
            if ( ! $old_note ){
                return $this->error( "not_found" );
            }
            $old_note->delete();
            $this->logResponse( $this->success( __('api.successfully') ) );
            return $this->success( __('api.successfully') );
//            return "لا حول ولا قوة الا بالله العلى العظيم";

        } catch (\Exception $ex) {
            $this->logResponse($ex);
            return $this->errorUnExpected($ex);
        }
    }
    ################################### END DELETE   #######################################

}
