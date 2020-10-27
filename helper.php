<?php

if (!function_exists('newObject')) {
    function newObject()
    {
        return new stdClass();
    }
}

if (!function_exists('getConfig')) {
    function getConfig($key, $default = '')
    {
        return VnConfig::getConfig($key, $default);
    }
}

if (!function_exists('is_admin')) {
    function is_admin()
    {
        return VnUser::isAdmin();
    }
}

if (!function_exists('user_info')) {
    function user_info()
    {
        return VnUser::getUser();
    }
}

if (!function_exists('debugbar_off')) {
    function debugbar_off()
    {
        Debugbar::disable();
    }
}

if (!function_exists('getContent')) {
    function getContent($key, $description = '')
    {
        return VnConfig::getContent($key, $description);
    }
}

if (!function_exists('dj')) {
    function dj($data = [])
    {
        header('Content-Type: application/json');
        echo json_encode($data);
        die;
    }
}

if (!function_exists('dp')) {
    function dp($data = [])
    {
        echo "<pre>";
        print_r($data);
        echo "</pre>";
        die;
    }
}

if (!function_exists('getParam')) {
    function getParam($param, $default = '')
    {
        $data = $_GET[$param] ?? $_POST[$param] ?? $_REQUEST[$param] ?? $default;
        return trim($data);
    }
}

if (!function_exists('getParamInt')) {
    function getParamInt($aVarName, $aVarAlt = 0)
    {
        return (int)getParam($aVarName, $aVarAlt);
    }
}

if (!function_exists('minify_output')) {
    function minify_output($buffer)
    {
        $search = array('/\>[^\S]+/s', '/[^\S]+\</s', '/(\s)+/s');
        $replace = array('> ', '<', '\\1');
        return preg_replace($search, $replace, $buffer);
    }
}

if (!function_exists('base_url')) {
    function base_url($path = '')
    {
        return BASE_URL . $path;
    }
}

if (!function_exists('core_assets')) {
    function core_assets($path = '')
    {
        return route('core-assets', ['filename' => $path]);
    }
}

if (! function_exists('request')) {
    function request($key = null, $default = null)
    {
        if ($key === null) {
            return app('request');
        }

        if (is_array($key)) {
            return app('request')->only($key);
        }

        $value = app('request')->__get($key);

        return $value ?? value($default);
    }
}

if (! function_exists('session')) {
    function session($key = null)
    {
        $session = app('session');
        if ($session) {
            if ($key === null) {
                return $session;
            }

            if (is_array($key)) {
                return $session->put($key);
            }
            return $session->get($key);
        }
        throw new \RuntimeException('Application session store not set.');
    }
}

if (! function_exists('cookie')) {
    function cookie($key, $default = '')
    {
        if (is_array($key)) {
            foreach ($key as $name => $val) {
                setcookie($name, $val, TIME_NOW + (86400 * 30), '/'); // 86400 = 1 day
            }
        } else {
            return $_COOKIE[$key] ?? $default;
        }
    }
}

if (!function_exists('flash')) {
    function flash($name, $message = null)
    {
        return session()->flash($name, $message);
    }
}

if (!function_exists('flash_message')) {
    function flash_message($message = null)
    {
        return session()->flash('message', $message);
    }
}

if (!function_exists('flash_error')) {
    function flash_error($data = null)
    {
        return session()->flash('errors', $data);
    }
}

if (!function_exists('safe_name')) {
    function safe_name($str = '')
    {
        $str = html_entity_decode($str, ENT_QUOTES, 'UTF-8');
        $filter_in = array('#(a|à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)#', '#(A|À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ)#', '#(e|è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)#', '#(E|È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)#', '#(i|ì|í|ị|ỉ)#', '#(I|ĩ|Ì|Í|Ị|Ỉ|Ĩ)#', '#(o|ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)#', '#(O|Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ)#', '#(u|ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)#', '#(U|Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)#', '#(y|ỳ|ý|ỵ|ỷ|ỹ)#', '#(Y|Ỳ|Ý|Ỵ|Ỷ|Ỹ)#', '#(d|đ)#', '#(D|Đ)#');
        $filter_out = array('a', 'A', 'e', 'E', 'i', 'I', 'o', 'O', 'u', 'U', 'y', 'Y', 'd', 'D');
        $text = preg_replace($filter_in, $filter_out, $str);
        $text = preg_replace('/[^a-zA-Z0-9.]/', ' ', $text);
        return trim($text);
    }
}

if (!function_exists('safe_text')) {
    function safe_text($str = '')
    {
        $text = safe_name($str);
        $text = preg_replace('/ /', '-', strtolower(trim($text)));
        $text = str_replace('--', '', $text);
        return trim($text);
    }
}

if (!function_exists('public_path')) {
    function public_path($path = '')
    {
        return BASE_PATH. DIRECTORY_SEPARATOR.'public'.DIRECTORY_SEPARATOR. $path;
    }
}

if (!function_exists('make_dir')) {
    function make_dir($path)
    {
        if (is_dir($path)) {
            return true;
        }
        $prev_path = substr($path, 0, strrpos($path, '/', -2) + 1);
        $return = make_dir($prev_path);
        return ($return && is_writable($prev_path)) ? mkdir($path) : false;
    }
}

if (!function_exists('ucname')) {
    function ucname($text)
    {
        return ucwords(str_replace('_', ' ', $text));
    }
}

