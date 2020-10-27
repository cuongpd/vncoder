<?php

namespace VnCoder\Middleware;

use Closure;
use VnCoder\Models\VnUser;

class LoginMiddleware
{
    public function handle($request, Closure $next)
    {
        $checkLogin = VnUser::checkLogin();
        if (!$checkLogin) {
            return redirect()->route('auth.login');
        }

        return $next($request);
    }
}
