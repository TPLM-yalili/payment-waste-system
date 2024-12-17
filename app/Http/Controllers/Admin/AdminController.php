<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use App\Models\User;
use App\Models\Invoice;
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
        // Menghitung jumlah admin dan jumlah pengguna
        $adminCount = Admin::count();
        $userCount = User::count();

        // Mengambil data admin untuk tabel
        $admins = Admin::where('role', 'admin')->get();

        return view('admin.super-admin.index', compact('adminCount', 'userCount', 'admins'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'username' => 'required|string|max:255',
            'password' => 'nullable|string|min:6|confirmed', // Pastikan password di-validasi
        ]);
    
        $admin = Admin::findOrFail($id);
        $admin->username = $request->input('username');
    
        if ($request->filled('password')) {
            $admin->password = bcrypt($request->input('password')); // Enkripsi password
        }
    
        $admin->save();

        return redirect()->route('super.admin.dashboard')->with('success', 'Admin updated successfully');
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

    public function updateAdminInfo(Request $request, $redirectRoute = 'admin.info')
    {
        $user = Auth::guard('admin')->user();

        $request->validate([
            'username' => 'required|string|unique:admins,username,' . $user->id,
        ]);

        $user->update([
            'username' => $request->username,
        ]);

        return redirect()->route($redirectRoute)->with('success', 'Info akun berhasil diperbarui!');
    }

    public function updateSuperAdminInfo(Request $request)
    {
        return $this->updateAdminInfo($request, 'super.admin.info');
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
        $pendingInvoicesCount = Invoice::where('status', 'pending')->count();

        // Mengambil jumlah pengguna
        $usersCount = User::count();
        
        // Mengambil jumlah pengguna yang belum terverifikasi
        $unverifiedUsersCount = User::where('is_verified', false)->count();

        // Mengambil total amount dari invoices yang terbayar
        $paidInvoicesAmount = Invoice::where('status', 'paid')->sum('amount');

        $pendingInvoices = Invoice::where('status', 'pending')->get();

        return view('admin.index', [
            'pendingInvoicesCount' => $pendingInvoicesCount,
            'usersCount' => $usersCount,
            'unverifiedUsersCount' => $unverifiedUsersCount,
            'paidInvoicesAmount' => $paidInvoicesAmount,
            'pendingInvoices' => $pendingInvoices,
        ]); // Dashboard khusus admin
    }

    public function adminInfo()
    {
        return view('admin.info');
    }

    public function adminUsersList()
    {
        $users = User::all();
        return view('admin.users-list', ['users' => $users]);
    }

    public function adminBills()
    {
        return view('admin.bills');
    }
}
