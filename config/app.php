<?php

return [
    // Класс аутентификации
    'auth' => \Src\Auth\Auth::class,
    // Класс пользователя
    'identity' => \Model\User::class,
    // Middleware
    'routeMiddleware' => [
        'auth' => \Middlewares\AuthMiddleware::class,
        'role' => \Middlewares\RoleMiddleware::class,
    ]
];