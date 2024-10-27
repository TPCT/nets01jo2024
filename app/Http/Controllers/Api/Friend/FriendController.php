<?php

namespace App\Http\Controllers\Api\Friend;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddFriendRequest;
use App\Http\Resources\FreiendProfileResource;
use App\Models\Client;
use App\Models\ClientFriend;
use App\Models\ClientJourney;
use App\Models\Country;
use App\Models\JobTitle;
use App\Models\Journey;
use App\Models\Note;
use App\Models\VoiceNote;
use App\Traits\HandleApiJsonResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\GetProfileByQrCodeRequest;
use App\Http\Resources\FriendResource;

class FriendController extends Controller
{
    use HandleApiJsonResponseTrait;
    ###################################### START ADD FRIEND #######################################
    protected function addFriend(AddFriendRequest $request)
    {
        try {
            if($request->friend_id != (($request->code / 9) - 963810587) ){
                $this->logResponse($this->error( __('api.Information Error')));
                return $this->error( __('api.Information Error') );
            }
            DB::beginTransaction();
            if ( $request['friend_id'] == auth('api')->id() ){
                $this->logResponse($this->error( __('api.You cannot add yourself as a friend') ));
                return $this->error( __('api.You cannot add yourself as a friend') );
            }
            /* START STORE FRIEND */
            if (  $this->storeFriend( $request['friend_id'], $request['share_data'] ) ){
                return  $this->storeFriend( $request['friend_id'],  $request['share_data']);
            }
            /*  END STORE FRIEND */
            /* START STORE NOTES */
            if ( $request['notes'] ){
                // $this->logResponse($ex);
                $this->storeNotes( $request['notes'] , $request['friend_id'] );
            }
            /*  END STORE NOTES  */
            /*  END STORE FRIEND */
            if ( $request['voice_notes'] ){
                $this->storeVoiceNotes( $request['voice_notes'] , $request['friend_id'] );
            }
            /*  START ADD IN JOURNEY */
            if ( $request['journey_name'] && $request['lat'] && $request['lng'] && $request['date'] && $request['address'] ){
                $this->addInJourney( $request['journey_name'] , $request['lat'] ,$request['lng'] , $request['date'] , $request['address']  ,$request['friend_id']);
            }
            /*  END ADD IN JOURNEY  */
            DB::commit();
            $this->logResponse($this->success( __('api.successfully') ));
            return $this->success( __('api.successfully') );
//            return "لا حول ولا قوة الا بالله العلى العظيم";

        } catch (\Exception $ex) {
            DB::rollBack();
            $this->logResponse($ex);
            return $this->errorUnExpected($ex);
        }
    }
    ###################################### END ADD FRIEND   #######################################
    ################################# START ADD FRIEND WITHOUT DATA ###############################
    protected function addFriendWithoutData( $qr_code )
    {
        try {
            DB::beginTransaction();
            $friend = Client::where('qr_code' , $qr_code )->first();
            if ( ! $friend ){
                $this->logResponse($this->errorNotFound());
                return $this->errorNotFound();
            }
            if ( $friend['id'] == auth('api')->id() ){
                $this->logResponse($this->error( __('api.You cannot add yourself as a friend') ));
                return $this->error( __('api.You cannot add yourself as a friend') );
            }
            /* START STORE FRIEND */
            if (  $this->storeFriend( $friend['id'] ) ){
                $this->logResponse($this->storeFriend( $friend['id'] ));
                return  $this->storeFriend( $friend['id'] );
            }
            /*  END STORE FRIEND */
            DB::commit();
            $this->logResponse($this->success( __('api.successfully') ));
            return $this->success( __('api.successfully') );
//            return "لا حول ولا قوة الا بالله العلى العظيم";

        } catch (\Exception $ex) {
            DB::rollBack();
            $this->logResponse($ex);
            return $this->errorUnExpected($ex);
        }
    }
    ################################# END ADD FRIEND WITHOUT DATA  ################################
    ######################### START STORE FRIEND ######################
    protected function storeFriend( $friend_id, $share_data ){
        $my_friend = ClientFriend::where([
            'client_id'         => auth('api')->id(),
            'friend_id'         => $friend_id,
        ])->first();
        if ( $my_friend ){
            $this->logResponse($this->error( __('api.This is your friend from before') ));
            return $this->error( __('api.This is your friend from before') );

        }
        ClientFriend::create([
            'client_id'         => auth('api')->id(),
            'friend_id'         => $friend_id,
            'share_data'        => $share_data
        ]);
//        ClientFriend::create([
//            'client_id'         => $friend_id,
//            'friend_id'         => auth('api')->id()
//        ]);
    }
    #########################  END STORE FRIEND  ######################
    ######################### START STORE NOTES  ######################
    protected function storeNotes( $notes ,$friend_id ){
       foreach ( $notes as $note ){
           Note::create([
               'client_id'         => auth('api')->id(),
               'friend_id'         => $friend_id,
               'note'              => $note
           ]);
       }
    }
    #########################  END STORE NOTES   ######################
    ######################### START STORE NOTES  ######################
    protected function storeVoiceNotes( $voice_notes ,$friend_id ){
        foreach ( $voice_notes as $voice_note ){
            $voice = uploadImage( $voice_note , 'uploads/voice_notes/');
            VoiceNote::create([
                'client_id'         => auth('api')->id(),
                'friend_id'         => $friend_id,
                'voice_note'        => $voice
            ]);
        }
    }
    #########################  END STORE NOTES   ######################
    ##################### START ADD IN JOURNEY   ######################
    protected function addInJourney( $journey_name , $lat ,$lng , $date , $address ,$friend_id ){
       $journey = Journey::where([
            [ 'lat' , $lat ],
            [ 'lng' , $lng ],
            [ 'date' , $date ],
            [ 'client_id' , Auth::id() ],
        ])->first();
       if ( ! $journey ){
           $journey = Journey::Create([
                'name' => $journey_name ,
                'lat' => $lat ,
                'lng' => $lng ,
                'date' => $date ,
                'address' => $address ,
                'client_id' => Auth::id() ,
           ]);
       }
        $client_journey = ClientJourney::where([
            'client_id'        => $friend_id,
            'journey_id'       => $journey['id']
        ])->first();
       if ( ! $client_journey ){
           ClientJourney::create([
               'client_id'        => $friend_id,
               'journey_id'       => $journey['id']
           ]);
       }
    }
    #####################  END ADD IN JOURNEY    ######################
    ###################################### START GENERAL #######################################
    protected function general()
    {
        try {
            $friends_ids = ClientFriend::where('client_id' , auth('api')->id() )->pluck('friend_id');
            $job_titles_ids = Client::whereIntegerInRaw('id' , $friends_ids )->pluck('job_title_id');
            $countries_ids = Client::whereIntegerInRaw('id' , $friends_ids )->pluck('country_id');
            $job_titles = JobTitle::whereIntegerInRaw('id' , $job_titles_ids )->whereStatus( 1 )->get();
            $countries  = Country::whereIntegerInRaw('id' , $countries_ids )->whereStatus( 1 )->get();
            $journeys   = Journey::whereClientId( Auth::id() )->orderByDesc('id')->get();
            
            $this->logResponse($this->success([
                'job_titles' => $job_titles,
                'countries'  => $countries,
                'journeys'   => $journeys
            ]));
            return $this->success([
                'job_titles' => $job_titles,
                'countries'  => $countries,
                'journeys'   => $journeys
            ]);
        } catch (\Exception $ex) {
            $this->logResponse($ex);
            return $this->errorUnExpected($ex);
        }
    }
    ###################################### END GENERAL   #######################################
    ##################################  START MY FRIENDS #######################################
    protected function myFriends( Request $request )
    {
        try {
            $info = Client::select('id' ,'first_name', 'last_name' , 'image' )
            ->find( auth('api')->id() );

            $friends_ids = ClientFriend::where('client_id' , auth('api')->id() )->pluck('friend_id');

            $friends = Client::when( $request['job_title_id'] , function ( $q ) use ( $request ) {
                     return $q->where( 'job_title_id',  $request['job_title_id'] );
                 })->when( $request['country_id'] , function ( $q ) use ( $request ) {
                    return $q->where( 'country_id',  $request['country_id'] );
                 })->orderBy('first_name')->whereNotNull('phone')->where('status' , 1)
                    ->whereIntegerInRaw('id' , $friends_ids )->get();
            $count_friends = $friends->count();

            $info['count_friends'] = $count_friends;
            $this->logResponse($this->success([
                'info'         => $info,
                'friends'      => FriendResource::collection($friends)
            ]));
            return $this->success([
                'info'         => $info,
                'friends'      => FriendResource::collection($friends)
            ]);
        } catch (\Exception $ex) {
            $this->logResponse($ex);
            return $this->errorUnExpected($ex);
        }
    }
    ##################################  END MY FRIENDS   #######################################
    ################################## START FRIEND PROFILE  ###################################
    protected function friendProfile(GetProfileByQrCodeRequest $request )
    {
        try {
            $client  = Client::where([
                'qr_code'      => $request['qr_code'],
                'status'       => 1
            ])->first();
            if ( ! $client ){
                $this->logResponse($this->error( "not_found" ));
                return $this->error( "not_found" );
            }
            $friend = ClientFriend::where([
                'client_id'       => auth('api')->id(),
                'friend_id'       => $client['id']
            ])->first();
            if ( ! $friend ){
                $this->logResponse($this->error( "not_found" ));
                return $this->error( "not_found" );
            }
            $this->logResponse($this->success([
                'friend_profile'        => FreiendProfileResource::make( $client )
            ]));
            return $this->success([
                'friend_profile'        => FreiendProfileResource::make( $client )
            ]);
        } catch (\Exception $ex) {
            $this->logResponse($ex);
            return $this->errorUnExpected($ex);
        }
    }
    ##################################  END FRIEND PROFILE   ###################################


}
