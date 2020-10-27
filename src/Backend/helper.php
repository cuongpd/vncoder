<?php
if (!function_exists('backend')) {
    function backend($slug = 'home')
    {
        $backend_url = BASE_URL . 'backend/';
        $slug = str_replace('.', '/', $slug);
        $slug = rtrim($slug, '/');
        return $backend_url . strtolower(trim($slug));
    }
}

if (!function_exists('getKeyName')) {
    function getKeyName($key = '')
    {
        $key = str_replace('_', ' ', $key);
        $key = ucwords($key);
        return trim($key);
    }
}

if (!function_exists('backend_route')) {
    function backend_route($controller, $action, $submit = false)
    {
    }
}

if (! function_exists('no_data')) {
    function no_data($title = '', $desc = '')
    {
        $title = $title ? $title : 'Không có dữ liệu';
        $desc = $desc ? $desc : 'Không tìm thấy dữ liệu trên hệ thống, vui lòng thử lại sau!';
        return "<div class='no-data-screen-wrap text-center my-2 pb-2'>
            <h3 class='no-data-title'>{$title}</h3>
            <h5 class='no-data-subtitle'>{$desc}</h5>
        </div>";
    }
}
