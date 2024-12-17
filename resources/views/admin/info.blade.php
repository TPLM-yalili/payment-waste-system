<x-admin-layout>
    <div class="flex">
        <!-- Sidebar Component -->
        @include('components.admin-sidebar')

        <!-- Main Content Area -->
        <div class="flex-1 bg-gray-100 p-4">

            @include('layouts.navigation')

            {{-- Form Info Akun Admin --}}
            <form action="{{ route('admin.update') }}" method="POST" class="space-y-6">
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
            <form action="{{ route('admin.password.update') }}" method="POST" class="space-y-6">
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
</x-admin-layout>