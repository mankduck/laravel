<form action="{{ route('user.index') }}">
    <div class="filter-wrapper">
        <div class="row">
            <div class="col-lg-2">
                @php
                    $perpage = request('perpage') ?: old('perpage');
                @endphp
                <div class="uk-flex uk-flex-middle uk-flex-space-between">
                    <select name="perpage" class="form-control input-sm perpage filter mr10">
                        @for ($i = 20; $i <= 200; $i += 20)
                            <option {{ $perpage == $i ? 'selected' : '' }} value="{{ $i }}">
                                {{ $i }} bản ghi</option>
                        @endfor
                    </select>
                </div>
            </div>
            <div class="action col-lg-2">
                @php
                    $publish = request('publish') ?: old('publish');
                @endphp
                <select name="publish" class="form-control setupSelect2 ml10">
                    @foreach (config('apps.general.publish') as $key => $val)
                        <option {{ $publish == $key ? 'selected' : '' }} value="{{ $key }}">
                            {{ $val }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-lg-3">
                <select name="user_catalogue_id" class="form-control mr10 setupSelect2">
                    <option value="0" selected="selected">Chọn Nhóm Thành Viên</option>
                    <option value="1">Quản trị viên</option>
                </select>
            </div>
            <div class="col-lg-3">
                <div class="input-group">
                    <input type="text" name="keyword" value="{{ request('keyword') ?: old('keyword') }}"
                        placeholder="Nhập từ khóa tìm kiếm..." class="form-control">
                    <span class="input-group-btn">
                        <button type="submit" name="search" value="search" class="btn btn-primary">Tìm
                            Kiếm
                        </button>
                    </span>
                </div>
            </div>
            <div class="col-lg-2">
                <a href="" class="btn btn-danger"><i class="fa fa-plus mr5"></i>Thêm mới</a>

            </div>
        </div>
    </div>
</form>
