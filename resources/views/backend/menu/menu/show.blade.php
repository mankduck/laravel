@extends('backend.dashboard.layout')
@section('adminContent')
    @include('backend.dashboard.component.breadcrumb', [
        'title' => $config['seo'][$config['method']]['title'],
    ])
    @include('backend.dashboard.component.formError')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-4">
                <div class="text-center uk-flex uk-flex-middle mb20">
                    @foreach ($languages as $language)
                        @if (session('app_locale') === $language->canonical)
                            @continue
                        @endif
                        <a class="image img-cover system-flag"
                            href="{{ route('menu.translate', ['languageId' => $language->id]) }}"><img
                                src="{{ $language->image }}" alt=""></a>
                    @endforeach
                </div>

                <div class="panel-header">Danh sách Menu</div>
                <div class="panel-body">
                    <p>Danh sách Menu giúp bạn dễ dàng kiểm soát được bố cục menu. Bạn có thể thêm hoặc cập nhật menu bằng
                        <span class="text-success">Cập nhật menu</span>
                    </p>
                    <p>Bạn có thể thay đổi vị trí hiển thị của menu bằng cách <span class="text-success">kéo thả</span> menu
                        đến vị trí mong muốn</p>
                    <p>Dễ dàng khởi tạo menu con bằng cách click vào <span class="text-success">quản lý menu con</span></p>
                    <p><span class="text-danger">Chỉ hỗ trợ tới danh mục con cấp 5</span></p>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="ibox">
                    <div class="ibox-title">
                        <div class="uk-flex uk-flex-middle uk-flex-space-between">
                            <h5>{{ $menuCatalogue->name }}</h5>
                            <a href="{{ route('menu.editMenu', ['id' => $id]) }}" class="custom-button">Cập nhật Menu cấp
                                1</a>
                        </div>
                    </div>
                    <div class="ibox-content" id="dataCatalogue" data-catalogueId="{{ $id }}">
                        @php
                            $menus = recursive($menus);
                            $menuString = recursive_menu($menus);
                        @endphp
                        @if (count($menus))
                            <div class="dd" id="nestable2">
                                <ol class="dd-list">
                                    {!! $menuString !!}
                                </ol>
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- 
    <form action="{{ $url }}" method="post" class="box menuContainer">
        @csrf
        <div class="wrapper wrapper-content animated fadeInRight">
            @include('backend.menu.menu.component.catalogue')
            <hr>
            @include('backend.menu.menu.component.list')

            <div class="text-right mb15">
                <button class="btn btn-primary" type="submit" name="send" value="send">Lưu lại</button>
            </div>
        </div>
    </form>

    @include('backend.menu.menu.component.popup') --}}
@endsection
