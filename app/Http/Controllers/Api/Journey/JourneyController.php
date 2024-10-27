<?php

namespace App\Http\Controllers\Api\Journey;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\ClientFriend;
use App\Models\ClientJourney;
use App\Models\Journey;
use App\Traits\HandleApiJsonResponseTrait;
use Illuminate\Http\Request;
use App\Http\Resources\FriendResource;
class JourneyController extends Controller
{
    use HandleApiJsonResponseTrait;
    ###################################### START MY JOURNEYS #######################################
    protected function myJourneys()
    {
        try {
            $client = Client::with(['journeys' => function( $q){
                return $q->with(['clients' => function( $q ){
                    return $q->get();
                }])->orderBy('name');
            }])->find( auth('api')->id() );

//            if (  $client['journeys']->count() == 0 ){
//                return $this->error("not_found");
//            }
            $this->logResponse($this->success([
                'journeys'       => $client['journeys']
            ]));
            return $this->success([
                'journeys'       => $client['journeys']
            ]);
//            return "لا حول ولا قوة الا بالله العلى العظيم";

        } catch (\Exception $ex) {
            $this->logResponse($ex);
            return $this->errorUnExpected($ex);
        }
    }
    ######################################  END MY JOURNEYS  #######################################
    ###################################  START SEARCH IN JOURNEY  ##################################
    protected function searchInJourney( Request $request ){
        try {
            if ( $request['journey_id'] ){
                $journey = Journey::where('client_id' , auth('api')->id() )->find( $request['journey_id'] );
                if ( ! $journey ){
                    $this->logResponse($this->error("not_found"));
                    return $this->error("not_found");
                }
                 $friends_ids = ClientJourney::where('journey_id' , $request['journey_id'])->pluck('client_id');
            }else{
                $friends_ids = ClientFriend::where('client_id' , auth('api')->id() )->pluck('friend_id');
            }
            $friends = Client::when( $request['job_title_id'] , function ( $q ) use ( $request ) {
                return $q->where( 'job_title_id',  $request['job_title_id'] );
                })->when( $request['country_id'] , function ( $q ) use ( $request ) {
                    return $q->where( 'country_id',  $request['country_id'] );
                })->orderBy('first_name')->whereNotNull('phone')->where('status' , 1)
                ->whereIntegerInRaw('id' , $friends_ids )->select('id' , 'email', 'first_name', 'last_name' , 'country_code', 'image' ,'phone','qr_code', 'work_mobile', 'home_mobile' )->get();
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
    ###################################   END SEARCH IM JOURNEY   ##################################

}
