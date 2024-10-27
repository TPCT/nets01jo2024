@extends('dashboard.layouts.app')

@section('content')

    <div class="content-wrapper" style="min-height: 0">

        <section class="content-header">
            <ol class="breadcrumb">
                <li class="active"><i class="fa fa-dashboard"></i> @lang('site.dashboard')</li>
            </ol>
        </section>
        <br/>

        <section class="content ">

                <div class="row">
                <div class="col-md-3">
                    @if (auth()->user()->hasPermission('read-users'))
                        <div class="col-lg-12 col-xs-6">
                            <div class="small-box bg-teal">
                                <div class="inner">
                                    <h3>{{ $admins_number }}</h3>
                                    <p>@lang('site.users')</p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-user-secret"></i>
                                </div>
                                <a href="{{ route('dashboard.users.index') }}" class="small-box-footer">@lang('site.read') <i class="fa fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="col-md-3 col-md-offset-1">
                    @if (auth()->user()->hasPermission('read-jobtitles'))
                        <div class="col-lg-12 col-xs-6">
                            <div class="small-box  bg-teal">
                                <div class="inner">
                                    <h3>{{ $job_titles_number }}</h3>
                                    <p>@lang('site.jobtitles')</p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-user-md"></i>
                                </div>
                                <a href="{{ route('dashboard.jobtitles.index') }}" class="small-box-footer">@lang('site.read') <i class="fa fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                    @endif
                </div>

                <div class="col-md-3 col-md-offset-1">
                    @if (auth()->user()->hasPermission('read-roles'))
                        <div class="col-lg-12 col-xs-6">
                            <div class="small-box bg-teal">
                                <div class="inner">
                                    <h3>{{ $roles_number }}</h3>
                                    <p>@lang('site.roles')</p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-hourglass-half"></i>
                                </div>
                                <a href="{{ route('dashboard.roles.index') }}" class="small-box-footer">@lang('site.read') <i class="fa fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
                <div class="row">
                <div class="col-12">

                    @if (auth()->user()->hasPermission('read-clients'))
                        <div class="col-lg-6 col-xs-6">
                            <div class="small-box bg-gray">
                                <div class="inner">
                                    <h3>{{count(App\Models\Client::get())}}</h3>
                                    <p>@lang('site.clients')</p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-users"></i>
                                </div>
                                <a href="{{ route('dashboard.clients.index') }}" class="small-box-footer">@lang('site.read') <i class="fa fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <div class="col-lg-6 col-xs-6">
                            <div class="small-box bg-gray">
                                <div class="inner">
                                    <h3> {{ $number_messages_remaining }} </h3>
                                    <p style="color: #d2d6de">@lang('site.number_messages_remaining')</p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-cogs"></i>
                                </div>
                                <a href="#" class="small-box-footer">@lang('site.read') <i class="fa fa-arrow-circle-right"></i></a>

                            </div>
                        </div>
                    @endif
                </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        @if (auth()->user()->hasPermission('read-countries'))
                            <div class="col-lg-12 col-xs-6">
                                <div class="small-box bg-teal">
                                    <div class="inner">
                                        <h3>{{ $countries_number }}</h3>
                                        <p>@lang('site.countries')</p>
                                    </div>
                                    <div class="icon">
                                        <i class="fa fa-globe"></i>
                                    </div>
                                    <a href="{{ route('dashboard.countries.index') }}" class="small-box-footer">@lang('site.read') <i class="fa fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="col-md-3 col-md-offset-1">
                        @if (auth()->user()->hasPermission('read-cities'))
                            <div class="col-lg-12 col-xs-6">
                                <div class="small-box bg-teal">
                                    <div class="inner">
                                        <h3> {{ $cities_number }} </h3>
                                        <p>@lang('site.cities')</p>
                                    </div>
                                    <div class="icon">
                                        <i class="fa fa-flag"></i>
                                    </div>
                                    <a href="{{ route('dashboard.cities.index') }}" class="small-box-footer">@lang('site.read') <i class="fa fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="col-md-3 col-md-offset-1">
                        @if (auth()->user()->hasPermission('read-about_us'))
                            <div class="col-lg-12 col-xs-6">
                                <div class="small-box bg-teal">
                                    <div class="inner">
                                        <h3>{{ $about_us_number }}</h3>
                                        <p>@lang('site.about_us')</p>
                                    </div>
                                    <div class="icon">
                                        <i class="fa fa-address-card" aria-hidden="true"></i>
                                    </div>
                                    <a href="{{ route('dashboard.about_us.edit' , 1 ) }}" class="small-box-footer">@lang('site.read') <i class="fa fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                        @endif
                    </div>

                </div>
        </section><!-- end of content -->
        {{-- @include('dashboard.layouts._char') --}}

    </div><!-- end of content wrapper -->


@endsection


@push('script')


@endpush
