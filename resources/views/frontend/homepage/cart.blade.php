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
                                @if (isset($cartUser) && !is_null($cartUser))
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
                                            <td class="cart__price">{{ $item->price }}đ</td>
                                            <td class="cart__quantity">
                                                <div class="pro-qty">
                                                    <input type="text" value="{{ $item->total }}">
                                                </div>
                                            </td>
                                            <td class="cart__total">{{ $item->price * $item->total }}đ</td>
                                            <td class="cart__close"><span class="icon_close"></span></td>
                                        </tr>
                                    @endforeach
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
                    <div class="discount__content">
                        <h6>Discount codes</h6>
                        <form action="#">
                            <input type="text" placeholder="Enter your coupon code">
                            <button type="submit" class="site-btn">Apply</button>
                        </form>
                    </div>
                </div>
                <div class="col-lg-4 offset-lg-2">
                    <div class="cart__total__procced">
                        <h6>Cart total</h6>
                        <ul>
                            <li>Subtotal <span>$ 750.0</span></li>
                            <li>Total <span>$ 750.0</span></li>
                        </ul>
                        <a href="#" class="primary-btn">Proceed to checkout</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
