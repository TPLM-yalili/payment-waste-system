<?php


use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\Auth\PostRegisterController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\RoleMiddleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Artisan;
use App\Models\Invoice;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $invoices = Invoice::where('user_id', auth()->id())->get();
    return view('dashboard', compact('invoices'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Post register
    Route::get('/auth/post-register', [PostRegisterController::class, 'index'])->name('post-register');
    Route::post('/auth/post-register', [PostRegisterController::class, 'update']);

    Route::get('/dashboard', [InvoiceController::class, 'index'])->name('dashboard');
    Route::get('/invoice/pay/{invoiceId}', [InvoiceController::class, 'payInvoice'])->name('invoice.pay');
    Route::get('/payment/success', [InvoiceController::class, 'paymentSuccess'])->name('payment.success');
    Route::get('/payment/failed', [InvoiceController::class, 'paymentFailed'])->name('payment.failed');
    Route::get('/payment/pending', [InvoiceController::class, 'paymentPending'])->name('payment.pending');
    Route::post('/midtrans/webhook', [InvoiceController::class, 'handleMidtransWebhook']);
    // web.php
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
});

Route::prefix('auth')->group(function () {
    // Google Login
    Route::get('/google', [GoogleController::class, 'redirect'])->name('google.login');
    Route::get('/google/callback', [GoogleController::class, 'callback']);
});

Route::prefix('admin')->group(function () {
    Route::get('/login', [AdminController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [AdminController::class, 'login'])->name('admin.login.submit');

    // Super Admin 
    Route::middleware(['auth:admin', RoleMiddleware::class . ':super admin'])->group(function () {
        Route::get('/super-admin', [AdminController::class, 'superAdminDashboard'])->name('super.admin.dashboard');
        Route::get('/super-admin/info', [AdminController::class, 'superAdminInfo'])->name('super.admin.info');
        Route::delete('/admin/{id}/delete', [AdminController::class, 'deleteAdmin'])->name('admin.delete');
        Route::put('/admin/{admin}', [AdminController::class, 'update'])->name('admin.update');
        Route::post('/admin/store', [AdminController::class, 'storeAdmin'])->name('admin.store');
        Route::put('/admin/super-admin/info', [AdminController::class, 'updateSuperAdminInfo'])->name('super.admin.update');
        Route::put('/admin/super-admin/password', [AdminController::class, 'updatePassword'])->name('super.admin.password.update');
    });

    // Admin 
    Route::middleware(['auth:admin', RoleMiddleware::class . ':admin'])->group(function () {
        Route::get('/', [AdminController::class, 'adminDashboard'])->name('admin.dashboard');
        Route::get('/info', [AdminController::class, 'adminInfo'])->name('admin.info');
        Route::get('/users-list', [AdminController::class, 'adminUsersList'])->name('admin.users-list');
        Route::get('/bills', [AdminController::class, 'adminBills'])->name('admin.bills');
        // Route for generating invoices
        Route::post('/generate-invoices', [InvoiceController::class, 'generateInvoices'])->name('generate.invoices');
        Route::put('/info', [AdminController::class, 'updateAdminInfo'])->name('admin.update');
        Route::put('/password', [AdminController::class, 'updatePassword'])->name('admin.password.update');
    });

    Route::post('/logout', function () {
        Auth::guard('admin')->logout(); // Logout menggunakan guard admin
        session()->invalidate();
        session()->regenerateToken();
        return redirect('/admin/login');
    })->name('admin.logout');
});


require __DIR__ . '/auth.php';