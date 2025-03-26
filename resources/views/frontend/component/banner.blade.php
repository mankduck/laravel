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
@section('styleCustom')
    <style>
        .slide-item {
            position: relative;
            text-align: center;
        }

        .slide-content {
            position: absolute;
            top: 40%;
            left: 50%;
            transform: translateX(-50%);
            padding: 10px 20px;
            color: white;
            border-radius: 5px;
        }

        .slide-title {
            font-size: 30px;
            text-transform: uppercase;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .slide-description {
            font-size: 20px;
        }
    </style>
@endsection
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
                                <div class="slide-content">
                                    <h2 class="slide-title">{{ $val['name'] ?? '' }}</h2>
                                    <p class="slide-description">{{ $val['alt'] ?? '' }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="swiper-pagination"></div>
            </div>
        </div>
    </div>
@endif
