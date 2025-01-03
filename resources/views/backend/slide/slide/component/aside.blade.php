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
                    <input type="text" name="name" value="{{ old('name', $slide->name ?? '') }}"
                        class="form-control" placeholder="" autocomplete="off">
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-row">
                    <label for="" class="control-label text-left">Từ khóa <span
                            class="text-danger">(*)</span></label>
                    <input type="text" name="keyword" value="{{ old('keyword', $slide->keyword ?? '') }}"
                        class="form-control" placeholder="" autocomplete="off">
                </div>
            </div>
        </div>
        <div class="row mb15">
            {{-- <div class="col-lg-6">
                <div class="setting-item mb20">
                    <div class="form-row">
                        <label for="" class="control-label text-left">Chiều rộng <span
                                class="text-danger">(*)</span></label>
                        <div class="setting-value">
                            <div class="input-group m-b">
                                <input type="text" name="setting[width]"
                                    value="{{ old('setting.width', $slide->setting['width'] ?? 0) }}"
                                    class="form-control int" placeholder="" autocomplete="off">
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
                                <input type="text" name="setting[height]"
                                    value="{{ old('setting.height', $slide->setting['height'] ?? 0) }}"
                                    class="form-control int">
                                <span class="input-group-addon">px</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}
            <div class="col-lg-12">
                <div class="setting-item mb20">
                    <div class="form-row">
                        <label for="" class="control-label text-left">Hiệu ứng <span
                                class="text-danger">(*)</span></label>
                        <div class="setting-value">

                            <select name="setting[animation]" class="form-control setupSelect2" id="">
                                @foreach (__('module.effect') as $key => $val)
                                    <option
                                        {{ $key == old('setting.animation', $slide->setting['animation'] ?? null) ? 'selected' : '' }}
                                        value="{{ $key }}">{{ $val }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="setting-item mb20">
                    <div class="form-row uk-flex uk-flex-space-between">
                        <label for="" class="control-label text-left">Mũi tên <span
                                class="text-danger">(*)</span></label>
                        <div class="setting-value">
                            <input type="checkbox" name="setting[arrow]" id="" value="accept"
                                @if (isset($slide->setting['arrow'])) checked = 'checked' @endif>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="setting-item">
                    <div class="form-row uk-flex uk-flex-space-between">
                        <label for="" class="control-label text-left">Điều hướng <span
                                class="text-danger">(*)</span></label>
                        <div class="setting-value">

                            @foreach (__('module.navigate') as $key => $val)
                                <div>
                                    <label>
                                        <input type="radio" value="{{ $key }}"
                                            id="navigate_{{ $key }}"
                                            {{ old('setting.navigate', $slide->setting['navigate'] ?? 'dots') === $key ? 'checked' : '' }}
                                            name="setting[navigate]">{{ $val }}
                                    </label>
                                </div>
                            @endforeach
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
                        <div class="uk-flex uk-flex-space-between">
                            <label for="" class="control-label text-left">Tự động chạy
                            </label>
                            <div class="setting-value">
                                <input type="checkbox" name="setting[autoplay]" value="accept" id=""
                                    @if (!old() || old('setting.autoplay', $slide->setting['autoplay'] ?? null) == 'accept') checked = 'checked' @endif>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 mb10">
                <div class="setting-item">
                    <div class="form-row">
                        <div class="uk-flex uk-flex-space-between">
                            <label for="" class="control-label text-left">Dừng khi di chuột
                            </label>
                            <div class="setting-value">
                                <input type="checkbox" name="setting[pausehover]" value="accept" id=""
                                    @if (!old() || old('setting.pausehover', $slide->setting['pausehover'] ?? null) == 'accept') checked = 'checked' @endif>
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
                                <input type="text" name="setting[animationdelay]"
                                    value="{{ old('setting.animationdelay', $slide->setting['animationdelay'] ?? 0) }}"
                                    class="form-control" placeholder="">
                                <span class="input-group-addon">ms</span>
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
                                <input type="text" name="setting[animationspeed]"
                                    value="{{ old('setting.animationspeed', $slide->setting['animationspeed'] ?? 0) }}"
                                    class="form-control" placeholder="">
                                <span class="input-group-addon">ms</span>
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
        <textarea name="short_code" class="form-control ck-editor" placeholder="" autocomplete="off" id="ckContent"
            data-height="200">{{ old('short_code', $slide->short_code ?? '') }}</textarea>
    </div>
</div>
