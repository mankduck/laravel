@extends('backend.dashboard.layout')
@section('adminContent')
    @include('backend.dashboard.component.breadcrumb', ['title' => $config['seo']['index']['title']])
    <div class="row mt20">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>{{ $config['seo']['index']['table'] }} </h5>
                </div>
                <div class="ibox-content">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th style="width: 10%">Mã đơn hàng</th>
                                <th>Thông tin đặt hàng</th>
                                <th>Địa chỉ</th>
                                <th>PTTT</th>
                                <th>Trạng thái</th>
                                <th>Tùy chọn</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (isset($orders) && count($orders) && !is_null($orders))
                                @foreach ($orders as $order)
                                    <tr>
                                        <td>{{ $order->code }}</td>
                                        <td>{{ $order->name }} <br> {{ $order->phone }} <br> {{ $order->email }}</td>
                                        <td>{{ $order->address }}, {{ $order->country }}</td>
                                        <td>{{ $order->payment_method == 'direct_payment' ? 'Thanh toán trực tiếp' : 'Thanh toán VNPAY' }}
                                        </td>
                                        <td>{{ $order->status }}</td>
                                        <td>
                                            <button type="button" class="btn btn-primary" data-toggle="modal"
                                                data-target="#exampleModal-{{ $order->id }}">
                                                View
                                            </button>
                                        </td>
                                    </tr>
                                    <div class="modal fade" id="exampleModal-{{ $order->id }}" tabindex="-1"
                                        aria-labelledby="exampleModalLabel-{{ $order->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel-{{ $order->id }}">Chi
                                                        tiết đơn hàng {{ $order->code }}</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row mb15">
                                                        <div class="col-lg-6">
                                                            <div class="form-row">
                                                                <label for="" class="control-label text-left">Mã đơn
                                                                    hàng </label>
                                                                <input type="text" class="form-control"
                                                                    value="{{ $order->code }}" placeholder=""
                                                                    autocomplete="off">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-row">
                                                                <label for="" class="control-label text-left">Họ Tên
                                                                </label>
                                                                <input type="text" class="form-control"
                                                                    value="{{ $order->name }}" placeholder=""
                                                                    autocomplete="off">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row mb15">
                                                        <div class="col-lg-6">
                                                            <div class="form-row">
                                                                <label for="" class="control-label text-left">Số
                                                                    điện thoại </label>
                                                                <input type="text" class="form-control"
                                                                    value="{{ $order->phone }}" placeholder=""
                                                                    autocomplete="off">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-row">
                                                                <label for="" class="control-label text-left">Email
                                                                </label>
                                                                <input type="text" class="form-control"
                                                                    value="{{ $order->email }}" placeholder=""
                                                                    autocomplete="off">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row mb15">
                                                        <div class="col-lg-12">
                                                            <div class="form-row">
                                                                <label for="" class="control-label text-left">Địa
                                                                    chỉ </label>
                                                                <input type="text" class="form-control"
                                                                    value="{{ $order->country }}, {{ $order->address }}"
                                                                    placeholder="" autocomplete="off">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        @if (isset($order->product) && count($order->product))
                                                            @php
                                                                $i = 1;
                                                            @endphp
                                                            @foreach ($order->product as $product)
                                                                <div class="col-lg-12 mb15">
                                                                    <div class="form-row">
                                                                        <label for=""
                                                                            class="control-label text-left">Tên sản phẩm {{$i}}
                                                                        </label>
                                                                        <input type="text" class="form-control"
                                                                            value="{{ $product[0] ?? 'Không có sản phẩm' }}"
                                                                            placeholder="" autocomplete="off">
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-6 mb15">
                                                                    <div class="form-row">
                                                                        <label for=""
                                                                            class="control-label text-left">Số lượng
                                                                        </label>
                                                                        <input type="text" class="form-control"
                                                                            value="{{ $product[3] ?? 'Không có số lượng' }}"
                                                                            placeholder="" autocomplete="off">
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-6 mb15">
                                                                    <div class="form-row">
                                                                        <label for=""
                                                                            class="control-label text-left">Giá tiền
                                                                        </label>
                                                                        <input type="text" class="form-control"
                                                                            value="{{ $product[2] ?? 'Không có giá tiền' }}"
                                                                            placeholder="" autocomplete="off">
                                                                    </div>
                                                                </div>
                                                                @php
                                                                    $i++;
                                                                @endphp
                                                            @endforeach
                                                        @endif
                                                    </div>
                                                    <div class="row mb15">
                                                        <div class="col-lg-6">
                                                            <div class="form-row">
                                                                <label for=""
                                                                    class="control-label text-left">Phương
                                                                    thức thanh toán </label>
                                                                <input type="text" class="form-control"
                                                                    value="{{ $order->payment_method == 'direct_payment' ? 'Thanh toán trực tiếp' : 'Thanh toán VNPAY' }}"
                                                                    placeholder="" autocomplete="off">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-row">
                                                                <label for=""
                                                                    class="control-label text-left">Trạng
                                                                    thái </label>
                                                                <input type="text" class="form-control"
                                                                    value="{{ $order->code }}" placeholder=""
                                                                    autocomplete="off">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row mb15">
                                                        <div class="col-lg-6">
                                                            <div class="form-row">
                                                                <label for="" class="control-label text-left">Thời
                                                                    gian đặt hàng </label>
                                                                <input type="text" class="form-control"
                                                                    value="{{ $order->created_at }}" placeholder=""
                                                                    autocomplete="off">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-row">
                                                                <label for="" class="control-label text-left">Thời
                                                                    gian cập nhật gần nhất </label>
                                                                <input type="text" class="form-control"
                                                                    value="{{ $order->updated_at ?? 'Chưa có cập nhật' }}"
                                                                    placeholder="" autocomplete="off">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                    {{ $orders->links('pagination::bootstrap-4') }}

                </div>
            </div>
        </div>
    </div>
@endsection
