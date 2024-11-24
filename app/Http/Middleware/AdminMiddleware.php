<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->role === 'admin') {
            return $next($request);
        }

        if ($request->is('admin/*')) {
            return redirect('/')->with('error', 'Bạn không có quyền truy cập quản trị.');
        }

        return $next($request);
    }
}