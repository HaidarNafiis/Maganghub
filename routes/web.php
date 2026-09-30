<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

use App\Http\Controllers\User\DashboardController as UserDashboardController;

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\FormationController;

use App\Http\Controllers\SuperAdmin\DashboardController as SuperAdminDashboardController;

use App\Http\Controllers\User\AttendanceController as UserAttendanceController;
use App\Http\Controllers\Admin\AttendanceController as AdminAttendanceController;

/*
|--------------------------------------------------------------------------
| Root
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('login');
});


/*
|--------------------------------------------------------------------------
| Authentication
|--------------------------------------------------------------------------
*/

Route::get('/login', [LoginController::class, 'showLogin'])
    ->name('login');

Route::post('/login', [LoginController::class, 'login'])
    ->name('login.process');

Route::post('/logout', [LoginController::class, 'logout'])
    ->name('logout');


/*
|--------------------------------------------------------------------------
| Register
|--------------------------------------------------------------------------
*/

Route::get('/register', [RegisterController::class, 'showRegister'])
    ->name('register');

Route::post('/register', [RegisterController::class, 'register'])
    ->name('register.process');


/*
|--------------------------------------------------------------------------
| User
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:user'])
    ->prefix('user')
    ->group(function () {

        Route::get('/dashboard', [UserDashboardController::class, 'index'])
            ->name('user.dashboard');

        Route::get('/absensi', [UserAttendanceController::class, 'index'])
            ->name('user.attendance.index');

        Route::post('/absensi/register-face', [UserAttendanceController::class, 'registerFace'])
            ->name('user.attendance.register-face');

        Route::post('/absensi/check-in', [UserAttendanceController::class, 'checkIn'])
            ->name('user.attendance.check-in');

        Route::post('/absensi/check-out', [UserAttendanceController::class, 'checkOut'])
            ->name('user.attendance.check-out');

        Route::get('/riwayat-absensi', [UserAttendanceController::class, 'history'])
            ->name('user.attendance.history');

    });


/*
|--------------------------------------------------------------------------
| Admin
|--------------------------------------------------------------------------
|
| Admin dan Super Admin dapat mengakses:
| - Dashboard Admin
| - Kelola User
| - Formasi
|
*/

Route::middleware(['auth', 'role:admin,superadmin'])
    ->prefix('admin')
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])
            ->name('admin.dashboard');


        Route::get('/attendances', [AdminAttendanceController::class, 'index'])
            ->name('admin.attendances.index');

        // Kelola User
        Route::resource('users', UserController::class)
            ->except(['show'])
            ->names('admin.users');


        // Formasi
        Route::resource('formations', FormationController::class)
            ->except(['show'])
            ->names('admin.formations');

    });


/*
|--------------------------------------------------------------------------
| Super Admin
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:superadmin'])
    ->prefix('superadmin')
    ->group(function () {

        Route::get('/dashboard', [SuperAdminDashboardController::class, 'index'])
            ->name('superadmin.dashboard');

    });