<?php

namespace App\Http\Controllers\PageDeepLink;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Client;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cookie;

class PageDeepLinkController extends Controller
{
    protected function getProfile($qr_code_user){
        App::setLocale('en');
        $friend = Client::with(['country','city','jobTitle'])
            ->whereQrCodeUser($qr_code_user)->first();
        if(!$friend){
            abort(404);
        }
        Cookie::queue('qr_code_user', $qr_code_user);
        return view('nets_web_page.web_page', compact('friend'));
    }
    protected function getProfile1($qr_code_user){
        App::setLocale('en');
        $friend = Client::with(['country','city','jobTitle'])
            ->whereQrCodeUser($qr_code_user)->first();
        if(!$friend){
            abort(404);
        }
        return view('nets_web_page.web_page1', compact('friend'));
    }
}
