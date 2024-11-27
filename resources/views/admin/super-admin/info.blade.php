<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Super Admin Info</title>
</head>

<body>
    <h1>Info Akun Super Admin</h1>
    <ul>
        <li><a href="/admin/super-admin">Dashboard</a></li>
        <li><a href="#">Account Info</a></li>
    </ul>
    <p>Selamat datang, {{ Auth::user()->username }}</p>

    {{-- Form Info Akun Super Admin --}}
    <form action="{{ route('super.admin.update') }}" method="POST">
        @csrf
        @method('PUT') {{-- Untuk update data --}}
        <div>
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" placeholder="{{ Auth::user()->username }}"
                value="{{ Auth::user()->username }}" required>
        </div>
        <div>
            <label for="name">Nama:</label>
            <input type="text" id="name" name="name" placeholder="{{ Auth::user()->name }}"
                value="{{ Auth::user()->name }}" required>
        </div>
        <button type="submit">Save Info</button>
    </form>

    <h2>Ubah Password</h2>
    <form action="{{ route('super.admin.password.update') }}" method="POST">
        @csrf
        @method('PUT')
        <div>
            <label for="current_password">Password Lama:</label>
            <input type="password" id="current_password" name="current_password" required
                placeholder="Masukkan password lama">
            @error('current_password')
                <span style="color: red;">{{ $message }}</span>
            @enderror
        </div>
        <div>
            <label for="new_password">Password Baru:</label>
            <input type="password" id="new_password" name="new_password" required placeholder="Masukkan password baru">
            @error('new_password')
                <span style="color: red;">{{ $message }}</span>
            @enderror
        </div>
        <div>
            <label for="new_password_confirmation">Konfirmasi Password Baru:</label>
            <input type="password" id="new_password_confirmation" name="new_password_confirmation" required
                placeholder="Ulangi password baru">
        </div>
        <button type="submit">Ubah Password</button>
    </form>


    {{-- Logout --}}
    <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
    <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
        Logout
    </a>
</body>

</html>
