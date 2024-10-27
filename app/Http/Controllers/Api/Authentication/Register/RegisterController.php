<?php

namespace App\Http\Controllers\Api\Authentication\Register;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Dashboard\NotificationController;
use App\Http\Requests\ClientRegisterByLinkedinRequest;
use App\Http\Requests\CheckEmailRequest;
use App\Http\Resources\MyProfileResource;
use App\Models\City;
use App\Models\Client;
use App\Models\ClientFriend;
use App\Models\ClientPhone;
use App\Models\Country;
use App\Models\JobTitle;
use App\Traits\HandleApiJsonResponseTrait;
use App\Traits\InfobipOTPTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Validation\Rule;
use Tymon\JWTAuth\Facades\JWTAuth;


class RegisterController extends Controller
{
    use HandleApiJsonResponseTrait, InfobipOTPTrait;

    public function registerAndConnect(Request $request)
    {
        $data = $request->validate([
            'full_name' => 'required',
            'phone' => 'required|regex:/^[+]{0,1}[0-9]*$/',
            'client_id' => 'required|exists:clients,qr_code_user',
            'share_data' => [ 'required|in:0,1'],
        ]);

        $friend_id = $data['client_id'] ?? null;
        $phone = new \Propaganistas\LaravelPhone\PhoneNumber($data['phone']);
        $phone = $phone->getPhoneNumberInstance();
        [$data['country_code'], $data['phone']] = [$phone->getCountryCode(), $phone->getNationalNumber()];

        $data['full_name'] = trim($data['full_name']);

        if (strpos($data['full_name'], ' ') !== false){
            $data['full_name'] = explode(' ', $data['full_name']);
            $data['first_name'] = $data['full_name'][0];
            $data['last_name'] = last($data['full_name']);
        }else{
            $data['first_name'] = $data['full_name'];
            $data['last_name'] = null;
        }

        unset($data['full_name'], $data['client_id']);

        $client = Client::firstOrCreate(['phone' => $data['phone']], $data);
        if ($client->wasRecentlyCreated) {
            $client->update([
                'qr_code' => url('/') . '/' . sha1(time()) . $client['id'],
                'qr_code_user' => sha1(time()) . $client['id']
            ]);
        }

        if (!$friend_id || $friend_id == $client->qr_code_user) {
            $this->logResponse($this->success([
                'client' => $client
            ]));
            return $this->success(['message' => __('api.account registered successfully')]);
        }


        $friend = Client::where('qr_code_user', $friend_id)->where('status', 1)->first();
        $client_name = $client->first_name . ' ' . $client->last_name;

        try{
            NotificationController::sendSingleNotification( $friend->id ,
                __('api.Add Friend',[],'en'),
                __('api.Add Friend',[],'ar'),
                __('api.You have a Friend Request From : ',[],'en').$client_name,
                __('api.You have a Friend Request From : ',[],'ar').$client_name,
                $client->qr_code , $request->share_data,0, 1);
        }catch(\Exception $e){
            $this->logResponse($e);
            return $this->errorUnExpected( $e );
        }

        return $this->success(['message' => __('api.Connection Request Sent Successfully')]);

    }
    protected function viewRegister(){
        try {
            app()->setLocale(app()->getLocale());
            $countries = Country::orderByTranslation('name')->where('status' , 1)->get();
            $job_titles = JobTitle::orderByTranslation('name')->where('status' , 1)->get();

            $this->logResponse($this->success( [
                'countries'      => $countries ,
                'job_titles'     => $job_titles
            ] ));
            return $this->success( [
                'countries'      => $countries ,
                'job_titles'     => $job_titles
            ] );
        } catch (\Exception $ex) {
            $this->logResponse($ex);
            return $this->errorUnExpected($ex);
        }
    }
    ##################################   END VIEW REGISTER   #################################

    ##########################  START GET CITIES BY COUNTRY ID   #############################
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
    ##########################   END GET CITIES BY COUNTRY ID   ##############################

    ###################################### START REGISTER ####################################
    protected function registerByLinkedin( ClientRegisterByLinkedinRequest $request)
    {
        $image = null;
        try{
            $data = $request->except(['image' , 'phones', 'job_title_id', 'country_id', 'city_id']);
            $data['job_title_id'] = ($request['job_title_id']  == 0)? null : $request['job_title_id'];
            $data['country_id']   = ($request['country_id']  == 0)? null : $request['country_id'];
            $data['city_id']      = ($request['city_id']  == 0)? null : $request['city_id'];
            $data['phone']        =  ltrim($data['phone'], '0');

            /* START STORE IMAGE */
            if ($request->hasFile('image')) {
                $image = uploadImage($request->file('image'), 'uploads/clients/');
                $data['image'] = $image;
            }
            /* END STORE IMAGE */
            DB::beginTransaction();
             $client = Client::create($data);
            if ( !$token =  JWTAuth::fromUser( $client) ){
                return $this->error( __('api.Information Error') );
            }
            $base_url = URL::to('/');
            $qr_code = "https://nets3.page.link/?link=". $base_url ."/" . sha1(time()) . $client['id'] . "&apn=com.dotjo.baddel&afl=" . $base_url . "/" . sha1(time()) . $client['id'] . "&isi=1667532660&ibi=jo.dot.Nets&ifl=" . $base_url ."/"  . sha1(time()) . $client['id'] . "&_imcp=1&efr=1";
            $client->update([
                'qr_code'         => $qr_code,
                'qr_code_user'    => sha1(time()) . $client['id']
            ]);
            $client = Client::find( $client['id'] );
            /* START STORE PHONES */
            if( $request['phones'] ){
                $this->storePhones( $request['phones'] , $client['id'] );
            }
            /* END STORE PHONES */
            DB::commit();
            return $this->success( ['client' =>  new MyProfileResource( $client , $token )] );
        } catch (\Exception $ex){
            DB::rollback();
            deleteFile($image , 'uploads/clients/' );
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
    ###################################### END REGISTER   ####################################

    #################################### START CHECK PHONE ###################################
    protected function checkEmail(CheckEmailRequest $request){
        try {
            $exists = Client::whereEmail($request['email'])->exists();
            return $this->success( [
                'exists' =>  $exists
            ] );
        } catch (\Exception $ex) {
            return $this->errorUnExpected($ex);
        }
    }
    ####################################  END CHECK PHONE  ###################################


}
