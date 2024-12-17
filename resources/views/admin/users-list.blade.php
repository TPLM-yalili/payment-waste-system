<x-admin-layout>
    <div class="flex">
        <!-- Sidebar Component -->
        @include('components.admin-sidebar')

        <!-- Main Content Area -->
        <div class="flex-1 bg-gray-100 p-4">

            @include('layouts.navigation')

            <!-- Tabel Invoices -->
            <h1 class="text-2xl font-semibold mb-6 mt-8">Daftar User terdaftar</h1>
            <div class="bg-white shadow-md rounded-lg p-6">
                <table id="users-table" class="stripe hover text-sm w-full">
                    <thead>
                        <tr class="bg-gray-100 text-gray-600 uppercase text-sm leading-normal">
                            <th class="py-3 px-4 text-left">#</th>
                            <th class="py-3 px-4 text-left">Name</th>
                            <th class="py-3 px-4 text-left">Email</th>
                            <th class="py-3 px-4 text-left">No KK</th>
                            <th class="py-3 px-4 text-left">No WhatsApp</th>
                            <th class="py-3 px-4 text-left">Status</th>
                            <th class="py-3 px-4 text-left">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr class="border-b border-gray-200 hover:bg-gray-50">
                                <td class="py-3 px-4 text-left">{{ $loop->iteration }}</td>
                                <td class="py-3 px-4 text-left">{{ $user->name }}</td>
                                <td class="py-3 px-4 text-left">{{ $user->email }}</td>
                                <td class="py-3 px-4 text-left">{{ $user->no_kk }}</td>
                                <td class="py-3 px-4 text-left">{{ $user->no_wa }}</td>
                                <td class="py-3 px-4 text-left">
                                    {{ $user->is_verified ? 'Terverifikasi' : 'Belum Terverifikasi' }}
                                </td>
                                <td class="py-3 px-4 text-left">
                                    @if (!$user->is_verified)
                                        <button class="btn bg-green-400">
                                            verifikasi
                                        </button>
                                    @endif
                                    <button class="btn bg-red-500 text-white">
                                        Hapus
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            $('#users-table').DataTable({
                responsive: true,
                language: {
                    url: "//cdn.datatables.net/plug-ins/1.13.5/i18n/id.json"
                },
                pagingType: "simple_numbers", // Gaya pagination
                lengthMenu: [[ 10, 25, 50, -1], [10, 25, 50, "All"]],
                columnDefs: [
                    { targets: [0], orderable: false }, // Kolom pertama tidak dapat diurutkan
                ],
            });
        });
    </script>
</x-admin-layout>
