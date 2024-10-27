<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\AboutUs;
use App\Models\City;
use App\Models\Country;
use App\Models\JobTitle;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $data['admins_number']      = User::count();
        $data['job_titles_number']  = JobTitle::count();
        $data['roles_number']       = Role::count();
        $data['users_number']       = User::count();
        $data['number_messages_remaining'] = $this->number_messages_remaining();
        $data['countries_number']   = Country::count();
        $data['cities_number']      = City::count();
        $data['about_us_number']    = AboutUs::count();
        return view('dashboard.home')->with( $data );
    }
    protected function otpToken(){
        $apiUrl = "https://notificationcenter.arabiacell.net/authenticate";
        $header = [
            'Content-Type' => 'application/json',
        ];
        $response =  Http::withHeaders( $header )->post( $apiUrl , [
            'username'   => "Nets_API_Inter",
            'password'   => "Rtn%35pstn#"
        ] );
        return $response['token'];
    }
    protected function number_messages_remaining(){
        $apiUrl = "https://notificationcenter.arabiacell.net/credit";
        $header = [
            'Content-Type'    => 'application/json',
            'Authorization'   => $this->otpToken(),
        ];
        $response =  Http::withHeaders( $header )->post( $apiUrl , [
            'notificationType'   => 1,
        ] );
        return $response['E001'];
    }
}
