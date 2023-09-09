<?php

namespace App\Http\Middleware;

use Closure;

class AdminAuthMiddleware
{
    public function handle($request, Closure $next)
    {
        if (!session()->exists("gubun") == "관리자") {
            return redirect()->route('login'); // 로그인 페이지로 리디렉션
        }

        return $next($request);
    }
}
