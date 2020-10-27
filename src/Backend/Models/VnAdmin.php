<?php

namespace VnCoder\Backend\Models;

use VnCoder\Models\VnUser;

class VnAdmin extends VnUser
{
    public static function getUserData($limit = 20)
    {
        $query = self::with('role');
        $search = getParam('_query', '');
        if ($search && strlen($search) > 2) {
            $query->where('name', 'LIKE', '%'.$search.'%')->orWhere('email', 'LIKE', '%'.$search.'%')->orWhere('phone', 'LIKE', '%'.$search.'%');
        }
        return $query->orderBy('id', 'desc')->paginate($limit);
    }

    public static function checkLogin()
    {
        $uid = session('uid') ?? 0;
        if ($uid > 0) {
            $role = session('role_id') ?? 0;
            if ($role > 0) {
                return true;
            } else {
                flash_message('Tài khoản của bạn không được phép truy cập vào hệ thống');
            }
        } else {
            flash_message('Bạn cần đăng nhập để truy cập vào hệ thống!');
        }
        session(['current_url' => request()->url()]);
        return false;
    }
}
