<form action="{{ $__currentUrl }}" method="post" accept-charset="utf-8">
    {!! csrf_field() !!}
    <input type="hidden" class="form-control" id="id" name="id" value="{{$postData->id}}">
    <input type="hidden" class="form-control" id="type" name="type" value="page">
    <input type="hidden" class="form-control" id="parent_id" name="parent_id" value="0">
    <div class="form-group">
        <label for="title">Tên trang</label>
        <input type="text" class="form-control" id="title" name="title" placeholder="Tên trang tĩnh" value="{{$postData->title}}" required>
        <small class="form-text text-muted">{!! show_error('title') !!}</small>
    </div>
    <div class="form-group">
        <label for="description">Mô tả</label>
        <textarea class="form-control" id="description" name="description" rows="2" placeholder="Nội dung mô tả">{{$postData->description}}</textarea>
        <small class="form-text text-muted">{!! show_error('description') !!}</small>
    </div>
    <div class="form-group">
        <label for="photo">Ảnh đại diện</label>
        <div class="input-group" onclick="loadMedia('photo');">
            <input type="text" class="form-control" id="photo" name="photo" placeholder="Ảnh đại diện" readonly="readonly" value="{{$postData->photo}}">
            <div class="input-group-append">
                <button class="btn btn-primary m-l" type="button"><i class="icon-image"></i> Chọn ảnh</button>
            </div>
        </div>
        <small class="form-text text-muted">{!! show_error('photo') !!}</small>
    </div>
    <div class="form-group">
        <label for="content">Nội dung trang</label>
        <textarea class="form-control js-summernote" id="content" name="content" rows="10">{{$postData->content}}</textarea>
        <small class="form-text text-muted">{!! show_error('content') !!}</small>
    </div>
    <div class="form-group row">
        <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12">
            <button type="submit" class="btn btn-danger btn-lg"><i class="fa fa-save"></i> Cập nhật</button>
        </div>
    </div>
</form>