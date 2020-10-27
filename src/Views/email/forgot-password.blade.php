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
                                            <p>Bạn đang kích hoạt tính năng khôi phục mật khẩu cho tài khoản trên hệ thống {{getConfig('name')}}.</p>
                                            <p>Vui lòng nhấn chuột vào link dưới đây để đổi mật khẩu cho tài khoản</p>
                                            <table role="presentation" border="0" cellpadding="0" cellspacing="0" class="btn btn-primary">
                                                <tbody>
                                                <tr>
                                                    <td align="left">
                                                        <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                                                            <tbody>
                                                            <tr>
                                                                <td> <a href="{{route('auth.request' , ['token' => $token])}}" target="_blank">Reset mật khẩu</a> </td>
                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                            <p>Nếu như liên kết trên không thể truy cập, vui lòng chọn lại đường link phía dưới đến địa chỉ trình duyệt:</p>
                                            <p>{{route('auth.request' , ['token' => $token])}}</p>
                                            <p>Cảm ơn.</p>
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

