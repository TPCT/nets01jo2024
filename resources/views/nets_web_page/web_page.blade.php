<?php
    $lang = 'en'
        ?>
@if($lang == 'en')
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="utf-8">
            <title>SWIFT-Automation</title>
            <meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;" />
            <meta name="keywords" content="" />
            <meta name="description" content="" />
{{--            <link rel="shortcut icon" type="image/x-icon" href="{{asset('nets_web_page/images/favicon.ico')}}">--}}

            <!-- CSS Files    ================================================== -->
            <link rel="stylesheet" href="{{asset('nets_web_page/css/style.css')}}">
            <link rel="stylesheet" href="{{asset('nets_web_page/css/bootstrap.css')}}">
            <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/><link href="{{asset('nets_web_page/css/menu.css')}}" rel="stylesheet">

            <style>
            .bodysection {padding-bottom: 300px;}
		footer {position: fixed;bottom: 0;width: 100%;}
            </style>
        </head>
        <body>

        <!--============================= Body =============================-->

         <div class="bodysection">
                <div class="container">

                    <div class="row">
                        <div class="col-md-12">



                            <div class="company-info topmargin">

                                <div class="company-profile">
                                    <img src="{{$friend['image']  != "" ? $friend['image'] : asset('nets_web_page/images/default.png')}}" alt=""/>
                                    <h2>{{$friend['first_name'] ?? ''}}  {{$friend['last_name'] ?? ''}}</h2>
                                </div>

                                <div class="rounded-3 p-3 mb-4 shadow-sm d-flex justify-content-center flex-column align-items-center" style="background-color: #14306A">
                                    <p class="text-white text-center m-0 p-0">{{__('site.alert')}}</p>
                                    <a href="{{'https://nets3.page.link/?link=https://netscontacts.com/' . $friend['qr_code_user'] .'&apn=com.dotjo.baddel&isi=1667532660&ibi=jo.dot.Nets&efr=1' ?? ''}}" class="btn-style-one last mt-3" style="color: #14306A; background-color: white !important;">
                                        {{__('Continue')}}
                                    </a>
                                </div>

                                <ul>
                                    @if($friend['share_data'] ?? '')
                                        <li><img src="{{asset('nets_web_page/images/company-icon7.png')}}" alt=""/>{{($friend['country_code']??'Not Defined'). $friend['phone'] ?? ''}}</li>
                                        <li><img src="{{asset('nets_web_page/images/company-icon1.png')}}" alt=""/>{{$friend['work_mobile'] ?? 'Not Defined'}}</li>
                                        <li><img src="{{asset('nets_web_page/images/company-icon9.png')}}" alt=""/>{{$friend['home_mobile'] ?? 'Not Defined'}}</li>
                                    @endif
                                            <li><img src="{{asset('nets_web_page/images/company-icon8.png')}}" alt=""/>{{$friend['email'] ?? 'Not Defined'}}</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="company-info">
                                <h5>Company Info</h5>
                                <ul>
                                    <li><img src="{{asset('nets_web_page/images/company-icon1.png')}}" alt=""/>{{$friend['jobTitle']['name'] ?? 'Not Defined'}}</li>
                                    <li><img src="{{asset('nets_web_page/images/company-icon2.png')}}" alt=""/>{{$friend['company_name'] ?? 'Not Defined'}}</li>
                                    <li><img src="{{asset('nets_web_page/images/company-icon3.png')}}" alt=""/>{{($friend['building_no'] ?? 'Not Defined') . ' ' . ($friend['street_name'] ?? ''). ' ' . ($friend['city']['name'] ?? ''). ' ' . ($friend['country']['name'] ?? '')}}</li>
                                    <li><img src="{{asset('nets_web_page/images/company-icon4.png')}}" alt=""/>{{$friend['office_phone'] ?? 'Not Defined'}}</li>
                                    {{--                                <li><img src="{{asset('nets_web_page/images/company-icon5.png')}}" alt=""/>(06) 560 3949</li>--}}
                                    <li><img src="{{asset('nets_web_page/images/company-icon6.png')}}" alt=""/>{{$friend['p_o_pox'] ?? 'Not Defined'}}</li>
                                    {{--                                <li><img src="{{asset('nets_web_page/images/company-icon7.png')}}" alt=""/>+962 79 0000 000</li>--}}
                                </ul>
                            </div>
                        </div>
                    </div>



                </div>
            </div>

        <!--============================= Body =============================-->

{{--        <footer>--}}
{{--            <div class="container">--}}
{{--                <div class="row">--}}
{{--                    <div class="col-lg-12">--}}
{{--                        <h5>Create your business card.</h5>--}}
{{--                        <h6>Download Application now</h6>--}}
{{--                        <a href="https://play.google.com/store/apps/details?id=com.dotjo.baddel" >--}}
{{--                            <img src="{{asset('nets_web_page/images/gplay.png')}}" alt=""/>--}}
{{--                        </a>--}}
{{--                        <a href="https://apps.apple.com/us/app/nets/id1667532660" >--}}
{{--                            <img src="{{asset('nets_web_page/images/iplay.png')}}" alt=""/>--}}
{{--                        </a>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </footer>--}}

        <!--============================= jQuery=============================-->

        <script src="{{asset('nets_web_page/js/jquery-3.6.3.min.js')}}"></script>
        <script src="{{asset('nets_web_page/js/bootstrap.bundle.min.js')}}"></script>


        </body>
        </html>
