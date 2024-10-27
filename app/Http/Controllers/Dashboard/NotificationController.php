<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Driver;
use App\Models\Notification;
use App\Models\SentNotification;
use App\Models\TimedNotification;
use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    private static $sourceKey = 'AAAADUl-87k:APA91bGRq3nHU4opakdYOtSE8jqLBbjxxGO20QBtk2GiVwpdUaDeW4j-3vvXz43LNU1P-ZzwHVNlbdlBUwB-Hf7P7fpplFs19eNzffBCrwJHfRSPa52eALqI3d5c8WI1iVd57qWxcKJS';
    public function index()
    {
        return view('dashboard.notifications.index');
    }

    public function send(Request $request)
    {
        $request->validate([
            'title_ar'      => 'required',
            'title_en'      => 'required',
            'title_fr'      => 'required',
            'body_ar'       => 'required',
            'body_en'       => 'required',
            'body_fr'       => 'required',
            'users_type'       => 'required',
        ]);

        $aps = [
            'content_available' => true
        ];

        $data['users_type'] = 'total';
        $request->users_type ?  $data['users_type'] = $request->users_type : 'total';

        $users = User::get();
        $drivers = Driver::get();

        $iosUsers = [];
        $androidUsers = [];
        $iosDrivers = [];
        $androidDrivers = [];

        foreach ($users as $user) {
            if ($user->fcm_token != null && $user->mobile_id == 0)
                $androidUsers[] = $user;
            else if ($user->fcm_token != null && $user->mobile_id == 1)
                $iosUsers[] = $user;
        }
        foreach ($drivers as $driver) {
            if ($driver->fcm_token != null && $driver->mobile_id == 0)
                $androidDrivers[] = $driver;
            else if ($driver->fcm_token != null && $driver->mobile_id == 1)
                $iosDrivers[] = $driver;
        }
        //return $ios_tokens;
        $sourceKey = self::$sourceKey;

        $header = [
            'Authorization' => 'key=' . $sourceKey,
            'Content-Type' => 'application/json',
            'aps' => $aps,
        ];

        // if (request()->has('image')) {
        //     $image = Image::make(request()->image)->resize(300, null, function ($constraint) {
        //         $constraint->aspectRatio();
        //     })
        //         ->save(public_path('uploads/notification_images/' . request()->image->hashName()));
        //     $data['image'] = request()->image->hashName();
        // }
        //return ($image);

        // if(isset($data['image'])){
        //             $data['image'] = asset('uploads/notification_images/'.$data['image']);
        // }

        // return $data['users_type'];

        $client = new Client(['headers' => $header]);


        if ($data['users_type'] == 'all') {

            //send notifications for android users devices
            foreach ($androidUsers as $androidUser) {
                if ($androidUser->locale == 'ar') {
                    $data = [
                        'title' => $request->title_ar,
                        'body'  => $request->body_ar,
                        'sound' => 'default'
                    ];
                } elseif($androidUser->locale == 'en') {
                    $data = [
                        'title' => $request->title_en,
                        'body'  => $request->body_en,
                        'sound' => 'default'
                    ];
                }else{
                    $data = [
                        'title' => $request->title_fr,
                        'body'  => $request->body_fr,
                        'sound' => 'default'
                    ];
                }

                $body = [
                    'data' => $data,
                    'aps' => $aps,
                    //'notification' => $data,
                    'to' => $androidUser->fcm_token,
                    // 'registration_ids' => $android_tokens,
                    "periority" => "high"
                ];

                $res = $client->post('https://fcm.googleapis.com/fcm/send', [
                    'body' => json_encode($body),
                ]);
                //return $res;
            }

            //send notifications for android drivers devices
            foreach ($androidDrivers as $androidDriver) {
                if ($androidDriver->locale == 'ar') {
                    $data = [
                        'title' => $request->title_ar,
                        'body'  => $request->body_ar,
                        'sound' => 'default'
                    ];
                }  elseif($androidDriver->locale == 'en') {
                    $data = [
                        'title' => $request->title_en,
                        'body'  => $request->body_en,
                        'sound' => 'default'
                    ];
                }else{
                    $data = [
                        'title' => $request->title_fr,
                        'body'  => $request->body_fr,
                        'sound' => 'default'
                    ];
                }

                $body = [
                    'data' => $data,
                    'aps' => $aps,
                    //'notification' => $data,
                    'to' => $androidDriver->fcm_token,
                    // 'registration_ids' => $android_tokens,
                    "periority" => "high"
                ];

                $res = $client->post('https://fcm.googleapis.com/fcm/send', [
                    'body' => json_encode($body),
                ]);
                //return $res;
            }

            //send notifications for ios users devices
            foreach ($iosUsers as $iosUser) {
                if ($iosUser->locale == 'ar') {
                    $data = [
                        'title' => $request->title_ar,
                        'body'  => $request->body_ar,
                        'sound' => 'default'
                    ];
                }  elseif($iosUser->locale == 'en') {
                    $data = [
                        'title' => $request->title_en,
                        'body'  => $request->body_en,
                        'sound' => 'default'
                    ];
                }else{
                    $data = [
                        'title' => $request->title_fr,
                        'body'  => $request->body_fr,
                        'sound' => 'default'
                    ];
                }

                $body = [
                    'aps' => $aps,
                    'data' => $data,
                    'notification' => $data,
                    'to' => $iosUser->fcm_token,
                    // 'registration_ids' => $ios_tokens,
                ];

                $res = $client->post('https://fcm.googleapis.com/fcm/send', [
                    'body' => json_encode($body),
                ]);
                //return $res;
            }

            //send notifications for ios drivers devices
            foreach ($iosDrivers as $iosDriver) {
                if ($iosDriver->locale == 'ar') {
                    $data = [
                        'title' => $request->title_ar,
                        'body'  => $request->body_ar,
                        'sound' => 'default'
                    ];
                } elseif($iosDriver->locale == 'en') {
                    $data = [
                        'title' => $request->title_en,
                        'body'  => $request->body_en,
                        'sound' => 'default'
                    ];
                }else{
                    $data = [
                        'title' => $request->title_fr,
                        'body'  => $request->body_fr,
                        'sound' => 'default'
                    ];
                }

                $body = [
                    'aps' => $aps,
                    'data' => $data,
                    'notification' => $data,
                    'to' => $iosDriver->fcm_token,
                    // 'registration_ids' => $ios_tokens,
                ];

                $res = $client->post('https://fcm.googleapis.com/fcm/send', [
                    'body' => json_encode($body),
                ]);
                //return $res;
            }

            if ($request->save) {
                foreach ($users as $user) {
                    if ($user->fcm_token != null) {
                        SentNotification::create([
                            'user_id'  => $user->id,
                            'title_ar' => $request->title_ar,
                            'title_en' => $request->title_en,
                            'title_fr' => $request->title_fr,
                            'body_ar'  => $request->body_ar,
                            'body_en'  => $request->body_en,
                            'body_fr'  => $request->body_fr
                        ]);
                    }
                }

                foreach ($drivers as $driver) {
                    if ($driver->fcm_token != null) {
                        SentNotification::create([
                            'driver_id' => $driver->id,
                            'title_ar' => $request->title_ar,
                            'title_en' => $request->title_en,
                            'title_fr' => $request->title_fr,
                            'body_ar'  => $request->body_ar,
                            'body_en'  => $request->body_en,
                            'body_fr'  => $request->body_fr
                        ]);
                    }
                }
            }
        } elseif ($data['users_type'] == 'users') {

            //send notifications for android users devices
            foreach ($androidUsers as $androidUser) {
                if ($androidUser->locale == 'ar') {
                    $data = [
                        'title' => $request->title_ar,
                        'body'  => $request->body_ar,
                        'sound' => 'default'
                    ];
                } elseif($androidUser->locale == 'en') {
                    $data = [
                        'title' => $request->title_en,
                        'body'  => $request->body_en,
                        'sound' => 'default'
                    ];
                }else{
                    $data = [
                        'title' => $request->title_fr,
                        'body'  => $request->body_fr,
                        'sound' => 'default'
                    ];
                }

                $body = [
                    'data' => $data,
                    'aps' => $aps,
                    //'notification' => $data,
                    'to' => $androidUser->fcm_token,
                    // 'registration_ids' => $android_tokens,
                    "periority" => "high"
                ];

                $res = $client->post('https://fcm.googleapis.com/fcm/send', [
                    'body' => json_encode($body),
                ]);
                //return $res;
            }

            //send notifications for ios users devices
            foreach ($iosUsers as $iosUser) {
                if ($iosUser->locale == 'ar') {
                    $data = [
                        'title' => $request->title_ar,
                        'body'  => $request->body_ar,
                        'sound' => 'default'
                    ];
                } elseif($iosUser->locale == 'en') {
                    $data = [
                        'title' => $request->title_en,
                        'body'  => $request->body_en,
                        'sound' => 'default'
                    ];
                }else{
                    $data = [
                        'title' => $request->title_fr,
                        'body'  => $request->body_fr,
                        'sound' => 'default'
                    ];
                }

                $body = [
                    'aps' => $aps,
                    'data' => $data,
                    'notification' => $data,
                    'to' => $iosUser->fcm_token,
                    // 'registration_ids' => $ios_tokens,
                ];

                $res = $client->post('https://fcm.googleapis.com/fcm/send', [
                    'body' => json_encode($body),
                ]);
                //return $res;
            }

            if ($request->save) {
                foreach ($users as $user) {
                    if ($user->fcm_token != null) {
                        SentNotification::create([
                            'user_id'  => $user->id,
                            'title_ar' => $request->title_ar,
                            'title_en' => $request->title_en,
                            'title_fr' => $request->title_fr,
                            'body_ar'  => $request->body_ar,
                            'body_en'  => $request->body_en,
                            'body_fr'  => $request->body_fr
                        ]);
                    }
                }
            }
        } elseif ($data['users_type'] == 'drivers') {

            //send notifications for android drivers devices
            foreach ($androidDrivers as $androidDriver) {
                if ($androidDriver->locale == 'ar') {
                    $data = [
                        'title' => $request->title_ar,
                        'body'  => $request->body_ar,
                        'sound' => 'default'
                    ];
                } elseif($androidDriver->locale == 'en') {
                    $data = [
                        'title' => $request->title_en,
                        'body'  => $request->body_en,
                        'sound' => 'default'
                    ];
                }else{
                    $data = [
                        'title' => $request->title_fr,
                        'body'  => $request->body_fr,
                        'sound' => 'default'
                    ];
                }

                $body = [
                    'data' => $data,
                    'aps' => $aps,
                    //'notification' => $data,
                    'to' => $androidDriver->fcm_token,
                    // 'registration_ids' => $android_tokens,
                    "periority" => "high"
                ];

                $res = $client->post('https://fcm.googleapis.com/fcm/send', [
                    'body' => json_encode($body),
                ]);
                //return $res;
            }

            //send notifications for ios drivers devices
            foreach ($iosDrivers as $iosDriver) {
                if ($iosDriver->locale == 'ar') {
                    $data = [
                        'title' => $request->title_ar,
                        'body'  => $request->body_ar,
                        'sound' => 'default'
                    ];
                } elseif($iosDriver->locale == 'en') {
                    $data = [
                        'title' => $request->title_en,
                        'body'  => $request->body_en,
                        'sound' => 'default'
                    ];
                }else{
                    $data = [
                        'title' => $request->title_fr,
                        'body'  => $request->body_fr,
                        'sound' => 'default'
                    ];
                }

                $body = [
                    'aps' => $aps,
                    'data' => $data,
                    'notification' => $data,
                    'to' => $iosDriver->fcm_token,
                    // 'registration_ids' => $ios_tokens,
                ];

                $res = $client->post('https://fcm.googleapis.com/fcm/send', [
                    'body' => json_encode($body),
                ]);
                //return $res;
            }

            if ($request->save) {
                foreach ($drivers as $driver) {
                    if ($driver->fcm_token != null) {
                        SentNotification::create([
                            'driver_id' => $driver->id,
                            'title_ar' => $request->title_ar,
                            'title_en' => $request->title_en,
                            'title_fr' => $request->title_fr,
                            'body_ar'  => $request->body_ar,
                            'body_en'  => $request->body_en,
                            'body_fr'  => $request->body_fr
                        ]);
                    }
                }
            }
        }



        session()->flash('success', __('user.sended_successfully'));
        return view('dashboard.notifications.index')->with($data);
    }

    public static function sendSingleNotification($user_id, $title, $title_ar, $body_en, $body_ar,  $my_qr_code, $share_data, $edit_person_profile, $save = 1)
    {
        $user = \App\Models\Client::find($user_id);

        $sourceKey = self::$sourceKey;

        $aps = [
            'content_available' => true
        ];

        $header = [
            'aps' => $aps,
            'Authorization' => 'key=' . $sourceKey,
            'Content-Type' => 'application/json'
        ];

        //send notification depends on user locale
        $data = [
            'title'       => $title,
            'title_ar'    => $title_ar,
            'body'        => $body_en,
            'body_ar'     => $body_ar,
            'qr_code'     => $my_qr_code,
            'share_data'  => $share_data,
            'sound'       => 'default',
            'edit_person_profile' => $edit_person_profile // 0 => scan 1 => update
        ];


        //send notifications for android device
        if ($user->mobile_id == 0) {
            $body = [
                'aps' => $aps,
                'data' => $data,
                //'notification' => $data,
                'to' => $user->fcm_token,
                //'registration_ids' => $tokens
                "priority" => "high",
                "delay_while_idle" => false

            ];
        }

        //send notifications for ios device
        if ($user->mobile_id == 1) {
            $body = [
                'aps' => $aps,
                'data' => $data,
                'notification' => $data,
                'content_available' => true,

                'to' => $user->fcm_token,
                //'registration_ids' => $tokens

            ];
        }

        if ($save == 1 && $edit_person_profile == 1) {
            SentNotification::create([
                'client_id'   => $user->id,
                'title_ar'    => $title_ar,
                'title_en'    => $title,
                'body_ar'     => $body_ar,
                'body_en'     => $body_en,
                'qr_code'     => $my_qr_code,
                'share_data'  => $share_data,
            ]);
        }

        if ($user->fcm_token != null) {
            $client = new Client(['headers' => $header]);
            $res = $client->post('https://fcm.googleapis.com/fcm/send', [
                'body' => json_encode($body),
            ]);
        }
    }

    public static function sendSingleNotificationToDriver($driver_id, $title_ar, $title_en, $title_fr, $body_ar, $body_en, $body_fr, $trip_id = null, $driver = null, $save = 1)
    {
        $user = Driver::find($driver_id);

        $sourceKey = self::$sourceKey;

        $aps = [
            'content_available' => true
        ];

        $header = [
            'aps' => $aps,
            'Authorization' => 'key=' . $sourceKey,
            'Content-Type' => 'application/json'
        ];


        //send notification depends on user locale
        if (app()->getLocale() == 'ar') {
            $data = [
                'title' => $title_ar,
                'body'  => $body_ar,
                'trip_id' => $trip_id,
                'driver' => $driver,
                'sound' => 'default'
            ];
        } elseif(app()->getLocale() == 'en') {
            $data = [
                'title' => $title_en,
                'body'  => $body_en,
                'trip_id' => $trip_id,
                'driver' => $driver,
                'sound' => 'default'
            ];
        }else{
            $data = [
                'title' => $title_fr,
                'body'  => $body_fr,
                'trip_id' => $trip_id,
                'driver' => $driver,
                'sound' => 'default'
            ];
        }


        //send notifications for android device
        if ($user->mobile_id == 0) {
            $body = [
                'aps' => $aps,
                'data' => $data,
                //'notification' => $data,
                'to' => $user->fcm_token,
                //'registration_ids' => $tokens
                "priority" => "high",
                "delay_while_idle" => false

            ];
        }

        //send notifications for ios device
        if ($user->mobile_id == 1) {
            $body = [
                'aps' => $aps,
                'data' => $data,
                'notification' => $data,
                'to' => $user->fcm_token
                //'registration_ids' => $tokens
            ];
        }

        if ($save == 1) {
            SentNotification::create([
                'driver_id' => $user->id,
                'title_ar' => $title_ar,
                'title_en' => $title_en,
                'title_fr' => $title_fr,
                'body_ar'  => $body_ar,
                'body_en'  => $body_en,
                'body_fr'  => $body_fr,
                'trip_id' => $trip_id,
            ]);
        }

        if ($user->fcm_token != null) {
            $client = new Client(['headers' => $header]);
            $res = $client->post('https://fcm.googleapis.com/fcm/send', [
                'body' => json_encode($body),
            ]);
        }
    }

    public static function sendMessageNotification($receiver_id, $title, $content, $sender_id, $user_is_sender = 1)
    {
        if ($user_is_sender == 1) {
            $user = Driver::find($receiver_id);
            $sender = User::find($sender_id);
        } else {
            $user = User::find($receiver_id);
            $sender = Driver::find($sender_id);
        }

        $sourceKey = self::$sourceKey;

        $aps = [
            'content_available' => true
        ];

        $header = [
            'aps' => $aps,
            'Authorization' => 'key=' . $sourceKey,
            'Content-Type' => 'application/json'
        ];
        $data = [
            'title' => $title,
            'body'  => $content,
            'sender_id' => $sender->id,
            'image' => $sender->image_path,
            'sound' => 'default'
        ];

        //send notifications for android device
        if ($user->mobile_id == 0) {
            $body = [
                'aps' => $aps,
                'data' => $data,
                //'notification' => $data,
                'to' => $user->fcm_token,
                //'registration_ids' => $tokens
                "periority" => "high"
            ];
        }

        //send notifications for ios device
        if ($user->mobile_id == 1) {
            $body = [
                'aps' => $aps,
                'data' => $data,
                'notification' => $data,
                'to' => $user->fcm_token
                //'registration_ids' => $tokens
            ];
        }

        if ($user->fcm_token != null) {
            $client = new Client(['headers' => $header]);
            $res = $client->post('https://fcm.googleapis.com/fcm/send', [
                'body' => json_encode($body),
            ]);

            // SentNotification::create([
            //     'user_id' => $user->id,
            //     'title' => $title,
            //     'body'  => $content
            // ]);
        }
    }
}
