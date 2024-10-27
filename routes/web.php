<?php

use App\Http\Controllers\Dashboard\AboutUsController;
use App\Http\Controllers\Dashboard\SettingController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Illuminate\Support\Facades\Cookie;

Auth::routes();

Route::get('/clear', function () {
    Artisan::call('optimize:clear');
    return 'optimize clear success';
});


Route::get('/dashboard', function () {
    return view('auth.login');
});
Route::get('/', function () {
    $qr_code_user = Cookie::get('qr_code_user');
    if (!$qr_code_user){
        abort(404);
    }
    return redirect()->route('getProfile', $qr_code_user);
});
Route::get('/{qr_code_user}', 'PageDeepLink\PageDeepLinkController@getprofile')->name('getProfile');
Route::get('roz/{qr_code_user}', 'PageDeepLink\PageDeepLinkController@getprofile1');

Route::group(
    [
        'prefix'     => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath'],
    ],
    function () {
        Route::prefix('dashboard')->namespace('Dashboard')->middleware(['auth','web'])->name('dashboard.')->group(function () {
            Route::get('home','HomeController@index')->name('home');
            Route::resource('users', 'UserController');
            Route::resource('clients', 'ClientController');
            Route::get('client/change-status/{id}', 'ClientController@changeStatus')->name('client.change_status');
            Route::resource('roles', 'RoleController');
            Route::resource('countries', 'CountryController');
            Route::get('store-countries', 'StoreCountriesController@storeCountries');
            Route::get('country/change-status/{id}', 'CountryController@changeStatus')->name('country.change_status');
            Route::resource('cities', 'CityController');
            Route::get('city/change-status/{id}', 'CityController@changeStatus')->name('city.change_status');
            Route::resource('jobtitles', 'JobTitleController');
            Route::get('job-title/change-status/{id}', 'JobTitleController@changeStatus')->name('jobtitle.change_status');
            Route::post('jobtitles-import-file', 'JobTitleController@import')->name('jobtitles.import_file');
            Route::get('jobtitles-export-file', 'JobTitleController@export')->name('jobtitles.export_file');
            Route::get('about-us-edit/{id}' ,[ AboutUsController::class , 'edit' ])->name('about_us.edit');
            Route::post('about-us-update' ,[ AboutUsController::class , 'update' ])->name('about_us.update');
            Route::get('settings-edit/{id}' ,[SettingController::class , 'edit' ])->name('settings.edit');
            Route::post('settings-update' ,[ SettingController::class , 'update' ])->name('settings.update');

        });


    });

