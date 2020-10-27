<form action="{{ $__currentUrl }}" method="post" accept-charset="utf-8">
    {!! csrf_field() !!}
    <div class="row gutters">
        @foreach($formData as $item)
        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
            <div class="form-group">
                <label for="{{$item->name}}">{{ucwords( str_replace('_', ' ' , $item->name))}}</label>
                <textarea class="form-control form-content js-summernote" id="{{$item->name}}" name="{{$item->name}}" rows="10">{!! $item->content !!}</textarea>
                <small class="form-text text-muted">{!! show_error($item->name) !!}</small>
            </div>
        </div>
        @endforeach
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="custom-btn-group" style="float: left;">
                <button type="submit" class="btn btn-warning btn-lg"><i class="icon-save"></i> Cập nhật</button>
            </div>
        </div>
    </div>
</form>
