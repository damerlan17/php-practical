<?php

namespace Middleware;

use Src\Auth\Auth;

class RoleMiddleware
{
    public function handle($role)
    {
        $user = Auth::user();
        if (!$user || $user->role->role_name !== $role) {
            http_response_code(403);
            die('Доступ запрещён');
        }
    }
}