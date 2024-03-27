@csrf
@method('DELETE')
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-5">
            <div class="panel-head">
                <div class="panel-title">Thông tin chung</div>
                <div class="panel-description">
                    <p>Thông tin chung <span class="text-danger">{{ $model->name }}</span></p>
                    <p>Bạn đang muốn xóa ngôn ngữ có tên là:
                        Lưu ý: Không thể khôi phục dữ liệu sau khi xóa. Hãy chắc chắn bạn muốn thực hiện chức năng này
                    </p>
                </div>
            </div>
        </div>
        <div class="col-lg-7">
            <div class="ibox">
                <div class="ibox-content">
                    <div class="row mb15">
                        <div class="col-lg-12">
                            <div class="form-row">
                                <label for="" class="control-label text-left">Tiêu đề
                                    <span class="text-danger">(*)</span></label>
                                <input type="text" name="name" value="{{ old('name', $model->name ?? '') }}"
                                    class="form-control" placeholder="" autocomplete="off" readonly>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="text-right mb15">
        <button class="btn btn-danger" type="submit" name="send"
            value="send">Xóa dữ liệu</button>
    </div>
</div>
