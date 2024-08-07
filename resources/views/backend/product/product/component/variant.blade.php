<div class="ibox variant-box">
    <div class="ibox-title">
        <div>
            <h5>Sản phẩm có nhiều phiên bản</h5>
        </div>
        <div class="description">Cho phép bạn bán các phiên bản khác nhau của sản phẩm, ví dụ: : quần, áo thì có các
            <strong class="text-danger">màu sắc</strong> và <strong class="text-danger">size</strong> số khác nhau. Mỗi
            phiên bản sẽ là 1 dòng trong mục danh sách phiên bản phía dưới
        </div>
    </div>
    <div class="ibox-content">
        <div class="row">
            <div class="col-lg-12">
                <div class="variant-checkbox uk-flex uk-flex-middle">
                    <input type="checkbox" value="1" name="accept" id="variantCheckbox"
                        class="variantInputCheckbox"
                        {{ old('accept') == 1 || (isset($product) && count($product->product_variants) > 0) ? 'checked' : '' }}>
                    <label for="variantCheckbox" class="turnOnVariant">Sản phẩm này có nhiều biến thể. Ví dụ như khác
                        nhau về màu sắc, kích thước</label>
                </div>
            </div>
        </div>

        @php
            $variantCatalogue = old('attributeCatalogue', (isset($product->attributeCatalogue) ? json_decode($product->attributeCatalogue, TRUE) : []
            ));
        @endphp

        <div class="variant-wrapper {{(isset($variantCatalogue)) ? '' : 'hidden'}}">
            <div class="row variant-container">
                <div class="col-lg-3">
                    <div class="attribute-title">Chọn thuộc tính</div>
                </div>
                <div class="col-lg-9">
                    <div class="attribute-title">Chọn giá trị của thuộc tính (nhập 2 từ để tìm kiếm)</div>
                </div>
            </div>
            <div class="variant-body">

                @if ($variantCatalogue && count($variantCatalogue))
                    @foreach ($variantCatalogue as $keyAttr => $valAttr)
                        <div class="row mb20 variant-item">
                            <div class="col-lg-3">
                                <div class="attribute-catalogue">
                                    <select name="attributeCatalogue[]" id=""
                                        class="choose-attribute niceSelect">
                                        <option value="">Chọn Nhóm thuộc tính</option>
                                        @foreach ($attributeCatalogue as $key => $val)
                                            <option {{ $valAttr == $val->id ? 'selected' : '' }}
                                                value="{{ $val->id }}">
                                                {{ $val->attribute_catalogue_language->first()->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-8">
                                {{-- <input type="text" name="" disabled class="fake-variant form-control"> --}}
                                <select name="attribute[{{ $valAttr }}][]"
                                    class="selectVariant variant-{{ $valAttr }} form-control" id=""
                                    multiple data-catid="{{ $valAttr }}"></select>
                            </div>
                            <div class="col-lg-1">
                                <button type="button" class="remove-attribute btn btn-danger"><svg
                                        data-icon="TrashSolidLarge" aria-hidden="true" focusable="false" width="15"
                                        height="16" viewBox="0 0 15 16" class="bem-Svg" style="display: block;">
                                        <path fill="currentColor"
                                            d="M2 14a1 1 0 001 1h9a1 1 0 001-1V6H2v8zM13 2h-3a1 1 0 01-1-1H6a1 1 0 01-1 1H1v2h13V2h-1z">
                                        </path>
                                    </svg></button>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
            <div class="variant-foot mt10">
                <button type="button" class="add-variant">Thêm phiên bản mới</button>
            </div>
        </div>
    </div>
</div>

<div class="ibox product-variant">
    <div class="ibox-title">
        <h5>Danh sách phiên bản</h5>
    </div>
    <div class="ibox-content">
        <div class="table-responsive">
            <table class="table table-striped variantTable">
                <thead></thead>
                <tbody></tbody>
            </table>
        </div>
        {{-- 
        <tr>
            <td colspan="6">
                <div class="updateVariant ibox">
                    <div class="ibox-title">
                        <div class="uk-flex uk-flex-middle uk-flex-space-between">
                            <h5>Cập nhật thông tin phiên bản</h5>
                            <div class="button-group">
                                <div class="uk-flex uk-flex-middle">
                                    <button type="button" class="cancleUpdate btn btn-danger mr10">Hủy bỏ</button>
                                    <button type="button" class="cancleUpdate btn btn-success">Lưu lại</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <div class="click-to-upload-variant">
                            <div class="icon">
                                <a type="button" class="upload-variant-picture">
                                    <svg style="width:80px;height:80px;fill: #d3dbe2;margin-bottom: 10px;"
                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 80 80">
                                        <path
                                            d="M80 57.6l-4-18.7v-23.9c0-1.1-.9-2-2-2h-3.5l-1.1-5.4c-.3-1.1-1.4-1.8-2.4-1.6l-32.6 7h-27.4c-1.1 0-2 .9-2 2v4.3l-3.4.7c-1.1.2-1.8 1.3-1.5 2.4l5 23.4v20.2c0 1.1.9 2 2 2h2.7l.9 4.4c.2.9 1 1.6 2 1.6h.4l27.9-6h33c1.1 0 2-.9 2-2v-5.5l2.4-.5c1.1-.2 1.8-1.3 1.6-2.4zm-75-21.5l-3-14.1 3-.6v14.7zm62.4-28.1l1.1 5h-24.5l23.4-5zm-54.8 64l-.8-4h19.6l-18.8 4zm37.7-6h-43.3v-51h67v51h-23.7zm25.7-7.5v-9.9l2 9.4-2 .5zm-52-21.5c-2.8 0-5-2.2-5-5s2.2-5 5-5 5 2.2 5 5-2.2 5-5 5zm0-8c-1.7 0-3 1.3-3 3s1.3 3 3 3 3-1.3 3-3-1.3-3-3-3zm-13-10v43h59v-43h-59zm57 2v24.1l-12.8-12.8c-3-3-7.9-3-11 0l-13.3 13.2-.1-.1c-1.1-1.1-2.5-1.7-4.1-1.7-1.5 0-3 .6-4.1 1.7l-9.6 9.8v-34.2h55zm-55 39v-2l11.1-11.2c1.4-1.4 3.9-1.4 5.3 0l9.7 9.7c-5.2 1.3-9 2.4-9.4 2.5l-3.7 1h-13zm55 0h-34.2c7.1-2 23.2-5.9 33-5.9l1.2-.1v6zm-1.3-7.9c-7.2 0-17.4 2-25.3 3.9l-9.1-9.1 13.3-13.3c2.2-2.2 5.9-2.2 8.1 0l14.3 14.3v4.1l-1.3.1z">
                                        </path>
                                    </svg>
                                </a>
                            </div>
                            <div class="small-text">Sử dụng nút chọn hình để thêm mới hình ảnh
                            </div>
                        </div>
                        <ul class="upload-variant-list hidden sortui ui-sortable clearfix " id="sortable2"></ul>
                        <div class="row mt20 uk-flex uk-flex-middle">
                            <div class="col-lg-2 uk-flex uk-flex-middle">
                                <label for="" class="mr10">Tồn kho</label>
                                <input type="checkbox" class="js-switch" data-target="variantQuantity">
                            </div>
                            <div class="col-lg-10">
                                <div class="row">
                                    <div class="col-lg-3">
                                        <label for="" class="control-label">Số lượng</label>
                                        <input type="text" disabled name="quantity" value="0"
                                            class="form-control disabled">
                                    </div>
                                    <div class="col-lg-3">
                                        <label for="" class="control-label">SKU</label>
                                        <input type="text" name="sku" value="" class="form-control">
                                    </div>
                                    <div class="col-lg-3">
                                        <label for="" class="control-label">Giá</label>
                                        <input type="text" name="sku" value="0" class="form-control">
                                    </div>
                                    <div class="col-lg-3">
                                        <label for="" class="control-label">Barcode</label>
                                        <input type="text" name="sku" value="" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt20 uk-flex uk-flex-middle">
                            <div class="col-lg-2 uk-flex uk-flex-middle">
                                <label for="" class="mr10">QL File</label>
                                <input type="checkbox" class="js-switch" data-target="disabled">
                            </div>
                            <div class="col-lg-10">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <label for="" class="control-label">Tên File</label>
                                        <input type="text" disabled name="file_name" value=""
                                            class="form-control disabled">
                                    </div>
                                    <div class="col-lg-6">
                                        <label for="" class="control-label">Đường dẫn</label>
                                        <input type="text" disabled name="file_url" value=""
                                            class="form-control disabled">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </td>
        </tr> --}}

    </div>
</div>

<script>
    var attributeCatalogue = @json(
        $attributeCatalogue->map(function ($item) {
                $name = $item->attribute_catalogue_language->first()->name;
                return [
                    'id' => $item->id,
                    'name' => $name,
                ];
            })->values());


    var attribute = '{{ base64_encode(json_encode(old('attribute', (isset($product->attribute) ? json_decode($product->attribute, TRUE) : [])))) }}'
    var variant = '{{ base64_encode(json_encode(old('variant', (isset($product->variant) ? json_decode($product->variant, TRUE) : [])))) }}'
</script>
