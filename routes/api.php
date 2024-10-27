<?php

use App\Http\Controllers\Api\AboutUs\AboutUsController;
use App\Http\Controllers\Api\Authentication\Login\LoginController;
use App\Http\Controllers\Api\Authentication\Logout\LogoutController;
use App\Http\Controllers\Api\Authentication\Register\RegisterController;
use App\Http\Controllers\Api\Friend\FriendController;
use App\Http\Controllers\Api\Journey\JourneyController;
use App\Http\Controllers\Api\Note\NoteController;
use App\Http\Controllers\Api\Notification\NotificationController;
use App\Http\Controllers\Api\Profile\ProfileController;
use App\Http\Controllers\Api\ScanQrCode\ScanQrCodeController;
use App\Http\Controllers\Api\Setting\SettingController;
use App\Http\Controllers\Api\VoiceNote\VoiceNoteController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::group(['middleware' => ['api', 'change.language', 'api.logger']], function () {


    Route::group(['prefix' => 'v2'], function(){
        Route::post('register-and-connect', [RegisterController::class, 'registerAndConnect']);

    });

    ################################ START AUTHENTICATION ###################################
    Route::group(['prefix' => 'auth', 'namespace' => 'Authentication'], function () {
        ######################## START REGISTER ########################
        Route::group(['prefix' => 'register' , 'namespace' => 'Register'], function () {
            Route::get('view', [ RegisterController::class, 'viewRegister']);
            Route::get('get-cities-by-country-id/{country_id}' , [ RegisterController::class , 'getCitiesByCountryId'] );
            Route::post( 'register-by-linkedin' , [ RegisterController::class , 'registerByLinkedin' ])->middleware('throttle:5,1');
            Route::post( 'register-by-apple' , [ RegisterController::class , 'registerByLinkedin' ])->middleware('throttle:5,1');
        });
        ########################  END REGISTER  ########################

        ########################  START LOGIN ########################
        Route::group(['prefix' => 'login' , 'namespace' => 'Login'], function () {
            Route::post('check-phone', [ LoginController::class, 'checkPhone'])->middleware(['throttle:5,1', 'api.sourcekey']);
            Route::post('', [ LoginController::class, 'login'])->middleware('throttle:7,1');
            Route::post('/verify-otp-code/{code}/{pin_id}', [LoginController::class, 'verifyOtp'])->middleware('throttle:5,1');
            Route::get('login-by-linkedin/{linkedin_id}', [ LoginController::class, 'loginByLinkedin'])->middleware('throttle:5,1');
            Route::get('login-by-apple/{apple_id}', [ LoginController::class, 'loginByApple'])->middleware('throttle:5,1');
            Route::post('login-by-biometrics', [LoginController::class, 'loginByBiometrics'])->middleware('throttle:5,1');
      
        });
        ########################   END LOGIN   ######################
    });
    Route::group([ 'namespace' => 'AboutUs',], function () {
        Route::get('about-us', [ AboutUsController::class, 'index']);
    });
    Route::group([ 'namespace' => 'Setting',], function () {
        Route::get('settings', [SettingController::class, 'index']);
    });
    ################################ END AUTHENTICATION   ###################################
    Route::group(['middleware' => ['auth.guard:api']], function () {
        Route::get('auth/logout', [ LogoutController::class, 'logout']);

        ############################### START PROFILE ###############################
        Route::group(['prefix' => 'profile', 'namespace' => 'Profile'], function () {
            Route::get('show' , [ ProfileController::class , 'show'] );
            Route::get('get-cities-by-country-id/{country_id}' , [ ProfileController::class , 'getCitiesByCountryId'] );
            // Route::get('check-phone/{country_code}/{phone}', [ ProfileController::class, 'checkPhone'])->middleware(['throttle:3,10', 'api.sourcekey']);
            Route::post('check-phone', [ ProfileController::class, 'checkPhone'])->middleware(['throttle:3,1', 'api.sourcekey']);
            Route::post('update' , [ ProfileController::class , 'update'] );
            Route::get('delete-account' , [ ProfileController::class , 'deleteAccount'] );
            Route::post('update-fcm-token' , [ ProfileController::class , 'updateFcmToken'] );
            Route::get('change-status-share-data' , [ ProfileController::class , 'changeStatusShareData'] );

        });
        ###############################  END PROFILE  ###############################
        ########################  START SCAN QR CODE  ###############################
        Route::post('scan-qr-code' , [ ScanQrCodeController::class , 'scanQrCode' ])->middleware('throttle:10,1');
        Route::post('get-profile-by-qr-code' , [ ScanQrCodeController::class , 'getProfileByQrCode' ])->middleware('throttle:10,1');
        ########################   END SCAN QR CODE   ###############################
        Route::group(['prefix' => 'friend', 'namespace' => 'Friend'], function () {

            Route::post('add-friend' , [ FriendController::class , 'addFriend'] )->middleware('throttle:5,1');
            Route::get('add-friend-without-data/{qr_code}' , [ FriendController::class , 'addFriendWithoutData'] )->middleware('throttle:5,1');
            Route::get('general' , [ FriendController::class , 'general'] );
            Route::post('my-friends' , [ FriendController::class , 'myFriends'] );
            Route::post('profile' , [ FriendController::class , 'friendProfile'] );
        });
        Route::group(['prefix' => 'note', 'namespace' => 'Note'], function () {

            Route::get('add/{friend_id}/{note}' , [ NoteController::class , 'add'] );
            Route::get('update/{friend_id}/{note}/{note_id}' , [ NoteController::class , 'update'] );
            Route::get('delete/{friend_id}/{note_id}' , [ NoteController::class , 'delete'] );
        });

        Route::group(['prefix' => 'voice-note', 'namespace' => 'VoiceNote'], function () {

            Route::post('add' , [ VoiceNoteController::class , 'add'] );
            Route::get('delete/{friend_id}/{voice_note_id}' , [ VoiceNoteController::class , 'delete'] );

        });
        Route::group(['prefix' => 'notifications'], function () {

            Route::get('' , [NotificationController::class , 'index']);

        });

        Route::group(['prefix' => 'journey', 'namespace' => 'Journey'], function () {

            Route::get('my-journeys' , [ JourneyController::class , 'myJourneys'] );
            Route::post('search-in-journey' , [ JourneyController::class , 'searchInJourney'] );

        });

    });
});
