@extends('core::email._loader')

@section('content')
    <table role="presentation" border="0" cellpadding="0" cellspacing="0" class="body">
        <tr>
            <td>&nbsp;</td>
            <td class="container">
                <div class="content">
                    <table role="presentation" class="main">
                        <tr>
                            <td class="wrapper">
                                <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td>
                                            <p>Xin chào <strong>{{$email}}</strong></p>
                                            <p>Bạn đã kích hoạt tính năng khôi phục mật khẩu cho tài khoản trên hệ thống {{getConfig('name')}}.</p>
                                            <p>Mật khẩu của bạn đã được đổi lại. Vui lòng đăng nhập lại hệ thống với thông tin mới như sau:</p>
                                            <p>Tên đăng nhập : <b>{{$email}}</b></p>
                                            <p>Mật khẩu đăng nhập : <b>{{$password}}</b></p>
                                            <p>Bạn vui lòng truy cập : {{route('auth.login')}} để đăng nhập bạn nhé</p>
                                            <p>Cảm ơn bạn đã sử dụng.</p>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                    <div class="footer">
                        <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                            <tr>
                                <td class="content-block">
                                    <span class="apple-link"><b>{{getConfig('name')}}</b> {{getConfig('address')}}</span>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </td>
            <td>&nbsp;</td>
        </tr>
    </table>
@endsection

