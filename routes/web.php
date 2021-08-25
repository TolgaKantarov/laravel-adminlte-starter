<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\HomeController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['verify' => true]);

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {

	Route::post('/users/{id}/update/general', [UserController::class, 'update_general'])->name('users.update.general');
	Route::post('/users/{id}/update/password', [UserController::class, 'update_password'])->name('users.update.password');
	Route::post('/users/{id}/update/status', [UserController::class, 'update_status'])->name('users.update.status');
	Route::post('/users/{id}/update/avatar', [UserController::class, 'update_avatar'])->name('users.update.avatar');
	Route::post('/users/{id}/update/role', [UserController::class, 'update_role'])->name('users.update.role');
	Route::post('/users/{user}/update/ban-hammer', [UserController::class, 'ban_hammer'])->name('users.ban-hammer');

    Route::resource('/users', UserController::class);
    Route::resource('/roles', RoleController::class);
    Route::resource('/permissions', PermissionController::class);
});
