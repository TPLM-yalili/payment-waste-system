<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\AdminController;
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
    Route::get('/login', [AdminController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [AdminController::class, 'login'])->name('admin.login.submit');

    // Super Admin
    Route::middleware(['auth'])->group(function () {
        Route::get('/super-admin', [AdminController::class, 'superAdminDashboard'])->name('super.admin.dashboard');
    })->middleware((RoleMiddleware::class.':super admin'));
    
    Route::middleware(['auth'])->group(function () {
        Route::get('/super-admin/info', [AdminController::class, 'superAdminInfo'])->name('super.admin.info');
    })->middleware((RoleMiddleware::class.':super admin'));

    Route::delete('/admin/{id}/delete', [AdminController::class, 'deleteAdmin'])->name('admin.delete');
    Route::post('/admin/store', [AdminController::class, 'storeAdmin'])->name('admin.store');
    Route::put('/admin/super-admin/info', [AdminController::class, 'updateSuperAdminInfo'])->name('super.admin.update');
    Route::put('/admin/super-admin/password', [AdminController::class, 'updatePassword'])->name('super.admin.password.update');

    // Admin 
    Route::middleware(['auth'])->group(function () {
        Route::get('/admin', [AdminController::class, 'adminDashboard'])->name('admin.dashboard');
    })->middleware((RoleMiddleware::class.':admin'));

    Route::middleware(['auth'])->group(function () {
        Route::get('/admin/info', [AdminController::class, 'adminInfo'])->name('admin.info');
    })->middleware((RoleMiddleware::class.':admin'));

    Route::post('/logout', function () {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();
        return redirect('/admin/login');
    })->name('admin.logout');
    
});


require __DIR__.'/auth.php';
