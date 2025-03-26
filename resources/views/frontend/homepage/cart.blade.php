@extends('frontend.layout')
@section('styleCustom')
    <style>
        .cart-prd-img {
            width: 90px;
            height: 90px;
            object-fit: cover;
        }
    </style>
@endsection
@section('contentUser')
    <section class="shop-cart spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="shop__cart__table">
                        <table>
                            <thead>
                                <tr>
                                    <th>Sản phẩm</th>
                                    <th>Thành tiền</th>
                                    <th>Số lượng</th>
                                    <th>Đơn giá</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (isset($cartUser) && !is_null($cartUser) && count($cartUser))
                                    @foreach ($cartUser as $item)
                                        <tr>
                                            <td class="cart__product__item">
                                                <img src="{{ $item->image }}" class="cart-prd-img" alt="">
                                                <div class="cart__product__item__title">
                                                    <h6>{{ $item->product->languages->first()->pivot->name }}</h6>
                                                    <h6 class="font-weight-normal text-danger">
                                                        {{ $item->attribute_name == '' ? '' : 'Mẫu: ' . $item->attribute_name }}
                                                    </h6>
                                                </div>
                                            </td>
                                            <td class="cart__price">{{ number_format_custom($item->price) }}</td>
                                            <td class="cart__quantity">
                                                <div class="pro-qty">
                                                    <input type="text" value="{{ $item->total }}">
                                                </div>
                                            </td>
                                            <td class="cart__total">{{ number_format_custom($item->price * $item->total) }}</td>
                                            <td class="cart__close" data-prd-id="{{$item->id}}"><span class="icon_close"></span></td>
                                        </tr>
                                    @endforeach
                                    @else
                                    <tr>
                                        <td>Chưa có sản phẩm</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            {{-- <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="cart__btn">
                        <a href="#">Continue Shopping</a>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="cart__btn update__btn">
                        <a href="#"><span class="icon_loading"></span> Update cart</a>
                    </div>
                </div>
            </div> --}}
            <div class="row">
                <div class="col-lg-6">
                    {{-- <div class="discount__content">
                        <h6>Mã giảm giá</h6>
                        <form action="#">
                            <input type="text" placeholder="Enter your coupon code">
                            <button type="submit" class="site-btn">Xác nhận</button>
                        </form>
                    </div> --}}
                </div>
                <div class="col-lg-4 offset-lg-2">
                    <div class="cart__total__procced">
                        <h6>Thành tiền</h6>
                        <ul>
                            <li>Tiền giảm giá <span>0đ</span></li>
                            <li>Tổng tiền <span class="sum-total-amount"></span></li>
                        </ul>
                        <a href="{{route('checkout.index')}}" class="primary-btn">Thanh toán</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
