<?php

use Src\Route;

Route::add('GET', '/hello', [Controller\Site::class, 'hello'])
    ->middleware('auth');
Route::add(['GET', 'POST'], '/signup', [Controller\Site::class, 'signup']);
Route::add(['GET', 'POST'], '/login', [Controller\Site::class, 'login']);
Route::add('GET', '/logout', [Controller\Site::class, 'logout']);

Route::add(['GET', 'POST'], '/edit', [Controller\Site::class, 'edit']);

Route::add('GET', '/positions', [Controller\Site::class, 'positions']);
Route::add('GET', '/create_position', [Controller\Site::class, 'create_position']);
Route::add('GET', '/edit_position', [Controller\Site::class, 'edit_position']);
Route::add('POST', '/update', [Controller\Site::class, 'updatePosition']);
Route::add('POST', '/delete', [Controller\Site::class, 'deletePosition']);
Route::add('POST', '/stored', [Controller\Site::class, 'storePosition']);


// Управление пользователями
Route::add('GET', '/users', [Controller\Site::class, 'users']);
Route::add('GET', '/users/create_users', [Controller\Site::class, 'create_users']);        // добавили слеш
Route::add('POST', '/store', [Controller\Site::class, 'storeUsers']);
         // единообразно

Route::add('GET', '/users/delete', [Controller\Site::class, 'deleteUsers']);      // GET для простоты


Route::add('GET', '/users/edit_users', [Controller\Site::class, 'edit_users']);
Route::add('POST', '/users/update_user', [Controller\Site::class, 'updateUsers']);