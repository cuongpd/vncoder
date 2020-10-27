<?php

namespace VnCoder\Controllers;

use VnCoder\Controllers\BaseController;

use Laravel\Socialite\Facades\Socialite;
use VnCoder\Models\VnUser;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AuthController extends BaseController
{
    protected $title = '';
    protected $active_provider = ['facebook','google'];

    public function Login_Form()
    {
        $current_url = session('current_url');
        if (!$current_url) {
            $referer = request()->headers->get('referer');
            if ($referer) {
                session(['current_url' => $referer]);
            }
        }
        $this->title = 'Đăng nhập trên hệ thống';
        return $this->views('login');
    }

    public function Register_Form()
    {
        $this->title = 'Đăng kí tài khoản';
        return $this->views('register');
    }

    public function Reset_Password_Form()
    {
        $this->title = 'Khôi phục mật khẩu';
        return $this->views('reset');
    }

    public function Login_Submit(Request $request)
    {
        try {
            $this->validate($request, [
                'email' => 'required|email',
                'password' => 'required|between:6,20',
            ], [
                'required' => 'Trường :attribute không được để trống.',
                'email' => ':attribute bạn nhập không phải là Email hợp lệ.',
                'unique' => ':attribute bạn nhập đã tồn tại trong hệ thống.',
                'confirmed' => ':attribute bạn nhập cần khớp nhau!',
                'between' => ':attribute cần trong khoản từ :min đến :max kí tự!',
            ]);
        } catch (ValidationException $e) {
            flash_error($e->errors());
            return redirect()->route('auth.login');
        }
        $isLogin = VnUser::Login_Email_Password($request->post('email'), $request->post('password'));
        return $this->doLoginAction($isLogin);
    }

    public function Register_Submit(Request $request)
    {
        try {
            $this->validate($request, [
                'name' => 'required|between:3,32',
                'email' => 'required|email|unique:__user',
                'password' => 'required|confirmed|between:6,20',
            ], [
                'required' => 'Trường :attribute không được để trống.',
                'email' => ':attribute bạn nhập không phải là Email hợp lệ.',
                'unique' => ':attribute bạn nhập đã tồn tại trong hệ thống.',
                'confirmed' => ':attribute bạn nhập cần khớp nhau!',
                'between' => ':attribute cần trong khoản từ :min đến :max kí tự!',
            ]);
        } catch (ValidationException $e) {
            flash_error($e->errors());
            return redirect()->route('auth.register');
        }
        return VnUser::Register_User($request->post('name'), $request->post('email'), $request->post('password'));
    }

    public function Reset_Password_Submit(Request $request)
    {
        try {
            $this->validate($request, [
                'email' => 'required|email|exists:__user'
            ], [
                'email' => ':attribute bạn nhập không phải là Email hợp lệ.',
                'exists' => ':attribute bạn nhập chưa có trên hệ thống, vui lòng kiểm tra lại.'
            ]);
        } catch (ValidationException $e) {
            flash_error($e->errors());
            return redirect()->route('auth.reset');
        }
        VnUser::Reset_Password($request->post('email'));
        return redirect()->route('auth.login');
    }

    public function Active_Action($token = '')
    {
        if ($token && strlen($token) == 32) {
            VnUser::ActiveUser($token);
        } else {
            flash_message('Đã có lỗi xảy ra, vui lòng thử lại!');
        }
        return redirect()->route('auth.login');
    }

    public function ReActive_Action($token)
    {
        if ($token && strlen($token) == 32) {
            VnUser::ReActiveUser($token);
        } else {
            flash_message('Đã có lỗi xảy ra, vui lòng thử lại!');
        }
        return redirect()->route('auth.login');
    }

    public function Reset_Password_Request($token = '')
    {
        if ($token && strlen($token) == 32) {
            VnUser::setPassword($token);
        } else {
            flash_message('Đã có lỗi xảy ra, vui lòng thử lại!');
        }
        return redirect()->route('auth.login');
    }

    public function Logout_Action()
    {
        VnUser::logout();
        return redirect()->route('auth.login');
    }

    public function Provider_Auth_Action($provider)
    {
        $this->checkProvider($provider);
        return Socialite::driver($provider)->redirect();
    }

    public function Provider_Callback_Action($provider)
    {
        $this->checkProvider($provider);
        $socialite = Socialite::driver($provider);
        try {
            $user = $socialite->user();
        } catch (\Exception $e) {
            info($e->getMessage());
            return abort(404, 'Provider Error!');
        }
        $isLogin = VnUser::Login_Socialite($user, $provider);
        return $this->doLoginAction($isLogin);
    }

    protected function doLoginAction($isLogin)
    {
        if ($isLogin) {
            return redirect()->route('home');
        } else {
            return redirect()->route('auth.login');
        }
    }

    protected function checkProvider($provider)
    {
        if (!in_array($provider, $this->active_provider)) {
            return abort(404, 'Nothing to do!');
        }
    }

    protected function views($view)
    {
        $data = [
            'title' => $this->title,
            'views' => 'core::auth.' . $view,
        ];
        debugbar_off();
        return view('core::auth._auth', $data);
    }
}
