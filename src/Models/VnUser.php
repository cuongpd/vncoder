<?php

namespace VnCoder\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;
use VnCoder\Jobs\SendEmailActiveUserJob;
use VnCoder\Jobs\SendEmailForgotPasswordJob;
use VnCoder\Jobs\SendEmailResetPasswordJob;

class VnUser extends Model
{
    public const CREATED_AT = 'created';
    public const UPDATED_AT = 'updated';
    protected $dateFormat = 'U';
    protected $table = '__user';
    protected $fillable = ['role_id', 'name', 'email', 'password', 'phone', 'avatar', 'birthday', 'status', 'auth', 'token', 'token_expire'];

    public function role(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(VnRole::class, 'role_id', 'id');
    }

    public function getRoleNameAttribute()
    {
        return $this->role->name ?? 'Member';
    }

    public function getAvatarAttribute($avatar)
    {
        return $avatar ?? url('core/images/avatar.jpg');
    }

    public static function Login_Socialite($user, $drive = 'facebook')
    {
        if ($user) {
            $email = $user->email ?? '';
            $name = $user->name ?? '';
            $avatar = $user->avatar ?? '';
            if ($email) {
                $userData = self::updateOrCreate(['email' => $email], ['name' => $name, 'email' => $email, 'avatar' => $avatar, 'auth' => $drive]);
                $userId = $userData ? $userData->id : 0;
                if ($userId) {
                    VnUserSocialite::updateOrCreate(['provider' => $drive , 'auth_id' => $user->id], ['user_id' => $userId, 'provider' => $drive , 'auth_id' => $user->id, 'token' => $user->token, 'nickname' => $user->nickname]);
                    return self::LoginUsingID($userId);
                }
            }
        }
        return false;
    }

    public static function Login_Email_Password($email, $password)
    {
        $password_encrypt = self::password_encrypt($password);
        $userInfo = self::where('email', $email)->where('password', $password_encrypt)->first();
        if ($userInfo) {
            self::where('id', $userInfo->id)->update(['auth' => 'password']);
            return self::LoginUsingID($userInfo->id);
        } else {
            flash_message('Thông tin đăng nhập không đúng!');
        }
        return false;
    }

    public static function Register_User($name, $email, $password)
    {
        $query = self::where('email', $email)->first();
        if (!$query) {
            $token = md5($email . '-' . TIME_NOW);
            $token_expire = TIME_NOW + 86400; // 1 day
            $update = ['status' => 0, 'name' => $name , 'email' => $email , 'password' => self::password_encrypt($password) , 'token' => $token, 'token_expire' => $token_expire];
            self::create($update);
            dispatch(new SendEmailActiveUserJob($name, $email, $token));
            flash_message('Tài khoản của bạn đã được đăng kí thành công. Vui lòng kiểm tra Email và xác nhận tài khoản!');
            return redirect()->route('auth.login');
        } else {
            flash_message('Đã có lỗi xảy ra! Vui lòng thử lại!');
            return redirect()->route('auth.register');
        }
    }

    public static function Reset_Password($email)
    {
        $userInfo = self::where('email', $email)->where('status', '>', 0)->first();
        if ($userInfo) {
            $token = self::password_encrypt($email);
            $token_expire = TIME_NOW + 86400; // 1 day
            self::where('id', $userInfo->id)->update(['token' => $token , 'token_expire' => $token_expire]);
            dispatch(new SendEmailForgotPasswordJob($email, $token));
            flash_message('Hệ thống đã gửi Email khôi phục mật khẩu. Vui lòng kiểm tra mail và làm theo hướng dẫn!');
            return true;
        }
        flash_message('Đã có lỗi xảy ra, vui lòng thử lại!');
        return false;
    }

    public static function ActiveUser($token)
    {
        $userInfo = self::where('token', $token)->where('status', 0)->first();
        if ($userInfo) {
            self::where('id', $userInfo->id)->update(['status' => 1, 'token' => '' ,  'token_expire' => 0]);
            flash_message('Tài khoản của bạn đã được kích hoạt thành công!');
        } else {
            flash_message('Đã có lỗi xảy ra, vui lòng thử lại!');
        }
    }

    public static function ReActiveUser($token)
    {
        $userInfo = self::where('token', $token)->where('status', 0)->first();
        if ($userInfo) {
            dispatch(new SendEmailActiveUserJob($userInfo->name, $userInfo->email, $token));
        } else {
            flash_message('Đã có lỗi xảy ra, vui lòng thử lại!');
        }
    }

    public static function setPassword($token)
    {
        $userInfo = self::where('token', $token)->where('status', '>', 0)->first();
        if ($userInfo) {
            $password = self::randomPassword();
            self::where('id', $userInfo->id)->update(['password' => self::password_encrypt($password), 'token' => '' ,  'token_expire' => 0]);
            dispatch(new SendEmailResetPasswordJob($userInfo->email, $password));
            flash_message('Mật khẩu đã được reset thành công. Vui lòng kiểm tra email để lấy thông tin đăng nhập!');
        } else {
            flash_message('Đã có lỗi xảy ra, vui lòng thử lại!');
        }
    }

    public static function randomPassword()
    {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < 8; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); //turn the array into a string
    }

    public static function getUid()
    {
        return session('uid') ?? 0;
    }

    public static function isAdmin()
    {
        $userInfo = self::getUser();
        if ($userInfo) {
            return $userInfo->role_id ?? 0;
        }
        return false;
    }

    public static function getUser()
    {
        $uid = session('uid');
        $user_info = session('user_info');
        if ($user_info && isset($user_info['id']) && $user_info['id'] == $uid) {
            return $user_info;
        }
        return false;
    }

    public static function LoginUsingID($uid)
    {
        $userInfo = self::select('id', 'role_id', 'name', 'email', 'phone', 'avatar', 'birthday', 'token', 'status')->where('id', $uid)->first();
        if ($userInfo) {
            if ($userInfo->status > 0) {
                session(['user_info' => $userInfo , 'uid' => $userInfo->id , 'role_id' => $userInfo->role_id]);
                return true;
            } elseif ($userInfo->status == 0) {
                flash_message('Tài khoản của bạn đang chờ kích hoạt Email!<br> Bấm vào <a href="'.route('auth.re-active', ['token' => $userInfo->token]).'">đây</a> để xác nhận tài khoản!');
            } else {
                flash_message('Tài khoản của bạn đang bị tạm khoá!');
            }
        }
        return false;
    }

    public static function logout(): void
    {
        session()->forget(['user_info', 'uid', 'role_id']);
    }

    public static function password_encrypt($password)
    {
        return md5('vn-' . md5($password) . '-2020');
    }

    public static function active($id): void
    {
        self::where('id', $id)->update(['status' => 1]);
        flash_message('Người dùng đã được mở đăng nhập!');
    }

    public static function deactive($id): void
    {
        self::where('id', $id)->update(['status' => -1]);
        flash_message('Người dùng đã bị chặn đăng nhập!');
    }

    public static function checkLogin()
    {
        $uid = session('uid') ?? 0;
        if (!$uid) {
            flash_message('Bạn cần đăng nhập để truy cập vào hệ thống!');
            session(['current_url' => request()->url()]);
            return false;
        }
        return true;
    }
}
