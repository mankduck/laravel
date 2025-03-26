@extends('frontend.layout')
@section('styleCustom')
    <style>
        .selected {
            border: 2px solid red;
            /* Viền màu đỏ khi được chọn */
            background-color: #f8d7da;
            /* Màu nền nhạt để dễ nhận biết */
        }
    </style>
@endsection
@section('contentUser')
    {{-- @dd($productCatalogue->name) --}}
    @include('frontend.component.breadcrumb', [
        'breadcrumb' => $breadcrumb,
    ])

    @if (!is_null($product))
        @php
            $name = $product->languages->first()->pivot->name;
            $content = $product->languages->first()->pivot->content;
            $description = $product->languages->first()->pivot->description;
            $canonical = write_url($product->languages->first()->pivot->canonical);
            $image = $product->image;
            $price = number_format_custom($product->price);
            $attributeCatalogue = $product->attributeCatalogue;
        @endphp
        <section class="product-details spad">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="product__details__pic">
                            <div class="product__details__pic__left product__thumb nice-scroll">
                                @if (!is_null($product->album))
                                    {{-- @dd($product->album) --}}
                                    @foreach (json_decode($product->album) as $key => $val)
                                        <a class="pt" href="javascript:void(0)">
                                            <img src="{{ $val }}" alt="">
                                        </a>
                                    @endforeach
                                @endif
                            </div>
                            <div class="product__details__slider__content">
                                <div class="product__details__pic__slider owl-carousel">
                                    @if (!is_null($product->album))
                                        {{-- @dd($product->album) --}}
                                        @foreach (json_decode($product->album) as $key => $val)
                                            <img data-hash="" class="product__big__img" src="{{ $val }}"
                                                alt="">
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="product__details__text">
                            <h3>{{ $name }}</h3>
                            <div class="rating">
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <span>( 138 reviews )</span>
                            </div>
                            <div class="product__details__price">{{ $price }}</div>
                            <p>{!! $description !!}</p>
                            <div class="product__details__button">
                                {{-- <div class="quantity">
                                    <span>Quantity:</span>
                                    <div class="pro-qty">
                                        <input type="text" value="1">
                                    </div>
                                </div> --}}
                                <button type="button" class="cart-btn btn chooseProductBtn" data-toggle="modal"
                                    data-target="#choosePrdModal"><span class="icon_bag_alt"></span> Thêm vào giỏ</button>
                                {{-- <a href="#" class="cart-btn"><span class="icon_bag_alt"></span> Thêm vào giỏ</a> --}}
                                <ul>
                                    {{-- <li><a href="#"><span class="icon_heart_alt"></span></a></li> --}}
                                </ul>
                            </div>
                            <!-- Modal -->
                            <div class="modal fade" id="choosePrdModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                                aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Chọn sản phẩm</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body choose-prd-modal-body">

                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-warning btnAddToCart" data-dismiss="modal"
                                                data-user-id="{{ Auth::user()->id ?? 0 }}">Thêm vào giỏ</button>
                                            <button type="button" class="btn btn-danger btnBuyNow">Mua ngay</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- @if (!is_null($attributeCatalogue))
                                <div class="product__details__widget">
                                    <ul>
                                        @foreach ($attributeCatalogue as $key => $val)
                                            <li>
                                                <span>{{ $val->name }}:</span>
                                                <div class="size__btn {{ $val->id }}_btn">
                                                    @if (!is_null($val->attribute))
                                                        @foreach ($val->attribute as $attr)
                                                            <label for="" class="">
                                                                <input data-attribute-id="{{ $attr->id }}"
                                                                    type="radio" name="{{ $key }}__radio"
                                                                    id="">
                                                                {{ $attr->name }}
                                                            </label>
                                                        @endforeach
                                                    @endif
                                                </div>
                                            </li>
                                        @endforeach

                                    </ul>
                                </div>
                            @endif --}}

                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="product__details__tab">
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="tab" href="#tabs-1" role="tab">Mô tả</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#tabs-2" role="tab">Chính sách hoàn
                                        trả</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#tabs-3" role="tab">Reviews ( 2
                                        )</a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active" id="tabs-1" role="tabpanel">
                                    <h6>Mô tả</h6>
                                    <p>{!! $content !!}</p>
                                </div>
                                <div class="tab-pane" id="tabs-2" role="tabpanel">
                                    <h6>Specification</h6>
                                    <p>Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut loret fugit, sed
                                        quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt loret.
                                        Neque porro lorem quisquam est, qui dolorem ipsum quia dolor si. Nemo enim ipsam
                                        voluptatem quia voluptas sit aspernatur aut odit aut loret fugit, sed quia ipsu
                                        consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Nulla
                                        consequat massa quis enim.</p>
                                    <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget
                                        dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes,
                                        nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium
                                        quis, sem.</p>
                                </div>
                                <div class="tab-pane" id="tabs-3" role="tabpanel">
                                    <h6>Reviews ( 2 )</h6>
                                    <p>Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut loret fugit, sed
                                        quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt loret.
                                        Neque porro lorem quisquam est, qui dolorem ipsum quia dolor si. Nemo enim ipsam
                                        voluptatem quia voluptas sit aspernatur aut odit aut loret fugit, sed quia ipsu
                                        consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Nulla
                                        consequat massa quis enim.</p>
                                    <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget
                                        dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes,
                                        nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium
                                        quis, sem.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <div class="related__title">
                            <h5>SẢN PHẨM TƯƠNG TỰ</h5>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <div class="product__item">
                            <div class="product__item__pic set-bg" data-setbg="frontend/img/product/related/rp-1.jpg">
                                <div class="label new">New</div>
                                <ul class="product__hover">
                                    <li><a href="frontend/img/product/related/rp-1.jpg" class="image-popup"><span
                                                class="arrow_expand"></span></a></li>
                                    <li><a href="#"><span class="icon_heart_alt"></span></a></li>
                                    <li><a href="#"><span class="icon_bag_alt"></span></a></li>
                                </ul>
                            </div>
                            <div class="product__item__text">
                                <h6><a href="#">Buttons tweed blazer</a></h6>
                                <div class="rating">
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                </div>
                                <div class="product__price">$ 59.0</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <div class="product__item">
                            <div class="product__item__pic set-bg" data-setbg="frontend/img/product/related/rp-2.jpg">
                                <ul class="product__hover">
                                    <li><a href="frontend/img/product/related/rp-2.jpg" class="image-popup"><span
                                                class="arrow_expand"></span></a></li>
                                    <li><a href="#"><span class="icon_heart_alt"></span></a></li>
                                    <li><a href="#"><span class="icon_bag_alt"></span></a></li>
                                </ul>
                            </div>
                            <div class="product__item__text">
                                <h6><a href="#">Flowy striped skirt</a></h6>
                                <div class="rating">
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                </div>
                                <div class="product__price">$ 49.0</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <div class="product__item">
                            <div class="product__item__pic set-bg" data-setbg="frontend/img/product/related/rp-3.jpg">
                                <div class="label stockout">out of stock</div>
                                <ul class="product__hover">
                                    <li><a href="frontend/img/product/related/rp-3.jpg" class="image-popup"><span
                                                class="arrow_expand"></span></a></li>
                                    <li><a href="#"><span class="icon_heart_alt"></span></a></li>
                                    <li><a href="#"><span class="icon_bag_alt"></span></a></li>
                                </ul>
                            </div>
                            <div class="product__item__text">
                                <h6><a href="#">Cotton T-Shirt</a></h6>
                                <div class="rating">
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                </div>
                                <div class="product__price">$ 59.0</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <div class="product__item">
                            <div class="product__item__pic set-bg" data-setbg="frontend/img/product/related/rp-4.jpg">
                                <ul class="product__hover">
                                    <li><a href="frontend/img/product/related/rp-4.jpg" class="image-popup"><span
                                                class="arrow_expand"></span></a></li>
                                    <li><a href="#"><span class="icon_heart_alt"></span></a></li>
                                    <li><a href="#"><span class="icon_bag_alt"></span></a></li>
                                </ul>
                            </div>
                            <div class="product__item__text">
                                <h6><a href="#">Slim striped pocket shirt</a></h6>
                                <div class="rating">
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                </div>
                                <div class="product__price">$ 59.0</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        @php
            ($attributeCatalogue == '') ? $attributeCatalogue = [] : $attributeCatalogue;
            if(isset($attributeCatalogue) && !is_null($attributeCatalogue)){
                foreach ($attributeCatalogue as $key => $val) {
                if (!is_null($val->attribute)) {
                    foreach ($val->attribute as $attr) {
                        $name = $attr->attribute_language->first()->name;
                        $attributeNames[$key][] = [
                            'id' => $attr->id,
                            'name' => $name,
                        ];
                    }
                }
            }
            }
        @endphp
    @endif

    <script>
        var attributeItem = '{!! addslashes(json_encode(isset($attributeNames) ? $attributeNames : [])) !!}'
        var product = '{!! addslashes($product) !!}'
        var attribute = '{!! addslashes(json_encode(value: isset($product->attribute) ? $product->attribute : [])) !!}'
        var variant =
            '{!! addslashes(json_encode(value: isset($variant) ? $variant : [])) !!}'
    </script>
@endsection
@section('scriptFrontend')
    <script src="{{ asset('frontend/custom/add-to-cart.js') }}"></script>
@endSection()
