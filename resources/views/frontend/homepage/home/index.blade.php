@extends('frontend.layout')
@section('contentUser')

    <!-- Banner Section Begin -->
    @include('frontend.component.banner')
    <!-- Banner Section End -->

    <!-- Product Section Begin -->
    <section class="product">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-4">
                    <div class="section-title">
                        <h4>New product</h4>
                    </div>
                </div>
                <div class="col-lg-8 col-md-8">

                </div>
            </div>
            <div class="row property__gallery">
                @if (!is_null($widgets['new-product']))
                    @php $products = collect(); @endphp
                    @foreach ($widgets['new-product'] as $catalogue)
                        @php
                            $products = $products->merge($catalogue->products);
                        @endphp
                    @endforeach
                    @foreach ($products->sortByDesc('created_at')->take(8) as $val)
                        @php
                            $name = $val->languages->first()->pivot->name;
                            $canonical = write_url($val->languages->first()->pivot->canonical);
                            $image = $val->image;
                            $price = number_format_custom($val->price);
                        @endphp
                        <div class="col-lg-3 col-md-4 col-sm-6 mix women">
                            <div class="product__item">
                                <div class="product__item__pic set-bg" data-setbg="{{ $image }}">
                                    <div class="label new">Mới</div>
                                    <ul class="product__hover">
                                        <li><a href="{{ $image }}" class="image-popup">
                                                <span class="arrow_expand"></span></a></li>
                                        <li><a href="#"><span class="icon_heart_alt"></span></a></li>
                                        <li><a href="{{ $canonical }}"><span class="icon_bag_alt"></span></a></li>
                                    </ul>
                                </div>
                                <div class="product__item__text">
                                    <h6><a href="{{ $canonical }}">{{ $name }}</a></h6>
                                    <div class="rating">
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                    </div>
                                    <div class="product__price">{{ $price }}</div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </section>
    <!-- Product Section End -->

    <!-- Trend Section Begin -->
    <section class="trend spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-6">
                    <div class="trend__content">
                        <div class="section-title">
                            <h4>Hot Trend</h4>
                        </div>
                        @if (isset($widgets['hot-trend']) && !is_null($widgets['hot-trend']))
                            @foreach ($widgets['hot-trend'] as $key => $val)
                                @php
                                    $name = $val->languages->first()->pivot->name;
                                    $canonical = write_url($val->languages->first()->pivot->canonical);
                                    $image = $val->image;
                                    $price = number_format_custom($val->price);
                                @endphp
                                <div class="trend__item">
                                    <div class="trend__item__pic">
                                        <img src="{{ $image }}" alt="" width="90px" height="90px">
                                    </div>
                                    <div class="trend__item__text">
                                        <h6><a href="{{ $canonical }}" class="text-dark">{{ $name }}</a></h6>
                                        <div class="rating">
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                        </div>
                                        <div class="product__price">{{ $price }}</div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <h5>Chưa có sản phẩm</h5>
                        @endif
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-6">
                    <div class="trend__content">
                        <div class="section-title">
                            <h4>Best seller</h4>
                        </div>
                        @if (isset($widgets['best-seller']) && !is_null($widgets['best-seller']))
                            @foreach ($widgets['best-seller'] as $key => $val)
                                @php
                                    $name = $val->languages->first()->pivot->name;
                                    $canonical = write_url($val->languages->first()->pivot->canonical);
                                    $image = $val->image;
                                    $price = number_format_custom($val->price);
                                @endphp
                                <div class="trend__item">
                                    <div class="trend__item__pic">
                                        <img src="{{ $image }}" alt="" width="90px" height="90px">
                                    </div>
                                    <div class="trend__item__text">
                                        <h6><a href="{{ $canonical }}" class="text-dark">{{ $name }}</a></h6>
                                        <div class="rating">
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                        </div>
                                        <div class="product__price">{{ $price }}</div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <h5>Chưa có sản phẩm</h5>
                        @endif
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-6">
                    <div class="trend__content">
                        <div class="section-title">
                            <h4>Feature</h4>
                        </div>
                        @if (isset($widgets['feature']) && !is_null($widgets['feature']))
                            @foreach ($widgets['feature'] as $key => $val)
                                @php
                                    $name = $val->languages->first()->pivot->name;
                                    $canonical = write_url($val->languages->first()->pivot->canonical);
                                    $image = $val->image;
                                    $price = number_format_custom($val->price);
                                @endphp
                                <div class="trend__item">
                                    <div class="trend__item__pic">
                                        <img src="{{ $image }}" alt="" width="90px" height="90px">
                                    </div>
                                    <div class="trend__item__text">
                                        <h6><a href="{{ $canonical }}" class="text-dark">{{ $name }}</a></h6>
                                        <div class="rating">
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                        </div>
                                        <div class="product__price">{{ $price }}</div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <h5>Chưa có sản phẩm</h5>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Trend Section End -->

    <!-- Discount Section Begin -->
    <section class="discount">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 p-0">
                    <div class="discount__pic">
                        <img src="frontend/img/discount.jpg" alt="">
                    </div>
                </div>
                <div class="col-lg-6 p-0">
                    <div class="discount__text">
                        <div class="discount__text__title">
                            <span>Giảm giá</span>
                            <h2>Summer 2025</h2>
                            <h5><span>Sale</span> 50%</h5>
                        </div>
                        <div class="discount__countdown" id="countdown-time">
                            <div class="countdown__item">
                                <span>22</span>
                                <p>Days</p>
                            </div>
                            <div class="countdown__item">
                                <span>18</span>
                                <p>Hour</p>
                            </div>
                            <div class="countdown__item">
                                <span>46</span>
                                <p>Min</p>
                            </div>
                            <div class="countdown__item">
                                <span>05</span>
                                <p>Sec</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Discount Section End -->

    <!-- Services Section Begin -->
    <section class="services spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="services__item">
                        <i class="fa fa-car"></i>
                        <h6>Free Shipping</h6>
                        <p>For all oder over $99</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="services__item">
                        <i class="fa fa-money"></i>
                        <h6>Money Back Guarantee</h6>
                        <p>If good have Problems</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="services__item">
                        <i class="fa fa-support"></i>
                        <h6>Online Support 24/7</h6>
                        <p>Dedicated support</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="services__item">
                        <i class="fa fa-headphones"></i>
                        <h6>Payment Secure</h6>
                        <p>100% secure payment</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Services Section End -->
@endsection
