<?php

namespace App\Http\Controllers\Api\ScanQrCode;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Dashboard\NotificationController;
use App\Http\Resources\FreiendProfileResource;
use App\Models\Client;
use App\Traits\HandleApiJsonResponseTrait;
use App\Http\Requests\ScanQrCodeRequest;
use App\Http\Requests\GetProfileByQrCodeRequest;
use Illuminate\Http\Request;

class ScanQrCodeController extends Controller
{
    use HandleApiJsonResponseTrait;

    private function sendFriendRequest($qr_code, $share_data){
        try {
            $my_qr_code  = auth('api')->user()->qr_code_user;
            $client_name = auth('api')->user()->first_name . ' ' .auth('api')->user()->last_name;

            $friend = Client::where('qr_code_user', $qr_code )->where('status' , 1 )->first();


            if ( !$friend || $my_qr_code == $qr_code || !$friend['phone']){
                $this->logResponse($this->error( __('api.not_found') ));
                return false;
            }

            try{
                NotificationController::sendSingleNotification( $friend->id ,
                    __('api.Add Friend',[],'en'),
                    __('api.Add Friend',[],'ar'),
                    __('api.You have a Friend Request From : ',[],'en').$client_name,
                    __('api.You have a Friend Request From : ',[],'ar').$client_name,
                    $my_qr_code , $share_data,0, 1);
            }catch(\Exception $e){
                $this->logResponse($e);
                return false;
            }

            $this->logResponse( $this->success( [
                'client'        =>  new FreiendProfileResource( $friend ),
            ] ) );
            return $friend;

        }catch (\Exception $ex){
            $this->logResponse($ex);
            return false;
        }
    }

    ############################        START SCAN QR CODE    ##############################
    protected function scanQrCode(ScanQrCodeRequest $request){
        $response = [
            'status'   => false,
            'message'   => __("Failed To Send Friend Request"),
            'success'      => [],
        ];
        foreach($request->users as $user){
            if ($friend = $this->sendFriendRequest($user, $request->share_data)){
                if (!$response['status'])
                    $response['message'] = __('api.Friend Request Send To: ');
                $response['message'] .= "{$friend->first_name} {$friend->last_name},";
                $response['status']   = true;
                $response['success'][] = $user;
            }
        }
        $response['message'] = rtrim($response['message'],",");
        return $response;
    }

    ############################         END SCAN QR CODE      ##############################
    ############################        START SCAN QR CODE    ##############################
    protected function getProfileByQrCode(GetProfileByQrCodeRequest $request){
        try {
            $my_qr_code = auth('api')->user()->qr_code;
            $friend = Client::whereQrCode( $request['qr_code'] )->where('status' , 1 )->first();
            if ( ! $friend ){
                $this->logResponse($this->error( __('api.not_found') ));
                return $this->error( __('api.not_found') );
            }
            if (  $my_qr_code  == $request['qr_code'] ){
                $this->logResponse($this->error( __('api.not_found') ));
                return $this->error( __('api.not_found') );
            }
            if ( ! $friend['phone'] ){
                $this->logResponse($this->error( "There is no data for this person" ));
                return $this->error( "There is no data for this person" );
            }
            $this->logResponse( $this->success( [
                'client'        =>  new FreiendProfileResource( $friend ),
            ] ) );
            return $this->success( [
                'client'        =>  new FreiendProfileResource( $friend ),
            ] );

        }catch (\Exception $ex){
            $this->logResponse($ex);
            return $this->errorUnExpected($ex);
        }
    }
    ############################         END SCAN QR CODE      ##############################

}
