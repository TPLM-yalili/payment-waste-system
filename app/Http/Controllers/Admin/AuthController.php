<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.login'); // Tampilkan halaman login
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            // Redirect berdasarkan role
            if ($user->role === 'super admin') {
                return redirect()->route('super.admin.dashboard');
            } elseif ($user->role === 'admin') {
                return redirect()->route('admin.dashboard');
            }

            // Logout jika role tidak valid
            Auth::logout();
            return redirect()->route('admin.login')->withErrors('Akun ini tidak memiliki akses.');
        }

        return back()->withErrors('Username atau password salah.');
    }


    public function redirectToDashboard()
    {
        $user = Auth::user();

        if ($user->role === 'super admin') {
            return redirect()->route('super.admin.dashboard');
        } elseif ($user->role === 'admin') {
            return redirect()->route('admin.dashboard.admin');
        }

        abort(403, 'Unauthorized access.');
    }

    public function superAdminDashboard()
    {
        return view('admin.super-admin-dashboard'); // Dashboard khusus super admin
    }

    public function adminDashboard()
    {
        return view('admin.admin-dashboard'); // Dashboard khusus admin
    }
}
