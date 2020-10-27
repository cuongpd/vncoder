<?php

namespace VnCoder\Helper;

class VnTube
{
    public static function getInfo($url)
    {
        $videoId = self::getVideoId($url);
        $data = [];
        $result = self::getJsonData($videoId);

        echo $result;
        die;
        return $data;
    }

    public static function getVideoId($url = '')
    {
        $videoID = '';
        if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match)) {
            $videoID   = $match[1];
        }
        return $videoID;
    }

    public static function getJsonData($videoId)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://m.youtube.com/watch?pbj=1&v=' . $videoId);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

        curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');

        $headers = [];
        $headers[] = 'Authority: m.youtube.com';
        $headers[] = 'X-Youtube-Sts: 18536';
        $headers[] = 'X-Youtube-Device: cbr=Safari+Mobile&cbrand=apple&cbrver=6.0.10A5376e&ceng=WebKit&cengver=536.26&cmodel=iphone&cos=iPhone&cosver=6_0&cplatform=MOBILE';
        $headers[] = 'X-Youtube-Page-Label: youtube.mobile.web.client_20200929_04_RC00';
        $headers[] = 'User-Agent: Mozilla/5.0 (iPhone; CPU iPhone OS 6_0 like Mac OS X) AppleWebKit/536.26 (KHTML, like Gecko) Version/6.0 Mobile/10A5376e Safari/8536.25';
//        $headers[] = 'X-Youtube-Variants-Checksum: 94fddeb62aa64315f673411dc55c1c20';
//        $headers[] = 'X-Youtube-Page-Cl: 334400611';
//        $headers[] = 'X-Spf-Referer: https://m.youtube.com/watch?v=eLKLn5FN70I';
//        $headers[] = 'X-Youtube-Utc-Offset: 420';
//        $headers[] = 'X-Youtube-Client-Name: 2';
//        $headers[] = 'X-Youtube-Client-Version: 2.20201002.02.01';
//        $headers[] = 'X-Youtube-Identity-Token: QUFFLUhqbUdPSTlERDlQTTEtX2gyeUwyN2xSUEFBejY5d3w=';
//        $headers[] = 'X-Youtube-Time-Zone: Asia/Saigon';
//        $headers[] = 'X-Youtube-Ad-Signals: dt=1601895761166&flash=0&frm&u_tz=420&u_his=6&u_java&u_h=812&u_w=375&u_ah=812&u_aw=375&u_cd=30&u_nplug&u_nmime&bc=31&bih=812&biw=375&brdim=0%2C0%2C0%2C0%2C375%2C0%2C375%2C812%2C375%2C812&vis=1&wgl=true&ca_type=image';
        $headers[] = 'Accept: */*';
//        $headers[] = 'X-Client-Data: CIm2yQEIprbJAQjBtskBCKmdygEIhrXKAQiZtcoBCKvHygEI9cfKAQjnyMoBCOnIygEIwdfKARjywMoB';
        $headers[] = 'Sec-Fetch-Site: same-origin';
        $headers[] = 'Sec-Fetch-Mode: cors';
        $headers[] = 'Sec-Fetch-Dest: empty';
        $headers[] = 'Referer: https://m.youtube.com/watch?v=eLKLn5FN70I';
        $headers[] = 'Accept-Language: en-US,en;q=0.9';
//        $headers[] = 'Cookie: VISITOR_INFO1_LIVE=6J1mDX1xA1I; PREF=f4=4000000; HSID=AI0WtdYbrYWWYVe9A; SSID=AW_f2s0yfe52vffc1; APISID=9HaNui5ADYKG-KHQ/ARUItVlB1Nckt6oA5; SAPISID=0h_47QjtGppy7Vim/A2e3AoyvzC-pQPkEQ; __Secure-3PAPISID=0h_47QjtGppy7Vim/A2e3AoyvzC-pQPkEQ; CONSENT=YES+VN.vi+; LOGIN_INFO=AFmmF2swRgIhAJNBBtN4iJ2-1R_SU_Fnitb9LnaPL1Ges2ygqJKheGQ_AiEAvlKaCfre19cFG3pweRLjn1KSDDG17eplxWNd_YxKwGw:QUQ3MjNmd3oxSkhrUjFwRHhBTHA5QV81MzZNaTR1TERmMGczdFIzMVRJTEJuTkI5MnQ0ZXFETm96RmV3LVRlM0NBbzNoT3RDeGZDeXJJM2V0djlYVWU3S1JtX29KYWVJVDY0OUZnNUN6T2hlUEVXS291eTdJQUZrWGk3ekt2dUtfcTd3T3YxME01Zk9fcjZBM2lrQkNHMEdkUXVOWS1wSkZqTUxrRjQ0Mm9QRTgtd0FzTVp2Rjg4bzdacUVFZ2llM1VjMEZ5TGF5eWkx; YSC=5HJtFyVZ84A; SID=2AcZweNFWCgbtR5RKQzAwOcN3mB70Fhf0qCigTrbOxHoPheXiJacJnZzwhdOUWi3kGWOHw.; __Secure-3PSID=2AcZweNFWCgbtR5RKQzAwOcN3mB70Fhf0qCigTrbOxHoPheXtDJoMOtA-WrYVKfD87ukYw.; SIDCC=AJi4QfGfwKPK3yEFBQNlv8_VqJ95zTzbSFaZYTAEH2jsBuBAOmqb1_YwL2fydcKHssIqdr3uyA; __Secure-3PSIDCC=AJi4QfHjibYS4eHin3aFKYTSZqTZ5ox4XhB5Sd8XfV_DB_pBjOj4cp7BlLjSgMPtDdBr7bLgZA; ST-10nagw5=itct=CB4QpDAYAiITCPCbuN6mnewCFQolKgodgs0EmjIHcmVsYXRlZEjC3reK-fOi2XiaAQUIARD4HQ%3D%3D';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            info('Error:' . curl_error($ch));
        }
        curl_close($ch);
        return $result;
    }
}
