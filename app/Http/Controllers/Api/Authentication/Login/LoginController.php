<?php

namespace App\Http\Controllers\Api\Authentication\Login;

use App\Helpers\OTP;
use App\Http\Controllers\Controller;
use App\Http\Requests\ClientLoginRequest;
use App\Http\Resources\MyProfileResource;
use App\Models\Client;
use App\Traits\HandleApiJsonResponseTrait;
use App\Traits\InfobipOTPTrait;
use Carbon\Carbon;
use Faker\Core\Uuid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Psy\Util\Str;
use Tymon\JWTAuth\Facades\JWTAuth;

class LoginController extends Controller
{
    use HandleApiJsonResponseTrait, InfobipOTPTrait;

    #################################### START CHECK PHONE ###################################
    protected function checkPhone( Request $request ){
        try {
            $trials = [1 => 0, 2 => 10, 3 => 30, 4 => 60];
            $country_code = $request->country_code;
            $phone = $request->phone;
            $phone = ltrim($phone, '0');
            $client = Client::where([
                ['country_code' , $country_code ],
                ['phone'        , $phone ]
            ])->first();

            $full_phone = $country_code . $phone;

            if ( ! $client ){
                $client = Client::create([
                    'country_code' => $country_code,
                    'phone'        => $phone,
                    'status'       => 0,
                    'otp_trials'   => 1,
                    'last_trial'   => Carbon::now()->format('Y-m-d H:i:s'),
                    "biometrics_key" => \Illuminate\Support\Str::uuid()->toString()
                ]);
            }

            if( $client['status'] == -1 ){
                return $this->success( [
                    'exists'   =>  $client['status'],
                    'pin_id' => '0000',
                ] );
            }


            if ($client->otp_trials >= 5){
                $last_trial = Carbon::createFromFormat('Y-m-d H:i:s', $client->last_trial);
                if ($last_trial->diffInDays(Carbon::now()) > 1){
                    $client->update([
                        'last_trial' => Carbon::now()->format('Y-m-d H:i:s'),
                        'otp_trials' => 1
                    ]);
                }else{
                    $response = $this->error( [
                        'exists'  =>  $client['status'],
                        'pin_id'  => '0000',
                        'msg' => __("api.Too Many Requests")
                    ]);
                    $this->logResponse($response);
                    return $response;
                }
            }

            if ($client->otp_trials == 3){
                $last_trial = Carbon::createFromFormat('Y-m-d H:i:s', $client->last_trial);
                if ($last_trial->diffInSeconds(Carbon::now()) < $trials[$client->otp_trials]){
                    $this->logResponse($this->error( [
                        'exists'  =>  $client['status'],
                        'pin_id'  => '0000',
                        'msg' => __("api.Too Many Requests")
                    ]));

                    return $this->error( [
                        'exists'  =>  $client['status'],
                        'pin_id'  => '0000',
                        'msg' => __("api.Too Many Requests")
                    ] );
                }

                $client->update([
                    'otp_trials' => $client->otp_trials + 1,
                    'last_trial'   => Carbon::now()->format('Y-m-d H:i:s'),
                ]);
                $response = $this->success( [
                    'exists'  =>  $client['status'],
                    'pin_id'  => $this->sendOTP($full_phone)->pinId ?? '000',
                ]);
                $this->logResponse($response);
                return $response;
            }

            if ($client->otp_trials < 5){
                $last_trial = Carbon::createFromFormat('Y-m-d H:i:s', $client->last_trial);
                if ($last_trial->diffInSeconds(Carbon::now()) < $trials[$client->otp_trials]){
                    $this->logResponse($this->error( [
                        'exists'  =>  $client['status'],
                        'pin_id'  => '0000',
                        'msg' => __("api.Too Many Requests")
                    ]));

                    return $this->error( [
                        'exists'  =>  $client['status'],
                        'pin_id'  => '0000',
                        'msg' => __("api.Too Many Requests")
                    ] );
                }

                $client->update([
                    'otp_trials' => $client->otp_trials + 1,
                    'last_trial'   => Carbon::now()->format('Y-m-d H:i:s'),
                ]);

                $response = $this->success( [
                    'exists'  =>  $client['status'],
                    'pin_id'  => OTP::sendOtp($full_phone, app()->getLocale())->PinID ?? '000',
                ]);
                $this->logResponse($response);
                return $response;
            }


        } catch (\Exception $ex) {
            $this->logResponse($ex);
            return $this->errorUnExpected($ex);
        }
    }

