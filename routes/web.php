<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\RoleMiddleware;

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
});

Route::prefix('admin')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [AuthController::class, 'login'])->name('admin.login.submit');

    // Super Admin Dashboard
    Route::middleware(['auth'])->group(function () {
        Route::get('/super-admin', [AuthController::class, 'superAdminDashboard'])->name('super.admin.dashboard');
    })->middleware((RoleMiddleware::class.':super admin'));

    // Admin Dashboard
    Route::middleware(['auth'])->group(function () {
        Route::get('/admin', [AuthController::class, 'adminDashboard'])->name('admin.dashboard');
    })->middleware((RoleMiddleware::class.':admin'));

    Route::post('/logout', function () {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();
        return redirect('/admin/login');
    })->name('admin.logout');
    
});


require __DIR__.'/auth.php';
