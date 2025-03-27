@extends('frontend.layout')
@section('contentUser')
    <section class="checkout spad">
        <div class="container">
            <div class="row">
            </div>
            <form action="{{ route('checkout.create') }}" method="POST" class="checkout__form">
                @method('POST')
                @csrf
                <div class="row">
                    <div class="col-lg-8">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <h5>Thông tin nhận hàng</h5>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="checkout__form__input">
                                    <p>Họ và tên <span>*</span></p>
                                    <input type="text" name="name" value="{{ old('name') }}">
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="checkout__form__input">
                                    <p>Thành phố <span>*</span></p>
                                    <input type="text" name="country" value="{{ old('country') }}">
                                </div>
                                <div class="checkout__form__input">
                                    <p>Địa chỉ <span>*</span></p>
                                    <input type="text" name="address" value="{{ old('address') }}">
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="checkout__form__input">
                                    <p>Số điện thoại <span>*</span></p>
                                    <input type="text" name="phone" value="{{ old('phone') }}">
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="checkout__form__input">
                                    <p>Email <span>*</span></p>
                                    <input type="text" name="email" value="{{ old('email') }}">
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="checkout__form__input">
                                    <p>Ghi chú <span>*</span></p>
                                    <input type="text" name="description" value="{{ old('description') }}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="checkout__order">
                            <h5>Đơn hàng</h5>
                            <div class="checkout__order__product">
                                <ul>
                                    <li>
                                        <span class="top__text">Sản phẩm</span>
                                        <span class="top__text__right">Đơn giá</span>
                                    </li>
                                    @if (isset($cartUser) && !is_null($cartUser))
                                        @foreach ($cartUser as $key => $val)
                                            <li class="row">
                                                <span
                                                    class="col-lg-8 text-left">{{ $val->product->languages->first()->pivot->name . ' - ' . ($val->attribute_name == '' ? '' : $val->attribute_name) }}</span>
                                                <span
                                                    class="col-lg-4 text-right total-checkout">{{ number_format_custom($val->price * $val->total) }}</span>
                                            </li>
                                            <input type="hidden" name="product[{{ $key }}][]"
                                                value="{{ $val->product->languages->first()->pivot->name . ' - ' . ($val->attribute_name == '' ? '' : $val->attribute_name) }}">
                                            <input type="hidden" name="product[{{ $key }}][]"
                                                value="{{ $val->product_id }}">
                                            <input type="hidden" name="product[{{ $key }}][]"
                                                value="{{ number_format_custom($val->price * $val->total) }}">
                                            <input type="hidden" name="product[{{ $key }}][]"
                                                value="{{ $val->total }}">
                                            <input type="hidden" name="product[{{ $key }}][]"
                                                value="{{ $val->uuid }}">
                                        @endforeach
                                    @endif
                                </ul>
                            </div>
                            <div class="checkout__order__total">
                                <ul>
                                    {{-- <li>Subtotal <span>$ 750.0</span></li> --}}
                                    <li>Tổng tiền: <span class="total-amount-checkout" name="total-amount"></span></li>
                                </ul>
                                <input type="hidden" name="total" class="total-checkout-db" value="">
                            </div>
                            <div class="checkout__order__widget">
                                <label for="check-payment">
                                    Thanh toán trực tiếp
                                    <input type="radio" id="check-payment" name="payment-method" value="direct_payment">
                                    <span class="checkmark"></span>
                                </label>
                                <label for="paypal">
                                    VN Pay
                                    <input type="radio" id="paypal" name="payment-method" value="vnp_payment">
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                            <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                            <button type="submit" class="site-btn">Đặt hàng</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let total = 0;

            let totalCheckoutElements = document.querySelectorAll(".total-checkout");

            totalCheckoutElements.forEach(function(element) {
                let priceText = element.textContent.replace(/[^\d]/g, '')
                    .trim();
                let price = parseFloat(priceText) || 0;
                total += price;
            });

            let totalAmountElement = document.querySelector(".total-amount-checkout");
            let totalDB = document.querySelector(".total-checkout-db")
            if (totalAmountElement) {
                totalAmountElement.textContent = total.toLocaleString('vi-VN') + 'đ';
                totalDB.value = total
            }
        });
    </script>
@endsection
