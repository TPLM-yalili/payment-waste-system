<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
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

    // Super admin handler
    public function superAdminDashboard()
    {
        $admins = User::where('role', 'admin')->get();
        return view('admin.super-admin.index', compact('admins'));
    }

    public function superAdminInfo()
    {
        return view('admin.super-admin.info');
    }

    public function deleteAdmin($id)
    {
        $admin = User::findOrFail($id);
        $admin->delete();

        return redirect()->route('super.admin.dashboard')->with('success', 'Admin berhasil dihapus!');
    }

    public function storeAdmin(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:users,username',
            'name' => 'required',
            'password' => 'required|min:6',
        ]);

        User::create([
            'username' => $request->username,
            'name' => $request->name,
            'email' => '',
            'password' => bcrypt($request->password),
            'role' => 'admin',
        ]);

        return redirect()->route('super.admin.dashboard')->with('success', 'Admin berhasil ditambahkan!');
    }

    public function updateSuperAdminInfo(Request $request)
    {
        $user = Auth::user(); // Mendapatkan data pengguna yang sedang login

        $request->validate([
            'username' => 'required|string|unique:users,username,' . $user->id, // Unique kecuali untuk user saat ini
            'name' => 'required|string|max:255',
            'password' => 'nullable|min:6', // Boleh kosong jika tidak ingin mengganti password
        ]);

        $user->update([
            'username' => $request->username,
            'name' => $request->name,
        ]);

        return redirect()->route('super.admin.info')->with('success', 'Info akun berhasil diperbarui!');
    }

    public function updatePassword(Request $request)
    {
        $user = Auth::user(); // Mendapatkan pengguna yang sedang login

        // Validasi data yang dikirimkan
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ]);

        // Verifikasi password lama
        if (!Hash::check($request->current_password, $user->password)) {
            throw ValidationException::withMessages([
                'current_password' => 'Password lama salah.',
            ]);
        }

        // Update password
        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        return redirect()->back()->with('success', 'Password berhasil diubah.');
    }



    // Admin handler
    public function adminDashboard()
    {
        return view('admin.index'); // Dashboard khusus admin
    }
}
