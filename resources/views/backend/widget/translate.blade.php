@extends('backend.dashboard.layout')
@section('adminContent')
    @php
        $title =
            str_replace('{language}', $translate['name'], $config['seo']['translate']['title']) . ' ' . $widget['name'];
    @endphp
    @include('backend.dashboard.component.breadcrumb', ['title' => $title])
    @include('backend.dashboard.component.formError')

    <form action="{{ route('widget.translate.save') }}" method="post">
        @csrf
        {{-- <input type="hidden" name="option[id]" value="{{ $option['id'] }}">
        <input type="hidden" name="option[languageId]" value="{{ $option['languageId'] }}">
        <input type="hidden" name="option[model]" value="{{ $option['model'] }}"> --}}
        <div class="wrapper wrapper-content animated fadeInRight">
            <input type="hidden" name="translateId" value="{{$translate->id}}">
            <input type="hidden" name="widgetId" value="{{$widget->id}}">
            <div class="row">
                <div class="col-lg-6">
                    <div class="ibox">
                        <div class="ibox-title">
                            <h5>{{ __('messages.tableHeading') }}</h5>
                        </div>
                        <div class="ibox-content">
                            @include('backend.dashboard.component.content', [
                                'model' => $widget ?? null,
                                'disabled' => 1,
                                'offTitle' => true,
                                'offContent' => true,
                            ])
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="ibox">
                        <div class="ibox-title">
                            <h5>{{ __('messages.tableHeading') }}</h5>
                        </div>
                        <div class="ibox-content">
                            @include('backend.dashboard.component.translate', [
                                'model' => $widgetTranslate ?? null,
                                'offTitle' => true,
                                'offContent' => true,
                            ])
                        </div>
                    </div>
                </div>
            </div>
            @include('backend.dashboard.component.button')
        </div>
    </form>
@endsection