@else
        <!DOCTYPE html>
        <html lang="ar">
        <head>
            <meta charset="utf-8">
            <title>SWIFT-Automation</title>
            <meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;" />
            <meta name="keywords" content="" />
            <meta name="description" content="" />
{{--            <link rel="shortcut icon" type="image/x-icon" href="images/favicon.ico">--}}

            <!-- CSS Files    ================================================== -->
            <link rel="stylesheet" href="{{asset('nets_web_page/css/style.css')}}">
            <link rel="stylesheet" href="{{asset('nets_web_page/css/bootstrap.css')}}">
            <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/><link href="{{asset('nets_web_page/css/menu.css')}}" rel="stylesheet">

        </head>
        <body class="arabic-version">


        <!--============================= Body =============================-->




        <div class="bodysection">
            <div class="container">

                <div class="row">
                    <div class="col-md-12">



                        <div class="company-info topmargin">

                            <div class="company-profile">
                                <img src="{{$friend['image']  != "" ? $friend['image'] : asset('nets_web_page/images/default.png')}}" alt=""/>
                                <h2>{{$friend['first_name'] ?? ''}}  {{$friend['last_name'] ?? ''}}</h2>
                            </div>

                            <div class="rounded-3 p-3 mb-4 shadow-sm d-flex justify-content-center flex-column align-items-center" style="background-color: #14306A">
                                <p class="text-white text-center m-0 p-0">{{__('site.alert')}}</p>
                                <a href="{{'https://nets3.page.link/?link=https://netscontacts.com/' . $friend['qr_code_user'] .'&apn=com.dotjo.baddel&isi=1667532660&ibi=jo.dot.Nets&efr=1' ?? ''}}" class="btn-style-one last mt-3" style="color: #14306A; background-color: white !important;">
                                    {{__('Continue')}}
                                </a>
                            </div>

                            <ul>
                                @if($friend['share_data'])
                                    <li><img src="{{asset('nets_web_page/images/company-icon7.png')}}" alt=""/><span class="eng-font1 numbers">{{($friend['country_code'] ?? 'Not Defined') . ($friend['phone'] ?? 'Not Defined')}}</span></li>
                                    <li><img src="{{asset('nets_web_page/images/company-icon1.png')}}" alt=""/><span class="eng-font1 numbers">{{$friend['work_mobile'] ?? 'Not Defined'}}</span></li>
                                    <li><img src="{{asset('nets_web_page/images/company-icon9.png')}}" alt=""/><span class="eng-font1 numbers">{{$friend['home_mobile'] ?? 'Not Defined'}}</span></li>
                                @endif
                                <li><img src="{{asset('nets_web_page/images/company-icon8.png')}}" alt=""/><span class="eng-font1 numbers">{{$friend['email'] ?? 'Not Defined'}}</span></li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="company-info">
                            <h5>??????? ??????</h5>
                            <ul>

                                <li><img src="{{asset('nets_web_page/images/company-icon1.png')}}" alt=""/>{{$friend['jobTitle']['name'] ?? 'Not Defined'}}</li>
                                <li><img src="{{asset('nets_web_page/images/company-icon2.png')}}" alt=""/>{{$friend['company_name'] ?? 'Not Defined'}}</li>
                                <li><img src="{{asset('nets_web_page/images/company-icon3.png')}}" alt=""/>{{($friend['building_no'] ?? 'Not Defined') . ' ' . ($friend['street_name'] ?? ''). ' ' .( $friend['city']['name'] ?? ''). ' ' . ($friend['country']['name'] ?? '')}}</li>
                                <li><img src="{{asset('nets_web_page/images/company-icon4.png')}}" alt=""/><span class="eng-font1 numbers">{{$friend['office_phone'] ?? 'Not Defined'}}</span></li>
{{--                                <li><img src="{{asset('nets_web_page/images/company-icon5.png')}}" alt=""/><span class="eng-font1 numbers">(06) 560 3949</span></li>--}}
                                <li><img src="{{asset('nets_web_page/images/company-icon6.png')}}" alt=""/><span class="eng-font1 numbers">{{$friend['p_o_pox'] ?? 'Not Defined'}}</span></li>
{{--                                <li><img src="{{asset('nets_web_page/images/company-icon7.png')}}" alt=""/><span class="eng-font1 numbers">+962 79 0000 000</span></li>--}}
                            </ul>
                        </div>
                    </div>
                </div>



            </div>
        </div>


        <!--============================= Body =============================-->

{{--        <footer>--}}
{{--            <div class="container">--}}
{{--                <div class="row">--}}
{{--                    <div class="col-lg-12">--}}
{{--                        <img src="{{asset('nets_web_page/images/footer-logo.png')}}" class="footer-logo" alt=""/>--}}
{{--                        <h5>?? ?????? ????? ????.</h5>--}}
{{--                        <h6>??? ??????? ????</h6>--}}
{{--                        <img src="{{asset('nets_web_page/images/gplay.png')}}" alt=""/> <img src="{{asset('nets_web_page/images/iplay.png')}}" alt=""/>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </footer>--}}

        <!--============================= jQuery=============================-->

        <script src="{{asset('nets_web_page/js/jquery-3.6.3.min.js')}}"></script>
        <script src="{{asset('nets_web_page/js/bootstrap.bundle.min.js')}}"></script>




        </body>
        </html>
@endif
