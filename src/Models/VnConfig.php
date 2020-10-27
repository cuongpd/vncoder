<?php

namespace VnCoder\Models;

use Illuminate\Database\Eloquent\Model;
use VnCoder\Helper\FormManager;
use Illuminate\Support\Facades\DB;

class VnConfig extends Model
{
    public $timestamps = false;
    protected $primaryKey = 'id';
    protected $table = '__config';
    protected $fillable = ['id','type','name','description', 'content'];

    public static $siteConfigKey = ['name', 'title' , 'logo', 'logo_dark', 'favicon' , 'email' , 'phone' , 'author' , 'author_url' , 'copyright' , 'description' , 'keywords' , 'photo' , 'address' , 'about_us' , 'facebook' , 'twitter' , 'youtube' , 'intagram', 'privacy'];

    // type = config -> Config Site
    // type = content -> Html Content

    public static function siteConfig()
    {
        $query = self::getConfigData();
        return json_decode(json_encode($query), false);
    }

    public static function getContent($key, $description = '')
    {
        $cacheKey = 'data_content_' . $key;
        $contentData = cache($cacheKey);
        if (!$contentData) {
            $query = self::where('name', $key)->where('type', 'content')->first();
            if ($query) {
                $contentData = $query->content;
                cache($cacheKey, $contentData, 3600);
            }
        }
        if ($contentData) {
            return $contentData;
        } else {
            self::setContent($key, '', $description);
        }
    }

    public static function forgetCacheContent($key)
    {
        return forget_cache('data_content_' . $key);
    }

    public static function getConfig($key, $default = '')
    {
        $configData = self::getConfigData();
        if (isset($configData[$key])) {
            return $configData[$key];
        }
        self::setConfig($key, $default);
        return $default;
    }

    public static function setConfig($name, $content = '')
    {
        return self::updateOrCreate(['name' => $name, 'type' => 'config'], ['name' => $name , 'content' => $content , 'type' => 'config']);
    }

    public static function setContent($key, $content, $description = '')
    {
        $update = ['name' => $key , 'content' => $content , 'type' => 'content'];
        if ($description) {
            $update['description'] = $description;
        }
        self::forgetCacheContent($key);
        self::updateOrCreate(['name' => $key, 'type' => 'content'], $update);
    }

    public static function saveConfig($configData = [])
    {
        if (is_array($configData) && count($configData) > 0) {
            if (isset($configData['_token'])) {
                unset($configData['_token']);
            }
            foreach ($configData as $name => $content) {
                self::setConfig($name, $content);
            }
            // Clear Cache Key
            self::getConfigData(true);
            flash_message('Thiết lập đã được lưu lại thành công!');
        }
    }

    public static function saveContent($contentData)
    {
        if (is_array($contentData) && count($contentData) > 0) {
            if (isset($contentData['_token'])) {
                unset($contentData['_token']);
            }
            foreach ($contentData as $name => $content) {
                self::setContent($name, $content);
            }
            // Clear Cache Key
            self::getConfigData(true);
            flash_message('Thiết lập đã được lưu lại thành công!');
        }
    }

    public static function formConfig()
    {
        return self::where('type', 'config')->whereNotIn('name', self::$siteConfigKey)->get();
    }

    public static function formContent()
    {
        return self::where('type', 'content')->get();
    }

    protected static function getConfigData($update = false)
    {
        $cacheKey = 'data_configs';
        $data = cache($cacheKey);
        if ($update || !$data) {
            $data = self::select('name', 'content')->where('type', 'config')->pluck('content', 'name')->toArray();
            if ($data) {
                cache($cacheKey, $data, 3600);
            }
        }
        return $data;
    }
}
