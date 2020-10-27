<?php

namespace VnCoder\Models;

use Illuminate\Support\Facades\Cache;

trait VnCoder
{
    // Cache
    protected static function setCache($cacheKey, $data = [], $minutes = 1440): bool
    {
        if ($data) {
            Cache::put(self::keyCache($cacheKey), $data, $minutes);
        }

        return true;
    }

    protected static function getCache($cacheKey, $update = false)
    {
        if (env('APP_DEBUG') && !$update) {
            $update = getParam('update', 0);
        }
        if ($update) {
            return false;
        }

        return Cache::get(self::keyCache($cacheKey));
    }

    protected static function keyCache($cacheKey)
    {
        $table = @with(new static)->table;

        if ($table) {
            return 'vn_'.$table.'_'.$cacheKey;
        }
        return $cacheKey;
    }
}
