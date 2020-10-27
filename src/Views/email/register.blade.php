@extends('core::email._loader')

@section('content')
    <table role="presentation" border="0" cellpadding="0" cellspacing="0" class="body">
        <tr>
            <td>&nbsp;</td>
            <td class="container">
                <div class="content">
                    <span class="preheader">Chào <strong>{{$name}}</strong>, thư này gửi đến bạn để kích hoạt tài khoản {{$email}} trên hệ thống {{getConfig('name')}}!</span>
                    <table role="presentation" class="main">
                        <tr>
                            <td class="wrapper">
                                <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td>
                                            <p>Xin chào <strong>{{$name}}</strong></p>
                                            <p>Bạn đã đăng kí làm thành viên của website {{getConfig('name')}}.</p>
                                            <p>Vui lòng nhấn chuột vào link dưới đây để kích hoạt tài khoản</p>
                                            <table role="presentation" border="0" cellpadding="0" cellspacing="0" class="btn btn-primary">
                                                <tbody>
                                                <tr>
                                                    <td align="left">
                                                        <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                                                            <tbody>
                                                            <tr>
                                                                <td> <a href="{{route('auth.active' , ['token' => $token])}}" target="_blank">Kích hoạt tài khoản</a> </td>
                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                            <p>Nếu như liên kết trên không thể truy cập, vui lòng chọn lại đường link phía dưới đến địa chỉ trình duyệt:</p>
                                            <p>{{route('auth.active' , ['token' => $token])}}</p>
                                            <p>Thư kích hoạt có hiệu lực trong vòng 24h, bạn vui lòng kích hoạt tài khoản của mình.</p>
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

