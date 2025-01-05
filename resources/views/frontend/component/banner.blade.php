{{-- @if (count($slideItems))
    <section class="banner panel-slide" data-setting="{{ json_encode($slides->setting) }}">
        <div class="row">
            <div class="col-xl-12 col-lg-12">
                <div class="banner__slider owl-carousel swiper-container">
                    @foreach ($slideItems as $key => $val)
                        <div class="banner__item banner set-bg" data-setbg="{!! $val['image'] !!}">
                            <div class="banner__text banner__text__custom">
                                <span>{!! $val['name'] !!}</span>
                                <h1>{!! $val['alt'] !!}</h1>
                                <h5 class="mb20">{!! $val['description'] !!}</h5>
                                @if (isset($val['canonical']))
                                    <a href="{{ $val['canonical'] }}">Shop now</a>
                                @endif
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
        </div>
    </section>
@endif --}}

@if (count($slideItems))
    <div class="panel-slide page-setup" data-setting='{{ json_encode($slides->setting) }}'>
        <div class="uk-container uk-container-center">
            <div class="swiper-container">
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
                <div class="swiper-wrapper">
                    @foreach ($slideItems as $key => $val)
                        <div class="swiper-slide">
                            <div class="slide-item">
                                <span class="image"><img src="{{ $val['image'] }}" alt=""></span>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="swiper-pagination"></div>
            </div>
        </div>
    </div>
@endif
