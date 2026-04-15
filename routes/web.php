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
Route::add('GET', '/users/create', [Controller\Site::class, 'create_users']);
Route::add('POST', '/users/store', [Controller\Site::class, 'storeUsers']);
Route::add('GET', '/users/edit', [Controller\Site::class, 'edit_users']);
Route::add('POST', '/users/update', [Controller\Site::class, 'updateUsers']);
Route::add('GET', '/users/delete', [Controller\Site::class, 'deleteUsers']);

// Начисления
Route::add('GET', '/allowances', [Controller\Site::class, 'allowances']);
Route::add('GET', '/allowances/create', [Controller\Site::class, 'create_allowance']);
Route::add('POST', '/allowances/store', [Controller\Site::class, 'storeAllowance']);
Route::add('GET', '/allowances/edit', [Controller\Site::class, 'edit_allowance']);
Route::add('POST', '/allowances/update', [Controller\Site::class, 'updateAllowance']);
Route::add('GET', '/allowances/delete', [Controller\Site::class, 'deleteAllowance']);

// Вычеты
Route::add('GET', '/deductions', [Controller\Site::class, 'deductions']);
Route::add('GET', '/deductions/create', [Controller\Site::class, 'create_deduction']);
Route::add('GET', '/deductions/edit', [Controller\Site::class, 'edit_deduction']);
Route::add('GET', '/deductions/delete', [Controller\Site::class, 'deleteDeduction']);
Route::add('POST', '/deductions/store', [Controller\Site::class, 'storeDeduction']);
Route::add('POST', '/deductions/update', [Controller\Site::class, 'updateDeduction']);

Route::add(['GET', 'POST'], '/payroll/calculate', [Controller\Site::class, 'calculatePayroll']);
Route::add('GET', '/payroll/reports', [Controller\Site::class, 'payrollReports']);
Route::add('GET', '/payslip', [Controller\Site::class, 'payslip']);
Route::add('GET', '/payroll/clear', [Controller\Site::class, 'clearReports']);
