@extends('backend.dashboard.layout')
@section('adminContent')
    @include('backend.dashboard.component.breadcrumb', ['title' => $config['seo']['index']['title']])
    @php
        $url =
            isset($config['method']) && $config['method'] == 'translate'
                ? route('system.savetranslate', ['languageId' => $languageId])
                : route('system.store');
    @endphp
    <form action="{{ $url }}" method="post" class="box">
        @csrf
        <div class="wrapper wrapper-content animated fadeInRight">

            <div class="text-center uk-flex uk-flex-middle">
                @foreach ($languages as $language)
                    <a class="image img-cover system-flag"
                        href="{{ route('system.translate', ['languageId' => $language->id]) }}"><img
                            src="{{ $language->image }}" alt=""></a>
                @endforeach
            </div>


            @foreach ($systemConfig as $key => $val)
                <div class="row">
                    <div class="col-lg-5">
                        <div class="panel-head">
                            <div class="panel-title">{{ $val['label'] }}</div>
                            <div class="panel-description">
                                {{ $val['description'] }}
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-7">
                        <div class="ibox">
                            @if (count($val['value']))
                                <div class="ibox-content">
                                    @foreach ($val['value'] as $keyVal => $item)
                                        @php
                                            $name = $key . '_' . $keyVal;
                                        @endphp
                                        <div class="row mb15">
                                            <div class="col-lg-12">
                                                <div class="form-row">
                                                    <label for="" class="uk-flex uk-flex-space-between">
                                                        <span>{{ $item['label'] }}</span>
                                                        {!! renderSystemLink($item) !!}
                                                        {!! renderSystemTitle($item) !!}
                                                    </label>
                                                    @switch($item['type'])
                                                        @case('text')
                                                            {!! renderSystemInput($name, $systems) !!}
                                                        @break

                                                        @case('images')
                                                            {!! renderSystemImage($name, $systems) !!}
                                                        @break

                                                        @case('textarea')
                                                            {!! renderSystemTextarea($name, $systems) !!}
                                                        @break

                                                        @case('select')
                                                            {!! renderSystemSelect($item, $name, $systems) !!}
                                                        @break

                                                        @case('editor')
                                                            {!! renderSystemEditor($name, $systems) !!}
                                                        @break

                                                        @default
                                                    @endswitch
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <hr>
                {{-- <div class="row">
                <div class="col-lg-5">
                    <div class="panel-head">
                        <div class="panel-title">Thông tin liên hệ</div>
                        <div class="panel-description">Nhập thông tin liên hệ của người sử dụng</div>
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="ibox">
                        <div class="ibox-content">
                            <div class="row mb15">
                                <div class="col-lg-6">
                                    <div class="form-row">
                                        <label for="" class="control-label text-left">Thành Phố</label>
                                        <select name="province_id" class="form-control setupSelect2 province location"
                                            data-target="districts">
                                            <option value="0">[Chọn Thành Phố]</option>
                                            @if (isset($provinces))
                                                @foreach ($provinces as $province)
                                                    <option @if (old('province_id') == $province->code) selected @endif
                                                        value="{{ $province->code }}">{{ $province->name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-row">
                                        <label for="" class="control-label text-left">Quận/Huyện </label>
                                        <select name="district_id" class="form-control districts setupSelect2 location"
                                            data-target="wards">
                                            <option value="0">[Chọn Quận/Huyện]</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb15">
                                <div class="col-lg-6">
                                    <div class="form-row">
                                        <label for="" class="control-label text-left">Phường/Xã </label>
                                        <select name="ward_id" class="form-control setupSelect2 wards">
                                            <option value="0">[Chọn Phường/Xã]</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-row">
                                        <label for="" class="control-label text-left">Địa chỉ </label>
                                        <input type="text" name="address"
                                            value="{{ old('addresss', $user->address ?? '') }}" class="form-control"
                                            placeholder="" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                            <div class="row mb15">
                                <div class="col-lg-6">
                                    <div class="form-row">
                                        <label for="" class="control-label text-left">Số điện thoại</label>
                                        <input type="text" name="phone"
                                            value="{{ old('phone', $user->phone ?? '') }}" class="form-control"
                                            placeholder="" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-row">
                                        <label for="" class="control-label text-left">Nhóm Thành viên <span
                                                class="text-danger">(*)</span></label>
                                        <select name="user_catalogue_id" class="form-control setupSelect2">
                                            @foreach ($userCatalogue as $key => $item)
                                                <option
                                                    {{ $key == old('user_catalogue_id', isset($user->user_catalogue_id) ? $user->user_catalogue_id : '') ? 'selected' : '' }}
                                                    value="{{ $key }}">{{ $item }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}
            @endforeach
            <div class="text-right mb15">
                <button class="btn btn-primary" type="submit" name="send" value="send">Lưu lại</button>
            </div>
        </div>
    </form>
@endsection
