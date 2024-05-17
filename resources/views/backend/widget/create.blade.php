@extends('backend.dashboard.layout')
@section('adminContent')
    @include('backend.dashboard.component.breadcrumb', ['title' => $config['seo']['create']['title']])
    @include('backend.dashboard.component.formError')
    @php
        $url = $config['method'] == 'create' ? route('widget.store') : route('widget.update', $slide->id);
    @endphp
    <form action="{{ $url }}" method="post" class="box">
        @csrf
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-9">
                    <div class="ibox">
                        <div class="ibox-title">
                            <h5>Thông tin chung</h5>
                        </div>
                        <div class="ibox-content widgetContent">
                            @include('backend.dashboard.component.content', [
                                'offTitle' => true,
                                'offContent' => true,
                            ])
                        </div>
                    </div>
                    <div class="ibox">
                        <div class="ibox-content widgetContent">
                            @include('backend.dashboard.component.album')
                        </div>
                    </div>
                    <div class="ibox">
                        <div class="ibox-title">
                            <h5>Cấu hình nội dung Widget</h5>
                        </div>
                        <div class="ibox-content model-list">
                            <div class="labelText">Chọn Module</div>
                            @foreach (__('module.model') as $key => $val)
                                <div class="model-item uk-flex uk-flex-middle">
                                    <input type="radio" class="input-radio" name="model" value="{{ $key }}"
                                        id="{{ $key }}">
                                    <label for="{{ $key }}">{{ $val }}</label>
                                </div>
                            @endforeach

                            <div class="search-model-box">
                                <i class="fa fa-search"></i>
                                <input type="text" name="" class="form-control search-model" id="">

                                <div class="ajax-search-result">

                                </div>
                            </div>

                            <div class="search-model-result">
                                
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    @include('backend.widget.component.aside')
                </div>
            </div>
            <div class="text-right mb15">
                <button class="btn btn-primary" type="submit" name="send" value="send">Lưu lại</button>
            </div>
        </div>
    </form>
@endsection
