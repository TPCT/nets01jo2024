<?php

namespace App\Http\Controllers\Api\Profile;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Dashboard\NotificationController;
use App\Http\Requests\ClientUpdateProfileRequest;
use App\Http\Resources\MyProfileResource;
use App\Jobs\SendEmailJob;
use App\Jobs\SendNotificationJob;
use App\Models\{City, Client, ClientFriend, ClientPhone, Country, JobTitle};
use App\Traits\HandleApiJsonResponseTrait;
use App\Traits\InfobipOTPTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    use HandleApiJsonResponseTrait, InfobipOTPTrait;

    ############################        START SHOW PROFILE    ##############################
    protected function show(){
        try {
            $id         = auth('api')->id();
            $countries = Country::orderByTranslation('name')->where('status' , 1)->get();
            $job_titles = JobTitle::orderByTranslation('name')->where('status' , 1 )->get();
            $client     = Client::find( $id );
            $token      = request()->header('token');

            $this->logResponse($this->success( [
                'client'        =>  new MyProfileResource( $client , $token ),
                'job_titles'    => $job_titles,
                'countries'     => $countries
            ] ));
            return $this->success( [
                'client'        =>  new MyProfileResource( $client , $token ),
                'job_titles'    => $job_titles,
                'countries'     => $countries
            ] );

        }catch (\Exception $ex){
            $this->logResponse($ex);
            return $this->errorUnExpected($ex);
        }
    }
    ############################        END SHOW PROFILE      ##############################
    ################################## START CHECK PHONE ###################################
    protected function checkPhone( Request $request ){
        try {
            $country_code = $request->country_code;
            $phone = $request->phone;
            
            $phone = ltrim($phone, '0');
            $client = Client::where([
                ['country_code' , $country_code ],
                ['phone'        , $phone ]
            ])->first();


            if ( ! $client ){
                /* START SEND OTP */
                // $otp_code = random_int( 1111, 9999 );
                // $current_client = Client::find( auth('api')->id() );
                // $current_client->update([
                //     'otp_code' => $otp_code
                // ]);

                $full_phone = $country_code . $phone;
                $responseOTP = $this->sendOTP($full_phone);
                /* END SEND OTP */
                $this->logResponse($this->success( [
                    'exists' =>  0 ,
                    'pin_id'  => $responseOTP->pinId?? '000',
                    // 'otp_code'  => $otp_code,
                ] ));
                return $this->success( [
                    'exists' =>  0 ,
                    'pin_id'  => $responseOTP->pinId?? '000',
                    // 'otp_code'  => $otp_code,
                ] );
            }
            if( $client['status'] == -1 ){
                $this->logResponse($this->success( ['exists' =>  $client['status'] ] ));
                return $this->success( ['exists' =>  $client['status'] ] );
            }
            return $this->success( [
                'exists' =>  $client['status'],
            ] );
        } catch (\Exception $ex) {
            $this->logResponse($ex);
            return $this->errorUnExpected($ex);
        }
    }
    ##################################  END CHECK PHONE  ###################################
   
    ############################### START UPDATE PROFILE ###################################
    protected function update( ClientUpdateProfileRequest $request)
    {
        try{
            $image   = null;
            $id      = auth('api')->id();
            $client  = Client::findOrFail( $id );
            $data = $request->except(['image' , 'phones' , 'phone' , 'country_code', 'job_title_id', 'country_id', 'city_id']);
            /* START CHANGE PHONE */
            if ( $request['otp_code'] ){
                $client = Client::where([
                    // ['otp_code' , $request['otp_code'] ],
                    ['status'   , 1 ]
                ])->find( $id );
                if ( ! $client ){
                    $this->logResponse($this->error( __('api.incorrect validation, it should be OTP is Incorrect') ));
                    return $this->error( __('api.incorrect validation, it should be OTP is Incorrect') );
                }
                $data['country_code']  = $request['country_code'];

                $data['phone']         = ltrim($request['phone'], '0');
                $data['otp_code']      = random_int( 1111, 9999 );
            }
            /* END CHANGE PHONE */

            $data['job_title_id'] = ($request['job_title_id']  == 0)? null : $request['job_title_id'];
            $data['country_id']   = ($request['country_id']  == 0)? null : $request['country_id'];
            $data['city_id']      = ($request['city_id']  == 0)? null : $request['city_id'];


//            $data['password']  = bcrypt($request->password);
//            $data['password']  =  Hash::make($request['password']);
            /* START STORE IMAGE */
            if ($request->hasFile('image')) {
                if ( $client['image'] ){
                    deleteFile( $client['image'] , 'uploads/clients/' );
                }
                $image = uploadImage($request->file('image'), 'uploads/clients/');
                $data['image'] = $image;
            }
            /* END STORE IMAGE */
            DB::beginTransaction();
            if ($this->checkPropertiesUpdate($request)->properties_add || $this->checkPropertiesUpdate($request)->properties_update ){
                  $client_name = $client['first_name'] . ' ' . $client['last_name'] .' ';
                  $this->sendNotifyMail($id, $this->checkPropertiesUpdate($request),$client_name);
                  $this->sendNotification($id,$this->checkPropertiesUpdate($request),$client_name);
            }
            $client->update($data);

            /* START DELETE PHONES */
            ClientPhone::whereClientId( $client['id'] )->delete();
            /*  END DELETE PHONES  */
            /* START STORE PHONES */
            if( $request['phones'] ){
                $this->storePhones( $request['phones'] , $client['id'] );
            }
            /* END STORE PHONES */
            DB::commit();
            $this->logResponse($this->success( __('api.successfully') ));
            return $this->success( __('api.successfully') );
        } catch (\Exception $ex){
            DB::rollback();
            deleteFile($image , 'uploads/clients/' );
            $this->logResponse($ex);
            return $this->errorUnExpected($ex);
        }
    }
    ################ START STORE PHONES   ##################
    protected function storePhones( $phones , $client_id){
        foreach ( $phones as $phone ){
            ClientPhone::create([
                'country_code'   => $phone['country_code'],
                'phone'          => $phone['phone'],
                'client_id'      => $client_id
            ]);
        }
    }
    ################  END STORE PHONES    ##################
    protected function checkPropertiesUpdate($request){
        $properties_add = [];
        $properties_update = [];
        $client = Client::find(auth('api')->id());
        if ($request['phone'] && $client['phone'] != $request['phone']){
            if ($client['phone'] == null){
                $properties_add[] = 'phone';

            }else{
                $properties_update[] = 'phone';
            }
        }
        if ($request['work_mobile'] && $client['work_mobile'] != $request['work_mobile']){
            if ($client['work_mobile'] == null){
                $properties_add[] = 'work_mobile';

            }else{
                $properties_update[] = 'work_mobile';
            }
        }
        if ($request['home_mobile'] && $client['home_mobile'] != $request['home_mobile']){
            if ($client['home_mobile'] == null){
                $properties_add[] = 'home_mobile';

            }else{
                $properties_update[] = 'home_mobile';
            }
        }
        if ($request['first_name'] && $client['first_name'] != $request['first_name']){
            if ($client['first_name'] == null){
                $properties_add[] = 'first_name';

            }else{
                $properties_update[] = 'first_name';
            }
        }
        if ($request['last_name'] && $client['last_name'] != $request['last_name']){
            if ($client['last_name'] == null){
                $properties_add[] = 'last_name';

            }else{
                $properties_update[] = 'last_name';
            }
        }
        if ($request['image']){
            if ($client['image'] == null){
                $properties_add[] = 'photo';

            }else{
                $properties_update[] = 'photo';
            }
        }
        if ($request['email'] && $client['email'] != $request['email']){
            if ($client['email'] == null){
                $properties_add[] = 'email';

            }else{
                $properties_update[] = 'email';
            }
        }
        if ($request['website'] && $client['website'] != $request['website']){
            if ($client['website'] == null){
                $properties_add[] = 'website';

            }else{
                $properties_update[] = 'website';
            }
        }
        if ($request['job_title_id'] && $client['job_title_id'] != $request['job_title_id']){
            if ($client['job_title_id'] == null){
                $properties_add[] = 'job_title_id';

            }else{
                $properties_update[] = 'job_title_id';
            }
        }
        if ($request['company_name'] && $client['company_name'] != $request['company_name']){
            if ($client['company_name'] == null){
                $properties_add[] = 'company_name';

            }else{
                $properties_update[] = 'company_name';
            }
        }
        if ($request['street_name'] && $client['street_name'] != $request['street_name']){
            if ($client['street_name'] == null){
                $properties_add[] = 'street_name';

            }else{
                $properties_update[] = 'street_name';
            }
        }
        if ($request['building_no'] && $client['building_no'] != $request['building_no']){
            if ($client['building_no'] == null){
                $properties_add[] = 'building_no';

            }else{
                $properties_update[] = 'building_no';
            }
        }
        if ($request['office_no'] && $client['office_no'] != $request['office_no']){
            if ($client['office_no'] == null){
                $properties_add[] = 'office_no';

            }else{
                $properties_update[] = 'office_no';
            }
        }
        if ($request['other_details'] && $client['other_details'] != $request['other_details']){
            if ($client['other_details'] == null){
                $properties_add[] = 'other_details';

            }else{
                $properties_update[] = 'other_details';
            }
        }
        if ($request['office_phone'] && $client['office_phone'] != $request['office_phone']){
            if ($client['office_phone'] == null){
                $properties_add[] = 'office_phone';

            }else{
                $properties_update[] = 'office_phone';
            }
        }
        if ($request['p_o_pox'] && $client['p_o_pox'] != $request['p_o_pox']){
            if ($client['p_o_pox'] == null){
                $properties_add[] = 'p_o_pox';

            }else{
                $properties_update[] = 'p_o_pox';
            }
        }
        if ($request['zip_code'] && $client['zip_code'] != $request['zip_code']){
            if ($client['zip_code'] == null){
                $properties_add[] = 'zip_code';

            }else{
                $properties_update[] = 'zip_code';
            }
        }
        if ($request['details'] && $client['details'] != $request['details']){
            if ($client['details'] == null){
                $properties_add[] = 'details';

            }else{
                $properties_update[] = 'details';
            }
        }
        return (object)[
            'properties_add'         => $properties_add,
            'properties_update'      => $properties_update
        ];
    }
    protected function sendNotifyMail($client_id, $properties, $client_name){
        $info = (object)[];
        $this->info['properties']  = $properties;
        $this->info['client_name'] = $client_name;
        $friends_ids = ClientFriend::whereFriendId($client_id)->pluck('client_id');
           Client::whereIntegerInRaw('id', $friends_ids)->whereNotNull('email')->chunk(25, function ($friends){
               dispatch(new SendEmailJob($friends, auth('api')->id(), $this->info));
           });
    }
    protected function sendNotification($client_id, $properties,$client_name){
         $info = (object)[];
         $this->info['properties']  = $properties;
         $this->info['client_name'] = $client_name;
//         return $this->info['properties']->properties_add;
        //        $friends_ids = ClientFriend::whereFriendId($client_id)->pluck('client_id');
//        $friends = Client::whereIntegerInRaw('id', $friends_ids)->paginate(700);
//        $client = Client::find($client_id);
//        $client_name = $client['first_name'] . ' ' . $client['last_name'] .' ';
//        $my_qr_code = $client['qr_code'];
//        foreach ($friends as $friend) {
//            $client_friend  = ClientFriend::where([
//                'client_id'       => $client['id'],
//                'friend_id'       => $friend['id']
//            ])->first();
//            $share_data = $client_friend['share_data'];
//
//            NotificationController::sendSingleNotification( $friend->id ,
//                __('api.Your friend has changed their profile',[],$friend['lang']),
//                __('api.Your friend has changed their profile',[],$friend['lang']),
//                $client_name .
//                __('api.has changed their information If he/she are in your phone contacts, go to contacts page in the app and sync them again to your phone contacts.',
//                    [],$friend['lang']),
//                $client_name .
//                __('api.has changed their information If he/she are in your phone contacts, go to contacts page in the app and sync them again to your phone contacts.',
//                    [],$friend['lang']) ,
//                $my_qr_code , $share_data,1, 1);
//        }

        $friends_ids = ClientFriend::whereFriendId($client_id)->pluck('client_id');
        Client::whereIntegerInRaw('id', $friends_ids)->chunk(100, function ($friends){
            dispatch(new SendNotificationJob($friends, auth('api')->id(), $this->info));
        });

    }
    ###############################  END UPDATE PROFILE  ####################################

    ############################  START GET CITIES BY COUNTRY ID      ######################
    protected function getCitiesByCountryId( $country_id ){
        try {
            $cities = City::whereCountryId( $country_id)->whereStatus( 1 )->get();
            $this->logResponse($this->success( [
                'cities'        =>  $cities,
            ] ));
            return $this->success( [
                'cities'        =>  $cities,
            ] );
        }catch (\Exception $ex){
            $this->logResponse($ex);
            return $this->errorUnExpected($ex);
        }
    }
    ############################   END GET CITIES BY COUNTRY ID       ######################
    ############################        START DELETE ACCOUNT  ##############################
    public function deleteAccount()
    {
        try {
            $id = auth('api')->user()->id;
            $client = Client::find( $id );
            if( ! $client ) {
                return $this->errorNotFound();
            }
            $client->delete();
            $this->logResponse($this->success(__('api.successfully')));
            return $this->success(__('api.successfully'));
        }catch (\Exception $ex){
            $this->logResponse($ex);
            return $this->errorUnExpected($ex);
        }
    }
    ############################          END DELETE ACCOUNT      ##########################
    ############################      START UPDATE FCM TOKEN  ##############################
    public function updateFcmToken(Request $request)
    {
        try {
            $validator = Validator::make(
                $request->all(),
                [
                    'fcm_token'   => 'required',
                    'lang'        => 'required',
                    'mobile_id'   => 'required|between:0,1'
                ]
            );
            if($validator->fails()){
                $this->logResponse( $this->errorValidate($validator) );
                return $this->errorValidate($validator);
            }

            $id                  = auth('api')->user()->id;
            $client              = Client::find( $id );
            $client['fcm_token'] = $request['fcm_token'];
            $client['lang']      = $request['lang'];
            $client['mobile_id'] = $request['mobile_id'];
            $client->save();
            $this->logResponse( $this->success(__('api.successfully')) );
            return $this->success(__('api.successfully'));
        }catch (\Exception $ex){
            $this->logResponse($ex);
            return $this->errorUnExpected($ex);
        }
    }
    ############################       END UPDATE FCM TOKEN   ##############################
    ##########################     START CHANGE STATUS SHARE DATA   ########################
    protected function changeStatusShareData(){
        try {
            $client              = Client::find( auth('api')->id() );
            $client->update([
                'share_data' => !$client->share_data
            ]);
            $this->logResponse($this->success( ['share_date' =>  $client['share_data'] ] ));
            return $this->success( ['share_date' =>  $client['share_data'] ] );
        }catch (\Exception $ex){
            $this->logResponse($ex);
            return $this->errorUnExpected($ex);
        }
    }
    ############################    END CHANGE STATUS SHARE DATA    ########################

}
