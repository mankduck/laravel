<div class="ibox w">
    <div class="ibox-title">
        <h5>Chọn danh mục cha</h5>
    </div>
    <div class="ibox-content">
        <div class="row">
            <div class="col-lg-12">
                <div class="form-row">
                    <span class="text-danger notice">*Chọn Root nếu không có danh mục cha</span>
                    <select name="parent_id" class="form-control setupSelect2" id="">
                        <option value="0">Root</option>
                        <option value="1">Danh mục cha</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>
@include('backend.dashboard.component.publish', ['model' => $postCatalogue ?? null])
