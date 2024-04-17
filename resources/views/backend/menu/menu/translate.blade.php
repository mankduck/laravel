@extends('backend.dashboard.layout')
@section('adminContent')
    @php
        $title =
            str_replace('{language}', $language->name, $config['seo']['translate']['title']) .
            ' ' .
            $menuCatalogue->name;
    @endphp
    @include('backend.dashboard.component.breadcrumb', ['title' => $title])
    @include('backend.dashboard.component.formError')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-4">
                <div class="panel-header">Thông tin chung</div>
                <div class="panel-body">
                    <p>Hệ thống tự động lấy ra bản dịch của Menu
                        <span class="text-success"> nếu có</span>
                    </p>
                    <p>Cập nhật các thông tin về bản dịch cho các Menu của bạn phía bên phải <span class="text-success">kéo
                            thả</span> menu
                        đến vị trí mong muốn</p>
                    <p>Lưu ý: Cập nhật đầy đủ thông tin <span class="text-success">quản lý menu con</span></p>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="ibox">
                    <div class="ibox-title">
                        <div class="uk-flex uk-flex-middle uk-flex-space-between">
                            <h5>Danh sách bản dịch</h5>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <div class="menu-translate-item">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-row">
                                        <div class="uk-flex uk-flex-middle">
                                            <div class="menu-name">Tên Menu</div>
                                            <input type="text" value="" class="form-control" placeholder=""
                                                autocomplete="off" disabled>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="uk-flex uk-flex-middle">
                                            <div class="menu-name">Đường Dẫn</div>
                                            <input type="text" value="" class="form-control" placeholder=""
                                                autocomplete="off" disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-row">
                                        <div class="uk-flex uk-flex-middle">
                                            <div class="menu-name">Tên Menu</div>
                                            <input type="text" value="" name="translate[name][]" class="form-control" placeholder=""
                                                autocomplete="off" >
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="uk-flex uk-flex-middle">
                                            <div class="menu-name">Đường Dẫn</div>
                                            <input type="text" value="" name="translate[canonical][]" class="form-control" placeholder=""
                                                autocomplete="off" >
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
