@extends('dashboard.layouts.app')

@section('title', __('site.' . $module_name_plural))


@section('content')

    <div class="content-wrapper">

        <section class="content-header">

            <h1>@lang('site.'.$module_name_plural)</h1>

            <ol class="breadcrumb">
                <li> <a href="{{ route('dashboard.home') }}"><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a>
                </li>
                <li class="active"><i class="fa fa-users"></i> @lang('site.'.$module_name_plural)</li>
            </ol>
        </section>

        <section class="content">

            <div class="box box-primary">

                <div class="box-header with-border">
                    <h1 class="box-title"> @lang('site.'.$module_name_plural) <small>{{ $rows->total() }}</small></h1>

                    <form action="{{ route('dashboard.' . $module_name_plural . '.index') }}" method="get">

                        <div class="row">

                            <div class="col-md-4">
                                <input type="text" name="search" value="{{ request()->search }}" class="form-control"
                                       placeholder="@lang('site.search')">
                            </div>

                            <div class="col-md-4">
                                <button class="btn btn-primary" type="submit"><i class="fa fa-search"></i>
                                    @lang('site.search')</button>
{{--                                @if (auth()->user()->hasPermission('create-'.$module_name_plural))--}}
{{--                                    <a href="{{ route('dashboard.' . $module_name_plural . '.create') }}"--}}
{{--                                       class="btn btn-primary"><i class="fa fa-plus"></i> @lang('site.add')</a>--}}
{{--                                @else--}}
{{--                                    <button disabled>add </button>--}}
{{--                                @endif--}}


                            </div>
                        </div>
                    </form>
                </div> {{-- end of box header --}}

                <div class="box-body">

                    @if ($rows->count() > 0)

                        <table class="table table-hover">

                            <thead style="background-color: #B5D0DF">
                            <tr>
                                <th>#</th>
                                <th>@lang('site.first_name')</th>
                                <th>@lang('site.last_name')</th>
                                <th>@lang('site.phone')</th>
                                <th>@lang('site.country')</th>
                                <th>@lang('site.city')</th>
                                <th>@lang('site.job_title')</th>
                                <th>@lang('site.status')</th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach ($rows as $index => $row)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ substr($row->first_name, 0, 25) }} @if(strlen($row->first_name) > 25 )...@endif</td>
                                    <td>{{ substr($row->last_name, 0, 25) }} @if(strlen($row->last_name) > 25 )...@endif</td>
                                    <td>{{ substr($row->phone, 0, 25) }} @if(strlen($row->phone) > 25 )...@endif</td>
                                    <td>
                                        @isset( $row->country->name )
                                            {{ substr($row->country->name, 0, 30) }} @if(strlen($row->country->name) >= 30 )... @endif
                                            @endisset
                                    </td>
                                    <td>
                                        @isset( $row->city->name )
                                            {{ substr($row->city->name, 0, 30) }} @if(strlen($row->city->name) >= 30 )... @endif
                                            @endisset
                                    </td>
                                    <td>
                                        @isset( $row->JobTitle->name )
                                            {{ substr($row->JobTitle->name, 0, 100 ) }} @if(strlen($row->JobTitle->name) >= 100 )... @endif
                                            @endisset

                                    </td>
                                    <td>
                                        <a   @if( $row['status'] == 1)
                                             class="btn btn-success"
                                             @else
                                             class="btn btn-danger"
                                             @endif
                                             href="{{ route('dashboard.client.change_status' , $row['id']) }}">
                                            @lang('site.' . $row['status'] )
                                        </a>
                                    </td>
{{--                                    <td>--}}
{{--                                        <button type="button" class="btn btn-default btn-xs" data-toggle="modal" data-target="#myModalWatch{{ $row->id }}">  <img src="{{$row->image_path}}" width="50" height='50'> </button>--}}
{{--                                    </td>--}}
                                    {{--                 START MODELE                   --}}
                                    <div class="container">
                                        <!-- Modal -->
                                        <div class="modal fade" id="myModalWatch{{ $row->id }}" role="dialog">
                                            <div class="modal-dialog">

                                                <!-- Modal content-->
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        <h4 class="modal-title">@lang('site.image')</h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        <ul class="list-group">
                                                            <div> {{ $row->name  }}</div>
                                                        </ul>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-default" data-dismiss="modal">@lang('site.close')</button>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                    </div>
                                    {{--                 END MODELE                     --}}

{{--                                    <td>--}}
{{--                                        @if (auth()->user()->hasPermission('update-'.$module_name_plural))--}}
{{--                                            @include('dashboard.buttons.edit')--}}
{{--                                        @else--}}
{{--                                            <input type="submit" value="edit" disabled>--}}
{{--                                        @endif--}}

{{--                                        @if (auth()->user()->hasPermission('delete-'.$module_name_plural))--}}
{{--                                            @include('dashboard.buttons.delete')--}}
{{--                                        @else--}}
{{--                                            <input type="submit" value="delete" disabled>--}}
{{--                                        @endif--}}

{{--                                    </td>--}}
                                </tr>
                            @endforeach

                            </tbody>

                        </table> {{-- end of table --}}

                        {{ $rows->appends(request()->query())->links() }}

                    @else
                        <tr>
                            <h4>@lang('site.no_records')</h4>
                        </tr>
                    @endif

                </div> {{-- end of box body --}}

            </div> {{-- end of box --}}

        </section><!-- end of content -->

    </div><!-- end of content wrapper -->

@endsection
