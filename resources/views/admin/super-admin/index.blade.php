<x-admin-layout title="Admin Dashboard">
    <div class="flex h-screen bg-gray-100 text-black">
        <!-- Sidebar -->
        <div class="w-64 bg-blue-100 shadow-lg">
            <!-- Logo Section -->
            <div class="flex items-center justify-center py-6">
                <span class="text-xl font-bold text-gray-800">Kapays</span>
            </div>

            <!-- User Section -->
            <div class="px-4 py-3 bg-blue-200 mx-4 rounded flex justify-between items-center">
                <span class="font-semibold">Super Admin</span>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </div>

            <!-- Navigation Menu -->
            <nav class="mt-6 px-4">
                <ul class="space-y-3">
                    <li
                        class="text-gray-700 hover:bg-blue-300 px-4 py-3 rounded cursor-pointer bg-blue-200 font-semibold">
                        Dashboard</li>
                    <li class="text-gray-700 hover:bg-blue-300 px-4 py-3 rounded cursor-pointer">
                        <a href="{{ route('super.admin.info') }}">Super Admin Info</a>
                    </li>
                    <li class="text-gray-700 hover:bg-blue-300 px-4 py-3 rounded cursor-pointer">
                        <form id="logout-form" action="{{ route('admin.logout') }}" method="POST"
                            style="display: none;">
                            @csrf
                        </form>

                        <a href="#" class="logout-link mt-4"
                            onclick="event.preventDefault(); 
                            $('#logout-form').submit();">
                            Logout
                        </a>
                    </li>
                </ul>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1 px-8 py-6 bg-white">
            <h1 class="text-2xl font-bold my-6">Super Admin Dashboard</h1>

            <!-- Success or Error message -->
            <x-success-alert />
            <x-error-alert />

            @if ($errors->has('username_error'))
                <div role="alert" class="alert alert-error my-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 stroke-current" fill="none"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>{{ $errors->first('username_error') }}</span>
                </div>
            @endif

            @if ($errors->has('password_error'))
                <div role="alert" class="alert alert-error my-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 stroke-current" fill="none"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>{{ $errors->first('password_error') }}</span>
                </div>
            @endif

            <!-- Cards Section -->
            <div class="grid grid-cols-3 gap-6 mb-8">
                <div class="p-6 bg-white rounded shadow">
                    <h2 class="text-lg font-bold">Jumlah Admin</h2>
                    <p class="text-3xl mt-4 font-semibold text-blue-600">{{ $adminCount }}</p>
                </div>
                <div class="p-6 bg-white rounded shadow">
                    <h2 class="text-lg font-bold">Jumlah Pengguna</h2>
                    <p class="text-3xl mt-4 font-semibold text-blue-600">{{ $userCount }}</p>
                </div>
            </div>

            <!-- Tabel Admin -->
            <h1 class="text-2xl font-semibold mb-6 mt-8">Daftar Admin</h1>
            <div class="bg-white shadow-md rounded-lg p-6">
                <table id="admin-list-table" class="stripe hover text-sm w-full">
                    <thead>
                        <tr class="bg-gray-100 text-gray-600 uppercase text-sm leading-normal">
                            <th class="py-3 px-4 text-left">#</th>
                            <th class="py-3 px-4 text-left">Username</th>
                            <th class="py-3 px-4 text-left">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($admins as $admin)
                            <tr class="border-b border-gray-200 hover:bg-gray-50">
                                <td class="py-3 px-4 text-left">{{ $loop->iteration }}</td>
                                <td class="py-3 px-4 text-left">{{ $admin->username }}</td>
                                <td class="py-3 px-4 text-left">
                                    <!-- Edit Button -->
                                    <button class="btn btn-ghost hover:text-yellow-600 mb-2"
                                        data-id="{{ $admin->id }}" data-username="{{ $admin->username }}"
                                        onclick="openEditModal(this)">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                            class="size-5">
                                            <path
                                                d="m5.433 13.917 1.262-3.155A4 4 0 0 1 7.58 9.42l6.92-6.918a2.121 2.121 0 0 1 3 3l-6.92 6.918c-.383.383-.84.685-1.343.886l-3.154 1.262a.5.5 0 0 1-.65-.65Z" />
                                            <path
                                                d="M3.5 5.75c0-.69.56-1.25 1.25-1.25H10A.75.75 0 0 0 10 3H4.75A2.75 2.75 0 0 0 2 5.75v9.5A2.75 2.75 0 0 0 4.75 18h9.5A2.75 2.75 0 0 0 17 15.25V10a.75.75 0 0 0-1.5 0v5.25c0 .69-.56 1.25-1.25 1.25h-9.5c-.69 0-1.25-.56-1.25-1.25v-9.5Z" />
                                        </svg>
                                        Edit
                                    </button>
                                    <!-- Delete Button -->
                                    <form action="{{ route('admin.delete', $admin->id) }}" method="POST"
                                        class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-ghost hover:text-error mt-2"
                                            onclick="return confirm('Yakin ingin menghapus admin ini?')">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                fill="currentColor" class="size-6">
                                                <path fill-rule="evenodd"
                                                    d="M5.47 5.47a.75.75 0 0 1 1.06 0L12 10.94l5.47-5.47a.75.75 0 1 1 1.06 1.06L13.06 12l5.47 5.47a.75.75 0 1 1-1.06 1.06L12 13.06l-5.47 5.47a.75.75 0 0 1-1.06-1.06L10.94 12 5.47 6.53a.75.75 0 0 1 0-1.06Z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Modal -->
            <div id="edit-modal"
                class="fixed top-0 left-0 w-full h-full bg-black bg-opacity-50 hidden flex justify-center items-center">
                <div class="bg-white p-8 rounded shadow-lg w-full max-w-md">
                    <h2 class="text-xl font-bold mb-6">Edit Admin</h2>
                    <form id="edit-form" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-4">
                            <label for="edit-username" class="block text-sm font-medium text-gray-700">Username:</label>
                            <input type="text" id="edit-username" name="username"
                                class="w-full border border-gray-300 rounded p-3" required />
                        </div>
                        <div class="mb-4">
                            <label for="edit-password"
                                class="block text-sm font-medium text-gray-700">Password:</label>
                            <input type="password" id="edit-password" name="password"
                                class="w-full border border-gray-300 rounded p-3" />
                        </div>
                        <div class="flex justify-end">
                            <button type="submit"
                                class="px-6 py-2 bg-green-500 text-white rounded hover:bg-green-600">Simpan</button>
                            <button type="button" class="ml-4 px-6 py-2 bg-gray-300 rounded hover:bg-gray-400"
                                onclick="closeEditModal()">Tutup</button>
                        </div>
                    </form>
                </div>
            </div>
            {{-- <!-- Admin Table -->
            <div class="overflow-x-auto">
                <table class="w-full border-collapse border border-gray-300 bg-white rounded shadow">
                    <thead class="bg-gray-200">
                        <tr>
                            <th class="border border-gray-300 p-4 text-left">No</th>
                            <th class="border border-gray-300 p-4 text-left">Username</th>
                            <th class="border border-gray-300 p-4 text-left">Password</th>
                            <th class="border border-gray-300 p-4 text-left">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $no = 1; @endphp
                        @foreach ($admins as $admin)
                        <tr class="hover:bg-gray-100">
                            <td class="border border-gray-300 p-4">{{ $no++ }}</td>
                            <td class="border border-gray-300 p-4">{{ $admin->username }}</td>
                            <td class="border border-gray-300 p-4">
                                <span id="password-{{ $admin->id }}" class="password-text">**********</span>
                                <button type="button" class="text-blue-500 hover:text-blue-600 ml-2"
                                    onclick="togglePasswordVisibility('{{ $admin->id }}')">
                                    Preview
                                </button>
                            </td>
                            <td class="border border-gray-300 p-4 flex items-center space-x-4">
                                <!-- Edit Button -->
                                <a href="#" class="btn btn-ghost hover:text-yellow-600"
                                    onclick="document.getElementById('edit-modal-{{ $admin->id }}').classList.remove('hidden')">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                        class="size-5">
                                        <path
                                            d="m5.433 13.917 1.262-3.155A4 4 0 0 1 7.58 9.42l6.92-6.918a2.121 2.121 0 0 1 3 3l-6.92 6.918c-.383.383-.84.685-1.343.886l-3.154 1.262a.5.5 0 0 1-.65-.65Z" />
                                        <path
                                            d="M3.5 5.75c0-.69.56-1.25 1.25-1.25H10A.75.75 0 0 0 10 3H4.75A2.75 2.75 0 0 0 2 5.75v9.5A2.75 2.75 0 0 0 4.75 18h9.5A2.75 2.75 0 0 0 17 15.25V10a.75.75 0 0 0-1.5 0v5.25c0 .69-.56 1.25-1.25 1.25h-9.5c-.69 0-1.25-.56-1.25-1.25v-9.5Z" />
                                    </svg>
                                </a>

                                <!-- Delete Button -->
                                <form action="{{ route('admin.delete', $admin->id) }}" method="POST"
                                    class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-ghost hover:text-error"
                                        onclick="return confirm('Yakin ingin menghapus admin ini?')">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                            class="size-6">
                                            <path fill-rule="evenodd"
                                                d="M5.47 5.47a.75.75 0 0 1 1.06 0L12 10.94l5.47-5.47a.75.75 0 1 1 1.06 1.06L13.06 12l5.47 5.47a.75.75 0 1 1-1.06 1.06L12 13.06l-5.47 5.47a.75.75 0 0 1-1.06-1.06L10.94 12 5.47 6.53a.75.75 0 0 1 0-1.06Z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </form>
                            </td>
                        </tr>

                        
                    </tbody>
                </table>
            </div> --}}

            <!-- Add Admin Button -->
            <div class="mt-6">
                <button id="open-modal" class="px-6 py-3 bg-blue-500 text-white rounded hover:bg-blue-600">Tambah
                    Admin</button>
            </div>

            <!-- Add Admin Modal -->
            <div id="modal"
                class="fixed top-0 left-0 w-full h-full bg-black bg-opacity-50 hidden flex justify-center items-center">
                <div class="bg-white p-8 rounded shadow-lg w-full max-w-md">
                    <h2 class="text-xl font-bold mb-6">Tambah Admin</h2>
                    <form action="{{ route('admin.store') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="username" class="block text-sm font-medium text-gray-700">Username:</label>
                            <input type="text" id="username" name="username"
                                class="w-full border border-gray-300 rounded p-3" required />
                        </div>
                        <div class="mb-4">
                            <label for="password" class="block text-sm font-medium text-gray-700">Password:</label>
                            <input type="password" id="password" name="password"
                                class="w-full border border-gray-300 rounded p-3" required />
                            <!--
                                Button tidak berfungsi

                            <button type="button" class="mt-2 text-blue-500 hover:text-blue-600"
                                onclick="togglePasswordVisibility('password')">
                                Preview
                            </button>
                            -->
                        </div>

                        <!--
                        <div class="mb-6">
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm
                                Password:</label>
                            <input type="password" id="password_confirmation" name="password_confirmation"
                                class="w-full border border-gray-300 rounded p-3" required />
                            <button type="button" class="mt-2 text-blue-500 hover:text-blue-600"
                                onclick="togglePasswordVisibility('password_confirmation')">
                                Preview
                            </button>
                        </div>
                        -->

                        <div class="flex justify-end">
                            <button type="submit"
                                class="px-6 py-2 bg-green-500 text-white rounded hover:bg-green-600">Simpan</button>
                            <button type="button" id="close-modal"
                                class="ml-4 px-6 py-2 bg-gray-300 rounded hover:bg-gray-400">Tutup</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Gak berfungsi
        // 
        // Toggle Password Visibility
        // function togglePasswordVisibility(id) {
        //     var passwordField = document.getElementById('password-' + id);
        //     var passwordText = document.getElementById('password-' + id + '-text');

        //     if (passwordField.type === "password") {
        //         passwordField.type = "text";
        //         passwordText.innerHTML = passwordField.value; // Show password text
        //     } else {
        //         passwordField.type = "password";
        //     }
        // }

        // Open Modal
        document.getElementById('open-modal').addEventListener('click', function() {
            document.getElementById('modal').classList.remove('hidden');
        });

        // Close Modal
        document.getElementById('close-modal').addEventListener('click', function() {
            document.getElementById('modal').classList.add('hidden');
        });

        // Close Modal on Outside Click
        document.getElementById('modal').addEventListener('click', function(e) {
            if (e.target === this) {
                this.classList.add('hidden');
            }
        });

        function openEditModal(button) {
            // Ambil data dari atribut data-*
            const id = button.getAttribute('data-id');
            const username = button.getAttribute('data-username');

            // Isi form modal dengan data
            document.getElementById('edit-username').value = username;

            // Atur action URL form
            const editForm = document.getElementById('edit-form');
            editForm.action = `/admin/admin/${id}`;

            // Tampilkan modal
            document.getElementById('edit-modal').classList.remove('hidden');
        }

        function closeEditModal() {
            // Sembunyikan modal
            document.getElementById('edit-modal').classList.add('hidden');
        }

        $(document).ready(function() {
            $('#admin-list-table').DataTable({
                responsive: true,
                language: {
                    url: "//cdn.datatables.net/plug-ins/1.13.5/i18n/id.json"
                },
                pagingType: "simple_numbers", // Gaya pagination
                lengthMenu: [
                    [10, 25, 50, -1],
                    [10, 25, 50, "All"]
                ],
                columnDefs: [{
                        targets: [0],
                        orderable: false
                    }, // Kolom pertama tidak dapat diurutkan
                ],
            });
        });
    </script>
</x-admin-layout>
