<div class="row">
    <div class="col-lg-5">
        <div class="ibox">
            <div class="ibox-content">
                <div class="panel-group" id="accordion">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h5 class="panel-title">
                                <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">Liên kết tự
                                    tạo </a>
                            </h5>
                        </div>
                        <div id="collapseOne" class="panel-collapse collapse in">
                            <div class="panel-body">
                                <div class="panel-title">Tạo menu</div>
                                <div class="panel-description">
                                    <p>+ Cài đặt menu bạn muốn hiển thị</p>
                                    <p><small class="text-danger">* Khi khởi tạo menu bạn phải chắc chắn đường dẫn của
                                            menu có hoạt động. Đường dẫn trên website được khởi tạo tại các module: Bài
                                            viết, sản phẩm, dự án...</small></p>
                                    <p><small class="text-danger">* Tiêu đề và đường dẫn của menu không được bỏ
                                            trống</small></p>
                                    <p><small class="text-danger">* Hệ thống chỉ hỗ trợ tối đa 5 cấp menu</small></p>
                                    <a href="" class="btn btn-default add-menu m-b m-r right"
                                        style="color:#000; border-color:#c4cdd5; display:inline-block !important;">Thêm
                                        đường dẫn</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @foreach (__('module.model') as $key => $val)
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a data-toggle="collapse" data-model="{{ $key }}" data-parent="#accordion"
                                        href="#{{ $key }}" class="menu-module">{{ $val }}</a>
                                </h4>
                            </div>
                            <div id="{{ $key }}" {{-- class="panel-collapse collapse {{ $key == 'PostCatalogue' ? 'in' : '' }}"> --}} class="panel-collapse collapse">
                                <div class="panel-body">
                                    <form action="" method="get" data-model="{{ $key }}"
                                        classs="search-model">
                                        <div class="form-row">
                                            <input type="text" name="keyword" autocomplete="off"
                                                class="form-control search-menu" id=""
                                                placeholder="Nhập 2 kí tự để tìm kiếm...">
                                        </div>
                                    </form>
                                    <div class="menu-list mt20">

                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-7">
        <div class="ibox">
            <div class="ibox-content">
                <div class="row form-row text-center">
                    <div class="col-lg-4">
                        <label for="">Tên Menu</label>
                    </div>
                    <div class="col-lg-4">
                        <label for="">Đường Dẫn</label>
                    </div>
                    <div class="col-lg-2">
                        <label for="">Vị trí</label>
                    </div>
                    <div class="col-lg-2">
                        <label for="">Xóa</label>
                    </div>
                </div>

                <div class="hr-line-dashed" style="margin: 10px 0;"></div>
                @php
                    $menu = old('menu', $menuList ?? null);
                @endphp
                <div class="menu-wrapper">
                    <div class="notification text-center {{ (is_array($menu) && count($menu)) ? 'hidden' : '' }}">
                        <h4 style="font-weight:500; font-size:16px; color:#000;">Danh sách liên kết này không có bất kì
                            đường dẫn nào</h4>
                        <p style="color:#555; margin-top:10px;">Hãy nhấn vào <span style="color: blue;">"Thêm đường
                                dẫn"</span> để bắt đầu
                            thêm</p>
                    </div>
                    @if (is_array($menu) && count($menu))
                        @foreach ($menu['name'] as $key => $val)
                            <div class="row mb10 menu-item">
                                <div class="col-lg-4">
                                    <input type="text" value="{{ $val }}" class="form-control"
                                        name="menu[name][]">
                                </div>
                                <div class="col-lg-4">
                                    <input type="text" value="{{ $menu['canonical'][$key] }}" class="form-control"
                                        name="menu[canonical][]">
                                </div>
                                <div class="col-lg-2"><input type="text" value="{{ $menu['order'][$key] }}"
                                        class="form-control int text-right" name="menu[order][]">
                                </div>
                                <div class="col-lg-2">
                                    <div class="form-row text-center"><a class="delete-menu"><i
                                                class="fa fa-times"></i></a></div>
                                    <input type="text" name="menu['id'][]" class="hidden"
                                        value="{{ $menu['id'][$key] }}" id="">
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
