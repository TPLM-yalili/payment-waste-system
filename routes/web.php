<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\Auth\PostRegisterController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\RoleMiddleware;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Post register
    Route::get('/auth/post-register', [PostRegisterController::class, 'index'])->name('post-register');
    Route::post('/auth/post-register', [PostRegisterController::class, 'update']);
});

Route::prefix('auth')->group(function () {
    // Google Login
    Route::get('/google', [GoogleController::class, 'redirect'])->name('google.login');
    Route::get('/google/callback', [GoogleController::class, 'callback']);
});

Route::prefix('admin')->group(function () {
    Route::get('/login', [AdminController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [AdminController::class, 'login'])->name('admin.login.submit');

    // Super Admin Dashboard
    Route::middleware(['auth'])->group(function () {
        Route::get('/super-admin', [AdminController::class, 'superAdminDashboard'])->name('super.admin.dashboard');
    })->middleware((RoleMiddleware::class . ':super admin'));

    // Admin Dashboard
    Route::middleware(['auth'])->group(function () {
        Route::get('/admin', [AdminController::class, 'adminDashboard'])->name('admin.dashboard');
    })->middleware((RoleMiddleware::class . ':admin'));

    Route::post('/logout', function () {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();
        return redirect('/admin/login');
    })->name('admin.logout');
});


require __DIR__ . '/auth.php';
