<?php

namespace App\Http\Controllers\Api\Setting;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Traits\HandleApiJsonResponseTrait;

class SettingController extends Controller
{
    use HandleApiJsonResponseTrait;
    public function index(): \Illuminate\Http\JsonResponse
    {
        try {
            $setting = Setting::first();
            if( !$setting){
                $this->logResponse($this->errorNotFound());
                return $this->errorNotFound();
            }
            $this->logResponse($this->success($setting));
            return $this->success($setting);
        } catch (\Exception $ex) {
            $this->logResponse($ex);
            return $this->errorUnExpected($ex);
        }
    }
}
