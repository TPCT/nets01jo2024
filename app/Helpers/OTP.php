<?php

namespace App\Helpers;

class OTP
{
    public static function sendOtp($phone_number, $lang){
        $data = [
            'phone' => $phone_number,
            'lang' => $lang
        ];
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.kinz.jo/nets/default/send-otp',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_HTTPHEADER => array(
                'Accept: application/json',
                'Content-Type: application/json'
            ),
        ));

        $response = json_decode(curl_exec($curl));
        curl_close($curl);
        return $response->Data;
    }

    public static function verifyOtp($code, $pin_id){
        $data = [
            'PinID' => $pin_id,
            "code" => $code
        ];
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.kinz.jo/nets/default/verify-otp',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_HTTPHEADER => array(
                'Accept: application/json',
                'Content-Type: application/json'
            ),
        ));

        $response = json_decode(curl_exec($curl));
        curl_close($curl);
        return $response->Data;
    }
}