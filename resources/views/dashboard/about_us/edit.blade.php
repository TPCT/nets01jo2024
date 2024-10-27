@extends('dashboard.layouts.app')

@section('title', __('site.about_us.edit'))

@section('content')

    <div class="content-wrapper">

        <section class="content-header">

            <h1>@lang('site.edit')</h1>

            <ol class="breadcrumb">
                <li> <a href="{{ route('dashboard.home') }}"><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a></li>
                <li class="active"><i class="fa fa-edit"></i> @lang('site.about_us.edit')</li>
            </ol>
        </section>

        <section class="content">

            <div class="box box-primary">

                <div class="box-header with-border">
                    <h1 class="box-title"> @lang('site.edit')</h1>
                </div> {{-- end of box header --}}

                <div class="box-body">

                    {{-- @include('dashboard.partials._errors') --}}
                    <form action="{{ route('dashboard.about_us.update' ) }}" method="post"
                        enctype="multipart/form-data">

                        {{ csrf_field() }}

                        @foreach (config('translatable.locales') as $index => $locale)
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>@lang('site.' . $locale . '.description')</label>


                                    <textarea class="form-control ckeditor" cols="30" rows="10" name="{{ $locale }}[description]" >
                                    {!! $row->translate($locale)->description !!}
                                    </textarea>

                                    @error($locale . '.description')
                                    <small class=" text text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </small>
                                    @enderror
                                </div>
                            </div>
                        @endforeach
                        <div class="row" style="margin: 0 !important;">
                            <div class="col-md-12">
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary"><i class="fa fa-edit"></i>
                                @lang('site.edit')</button>
                        </div>
                        </div>
                        </div>

                    </form> {{-- end of form --}}

                </div> {{-- end of box body --}}

            </div> {{-- end of box --}}

        </section><!-- end of content -->

    </div><!-- end of content wrapper -->

@endsection
