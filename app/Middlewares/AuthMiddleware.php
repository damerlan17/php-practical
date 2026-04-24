<?php

namespace Middlewares;

use Src\Auth\Auth;
use Src\Request;

class AuthMiddleware
{
    public function handle(Request $request): Request
    {
        if (!Auth::check()) {
            app()->route->redirect('/login');
        }
        return $request;
    }
}