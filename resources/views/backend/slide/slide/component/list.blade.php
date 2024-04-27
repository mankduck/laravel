<div class="ibox">
    <div class="ibox-title">
        <div class="uk-flex uk-flex-middle uk-flex-space-between">
            <h5>Danh sách slides</h5>
            <button type="button" class="addSlide btn btn-primary">Thêm Slide</button>
        </div>
    </div>

    @php
        $slides = old('slide', ($slides) ?? null);
    @endphp

    <div class="ibox-content">
        <div id="sortable" class="row slide-list sortui ui-sortable">
            <div class="text-danger slide-notification">
                Chưa có hình ảnh nào được chọn...
            </div>
            @if (count($slides))
                @foreach ($slides['image'] as $key => $val)
                @php
                    $image = $val;
                    $description = $slides['description'][$key];
                    $canonical = $slides['canonical'][$key];
                    $name = $slides['name'][$key]
                    $alt = $slides['alt'][$key]

                @endphp
                    <div class="col-lg-12 ui-state-default">
                        <div class="slide-item mb20">
                            <div class="row">
                                <div class="col-lg-3">
                                    <span class="silde-image img-cover">
                                        <img src="{{ $val }}" alt="">
                                        <input type="hidden" name="slide[image][]" value="{{ $val }}">
                                        <button type="button" class="delete-slide"><i class="fa fa-trash"></i></button>
                                    </span>
                                </div>
                                <div class="col-lg-9">
                                    <div class="tabs-container">
                                        <ul class="nav nav-tabs">
                                            <li class="active"><a data-toggle="tab" href="#{{$key}}">Thông tin
                                                    chung</a></li>
                                            <li class=""><a data-toggle="tab" href="#{{$key + 1}}">SEO</a>
                                            </li>
                                        </ul>
                                        <div class="tab-content">
                                            <div id="{{$key}}" class="tab-pane active">
                                                <div class="panel-body">
                                                    <div class="label-text mb10">Mô tả</div>
                                                    <div class="form-row mb10">
                                                        <textarea name="slide[description][]" class="form-control" placeholder="">{{$description}}</textarea>
                                                    </div>
                                                    <div class="form-row form-row-url">
                                                        <input type="text" name="slide[canonical][]" class="form-control"
                                                            placeholder="URL" value="{{$canonical}}" id="">
                                                        <div class="overlay">
                                                            <div class="uk-flex uk-flex-middle">
                                                                <label for="input_{{$key}}">Mở trong tab mới</label>
                                                                <input type="checkbox" name="slide[window][]"
                                                                    id="input_{{$key}}" value="_blank" {{old('slide.window') == '_blank' ? 'checked' : ''}}>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="{{$key + 1}}" class="tab-pane">
                                                <div class="panel-body">
                                                    <div class="label-text mb10">Tiêu đề</div>
                                                    <div class="form-row form-row-url slide-seo-tab mb10">
                                                        <input type="text" name="slide[name][]" class="form-control"
                                                            placeholder="URL" value="{{$name}}" id="">
                                                    </div>

                                                    <div class="label-text mb10">Mô tả </div>
                                                    <div class="form-row form-row-url slide-seo-tab">
                                                        <input type="text" value="{{$alt}}" name="slide[alt][]" class="form-control"
                                                            placeholder="URL" value="" id="">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                    </div>
                @endforeach
            @endif

        </div>
    </div>
</div>
