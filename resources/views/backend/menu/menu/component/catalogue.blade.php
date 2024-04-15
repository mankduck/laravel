<div class="row">
    <div class="col-lg-5">
        <div class="panel-head">
            <div class="panel-title">Vị trí Menu</div>
            <div class="panel-description">
                <p>Cài đặt vị trí hiển thị cho từng menu</p>
                <p>Lưạ chọn vị trí bạn muốn hiển thị</p>
            </div>
        </div>
    </div>
    <div class="col-lg-7">
        <div class="ibox">
            <div class="ibox-content">
                <div class="row">
                    <div class="col-lg-12 mb10">
                        <div class="uk-flex uk-flex-middle uk-flex-space-between">
                            <div class="font-bold">Chọn vị trí hiển thị <span class="text-danger">(*)</span>
                            </div>
                            <button type="button" data-toggle="modal" data-target="#createMenuCatalogue"
                                class="createMenuCatalogue btn btn-danger">Chọn vị trí hiển thị</button>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        @if (count($menuCatalogues))
                            <select name="menu_catalogue_id" class="setupSelect2" id="">
                                <option value="">[Chọn vị trí hiển thị]</option>
                                @foreach ($menuCatalogues as $key => $val)
                                    <option value="{{ $val->id }}">{{ $val->name }}</option>
                                @endforeach
                            </select>
                        @endif
                    </div>
                    <div class="col-lg-6">
                        <select name="type" class="setupSelect2" id="">
                            <option value="">[Chọn kiểu Menu]</option>
                            @foreach (__('module.type') as $key => $val)
                                <option value="{{ $key }}">{{ $val }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
