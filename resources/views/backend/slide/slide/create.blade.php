@extends('backend.dashboard.layout')
@section('adminContent')
    @include('backend.dashboard.component.breadcrumb', ['title' => $config['seo']['create']['title']])
    @include('backend.dashboard.component.formError')
    @php
        $url = $config['method'] == 'create' ? route('slide.store') : route('slide.update');
    @endphp
    <form action="{{ $url }}" method="post" class="box">
        @csrf
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-8">
                    <div class="ibox">
                        <div class="ibox-title">
                            <div class="uk-flex uk-flex-middle uk-flex-space-between">
                                <h5>Danh sách slides</h5>
                                <button type="button" class="addSlide btn btn-primary">Thêm Slide</button>
                            </div>
                        </div>

                        <div class="ibox-content">
                            <div class="row custom-row">
                                <div class="col-lg-12">
                                    @for ($i = 0; $i < 10; $i++)
                                        <div class="slide-item mb20">
                                            <div class="row">
                                                <div class="col-lg-3">
                                                    <span class="silde-image img-cover"><img
                                                            src="https://images-wixmp-ed30a86b8c4ca887773594c2.wixmp.com/f/80a9d98d-327f-4bb2-b173-4298d710e51c/derkflv-9f975f3d-791f-4e16-8d9d-fb0a9e5e0554.png?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJ1cm46YXBwOjdlMGQxODg5ODIyNjQzNzNhNWYwZDQxNWVhMGQyNmUwIiwiaXNzIjoidXJuOmFwcDo3ZTBkMTg4OTgyMjY0MzczYTVmMGQ0MTVlYTBkMjZlMCIsIm9iaiI6W1t7InBhdGgiOiJcL2ZcLzgwYTlkOThkLTMyN2YtNGJiMi1iMTczLTQyOThkNzEwZTUxY1wvZGVya2Zsdi05Zjk3NWYzZC03OTFmLTRlMTYtOGQ5ZC1mYjBhOWU1ZTA1NTQucG5nIn1dXSwiYXVkIjpbInVybjpzZXJ2aWNlOmZpbGUuZG93bmxvYWQiXX0.eEDVAlJGBqXo6OeZEORXWk1veGSHFL-ZTUMz43Jtr3Q"
                                                            alt=""></span>
                                                </div>
                                                <div class="col-lg-9">
                                                    <div class="tabs-container">
                                                        <ul class="nav nav-tabs">
                                                            <li class="active"><a data-toggle="tab" href="#tab-1">Thông tin
                                                                    chung</a></li>
                                                            <li class=""><a data-toggle="tab" href="#tab-2">SEO</a>
                                                            </li>
                                                        </ul>
                                                        <div class="tab-content">
                                                            <div id="tab-1" class="tab-pane active">
                                                                <div class="panel-body">
                                                                    <div class="label-text mb10">Mô tả</div>
                                                                    <div class="form-row mb10">
                                                                        <textarea name="" class="form-control" placeholder=""></textarea>
                                                                    </div>
                                                                    <div class="form-row form-row-url">
                                                                        <input type="text" name=""
                                                                            class="form-control" placeholder="URL"
                                                                            value="" id="">
                                                                        <div class="overlay">
                                                                            <div class="uk-flex uk-flex-middle">
                                                                                <label>Mở trong tab mới</label>
                                                                                <input type="checkbox" name=""
                                                                                    id="">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div id="tab-2" class="tab-pane">
                                                                <div class="panel-body">
                                                                    <div class="label-text mb10">Tiêu đề</div>
                                                                    <div class="form-row form-row-url slide-seo-tab mb10">
                                                                        <input type="text" name=""
                                                                            class="form-control" placeholder="URL"
                                                                            value="" id="">
                                                                    </div>

                                                                    <div class="label-text mb10">Tiêu đề</div>
                                                                    <div class="form-row form-row-url slide-seo-tab">
                                                                        <input type="text" name=""
                                                                            class="form-control" placeholder="URL"
                                                                            value="" id="">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                    @endfor
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="ibox slide-setting slide-normal">
                        <div class="ibox-title">
                            <h5>Cài đặt cơ bản</h5>
                        </div>
                        <div class="ibox-content">
                            <div class="row mb15">
                                <div class="col-lg-6">
                                    <div class="form-row">
                                        <label for="" class="control-label text-left">Tên Slide <span
                                                class="text-danger">(*)</span></label>
                                        <input type="text" name="name" value="{{ old('name', $slide->email ?? '') }}"
                                            class="form-control" placeholder="" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-row">
                                        <label for="" class="control-label text-left">Từ khóa <span
                                                class="text-danger">(*)</span></label>
                                        <input type="text" name="keyword"
                                            value="{{ old('keyword', $slide->keyword ?? '') }}" class="form-control"
                                            placeholder="" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                            <div class="row mb15">
                                <div class="col-lg-6">
                                    <div class="setting-item mb20">
                                        <div class="form-row">
                                            <label for="" class="control-label text-left">Chiều rộng <span
                                                    class="text-danger">(*)</span></label>
                                            <div class="setting-value">
                                                <div class="input-group m-b">
                                                    <input type="text" name="name"
                                                        value="{{ old('name', $slide->email ?? '') }}"
                                                        class="form-control" placeholder="" autocomplete="off">
                                                    <span class="input-group-addon">px</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="setting-item mb20">
                                        <div class="form-row">
                                            <label for="" class="control-label text-left">Chiều cao <span
                                                    class="text-danger">(*)</span></label>
                                            <div class="setting-value">
                                                <div class="input-group m-b">
                                                    <input type="text" class="form-control">
                                                    <span class="input-group-addon">px</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="setting-item mb20">
                                        <div class="form-row">
                                            <label for="" class="control-label text-left">Hiệu ứng <span
                                                    class="text-danger">(*)</span></label>
                                            <div class="setting-value">

                                                <select name="post_catalogue_id" class="form-control setupSelect2"
                                                    id="">
                                                    <option value="">Hiệu ứng 1</option>
                                                    <option value="">Hiệu ứng 2</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="setting-item">
                                        <div class="form-row">
                                            <label for="" class="control-label text-left">Điều hướng <span
                                                    class="text-danger">(*)</span></label>
                                            <div class="setting-value">

                                                <div>
                                                    <label>
                                                        <input type="radio" checked="" value="option1"
                                                            id="optionsRadios1" name="optionsRadios"> Ẩn thanh điều
                                                        hướng
                                                    </label>
                                                </div>
                                                <div>
                                                    <label>
                                                        <input type="radio" value="option2" id="optionsRadios2"
                                                            name="optionsRadios"> Hiển thị dạng dấu chấm
                                                    </label>
                                                </div>
                                                <div>
                                                    <label>
                                                        <input type="radio" value="option2" id="optionsRadios2"
                                                            name="optionsRadios"> Hiển thị dạng ảnh thumbnail
                                                    </label>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="ibox slide-setting slide-advance">
                        <div class="ibox-title">
                            <h5>Cài đặt nâng cao</h5>
                            <div class="ibox-tools">
                                <a class="collapse-link">
                                    <i class="fa fa-chevron-up"></i>
                                </a>
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                    <i class="fa fa-wrench"></i>
                                </a>
                                <a class="close-link">
                                    <i class="fa fa-times"></i>
                                </a>
                            </div>
                        </div>
                        <div class="ibox-content">
                            <div class="row">
                                <div class="col-lg-6 mb10">
                                    <div class="setting-item">
                                        <div class="form-row">
                                            <div class="uk-flex uk-flex-midlle">
                                                <label for="" class="control-label text-left">Tự động chạy
                                                </label>
                                                <div class="setting-value">
                                                    <input type="checkbox" name="" value="" id="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 mb10">
                                    <div class="setting-item">
                                        <div class="form-row">
                                            <div class="uk-flex uk-flex-midlle">
                                                <label for="" class="control-label text-left">Dừng khi di chuột
                                                </label>
                                                <div class="setting-value">
                                                    <input type="checkbox" name="" value="" id="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="setting-item mb20">
                                        <div class="form-row">
                                            <label for="" class="control-label text-left">Thời gian chuyển ảnh
                                            </label>
                                            <div class="setting-value">
                                                <div class="input-group m-b">
                                                    <input type="text" name="name"
                                                        value="{{ old('name', $slide->email ?? '') }}"
                                                        class="form-control" placeholder="" autocomplete="off">
                                                    <span class="input-group-addon">px</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="setting-item mb20">
                                        <div class="form-row">
                                            <label for="" class="control-label text-left">Tốc độ hiệu ứng
                                            </label>
                                            <div class="setting-value">
                                                <div class="input-group m-b">
                                                    <input type="text" name="name"
                                                        value="{{ old('name', $slide->email ?? '') }}"
                                                        class="form-control" placeholder="" autocomplete="off">
                                                    <span class="input-group-addon">px</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="ibox short-code">
                        <div class="ibox-title">
                            <h5>Short Code</h5>
                            <div class="ibox-tools">
                                <a class="collapse-link">
                                    <i class="fa fa-chevron-up"></i>
                                </a>
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                    <i class="fa fa-wrench"></i>
                                </a>
                                <a class="close-link">
                                    <i class="fa fa-times"></i>
                                </a>
                            </div>
                        </div>
                        <div class="ibox-content">
                            <textarea name="content" class="form-control ck-editor" placeholder="" autocomplete="off" id="ckContent"
                                data-height="200" {{ isset($disabled) ? 'disabled' : '' }}>{{ old('content', $model->content ?? '') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-right mb15">
                <button class="btn btn-primary" type="submit" name="send" value="send">Lưu lại</button>
            </div>
        </div>
    </form>
@endsection