    public function verifyOtp( Request $request, $code, $pin_id){
        $country_code = $request->country_code;
        $phone = $request->phone;
        $phone = ltrim($phone, '0');
        $verified = false;

        $client = Client::where([
            ['country_code' , $country_code ],
            ['phone'        , $phone ]
        ])->first();

        if (!$client){
            $this->logResponse($this->error( [
                'exists'  =>  0,
                'msg' => __("api.Please Register First")
            ]));

            return $this->error( [
                'exists'  =>  0,
                'msg' => __("api.Please Register First")
            ] );
        }

        if ($client->otp_trials - 1 == 3){
            $verified = (bool)$this->VerifyOTPCode( $code , $pin_id );

        }

        if ($client->otp_trials <= 5){
            $verified = OTP::verifyOtp($code, $pin_id)->verified;
        }

        if ($verified) {
            $client->update([
                'status' => 1,
                'otp_code' => $code,
                'otp_trials' => 1,
            ]);

            try {
                $response = $this->success([
                    'verified' => $verified,
                    'code' => Hash::make($client->phone . $client->otp_code)
                ]);
                $this->logResponse($response);
                return $response;

            } catch (\Exception $ex) {
                $this->logResponse($ex);
                return $this->errorUnExpected($ex);
            }
        }

        $client->update([
            'otp_code' => null,
            'otp_trials' => 1,
        ]);

        $response = $this->success([
            'verified' => $verified,
            'code' => null
        ]);
        $this->logResponse($response);
        return $response;
    }
    ####################################  END CHECK PHONE  ###################################

    ###################################### START LOGIN #######################################
    protected function login(ClientLoginRequest $request)
    {
        try {
            $phone = ltrim($request->phone, '0');

            $client = Client::where([
                ['country_code' , $request->country_code ],
                ['phone'        , $phone ],
            ])->first();


            if ( ! $client  ){
                $this->logResponse($this->error( __('api.Information Error')));
                return $this->error( __('api.Information Error') );
            }

            if(!Hash::check($request->phone .  $client->otp_code, $request->code)){
                $this->logResponse($this->error( __('api.Information Error')));
                return $this->error( __('api.Information Error') );
            }


            $client->update([
                'otp_code' => null,
                'biometrics_key' => \Illuminate\Support\Str::uuid()->toString()
            ]);

            $token = JWTAuth::fromUser( $client);
            return $this->success( ['client' =>  new MyProfileResource( $client , $token )] );
        } catch (\Exception $ex) {
            $this->logResponse($ex);
            return $this->errorUnExpected($ex);
        }
    }
    ###################################### END LOGIN   #######################################
    ############################### START LOGIN BY LINKEDIN ##################################
    protected function loginByLinkedin( $linkedin_id )
    {
        try {
            $client = Client::where([
                ['linkedin_id' , $linkedin_id ]
            ])->first();

            if ( ! $client  ){
                return $this->error( __('api.Information Error') );
            }
            $client->update([
                'otp_code' => 0,
                'biometrics_key' => \Illuminate\Support\Str::uuid()->toString()
            ]);
            $token = JWTAuth::fromUser( $client);
            return $this->success( ['client' =>  new MyProfileResource( $client , $token )] );
        } catch (\Exception $ex) {
            return $this->errorUnExpected($ex);
        }
    }
    ###############################  END LOGIN BY LINKEDIN  ##################################
    ############################### START LOGIN BY Apple ##################################
    protected function loginByApple( $apple_id )
    {
        try {
            $client = Client::where([
                ['apple_id' , $apple_id ]
            ])->first();

            if ( ! $client  ){
                $this->logResponse($this->error( __('api.Information Error')));
                return $this->error( __('api.Information Error') );
            }
            $client->update([
                'otp_code' => 0,
                'biometrics_key' => \Illuminate\Support\Str::uuid()->toString()
            ]);
            $token = JWTAuth::fromUser( $client);
            $this->logResponse($this->success( ['client' =>  new MyProfileResource( $client , $token )] ));
            return $this->success( ['client' =>  new MyProfileResource( $client , $token )] );
        } catch (\Exception $ex) {
            $this->logResponse($ex);
            return $this->errorUnExpected($ex);
        }
    }
    ###############################  END LOGIN BY Apple  ##################################

    protected function loginByBiometrics(Request $request){
        try {
            $client = Client::where([
                ['biometrics_key' , $request->biometrics_key ],
            ])->first();

            if ( ! $client  ){
                $this->logResponse($this->error( __('api.Information Error')));
                return $this->error( __('api.Information Error') );
            }
            $client->update([
                'otp_code' => 0,
                'biometrics_key' => \Illuminate\Support\Str::uuid()->toString()
            ]);
            $token = JWTAuth::fromUser( $client);
            return $this->success( ['client' =>  new MyProfileResource( $client , $token )] );
        } catch (\Exception $ex) {
            $this->logResponse($ex);
            return $this->errorUnExpected($ex);
        }
    }
}
