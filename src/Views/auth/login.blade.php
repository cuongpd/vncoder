<form action="{{route('auth.login')}}" class="js-validation-signin px-30" method="post">
    {!! csrf_field() !!}
    <div class="form-group row">
        <div class="col-12">
            <div class="form-material floating">
                <input type="text" class="form-control" id="login-username" name="email" value="" required>
                <label for="login-username">Email</label>
            </div>
        </div>
    </div>
    <div class="form-group row">
        <div class="col-12">
            <div class="form-material floating">
                <input type="password" class="form-control" id="login-password" name="password" required>
                <label for="login-password">Password</label>
            </div>
        </div>
    </div>
    <div class="form-group row">
        <div class="col-12">
            <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" id="login-remember-me" name="login-remember-me">
                <label class="custom-control-label" for="login-remember-me">Remember Me</label>
            </div>
        </div>
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-sm btn-hero btn-alt-primary">
            <i class="si si-login mr-10"></i> Đăng nhập
        </button>
        <div class="mt-30">
            <a class="link-effect text-muted mr-10 mb-5 d-inline-block" href="{{route('auth.register')}}">
                <i class="fa fa-plus mr-5"></i> Tạo tài khoản mới
            </a>
            <a class="link-effect text-muted mr-10 mb-5 d-inline-block" href="{{route('auth.reset')}}">
                <i class="fa fa-warning mr-5"></i> Quên mật khẩu
            </a>
        </div>
    </div>
    <div class="fxt-style-line">
        <div class="fxt-transformY-50 fxt-transition-delay-5">
            <h5>Hoặc đăng nhập nhanh qua</h5>
        </div>
    </div>
    <div class="mb-10">
        <a href="{{route('auth.provider', ['provider' => 'google'])}}" title="Đăng nhập nhanh qua Google">
            <button type="button" class="btn btn-sm btn-hero btn-alt-success pr-3"><i class="fa fa-google-plus mr-5"></i> Google +</span></button>
        </a>
        <a href="{{route('auth.provider', ['provider' => 'facebook'])}}" title="Đăng nhập nhanh qua Facebook">
            <button type="button" class="btn btn-sm btn-hero btn-alt-primary"><i class="fa fa-facebook-official mr-5"></i> Facebook</span></button>
        </a>
    </div>
</form>