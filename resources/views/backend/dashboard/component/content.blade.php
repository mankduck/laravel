<div class="row mb15">
    <div class="col-lg-12">
        <div class="form-row">
            <label for="" class="control-label text-left">Thêm mới nhóm bài viết<span class="text-danger">(*)</span></label>
            <input 
                type="text"
                name="name"
                value="{{ old('name', ($model->name) ?? '' ) }}"
                class="form-control"
                placeholder=""
                autocomplete="off"
                {{ (isset($disabled)) ? 'disabled' : '' }}
            >
        </div>
    </div>
</div>
<div class="row mb30">
    <div class="col-lg-12">
        <div class="form-row">
            <label for="" class="control-label text-left">Mô tả ngắn </label>
            <textarea 
                name="description" 
                class="ck-editor" 
                id="ckDescription"
                {{ (isset($disabled)) ? 'disabled' : '' }} 
                data-height="100">{{ old('description', ($model->description) ?? '') }}</textarea>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="form-row">
            <div class="uk-flex uk-flex-middle uk-flex-space-between">
                <label for="" class="control-label text-left">Nội dung </label>
                <a href="" class="multipleUploadImageCkeditor" data-target="ckContent">Upload hình ảnh</a>
            </div>
            <textarea
                name="content"
                class="form-control ck-editor"
                placeholder=""
                autocomplete="off"
                id="ckContent"
                data-height="500"
                {{ (isset($disabled)) ? 'disabled' : '' }}
            >{{ old('content', ($model->content) ?? '' ) }}</textarea>
        </div>
    </div>
</div>