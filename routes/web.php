<?php

use Src\Route;
use App\Controllers\UserController;

Route::add('GET', '/hello', [Controller\Site::class, 'hello'])
    ->middleware('auth');
Route::add(['GET', 'POST'], '/signup', [Controller\Site::class, 'signup']);
Route::add(['GET', 'POST'], '/login', [Controller\Site::class, 'login']);
Route::add('GET', '/logout', [Controller\Site::class, 'logout']);

Route::add(['GET', 'POST'], '/edit', [Controller\Site::class, 'edit']);
Route::add('GET', '/admin/users', [Controller\AdminController::class, 'users'])
    ->middleware('role:admin');

Route::add('GET', '/positions', [Controller\Site::class, 'positions']);
Route::add('GET', '/create_position', [Controller\Site::class, 'create_position']);
Route::add('GET', '/edit_position', [Controller\Site::class, 'edit_position']);
Route::add('POST', '/update', [Controller\Site::class, 'updatePosition']);
Route::add('POST', '/delete', [Controller\Site::class, 'deletePosition']);

Route::add('POST', '/stored', [Controller\Site::class, 'storePosition']);

Route::add('GET', '/users', [Controller\Site::class, 'users']);
Route::add('GET', '/users/create', [Controller\Site::class, 'create_users']);
Route::add('POST', '/users/store', [Controller\Site::class, 'storeUsers']);
Route::add('GET', '/users/edit', [Controller\Site::class, 'edit_users']);      // id через GET
Route::add('POST', '/users/update', [Controller\Site::class, 'updateUsers']);  // id через POST
Route::add('GET', '/users/delete', [Controller\Site::class, 'deleteUsers']);   // id через GET