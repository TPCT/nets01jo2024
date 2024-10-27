<?php

namespace App\Http\Controllers\Api\AboutUs;

use App\Http\Controllers\Controller;
use App\Models\AboutUs;
use App\Traits\HandleApiJsonResponseTrait;
use Illuminate\Http\Request;

class AboutUsController extends Controller
{
    use HandleApiJsonResponseTrait;
    public function index(): \Illuminate\Http\JsonResponse
    {
        try {
            $about = AboutUs::first();
            if( !$about){
                $this->logResponse($this->errorNotFound());
                return $this->errorNotFound();
            }
            $this->logResponse($this->success($about));
            return $this->success($about);
        } catch (\Exception $ex) {
            $this->logResponse($ex);
            return $this->errorUnExpected($ex);
        }
    }
}
