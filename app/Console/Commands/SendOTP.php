<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SendOTP extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sent:otp';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test OTP service';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        
        //Change me to Database
        $today = date("Y-m-d");
        
        $url = 'https://zjjyv6.api.infobip.com/2fa/2/pin';

        $postData = [
            "applicationId" => "C61C9CCE2416CE1DBAC1890027A73067",
            "messageId" => "C06133837D67D2046D8CFE902ABBFB5A",
            "from" => "MKT Nets",
            // "to" => "962797986466",
           "to" => "962799025974",
//            "placeholders" => [
//                "pin" => 1233,//can't be used here
//            ]
        ];

        $header = array(
            'Accept: application/json',
            'Content-Type: application/json',
            'Authorization: App 7590947ce9cf15a3f88806cf8f02039e-96edcf28-ded1-4490-a2c4-c77473e9b6d7',

        );

        $ch = curl_init();
//        curl_setopt($ch, CURLOPT_USERPWD, self::$username . ":" . self::$password);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_URL, $url); // set url
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_ENCODING, 'UTF8');
        curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        $content = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $resArr = json_decode($content, true);
        curl_close($ch);

        var_dump(['CODE' => $http_code, 'BODY' => $resArr]);

        return 0;
    }
}