if (!function_exists('mb_ucwords')) {
    function mb_ucwords($str)
    {
        return mb_convert_case($str, MB_CASE_TITLE, 'UTF-8');
    }
}

if (!function_exists('str_limit')) {
    function str_limit($string, $max = 255)
    {
        if (mb_strlen($string, 'utf-8') >= $max) {
            $string = mb_substr($string, 0, $max - 5, 'utf-8').'...';
        }
        return $string;
    }
}

if (!function_exists('is_mobile')) {
    function is_mobile()
    {
        $aMobileUA = array(
            '/iphone/i' => 'iPhone',
            '/ipod/i' => 'iPod',
            '/android/i' => 'Android',
            '/blackberry/i' => 'BlackBerry',
            '/webos/i' => 'Mobile'
        );

        foreach ($aMobileUA as $sMobileKey => $sMobileOS) {
            if (preg_match($sMobileKey, $_SERVER['HTTP_USER_AGENT'])) {
                return true;
            }
        }
        return false;
    }
}

if (!function_exists('is_url')) {
    function is_url($text)
    {
        return filter_var($text, FILTER_VALIDATE_URL) ? true : false;
    }
}

if (! function_exists('cache')) {
    function cache($key, $data = null, $time_seconds = 3600)
    {
        // Illuminate\Support\Facades\Cache
        if ($data) {
            return app('cache')->put($key, $data, $time_seconds);
        }
        return app('cache')->get($key);
    }
}

if (! function_exists('forget_cache')) {
    function forget_cache($key)
    {
        return app('cache')->forget($key);
    }
}

if (! function_exists('csrf_field')) {
    function csrf_field()
    {
        return '<input type="hidden" name="_token" value="'.csrf_token().'"><input type="hidden" name="_request_url" value="'.request()->fullUrl().'">';
    }
}

if (!function_exists('filemanager')) {
    function filemanager($field_id = 'photo', $type = 1)
    {
        // Type :  1 : image , 2 : file , 3 : video
        return env('FILE_MANAGER_URL') . 'dialog.php?type='.$type.'&akey='.env('FILE_MANAGER_KEY').'&field_id='.$field_id;
    }
}

if (! function_exists('csrf_token')) {
    function csrf_token()
    {
        try {
            $session = app('session');
            if (isset($session)) {
                return $session->token();
            }
        } catch (Exception $e) {
            return md5(TIME_NOW);
        }

        throw new \RuntimeException('Application session store not set.');
    }
}

if (!function_exists('time_format')) {
    function time_format($duation = 0)
    {
        if ($duation < 60) {
            return $duation.' phút';
        }
        $h = round($duation/60);
        $p = $duation%60;
        return $p === 0 ? $h.' giờ' : $h.' giờ '.$p.' phút';
    }
}

if (!function_exists('stripQuotes')) {
    function stripQuotes($expression)
    {
        return str_replace(["'", '"'], '', $expression);
    }
}

if (!function_exists('getControllerName')) {
    function getControllerName($controller)
    {
        $controller = ucwords(str_replace('-', ' ', $controller));
        $controller = str_replace(' ', '', $controller);
        return $controller . "Controller";
    }
}

if (!function_exists('getFunctionName')) {
    function getFunctionName($action = '')
    {
        $default = "Index_Action"; // Default
        if ($action) {
            $action = str_replace("-", " ", $action);
            $action = ucwords($action);
            $default = str_replace(" ", "_", $action)."_Action";
        }
        return $default;
    }
}

if (!function_exists('scheduleX')) {
    function scheduleX($command, $step_time = 5)
    {
        $dt = \Illuminate\Support\Carbon::now();
        $total = (int) 60/$step_time;
        do {
            \Illuminate\Support\Facades\Artisan::call($command);
            @time_sleep_until($dt->addSeconds($step_time)->timestamp);
        } while ($total-- > 0);
    }
}

if (!function_exists('logs')) {
    function logs($name, $message = '', $logTime = true)
    {
        if ($logTime) {
            $now = \DateTime::createFromFormat('U.u', number_format(microtime(true), 6, '.', ''));
            $message = $now->format("m-d-Y H:i:s.u") . ' - ' . $message;
        }

        file_put_contents(storage_path($name . '.txt'), $message . PHP_EOL, FILE_APPEND);
    }
}

if (!function_exists('show_error')) {
    function show_error($name = '')
    {
        $errorData = session('errors');
        $message = $errorData[$name] ?? '';
        if (is_array($message)) {
            $message = $message[0];
        }
        return $message;
    }
}

if (!function_exists('excel_time')) {
    function excel_time($xls_date_data, $format = '')
    {
        $xls_date = (int) $xls_date_data;
        if ($xls_date) {
            $unix_date = ($xls_date - 25569) * 86400;
            if ($format) {
                return date($format, $unix_date);
            }
            return $unix_date;
        }
        return $xls_date_data;
    }
}

if (!function_exists('price_format')) {
    function price_format($price = 0, $free = true)
    {
        if ($price > 0) {
            return number_format($price).'<sup>đ</sup>';
        }
        if ($free) {
            return 'Miễn phí';
        }
        return '';
    }
}

if (!function_exists('get_number')) {
    function get_number($str)
    {
        $number = preg_replace("/[^0-9]/", "", $str);
        return (int) $number;
    }
}

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
