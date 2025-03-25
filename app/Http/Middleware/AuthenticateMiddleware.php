<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AuthenticateMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $user_role = Auth::user()->user_catalogue_id;
            if ($user_role == 1) {
                return $next($request);
            } else {
                return redirect()->route('home.index')->with('error', 'Bạn không có quyền truy cập!');
            }
        } else {
            return redirect()->route('auth.signin')->with('error', 'Bạn phải đăng nhập để sử dụng chức năng này');
        }
    }
}
