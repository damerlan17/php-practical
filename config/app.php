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
    ],
    'validators' => [
        'required'  => \Validators\RequiredValidator::class,
        'unique'    => \Validators\UniqueValidator::class,
        'numeric'   => \Validators\NumericValidator::class,
        'min'       => \Validators\MinValidator::class,
        'max'       => \Validators\MaxValidator::class,
        'date_format' => \Validators\DateFormatValidator::class,
        'exists' => \Validators\ExistsValidator::class,
    ],

    // Глобальные middleware (выполняются для каждого запроса)
    'routeAppMiddleware' => [
        'trim'   => \Middlewares\TrimMiddleware::class,
        'specialChars' => \Middlewares\SpecialCharsMiddleware::class,
        'csrf'   => \Middlewares\CSRFMiddleware::class,
    ],

];