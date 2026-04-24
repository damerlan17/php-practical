<?php
namespace Middlewares;

use Src\Request;

class SpecialCharsMiddleware
{
    public function handle(Request $request): Request
    {
        foreach ($request->all() as $key => $value) {
            if ($key === 'password') continue;
            if (is_string($value)) {
                $request->set($key, htmlspecialchars($value, ENT_QUOTES, 'UTF-8'));
            }
        }
        return $request;   // ВАЖНО!
    }
}