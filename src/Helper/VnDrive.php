<?php

namespace VnCoder\Helper;

class VnDrive
{
    public static function start($driveUrl = 'https://drive.google.com/file/d/1nqgGJr2v1V_s3UcaPg4gK4fGgKHWC8O4/view')
    {
        $driveId = self::getDriveId($driveUrl);
        if ($driveId) {
            return self::getDriveInfo($driveId);
        }
        return false;
    }

    public static function getDriveInfo($gid)
    {
        if (!$gid) {
            return false;
        }
        $data = [];
        /*
         * https://mail.google.com/e/get_video_info

https://drive.google.com/e/get_video_info

https://docs.google.com/e/get_video_info
         */
        $driveInfoUrl = 'https://drive.google.com/e/get_video_info?docid=' . $gid;
        $driveInfoUrl = 'https://mail.google.com/e/get_video_info?docid=' . $gid;
        $driveInfoUrl = 'https://docs.google.com/e/get_video_info?docid=' . $gid;
        $query = self::getContent($driveInfoUrl, true);
        if ($query) {
            $p = $query['source'];
            $stream = $query['cookie']['DRIVE_STREAM'] ?? '';
            $p = urldecode(explode("&", explode("&fmt_stream_map=", $p)[1])[0]);
            $p = explode(",", $p);
            foreach ($p as $w) {
                @list($vkey, $vurl) = explode("|", $w);
                if ($vurl) {
//                    $curl = curl_init();
//                    curl_setopt_array($curl, array(
//                        CURLOPT_URL => $vurl,
//                        CURLOPT_HEADER => true,
//                        CURLOPT_CONNECTTIMEOUT => 0,
//                        CURLOPT_TIMEOUT => 1000,
//                        CURLOPT_FRESH_CONNECT => true,
//                        CURLOPT_SSL_VERIFYPEER => 0,
//                        CURLOPT_NOBODY => true,
//                        CURLOPT_VERBOSE => 1,
//                        CURLOPT_RETURNTRANSFER => true,
//                        CURLOPT_FOLLOWLOCATION => true,
//                        CURLOPT_HTTPHEADER => array(
//                            'Connection: keep-alive',
//                            'Cookie: DRIVE_STREAM=' . $stream
//                        )
//                    ));
//                    curl_exec($curl);
//                    $content_length = curl_getinfo($curl, CURLINFO_CONTENT_LENGTH_DOWNLOAD);
//                    curl_close($curl);
                    $iTag = self::getITag($vkey);
//                    $vurl = preg_replace("/\/[^\/]+\.google\.com/","/redirector.googlevideo.com",$vurl);


                    // redirect by zdn
                    $vurl = 'https://link.photo.talk.zdn.vn/photolinkv2/' . $iTag . '/' . base64_encode($vurl);

                    $data['video'][] = [
                        'file' => $vurl,
                        'label' => $iTag . 'p'
                    ];

//                    $data['video'][$iTag]['url'] = $vurl;
//                    $data['video'][$iTag]['length'] = $content_length;
                    //$data['videos'][$iTag] = route('g-drive') . '?source=' . encrypt($vurl) . '&stream=' . $stream . '&length=' . $content_length;
                }
            }
            $data['cookie'] = $stream;
            $data['title'] =  pathinfo(urldecode(explode("&", explode("&title=", $query["source"])[1])[0]), PATHINFO_FILENAME);
        }
        return $data;
    }

    public static function getDriveId($url)
    {
        $videoID = '';
        if (preg_match('/(?:https?:\/\/)?(?:[\w\-]+\.)*(?:drive|docs)\.google\.com\/(?:(?:folderview|open|uc)\?(?:[\w\-\%]+=[\w\-\%]*&)*id=|(?:folder|file|document|presentation)\/d\/|spreadsheet\/ccc\?(?:[\w\-\%]+=[\w\-\%]*&)*key=)([\w\-]{28,})/i', $url, $match)) {
            $videoID = $match[1];
        }
        // Check if File ID have 33 Length (Google Drive ID)
        return strlen($videoID) == 33 ? $videoID : '';
    }

    private static function setCookieHeader($cookies)
    {
        $headers = !empty($cookies) ? ['Cookie: ' . $cookies] : [];
        if (isset($_SERVER['HTTP_RANGE'])) {
            $headers[] = 'Range: ' . $_SERVER['HTTP_RANGE'];
        }
        return $headers;
    }

    private static function getContent($url, $getCookie = false)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, $getCookie);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 15);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
        $result = curl_exec($ch);
        $cookie = [];
        $info = curl_getinfo($ch);
        if ($getCookie === true) {
            $header = substr($result, 0, $info['header_size']);
            $result = substr($result, $info['header_size']);
            preg_match_all('/^Set-Cookie:\\s*([^=]+)=([^;]+)/mi', $header, $cookieData);
            if ($cookieData && isset($cookieData[1])) {
                foreach ($cookieData[1] as $i => $val) {
                    $cookie[$val] = trim($cookieData[2][$i], ' ' . "\n\r\t" . '' . "\0" . '' . "\xb");
                }
            }
        }
        return  ['cookie' => $cookie , 'source' => $result];
    }

    private static function getITag($id)
    {
        $vcode = [18 => '360', 22 => '720', 37 => '1080', 59 => '480', 133 => '240', 138 => '4320', 160 => '144'];
        return $vcode[$id] ?? '360p';
    }

    public static function play($source, $cooke_stream, $content_length)
    {
        $url = decrypt($source);
        if (!$url) {
            return false;
        }

        $headers = array(
            'Connection: keep-alive',
            'Cookie: DRIVE_STREAM=' . $cooke_stream
        );

        if (isset($_SERVER['HTTP_RANGE'])) {
            preg_match('/bytes=(\d+)-(\d+)?/', $_SERVER['HTTP_RANGE'], $range);
            $initial = intval($range[1]);
            $final = $content_length - $initial - 1;
            array_push($headers, 'Range: bytes=' . $initial . '-' . ($initial + $final));
            header('HTTP/1.1 206 Partial Content');
            header('Accept-Ranges: bytes');
            header('Content-Range: bytes ' . $initial . '-' . ($initial + $final) . '/' . $content_length);
        } else {
            header('Accept-Ranges: bytes');
        }

        $ch = curl_init();
        curl_setopt_array($ch, array(
            CURLOPT_URL => $url,
            CURLOPT_CONNECTTIMEOUT => 0,
            CURLOPT_TIMEOUT => 1000,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_FRESH_CONNECT => true,
            CURLOPT_HTTPHEADER => $headers
        ));

        curl_setopt($ch, CURLOPT_WRITEFUNCTION, function ($curl, $body) {
            echo $body;
            return strlen($body);
        });
        header('Content-Type: video/mp4');
        header('Content-length: ' . $content_length);
        curl_exec($ch);
    }
}
