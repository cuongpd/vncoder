<?php

namespace VnCoder\Helper;

class LingoHub
{
    protected $api_token = '3227b57a6a3ab82c0f3eafb6a3091bebebb677400606ff1022d8ff7813a3adb2';

    protected $language = [
        'vi-VN' => 'Vietnamese (Vietnam)',
        'ar-AR' => 'Arabic (Arabic)',
        'bn-IN' => 'Bengali (India)',
        'de-DE' => 'German (Germany)',
        'en-US' => 'English (United States)',
        'es-ES' => 'Spanish (Spain)',
        'fr-FR' => 'French (France)',
        'hi-IN' => 'Hindi (India)',
        'id-ID' => 'Indonesian (Indonesia)',
        'ja-JP' => 'Japanese (Japan)',
        'ko-KR' => 'Korean (South Korea)',
        'pt-BR' => 'Portuguese (Brazil)',
        'pt-PT' => 'Portuguese (Portugal)',
        'ru-RU' => 'Russian (Russia)',
        'th-TH' => 'Thai (Thailand)',
        'zh-CN' => 'Chinese (China)',
        'zh-HK' => 'Chinese (Hong Kong)',
        'zh-TW' => 'Chinese (Taiwan)',
    ];

    public static function localization($textInput = [])
    {
        $Info = [];

        $language = with(new static())->language;
        foreach ($textInput  as $text) {
            $query = [];
            foreach ($language as $code => $name) {
                $translateText = self::translate($text, 'en', $code);
            }
        }
    }


    public static function translate($sourceText, $sourceLocale = 'en', $targetLocale = 'vi')
    {
        $postData = [
            'sourceLocale' => $sourceLocale,
            'targetLocale' => $targetLocale,
            'sourceText' => $sourceText
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://api.lingohub.com/lh/accounts/thinhlee/projects/hero-game/mt');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
        curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');

        $headers = array();
        $headers[] = 'Authority: api.lingohub.com';
        $headers[] = 'Accept: application/json, text/plain, */*';
        $headers[] = 'X-Auth-Token: 3227b57a6a3ab82c0f3eafb6a3091bebebb677400606ff1022d8ff7813a3adb2';
        $headers[] = 'X-Auth-Email: thinhlee211@gmail.com';
        $headers[] = 'User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.89 Safari/537.36';
        $headers[] = 'Content-Type: application/json;charset=UTF-8';
        $headers[] = 'Origin: https://translate.lingohub.com';
        $headers[] = 'Sec-Fetch-Site: same-site';
        $headers[] = 'Sec-Fetch-Mode: cors';
        $headers[] = 'Sec-Fetch-Dest: empty';
        $headers[] = 'Referer: https://translate.lingohub.com/';
        $headers[] = 'Accept-Language: vi-VN,vi;q=0.9,fr-FR;q=0.8,fr;q=0.7,en-US;q=0.6,en;q=0.5';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            return false;
        }
        curl_close($ch);
        $data = json_decode($result, true);
        return $data['translatedText'] ?? '';
    }
}
