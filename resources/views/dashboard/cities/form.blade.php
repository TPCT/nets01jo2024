{{ csrf_field() }}

@foreach (config('translatable.locales') as $index => $locale)
    <div class="col-md-6">
        <div class="form-group">
            <label>@lang('site.' . $locale . '.name')</label>
            <input type="text" class="form-control @error($locale . ' .name') is-invalid
        @enderror " name=" {{ $locale }}[name]"
                value="{{ isset($row) ? $row->translate($locale)->name : old($locale . '.name') }}"
            required >

            @error($locale . '.name')
                <small class=" text text-danger" role="alert">
                    <strong>{{ $message }}</strong>
                </small>
            @enderror
        </div>
    </div>
@endforeach

    <div class="col-md-12">
    <div class="form-group">
        <label>@lang('site.country_id')</label>
        <select name="country_id"  class='form-control js-example-basic-single'>
            <option value="">@lang('site.choose_country_id')</option>
            @foreach(\App\Models\Country::all() as $country )
                <option value="{{ $country->id }}" @if(isset($row) && $row->country_id==$country->id || old('country_id') == $country->id) selected  @endif >{{$country->name}}</option>
            @endforeach
        </select>
        @error('country_id')
            <small class=" text text-danger" role="alert">
                <strong>{{ $message }}</strong>
            </small>
        @enderror
    </div>

</div>


@section('scripts')

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            $('.js-example-basic-single').select2();
        });
    </script>

@endsection




