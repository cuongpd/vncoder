<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="x-apple-disable-message-reformatting">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Email Template</title>
    <base href="{{url('/')}}">
    <style type="text/css">
        a { text-decoration: none; outline: none; }
        @media (max-width: 649px) {
            .o_col-full { max-width: 100% !important; }
            .o_col-half { max-width: 50% !important; }
            .o_hide-lg { display: inline-block !important; font-size: inherit !important; max-height: none !important; line-height: inherit !important; overflow: visible !important; width: auto !important; visibility: visible !important; }
            .o_hide-xs, .o_hide-xs.o_col_i { display: none !important; font-size: 0 !important; max-height: 0 !important; width: 0 !important; line-height: 0 !important; overflow: hidden !important; visibility: hidden !important; height: 0 !important; }
            .o_xs-center { text-align: center !important; }
            .o_xs-left { text-align: left !important; }
            .o_xs-right { text-align: left !important; }
            table.o_xs-left { margin-left: 0 !important; margin-right: auto !important; float: none !important; }
            table.o_xs-right { margin-left: auto !important; margin-right: 0 !important; float: none !important; }
            table.o_xs-center { margin-left: auto !important; margin-right: auto !important; float: none !important; }
            h1.o_heading { font-size: 32px !important; line-height: 41px !important; }
            h2.o_heading { font-size: 26px !important; line-height: 37px !important; }
            h3.o_heading { font-size: 20px !important; line-height: 30px !important; }
            .o_xs-py-md { padding-top: 24px !important; padding-bottom: 24px !important; }
            .o_xs-pt-xs { padding-top: 8px !important; }
            .o_xs-pb-xs { padding-bottom: 8px !important; }
        }
    </style>
    <!--[if mso]>
    <style>
        table { border-collapse: collapse; }
        .o_col { float: left; }
    </style>
    <xml>
        <o:OfficeDocumentSettings>
            <o:PixelsPerInch>96</o:PixelsPerInch>
        </o:OfficeDocumentSettings>
    </xml>
    <![endif]-->
</head>
<body class="o_body o_bg-white" style="width: 100%;margin: 0px;padding: 0px;-webkit-text-size-adjust: 100%;-ms-text-size-adjust: 100%;background-color: #ffffff;">
<table width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation">
    <tbody>
    <tr>
        <td class="o_hide" align="center" style="display: none;font-size: 0;max-height: 0;width: 0;line-height: 0;overflow: hidden;mso-hide: all;visibility: hidden;">Email Summary (Hidden)</td>
    </tr>
    </tbody>
</table>
<table width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation">
    <tbody>
    <tr>
        <td class="o_bg-primary o_px-md o_py-md o_sans o_text" align="center" style="font-family: Helvetica, Arial, sans-serif;margin-top: 0px;margin-bottom: 0px;font-size: 16px;line-height: 24px;background-color: #126de5;padding-left: 24px;padding-right: 24px;padding-top: 24px;padding-bottom: 24px;">
            <p style="margin-top: 0px;margin-bottom: 0px;"><a class="o_text-white" href="{{url('/')}}" style="text-decoration: none;outline: none;color: #ffffff;"><img src="{{getConfig('logo')}}" width="136" height="36" alt="{{getConfig('name')}}" style="max-width: 136px;-ms-interpolation-mode: bicubic;vertical-align: middle;border: 0;line-height: 100%;height: auto;outline: none;text-decoration: none;"></a></p>
        </td>
    </tr>
    </tbody>
</table>

@yield('content')

<table width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation">
    <tbody>
    <tr>
        <td class="o_bg-white" style="font-size: 48px;line-height: 48px;height: 48px;background-color: #ffffff;">&nbsp; </td>
    </tr>
    </tbody>
</table>

<table width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation">
    <tbody>
    <tr>
        <td class="o_bg-light o_px o_pb-lg" align="center" style="background-color: #dbe5ea;padding-left: 16px;padding-right: 16px;padding-bottom: 32px;">
            <!--[if mso]><table cellspacing="0" cellpadding="0" border="0" role="presentation"><tbody><tr><td width="200" align="left" valign="top" style="padding:0px 8px;"><![endif]-->
            <div class="o_col o_col-4" style="display: inline-block;vertical-align: top;width: 100%;max-width: 400px;">
                <div style="font-size: 32px; line-height: 32px; height: 32px;">&nbsp; </div>
                <div class="o_px-xs o_sans o_text-xs o_text-light o_left o_xs-center" style="font-family: Helvetica, Arial, sans-serif;margin-top: 0px;margin-bottom: 0px;font-size: 14px;line-height: 21px;color: #82899a;text-align: left;padding-left: 8px;padding-right: 8px;">
                    <p class="o_mb-xs" style="margin-top: 0px;margin-bottom: 8px;">Địa chỉ: {{getConfig('address')}}</p>
                </div>
            </div>
            <!--[if mso]></td><td width="400" align="right" valign="top" style="padding:0px 8px;"><![endif]-->
            <div class="o_col o_col-4" style="display: inline-block;vertical-align: top;width: 100%;max-width:400px;">
                <div style="font-size: 32px; line-height: 32px; height: 32px;">&nbsp; </div>
                <div class="o_px-xs o_sans o_text-xs o_text-light o_right o_xs-center" style="font-family: Helvetica, Arial, sans-serif;margin-top: 0px;margin-bottom: 0px;font-size: 14px;line-height: 21px;color: #82899a;text-align: right;padding-left: 8px;padding-right: 8px;">
                    <p class="o_mb-xs" style="margin-top: 0px;margin-bottom: 8px;">{{getConfig('copyright')}}</p>
                </div>
            </div>
            <!--[if mso]></td></tr></table><![endif]-->
            <div class="o_hide-xs" style="font-size: 64px; line-height: 64px; height: 64px;">&nbsp; </div>
        </td>
    </tr>
    </tbody>
</table>
</body>
</html>
