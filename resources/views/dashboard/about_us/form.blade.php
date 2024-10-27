{{ csrf_field() }}

@foreach (config('translatable.locales') as $index => $locale)
    <div class="col-md-6">
        <div class="form-group">
            <label>@lang('site.' . $locale . '.description')</label>
            <input type="text" class="form-control @error($locale . ' .description') is-invalid
        @enderror " name=" {{ $locale }}[name]"
                   value="{{ isset($row) ? $row->translate($locale)->description : old($locale . '.description') }}" required >

            @error($locale . '.description')
            <small class=" text text-danger" role="alert">
                <strong>{{ $message }}</strong>
            </small>
            @enderror
        </div>
    </div>
@endforeach

