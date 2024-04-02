<div class="ibox w">
    <div class="ibox-title">
        <h5>Chọn danh mục cha</h5>
    </div>
    <div class="ibox-content">
        <div class="row mb15">
            <div class="col-lg-12">
                <div class="form-row">
                    <select name="post_catalogue_id" class="form-control setupSelect2" id="">
                        @foreach ($dropdown as $key => $val)
                            <option
                                {{ $key == old('post_catalogue_id', isset($post->post_catalogue_id) ? $post->post_catalogue_id : '') ? 'selected' : '' }}
                                value="{{ $key }}">{{ $val }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        @php
            $catalogue = [];
            if (isset($post)) {
                foreach ($post->post_catalogues as $key => $val) {
                    $catalogue[] = $val->id;
                }
            }
        @endphp
        <div class="row">
            <div class="col-lg-12">
                <div class="form-row">
                    <label class="control-label">Chọn danh mục phụ (nếu có)</label>
                    <select multiple name="catalogue[]" class="form-control setupSelect2" id="">
                        @foreach ($dropdown as $key => $val)
                            <option @if (is_array(old('catalogue', isset($post->catalogue) ? $post->catalogue : [])) &&
                                    in_array($key, old('catalogue', isset($post->catalogue) ? $post->catalogue : []))) selected @endif value="{{ $key }}">
                                {{ $val }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>
@include('backend.dashboard.component.publish', ['model' => $post ?? null])
