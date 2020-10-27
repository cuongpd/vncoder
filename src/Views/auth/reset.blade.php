<form action="{{route('auth.reset')}}" class="js-validation-signin px-30" method="post">
    {!! csrf_field() !!}
    <div class="form-group row">
        <div class="col-12">
            <div class="form-material floating">
                <input type="email" class="form-control" id="signup-email" name="email" required>
                <label for="signup-email">Email</label>
                <small class="form-text text-muted">{!! show_error('email') !!}</small>
            </div>
        </div>
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-sm btn-hero btn-alt-primary">
            <i class="si si-login mr-10"></i> Khôi phục mật khẩu
        </button>
        <div class="mt-30">
            <a class="link-effect text-muted mr-10 mb-5 d-inline-block" href="{{route('auth.login')}}">
                <i class="fa fa-plus mr-5"></i> Quay lại trang đăng nhập
            </a>
        </div>
    </div>
</form>