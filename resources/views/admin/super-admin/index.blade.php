<x-admin-layout title="Admin Dashboard">
    @section('title', 'Super Admin')
    
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
                        <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
        
                        <a href="#" class="logout-link mt-4" onclick="event.preventDefault(); 
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

            <!-- Admin Table -->
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

                        <!-- Edit Admin Modal -->
                        <div id="edit-modal-{{ $admin->id }}"
                            class="fixed top-0 left-0 w-full h-full bg-black bg-opacity-50 hidden flex justify-center items-center">
                            <div class="bg-white p-8 rounded shadow-lg w-full max-w-md">
                                <h2 class="text-xl font-bold mb-6">Edit Admin</h2>
                                <form action="{{ route('admin.update', $admin->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="mb-4">
                                        <label for="username"
                                            class="block text-sm font-medium text-gray-700">Username:</label>
                                        <input type="text" id="username" name="username"
                                            class="w-full border border-gray-300 rounded p-3"
                                            value="{{ $admin->username }}" required />
                                    </div>
                                    <div class="mb-4">
                                        <label for="password"
                                            class="block text-sm font-medium text-gray-700">Password:</label>
                                        <input type="password" id="password-{{ $admin->id }}" name="password"
                                            class="w-full border border-gray-300 rounded p-3" />
                                        <button type="button" class="mt-2 text-blue-500 hover:text-blue-600"
                                            onclick="togglePasswordVisibility('{{ $admin->id }}')">
                                            Preview
                                        </button>
                                    </div>
                                    <div class="flex justify-end">
                                        <button type="submit"
                                            class="px-6 py-2 bg-green-500 text-white rounded hover:bg-green-600">Simpan</button>
                                        <button type="button"
                                            class="ml-4 px-6 py-2 bg-gray-300 rounded hover:bg-gray-400"
                                            onclick="document.getElementById('edit-modal-{{ $admin->id }}').classList.add('hidden')">Tutup</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        @endforeach
                    </tbody>
                </table>
            </div>

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
                            <button type="button" class="mt-2 text-blue-500 hover:text-blue-600"
                                onclick="togglePasswordVisibility('password')">
                                Preview
                            </button>
                        </div>
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
    // Toggle Password Visibility
    function togglePasswordVisibility(id) {
        var passwordField = document.getElementById('password-' + id);
        var passwordText = document.getElementById('password-' + id + '-text');

        if (passwordField.type === "password") {
            passwordField.type = "text";
            passwordText.innerHTML = passwordField.value; // Show password text
        } else {
            passwordField.type = "password";
        }
    }
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
    </script>
</x-admin-layout>