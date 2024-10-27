<?php

namespace App\Http\Controllers\Api\Notification;

use App\Http\Controllers\Controller;
use App\Models\SentNotification;
use App\Traits\HandleApiJsonResponseTrait;
use Exception;
use Illuminate\Http\JsonResponse;

class NotificationController extends Controller
{
    use HandleApiJsonResponseTrait;
    protected function index(): JsonResponse
    {
        try {
            $notifications = SentNotification::select('id',
                'title_' .app()->getLocale() .' as title',
                'body_' .app()->getLocale() . ' as body',
                'share_data',
                'qr_code'
            )->where('client_id', auth('api')->id())->paginate(25);
            return $this->success([
                'notifications'       => $notifications
            ]);

        } catch (Exception $ex) {
            return $this->errorUnExpected($ex);
        }

    }
}
