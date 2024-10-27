<style >
    .myLinkClass:hover {text-decoration:underline;}
</style>
<aside class="main-sidebar" style="background-color:black;" >
    <section class="sidebar">

        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{auth()->user()->image_path}}" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p>{{auth()->user()->name}}</p>
                <a href="#"><i class="fa fa-circle text-success"></i> @lang('site.status')</a>
            </div>
        </div>
        <hr style="color: #EAF7FF ; width: 75%" />
        <ul class="sidebar-menu" data-widget="tree">

            <li class="{{request()->is(LaravelLocalization::getCurrentLocale().'/dashboard/home')? 'active':''}}"><a href="{{ route('dashboard.home') }}"><i
                class="fa fa-dashboard"></i><span>@lang('site.dashboard')</span></a></li>

                @if (auth()->user()->hasPermission('read-users'))
                <li  class="{{request()->is(LaravelLocalization::getCurrentLocale().'/dashboard/users*')? 'active':''}}"><a href="{{ route('dashboard.users.index') }}"><i
                            class="fa fa-user-secret"></i><span>@lang('site.users')</span></a></li>
                @endif
                @if (auth()->user()->hasPermission('read-clients'))
                    <li  class="{{request()->is(LaravelLocalization::getCurrentLocale().'/dashboard/clients*')? 'active':''}}"><a href="{{ route('dashboard.clients.index') }}"><i
                                class="fa fa-users"></i><span>@lang('site.clients')</span></a></li>
                @endif

                @if (auth()->user()->hasPermission('read-roles'))
                    <li class="{{request()->is(LaravelLocalization::getCurrentLocale().'/dashboard/roles*')? 'active':''}}"><a href="{{ route('dashboard.roles.index') }}"><i
                            class="fa fa-hourglass-half"></i><span>@lang('site.roles')</span></a></li>
                @endif
                @if (auth()->user()->hasPermission('read-countries'))
                    <li class="{{request()->is(LaravelLocalization::getCurrentLocale().'/dashboard/countries*')? 'active':''}}"><a href="{{ route('dashboard.countries.index') }}"><i
                                class="fa fa-globe"></i><span>@lang('site.countries')</span></a></li>
                @endif
                @if (auth()->user()->hasPermission('read-cities'))
                    <li class="{{request()->is(LaravelLocalization::getCurrentLocale().'/dashboard/cities*')? 'active':''}}"><a href="{{ route('dashboard.cities.index') }}"><i
                                class="fa fa-flag"></i><span>@lang('site.cities')</span></a></li>
                @endif
                @if (auth()->user()->hasPermission('read-jobtitles'))
                    <li class="{{request()->is(LaravelLocalization::getCurrentLocale().'/dashboard/jobtitles*')? 'active':''}}"><a href="{{ route('dashboard.jobtitles.index') }}"><i
                                class="fa fa-user-md"></i><span>@lang('site.job_titles')</span></a></li>
                @endif
                @if (auth()->user()->hasPermission('read-about_us'))
                    <li class="{{request()->is(LaravelLocalization::getCurrentLocale().'/dashboard/about_us*')? 'active':''}}"><a href="{{ route('dashboard.about_us.edit' , 1 ) }}"><i
                                class="fa fa-address-card"></i><span>@lang('site.about_us')</span></a></li>
                @endif
                @if (auth()->user()->hasPermission('read-settings'))
                    <li class="{{request()->is(LaravelLocalization::getCurrentLocale().'/dashboard/settings*')? 'active':''}}"><a href="{{ route('dashboard.settings.edit' , 1 ) }}"><i
                                    class="fa fa-address-card"></i><span>@lang('site.settings')</span></a></li>
                @endif



    </section>

</aside>
