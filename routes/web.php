<?php

use Controller\Site;
use Src\Route;

// ========== Публичные маршруты ==========
Route::add(['GET', 'POST'], '/login', [Site::class, 'login']);
Route::add(['GET', 'POST'], '/signup', [Site::class, 'signup']);
Route::add('GET', '/hello', [Site::class, 'hello'])->middleware('auth');
Route::add('GET', '/logout', [Site::class, 'logout'])->middleware('auth');
Route::add(['GET', 'POST'], '/edit', [Site::class, 'edit'])->middleware('auth');

// ========== Маршруты только для администратора ==========
Route::add('GET', '/users', [Site::class, 'users'])->middleware('auth', 'role:admin');
Route::add('GET', '/users/create', [Site::class, 'create_users'])->middleware('auth', 'role:admin');
Route::add('POST', '/users/store', [Site::class, 'storeUsers'])->middleware('auth', 'role:admin');
Route::add('GET', '/users/edit', [Site::class, 'edit_users'])->middleware('auth', 'role:admin');
Route::add('POST', '/users/update', [Site::class, 'updateUsers'])->middleware('auth', 'role:admin');
Route::add('GET', '/users/delete', [Site::class, 'deleteUsers'])->middleware('auth', 'role:admin');

Route::add('GET', '/positions', [Site::class, 'positions'])->middleware('auth', 'role:admin');
Route::add('GET', '/positions/create_position', [Site::class, 'create_position'])->middleware('auth', 'role:admin');
Route::add('POST', '/positions/stored', [Site::class, 'storePosition'])->middleware('auth', 'role:admin');
Route::add('GET', '/positions/edit_position', [Site::class, 'edit_position'])->middleware('auth', 'role:admin');
Route::add('POST', '/positions/update', [Site::class, 'updatePosition'])->middleware('auth', 'role:admin');
Route::add('GET', '/positions/delete', [Site::class, 'deletePosition'])->middleware('auth', 'role:admin');

Route::add('GET', '/allowances', [Site::class, 'allowances'])->middleware('auth', 'role:admin');
Route::add('GET', '/allowances/create', [Site::class, 'create_allowance'])->middleware('auth', 'role:admin');
Route::add('POST', '/allowances/store', [Site::class, 'storeAllowance'])->middleware('auth', 'role:admin');
Route::add('GET', '/allowances/edit', [Site::class, 'edit_allowance'])->middleware('auth', 'role:admin');
Route::add('POST', '/allowances/update', [Site::class, 'updateAllowance'])->middleware('auth', 'role:admin');
Route::add('GET', '/allowances/delete', [Site::class, 'deleteAllowance'])->middleware('auth', 'role:admin');

Route::add('GET', '/deductions', [Site::class, 'deductions'])->middleware('auth', 'role:admin');
Route::add('GET', '/deductions/create', [Site::class, 'create_deduction'])->middleware('auth', 'role:admin');
Route::add('POST', '/deductions/store', [Site::class, 'storeDeduction'])->middleware('auth', 'role:admin');
Route::add('GET', '/deductions/edit', [Site::class, 'edit_deduction'])->middleware('auth', 'role:admin');
Route::add('POST', '/deductions/update', [Site::class, 'updateDeduction'])->middleware('auth', 'role:admin');
Route::add('GET', '/deductions/delete', [Site::class, 'deleteDeduction'])->middleware('auth', 'role:admin');

// ========== Маршруты для администратора и бухгалтера ==========
Route::add(['GET', 'POST'], '/payroll/calculate', [Site::class, 'calculatePayroll'])->middleware('auth');
Route::add('GET', '/payroll/reports', [Site::class, 'payrollReports'])->middleware('auth');
Route::add('GET', '/payroll/clear', [Site::class, 'clearReports'])->middleware('auth', 'role:admin');