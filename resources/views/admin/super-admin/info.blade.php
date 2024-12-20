<x-admin-layout>
    @section('title', 'Edit Profile')
    <div class="flex h-screen bg-gray-100">
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
                    <li class="text-gray-700 hover:bg-blue-300 px-4 py-3 rounded cursor-pointer">
                        <a href="{{ route('super.admin.dashboard') }}">Dashboard</a>
                    </li>
                    <li
                        class="text-gray-700 hover:bg-blue-300 px-4 py-3 rounded cursor-pointer bg-blue-200 font-semibold">
                        Super Admin Info</li>
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
        <div class="flex-1 bg-white">
            <div class="px-8 py-6">
                <h1 class="text-2xl font-bold my-6 pb-6">Info Akun Super Admin</h1>

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

                {{-- Form Info Akun Super Admin --}}
                <form action="{{ route('super.admin.update') }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT') {{-- Untuk update data --}}
                    <div>
                        <label for="username" class="block text-sm font-medium text-gray-700">Username:</label>
                        <input type="text" id="username" name="username" placeholder="{{ Auth::user()->username }}"
                            value="{{ Auth::user()->username }}" required
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                    <button type="submit"
                        class="px-6 py-2 bg-green-500 text-white rounded hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-opacity-50">Save
                        Info</button>
                </form>

                <h2 class="text-xl font-semibold mt-10 mb-4">Ubah Password</h2>
                <form action="{{ route('super.admin.password.update') }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')
                    <div>
                        <label for="current_password" class="block text-sm font-medium text-gray-700">Password
                            Lama:</label>
                        <input type="password" id="current_password" name="current_password" required
                            placeholder="Masukkan password lama"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                        @error('current_password')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label for="new_password" class="block text-sm font-medium text-gray-700">Password Baru:</label>
                        <input type="password" id="new_password" name="new_password" required
                            placeholder="Masukkan password baru"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                        @error('new_password')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label for="new_password_confirmation"
                            class="block text-sm font-medium text-gray-700">Konfirmasi Password Baru:</label>
                        <input type="password" id="new_password_confirmation" name="new_password_confirmation" required
                            placeholder="Ulangi password baru"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                    <button type="submit"
                        class="px-6 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">Ubah
                        Password</button>
                </form>
            </div>
        </div>
    </div>
</x-admin-layout>
