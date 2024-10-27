<?php

namespace App\Http\Controllers\Api\Authentication\Logout;

use App\Http\Controllers\Controller;
use App\Traits\HandleApiJsonResponseTrait;
use Illuminate\Http\Request;
use App\Models\Client;

class LogoutController extends Controller
{
    use HandleApiJsonResponseTrait;

    ###################################### START  LOGOUT #####################################
    protected function logout(Request $request)
    {
        try{
                $client = Client::find(auth('api')->id());
                $client->fcm_token = null;
                $client->save();
                auth('api')->logout(true);

            $this->logResponse($this->success(__('api.Logout Successfully')));
            return $this->success(__('api.Logout Successfully'));

        } catch (\Exception $ex) {
            $this->logResponse($ex);
            return $this->errorUnExpected($ex);
        }
    }
    ###################################### END LOGOUT ########################################
}
