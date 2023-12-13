<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckAuth
{
    public function handle($request, Closure $next)
    {
        // Проверяем, аутентифицирован ли пользователь
        if (Auth::check()) {
            return $next($request); // Переходим к следующему middleware
        } else {
            return redirect('/login'); // Если не аутентифицирован, перенаправляем на страницу входа
        }
    }
}