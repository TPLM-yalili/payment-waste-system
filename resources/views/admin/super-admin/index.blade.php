<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Super Admin Dashboard</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .modal {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            padding: 20px;
            background: white;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            z-index: 101; /* Pastikan modal berada di atas overlay */
        }

        .modal.active {
            display: block;
        }

        .overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 100; /* Overlay di bawah modal */
        }

        .overlay.active {
            display: block;
        }
    </style>
</head>

<body>
    <h1>Dashboard Super Admin</h1>
    <ul>
        <li><a href="#">Dashboard</a></li>
        <li><a href="/admin/super-admin/info">Account Info</a></li>
    </ul>
    <p>Selamat datang, {{ Auth::user()->username }}</p>

    {{-- Tabel daftar admin --}}
    <h2>Daftar Admin</h2>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Username</th>
                <th>Nama</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @php $no = 1; @endphp
            @foreach ($admins as $admin)
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $admin->username }}</td>
                    <td>{{ $admin->name }}</td>
                    <td>
                        <form action="{{ route('admin.delete', $admin->id) }}" method="POST"
                            style="display: inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                onclick="return confirm('Yakin ingin menghapus admin ini?')">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{-- Button untuk membuka modal --}}
    <button id="open-modal">Tambah Admin</button>

    {{-- Modal untuk tambah admin --}}
    <div id="modal" class="modal">
        <h2>Tambah Admin</h2>
        <form action="{{ route('admin.store') }}" method="POST">
            @csrf
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            <br>
            <label for="name">Nama:</label>
            <input type="text" id="name" name="name" required>
            <br>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <br>
            <button type="submit">Simpan</button>
        </form>
        <button id="close-modal">Tutup</button>
    </div>

    {{-- Overlay --}}
    <div id="overlay" class="overlay"></div>

    {{-- Logout --}}
    <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
    <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>

    <script>
        // Script untuk mengatur modal
        const modal = document.getElementById('modal');
        const overlay = document.getElementById('overlay');
        const openModalButton = document.getElementById('open-modal');
        const closeModalButton = document.getElementById('close-modal');

        openModalButton.addEventListener('click', () => {
            modal.classList.add('active');
            overlay.classList.add('active');
        });

        closeModalButton.addEventListener('click', () => {
            modal.classList.remove('active');
            overlay.classList.remove('active');
        });

        overlay.addEventListener('click', () => {
            modal.classList.remove('active');
            overlay.classList.remove('active');
        });
    </script>
</body>

</html>
