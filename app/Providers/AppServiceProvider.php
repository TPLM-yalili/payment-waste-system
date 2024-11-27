<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\User;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (User::where('role', 'super admin')->count() < 1) {
            User::create([
                'name' => 'Super Admin',
                'username' => 'superadmin',
                'email' => '',
                'password' => bcrypt('SuperAdminPW'),
                'role' => 'super admin',
            ]);
        }
    }
}
