<?php
namespace Middlewares;

use Src\Auth\Auth;
use Src\Request;

class RoleMiddleware
{
    public function handle(Request $request, string $roleName): Request
    {
        $user = Auth::user();
        if (!$user || $user->role->role_name !== $roleName) {
            http_response_code(403);
            die('Доступ запрещен');
        }
        return $request;
    }
}