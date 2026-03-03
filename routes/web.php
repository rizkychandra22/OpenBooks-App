<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Websites\Homepage;
use Illuminate\Support\Facades\Route;

// Website Books
Route::get('/', [Homepage::class, 'blogIndex'])->name('homepage');

// Route untuk Guest (Hanya bisa diakses jika BELUM login)
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'authenticate']);
    Route::get('/register', [LoginController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [LoginController::class, 'register'])->name('register.store');
});

// Route Logout (Hanya bisa diakses jika SUDAH login)
Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// Route Role Admin
Route::middleware('role:admin')->group(function () {
    Route::get('/admin/dashboard', [DashboardController::class, 'indexAdmin'])->name('adminDashboard');
});

// Route Role Member
Route::middleware('role:member')->group(function () {
    Route::get('/user/dashboard', [DashboardController::class, 'indexMember'])->name('userDashboard');
});

