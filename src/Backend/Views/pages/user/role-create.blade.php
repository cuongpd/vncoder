<div class="row">
    <div class="col-12">
        <form class="form-horizontal p-x-xs vncoder-form" action="" method="POST" autocomplete="off">
            {!! csrf_field() !!}
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label class="control-label">Tên quyền</label>
                    <input type="text" class="form-control" id="name" name="name">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label class="control-label">Mô tả</label>
                    <textarea type="text" class="form-control" id="description" name="description" required="required"></textarea>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-12">
                    <button class="btn btn-danger" type="submit"><i class="fa fa-send"></i> Cập nhật</button>
                </div>
            </div>
        </form>
    </div>
</div>