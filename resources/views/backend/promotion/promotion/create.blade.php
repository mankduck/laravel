@extends('backend.dashboard.layout')
@section('adminContent')
    @include('backend.dashboard.component.breadcrumb', ['title' => $config['seo']['create']['title']])
    @include('backend.dashboard.component.formError')
    @php
        $url = $config['method'] == 'create' ? route('widget.store') : route('widget.update', $widget->id);
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
                                            class="control-label text-left">{{ __('messages.promotion.createPromotion.code') }}<span
                                                class="text-danger">(*)</span></label>
                                        <input type="text" name="code"
                                            value="{{ old('code', $promotion->code ?? '') }}" class="form-control"
                                            placeholder="" autocomplete="off" {{ isset($disabled) ? 'disabled' : '' }}>
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
                                <select name="" class="setupSelect2" id="">
                                    <option value="">Chọn hình thức</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="ibox">
                        <div class="ibox-title">
                            <h5>{{ __('messages.promotion.createPromotion.timeProgram') }}</h5>
                        </div>
                        <div class="ibox-content">
                            <div class="form-row mb20">
                                <label for=""
                                    class="control-label text-left">{{ __('messages.promotion.createPromotion.startDate') }}<span
                                        class="text-danger">(*)</span></label>
                                <input type="datetime-local" name="startDate" id="datetime"
                                    value="{{ old('startDate', $promotion->startDate ?? '') }}" class="form-control"
                                    placeholder="" autocomplete="off" {{ isset($disabled) ? 'disabled' : '' }}>
                            </div>
                            <div class="form-row mb20">
                                <label for=""
                                    class="control-label text-left">{{ __('messages.promotion.createPromotion.endDate') }}<span
                                        class="text-danger">(*)</span></label>
                                <input type="datetime-local" name="endDate"
                                    value="{{ old('endDate', $promotion->endDate ?? '') }}" class="form-control"
                                    placeholder="" autocomplete="off" {{ isset($disabled) ? 'disabled' : '' }}>
                            </div>
                            <div class="form-row">
                                <div class="uk-flex uk-flex-middle">
                                    <input type="checkbox" name="" class="" value="accept" id="neverEnd">
                                    <label for=""
                                        class="control-label fix-label ml5">{{ __('messages.promotion.createPromotion.noEndDate') }}</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="ibox">
                        <div class="ibox-title">
                            <h5>{{ __('messages.promotion.createPromotion.customer') }}</h5>
                        </div>
                        <div class="ibox-content">
                            <div class="setting-value">
                                <div class="form-row mb20">
                                    <div class="uk-flex uk-flex-middle">
                                        <input type="radio" name="customer" class="chooseSource" value="accept"
                                            id="allSource">
                                        <label for="allSource"
                                            class="control-label fix-label ml5">{{ __('messages.promotion.createPromotion.allCustomer') }}</label>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="uk-flex uk-flex-middle">
                                        <input type="radio" name="customer" class="chooseSource" value="accept"
                                            id="chooseSource">
                                        <label for="chooseSource"
                                            class="control-label fix-label ml5">{{ __('messages.promotion.createPromotion.chooseCustomer') }}</label>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="ibox">
                        <div class="ibox-title">
                            <h5>{{ __('messages.promotion.createPromotion.object') }}</h5>
                        </div>
                        <div class="ibox-content">
                            <div class="form-row mb20">
                                <div class="uk-flex uk-flex-middle">
                                    <input type="radio" name="apply" class="chooseApply" value=""
                                        id="allApply">
                                    <label for="allApply"
                                        class="control-label fix-label ml5">{{ __('messages.promotion.createPromotion.allObject') }}</label>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="uk-flex uk-flex-middle">
                                    <input type="radio" name="apply" class="chooseApply" value=""
                                        id="chooseApply">
                                    <label for="chooseApply"
                                        class="control-label fix-label ml5">{{ __('messages.promotion.createPromotion.chooseObject') }}</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-right mb15">
                <button class="btn btn-primary" type="submit" name="send" value="send">Lưu lại</button>
            </div>
        </div>
    </form>
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
