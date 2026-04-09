<?php

use Src\Route;

Route::add('GET', '/hello', [Controller\Site::class, 'hello'])
    ->middleware('auth');
Route::add(['GET', 'POST'], '/signup', [Controller\Site::class, 'signup']);
Route::add(['GET', 'POST'], '/login', [Controller\Site::class, 'login']);
Route::add('GET', '/logout', [Controller\Site::class, 'logout']);

Route::add(['GET', 'POST'], '/edit', [Controller\Site::class, 'edit']);
Route::add('GET', '/admin/users', [Controller\Site::class, 'users'])->middleware('role:admin');

Route::add(['GET', 'POST'], '/positions', [Controller\Site::class, 'positions']);
Route::add('GET', '/create_position', [Controller\Site::class, 'create_position']);

