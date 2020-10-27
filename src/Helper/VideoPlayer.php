<?php

namespace VnCoder\Helper;

class VideoPlayer
{
    public static function getVideoInfo($url = '')
    {
        $videoID = '';
        if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match)) {
            $videoID   = $match[1];
        }
        if (!$videoID) {
            die('404');
        }

        $youtube = new \YouTube\YouTubeDownloader();
        $links = $youtube->getDownloadLinks($url);
        $error = $youtube->getLastError();

        header('Content-Type: application/json');
        echo json_encode([
            'links' => $links,
            'error' => $error
        ], JSON_PRETTY_PRINT);
    }
}
