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
                                <select name="" class="setupSelect2 promotionMethod" id="">
                                    <option value="">Chọn hình thức</option>
                                    @foreach (__('module.promotion') as $key => $val)
                                        <option value="{{ $key }}">{{ $val }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="promotion-container">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th class="text-right" style="width: 390px">Sản phẩm mua</th>
                                            <th class="text-right" style="width: 100px">SL tối thiểu</th>
                                            <th class="text-right">Giới hạn KM</th>
                                            <th class="text-right" style="width: 150px">Chiết khấu</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="order_amount_range_from td-range">
                                                <div class="product-quantity" data-toggle="modal"
                                                    data-target="#findProduct">
                                                    <div class="uk-flex uk-flex-middle">
                                                        <div class="boxWrapper">
                                                            <div class="boxSearchIcon ">
                                                                <i class="fa fa-search"></i>
                                                            </div>
                                                            @for ($i = 1; $i <= 10; $i++)
                                                                <div class="fixGrid6 hidden">
                                                                    <div class="goods-item">
                                                                        <span class="goods-item-name">Áo Sơ Mi Cộc Tay
                                                                            Nam</span>
                                                                        <button class="delete-goods-item">
                                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                                viewBox="0 0 384 512"><!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                                                                <path
                                                                                    d="M342.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L192 210.7 86.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L146.7 256 41.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 301.3 297.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L237.3 256 342.6 150.6z" />
                                                                            </svg>
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            @endfor


                                                            <div class="boxSearchInput fixGrid6">
                                                                <p>Tìm kiếm sản phẩm...</p>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="order_amount_range_to td-range">
                                                <input type="text" name="amountTo[]" class="form-control int"
                                                    value="1" placeholder="1" id="">
                                            </td>
                                            <td>
                                                <input type="text" name="amountTo[]" class="form-control int"
                                                    value="0" placeholder="0" id="">
                                            </td>
                                            <td class="discountType">
                                                <div class="uk-flex uk-flex-middle">
                                                    <input type="text" name="amountValue[]" class="form-control int"
                                                        value="0" placeholder="0" id="">
                                                    <select name="amountType" class="multipleSelect2" id="">
                                                        <option value="cash">đ</option>
                                                        <option value="percent">%</option>
                                                    </select>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
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
