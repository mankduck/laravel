<div id="createMenuCatalogue" class="modal fade">
    <form action="" class="form create-menu-catalogue" method="">

        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">x</span><span
                            class="sr-only">Close</span></button>
                    <h4 class="modal-title">Thêm mới vị trí hiển thị menu</h4>
                    <small class="font-bold">Nhập thông tin...</small>
                </div>
                <div class="modal-body">
                    <div class="error form-error">
                    </div>
                    <div class="row">
                        <div class="col-lg-12 mb10">
                            <label for="">Tên vị trí hiển thị</label>
                            <input type="text" class="form-control" value="" name="name">
                            <span class="text-danger font-italic error name"></span>
                        </div>
                        <div class="col-lg-12 mb10">
                            <label for="">Từ khóa hiển thị</label>
                            <input type="text" class="form-control" value="" name="keyword">
                            <span class="text-danger font-italic error keyword"></span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                    <button type="submit" name="create" value="create" class="btn btn-primary">Lưu lại</button>
                </div>
            </div>
        </div>
    </form>
</div>
