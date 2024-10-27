<?php

namespace App\Traits;
// use Request;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\URL;


Trait  InfobipOTPTrait
{
    
    protected function sendOTP( $phone ){
        
        // new OTP( www.infobip.com )

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://'. env('INFOBIP_CURLOPT_URL') .'/2fa/2/pin?ncNeeded=true',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>'{"applicationId":"' . env('INFOBIP_APPLICATION_ID') . '","messageId":"' . env('INFOBIP_MESSAGE_ID') . '","from":"MKT Nets","to":" ' . $phone . ' "}',
            CURLOPT_HTTPHEADER => array(
                'Authorization: App '. env('INFOBIP_Authorization'),
                'Content-Type: application/json',
                'Accept: application/json'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return json_decode($response);
        // return $response;
        // echo $response;
    } // end of sendOTP
    
    protected function VerifyOTPCode( $code , $pinId ){
        // return 0;
//        $curl = curl_init();
//
//        curl_setopt_array($curl, array(
//            CURLOPT_URL => 'https://'. env('INFOBIP_CURLOPT_URL') .'/2fa/2/pin/'. $pinId .'/verify',
//            CURLOPT_RETURNTRANSFER => true,
//            CURLOPT_ENCODING => '',
//            CURLOPT_MAXREDIRS => 10,
//            CURLOPT_TIMEOUT => 0,
//            CURLOPT_FOLLOWLOCATION => true,
//            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
//            CURLOPT_CUSTOMREQUEST => 'POST',
//            CURLOPT_POSTFIELDS =>'{"pin":"'. $code .'"}',
//            CURLOPT_HTTPHEADER => array(
//                'Authorization: App '. env('INFOBIP_Authorization'),
//                'Content-Type: application/json',
//                'Accept: application/json'
//            ),
//        ));
//
//        $response = curl_exec($curl);
//
//        curl_close($curl);
//        return json_decode($response);
        return true;
        // return $response;
        // echo $response;
    } // end of VerifyOTPCode //('pinId', 'verified')

   

} // end of InfobipOTPTrait
