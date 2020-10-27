<?php

namespace VnCoder\Middleware;

use Closure;
use VnCoder\Backend\Models\VnAdmin;

class AuthMiddleware
{
    public function handle($request, Closure $next)
    {
        $checkLogin = VnAdmin::checkLogin();
        if (!$checkLogin) {
            return redirect()->route('auth.login');
        }
        return $next($request);
    }
}
