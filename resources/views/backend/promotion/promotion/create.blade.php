@extends('backend.dashboard.layout')
@section('adminContent')
    @include('backend.dashboard.component.breadcrumb', ['title' => $config['seo']['create']['title']])
    @include('backend.dashboard.component.formError')
    @php
        $url = $config['method'] == 'create' ? route('promotion.store') : route('promotion.update', $promotion->id);
    @endphp
    <form action="{{ $url }}" method="post" class="box">
        @csrf
        <div class="wrapper wrapper-content animated fadeInRight promotion-wrapper">
            <div class="row">
                <div class="col-lg-8">
                    <div class="ibox">
                        <div class="ibox-title">
                            <h5>{{ __('messages.tableHeading') }}</h5>
                        </div>
                        <div class="ibox-content">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-row">
                                        <label for=""
                                            class="control-label text-left">{{ __('messages.promotion.createPromotion.name') }}<span
                                                class="text-danger">(*)</span></label>
                                        <input type="text" name="name"
                                            value="{{ old('name', $promotion->name ?? '') }}" class="form-control"
                                            placeholder="" autocomplete="off" {{ isset($disabled) ? 'disabled' : '' }}>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-row">
                                        <label for=""
                                            class="control-label text-left">{{ __('messages.promotion.createPromotion.code') }}</label>
                                        <input type="text" name="code"
                                            value="{{ old('code', $promotion->code ?? '') }}" class="form-control"
                                            placeholder="{{ __('messages.promotion.createPromotion.placeholder') }}" autocomplete="off" {{ isset($disabled) ? 'disabled' : '' }}>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-row">
                                        <label for=""
                                            class="control-label text-left">{{ __('messages.promotion.createPromotion.description') }}
                                        </label>
                                        <textarea name="description" class="ck-editor" id="ckDescription" {{ isset($disabled) ? 'disabled' : '' }}
                                            data-height="100">{{ old('description', $promotion->description ?? '') }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="ibox">
                        <div class="ibox-title">
                            <h5>
                                {{ __('messages.promotion.createPromotion.setupPromotionDetail') }}
                            </h5>
                        </div>
                        <div class="ibox-content">
                            <div class="form-row">
                                <label for=""
                                    class="control-label text-left mb10">{{ __('messages.promotion.createPromotion.formPromotion') }}<span
                                        class="text-danger">(*)</span></label>
                                <select name="method" class="setupSelect2 promotionMethod" id="">
                                    <option value="">Chọn hình thức</option>
                                    @foreach (__('module.promotion') as $key => $val)
                                        <option value="{{ $key }}">{{ $val }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="promotion-container">

                            </div>
                        </div>
                    </div>
                </div>
                @include('backend.promotion.promotion.component.aside')
            </div>
            <div class="text-right mb15">
                <button class="btn btn-primary" type="submit" name="send" value="send">Lưu lại</button>
            </div>
        </div>
    </form>
    <input type="hidden" class="input-product-and-quantity" value="{{ json_encode(__('module.item')) }}">
    @include('backend.promotion.promotion.component.popup')
    <script>
        const now = new Date();
        const year = now.getFullYear();
        const month = String(now.getMonth() + 1).padStart(2, '0');
        const day = String(now.getDate()).padStart(2, '0');
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');

        const formattedDateTime = `${year}-${month}-${day}T${hours}:${minutes}`;

        const datetimeInput = document.getElementById('datetime');
        datetimeInput.value = formattedDateTime;
        datetimeInput.min = formattedDateTime; // Set the minimum value to current date and time
    </script>
@endsection
