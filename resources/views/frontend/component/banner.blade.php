@if (count($slideItems))
    <section class="banner panel-slide" data-setting="{{ json_encode($slides->setting) }}">
        <div class="row">
            <div class="col-xl-12 col-lg-12">
                <div class="banner__slider owl-carousel swiper-container">
                    @foreach ($slideItems as $key => $val)
                        <div class="banner__item banner set-bg" data-setbg="{!! $val['image'] !!}">
                            <div class="banner__text banner__text__custom">
                                <span>{!! $val['name'] !!}</span>
                                <h1>{!! $val['description'] !!}</h1>
                                <a href="#">Shop now</a>
                            </div>
                        </div>
                    @endforeach
                    {{-- <div class="banner__item banner set-bg" data-setbg="frontend/img/banner/banner-2.jpg">
                        <div class="banner__text banner__text__custom">
                            <span>The Chloe Collection</span>
                            <h1>The Project Jacket</h1>
                            <a href="#">Shop now</a>
                        </div>
                    </div>
                    <div class="banner__item banner set-bg" data-setbg="frontend/img/banner/banner-3.jpg">
                        <div class="banner__text banner__text__custom">
                            <span>The Chloe Collection</span>
                            <h1>The Project Jacket</h1>
                            <a href="#">Shop now</a>
                        </div>
                    </div> --}}
                </div>
            </div>
        </div>
    </section>
@endif
{{-- 
@if (count($slideItems))
    <div class="panel-slide page-setup" data-setting="{{ json_encode($slides->setting) }}">
        <div class="uk-container uk-container-center">
            <div class="swiper-container">
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
                <div class="swiper-wrapper">
                    @foreach ($slideItems as $key => $val)
                        <div class="swiper-slide">
                            <div class="slide-item">
                                <div class="slide-overlay">
                                    <div class="slide-title">{!! $val['name'] !!}</div>
                                    <div class="slide-description">{!! $val['description'] !!}</div>
                                </div>
                                <span class="image"><img src="{!! $val['image'] !!}" alt=""></span>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="swiper-pagination"></div>
            </div>

        </div>
    </div>
@endif --}}
