<form action="{{route('auth.register')}}" class="js-validation-signup px-30" method="post" id="register-form">
    {!! csrf_field() !!}
    <div class="form-group row">
        <div class="col-12">
            <div class="form-material floating">
                <input type="text" class="form-control" id="signup-username" name="name" required>
                <label for="signup-username">Họ và tên</label>
                <small class="form-text text-muted">{!! show_error('name') !!}</small>
            </div>
        </div>
    </div>
    <div class="form-group row">
        <div class="col-12">
            <div class="form-material floating">
                <input type="email" class="form-control" id="signup-email" name="email" required>
                <label for="signup-email">Email</label>
                <small class="form-text text-muted">{!! show_error('email') !!}</small>
            </div>
        </div>
    </div>
    <div class="form-group row">
        <div class="col-12">
            <div class="form-material floating">
                <input type="password" class="form-control" id="signup-password" name="password" required>
                <label for="signup-password">Password</label>
                <small class="form-text text-muted">{!! show_error('password') !!}</small>
            </div>
        </div>
    </div>
    <div class="form-group row">
        <div class="col-12">
            <div class="form-material floating">
                <input type="password" class="form-control" id="signup-password-confirm" name="password_confirmation">
                <label for="signup-password-confirm">Password Confirmation</label>
            </div>
        </div>
    </div>
    <div class="form-group row">
        <div class="col-12">
            <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" id="signup-terms" name="signup-terms" readonly="readonly" checked="checked">
                <label class="custom-control-label" for="signup-terms">I agree to Terms &amp; Conditions</label>
            </div>
        </div>
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-sm btn-hero btn-alt-primary">
            <i class="si si-plus mr-10"></i> Đăng kí tài khoản
        </button>
        <div class="mt-30">
            <a class="link-effect text-muted mr-10 mb-5 d-inline-block" href="#" data-toggle="modal" data-target="#modal-terms">
                <i class="fa fa-book text-muted mr-5"></i> Điều khoản chính sách
            </a>
            <a class="link-effect text-muted mr-10 mb-5 d-inline-block pull-right" href="{{route('auth.login')}}">
                <i class="fa fa-user mr-5"></i> Đăng nhập vào website
            </a>
        </div>
    </div>
    <div class="fxt-style-line">
        <div class="fxt-transformY-50 fxt-transition-delay-5">
            <h5>Hoặc đăng kí nhanh qua</h5>
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


@push('footer')
    <div class="modal fade" id="modal-terms" tabindex="-1" role="dialog" aria-labelledby="modal-terms" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-slidedown" role="document">
            <div class="modal-content">
                <div class="block block-themed block-transparent mb-0">
                    <div class="block-header bg-primary-dark">
                        <h3 class="block-title">Terms &amp; Conditions</h3>
                        <div class="block-options">
                            <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                                <i class="si si-close"></i>
                            </button>
                        </div>
                    </div>
                    <div class="block-content">
                        {!! getConfig('privacy') !!}
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-alt-success" data-dismiss="modal">
                        <i class="fa fa-check"></i> Đồng ý
                    </button>
                </div>
            </div>
        </div>
    </div>
@endpush

{{--

<div class="fxt-form">
    <form action="{{route('auth.register.submit')}}" class="panel-body" method="post" id="register-form">
        {!! csrf_field() !!}
        <div class="form-group">
            <div class="fxt-transformY-50 fxt-transition-delay-1">
                <input class="form-control" type="text" id="inputName" name="name" required="" placeholder="Họ và tên" value="">
                <small class="form-text text-muted">{!! show_error('name') !!}</small>
            </div>
        </div>
        <div class="form-group">
            <div class="fxt-transformY-50 fxt-transition-delay-1">
                <input class="form-control" type="email" id="inputEmail" name="email" required="" placeholder="Địa chỉ Email đăng nhập" value="">
                <small class="form-text text-muted">{!! show_error('email') !!}</small>
            </div>
        </div>
        <div class="form-group">
            <div class="fxt-transformY-50 fxt-transition-delay-2">
                <div class="form-row">
                    <div class="col">
                        <input class="form-control" type="password" required="" name="password" id="inputPassword" placeholder="Mật khẩu" value="">
                    </div>
                    <div class="col">
                        <input class="form-control" type="password" required="" name="password_confirmation" id="inputRePassword" placeholder="Nhập lại mật khẩu" value="">
                    </div>
                </div>
                <small class="form-text text-muted">{!! show_error('password') !!}</small>
            </div>
        </div>
        <div class="form-group">
            <div class="fxt-transformY-50 fxt-transition-delay-3">
                <div class="fxt-checkbox-area">
                    <div class="checkbox">
                        <input id="checkbox-signup" type="checkbox" name="vncoder" checked="checked" readonly>
                        <label class="custom-control-label" for="checkbox-signup">Tôi đã đọc và đồng ý với các <a href="javascript:void(0);" data-toggle="modal" data-target="#privacy_policy" class="text-dark">điều khoản và chính sách</a> của hệ thống</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="fxt-transformY-50 fxt-transition-delay-4">
                <button type="submit" id="btn-submit" class="fxt-btn-fill btn-success">Submit</button>
            </div>
        </div>
    </form>
</div>
<div class="fxt-style-line">
    <div class="fxt-transformY-50 fxt-transition-delay-5">
        <h3>Hoặc đăng kí nhanh qua</h3>
    </div>
</div>
<ul class="fxt-socials">
    <li class="fxt-google">
        <div class="fxt-transformY-50 fxt-transition-delay-6">
            <a href="{{route('auth.provider', ['provider' => 'google'])}}" title="Đăng nhập nhanh qua Google"><i class="icon-google"></i><span>Google +</span></a>
        </div>
    </li>
    <li class="fxt-facebook"><div class="fxt-transformY-50 fxt-transition-delay-8">
            <a href="{{route('auth.provider', ['provider' => 'facebook'])}}" title="Đăng nhập nhanh qua Facebook"><i class="icon-facebook1"></i><span>Facebook</span></a>
        </div>
    </li>
</ul>
<div class="fxt-footer">
    <div class="fxt-transformY-50 fxt-transition-delay-9">
        <p>Bạn đã có tài khoản? <a href="{{route('auth.login')}}" class="switcher-text2">Đăng nhập tại đây</a></p>
    </div>
</div>


--}}