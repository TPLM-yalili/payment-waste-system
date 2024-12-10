<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AdminController extends Controller
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

        // Autentikasi menggunakan guard admin
        if (Auth::guard('admin')->attempt($credentials)) {
            $admin = Auth::guard('admin')->user();

            // Redirect berdasarkan role
            if ($admin->role === 'super admin') {
                return redirect()->route('super.admin.dashboard');
            } elseif ($admin->role === 'admin') {
                return redirect()->route('admin.dashboard');
            }

            // Logout jika role tidak valid
            Auth::guard('admin')->logout();
            return redirect()->route('admin.login')->withErrors('Akun ini tidak memiliki akses.');
        }

        return back()->withErrors('Username atau password salah.');
    }




    public function redirectToDashboard()
    {
        $user = Auth::guard('admin')->user();

        if ($user->role === 'super admin') {
            return redirect()->route('super.admin.dashboard');
        } elseif ($user->role === 'admin') {
            return redirect()->route('admin.dashboard.admin');
        }

        abort(403, 'Unauthorized access.');
    }

    // Super admin handler
    public function superAdminDashboard()
    {
        $admins = Admin::where('role', 'admin')->get();
        return view('admin.super-admin.index', compact('admins'));
    }

    public function superAdminInfo()
    {
        return view('admin.super-admin.info');
    }

    public function deleteAdmin($id)
    {
        $admin = Admin::findOrFail($id);
        $admin->delete();

        return redirect()->route('super.admin.dashboard')->with('success', 'Admin berhasil dihapus!');
    }

    public function storeAdmin(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:admins,username',
            'password' => 'required|min:6',
        ]);

        Admin::create([
            'username' => $request->username,
            'password' => bcrypt($request->password),
            'role' => 'admin',
        ]);

        return redirect()->route('super.admin.dashboard')->with('success', 'Admin berhasil ditambahkan!');
    }

    public function updateSuperAdminInfo(Request $request)
    {
        $user = Auth::guard('admin')->user();

        $request->validate([
            'username' => 'required|string|unique:admins,username,' . $user->id,
        ]);

        $user->update([
            'username' => $request->username,
        ]);

        return redirect()->route('super.admin.info')->with('success', 'Info akun berhasil diperbarui!');
    }

    public function updatePassword(Request $request)
    {
        $user = Auth::guard('admin')->user();

        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ]);

        if (!Hash::check($request->current_password, $user->password)) {
            throw ValidationException::withMessages([
                'current_password' => 'Password lama salah.',
            ]);
        }

        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        return redirect()->back()->with('success', 'Password berhasil diubah.');
    }



    public function adminDashboard()
    {
        return view('admin.index'); // Dashboard khusus admin
    }
}
