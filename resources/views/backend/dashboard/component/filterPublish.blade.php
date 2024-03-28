@php
    $publish = request('publish') ?: old('publish');
@endphp
<select name="publish" class="form-control setupSelect2 ml10">
    @foreach(config('apps.general.publish') as $key => $val)
    <option {{ ($publish == $key)  ? 'selected' : '' }} value="{{ $key }}">{{ $val }}</option>
    @endforeach
</select>