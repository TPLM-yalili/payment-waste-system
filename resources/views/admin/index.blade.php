<x-admin-layout>
    <div class="flex">
        <!-- Sidebar Component -->
        <x-admin-sidebar />

        <!-- Main Content Area -->
        <div class="flex-1 bg-gray-100 p-4">

            <!-- Cards Section -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mt-6">
                <!-- Pending Invoices Card -->
                <div class="bg-white p-6 shadow-md rounded-lg">
                    <h2 class="text-xl font-semibold text-gray-700">Pending Invoices</h2>
                    <p class="text-2xl font-bold text-blue-600 mt-2">{{ $pendingInvoicesCount }}</p>
                </div>

                <!-- Users Count Card -->
                <div class="bg-white p-6 shadow-md rounded-lg">
                    <h2 class="text-xl font-semibold text-gray-700">Total Users</h2>
                    <p class="text-2xl font-bold text-green-600 mt-2">{{ $usersCount }}</p>
                </div>

                <!-- Unverified Users Count Card -->
                <div class="bg-white p-6 shadow-md rounded-lg">
                    <h2 class="text-xl font-semibold text-gray-700">Unverified Users</h2>
                    <p class="text-2xl font-bold text-yellow-600 mt-2">{{ $unverifiedUsersCount }}</p>
                </div>

                <!-- Paid Invoices Amount Card -->
                <div class="bg-white p-6 shadow-md rounded-lg">
                    <h2 class="text-xl font-semibold text-gray-700">Total Paid Invoices</h2>
                    <p class="text-2xl font-bold text-red-600 mt-2">Rp
                        {{ number_format($paidInvoicesAmount, 2, ',', '.') }}
                    </p>
                </div>
            </div>

            <!-- Tabel Invoices -->
            <h1 class="text-2xl font-semibold mb-6 mt-8">Daftar Invoices Pending</h1>
            <div class="bg-white shadow-md rounded-lg p-6">
                <table id="invoices-table" class="stripe hover text-sm w-full">
                    <thead>
                        <tr class="bg-gray-100 text-gray-600 uppercase text-sm leading-normal">
                            <th class="py-3 px-4 text-left">#</th>
                            <th class="py-3 px-4 text-left">User</th>
                            <th class="py-3 px-4 text-left">Amount</th>
                            <th class="py-3 px-4 text-left">Status</th>
                            <th class="py-3 px-4 text-left">Jatuh Tempo</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pendingInvoices as $invoice)
                        <tr class="border-b border-gray-200 hover:bg-gray-50">
                            <td class="py-3 px-4 text-left">{{ $loop->iteration }}</td>
                            <td class="py-3 px-4 text-left">{{ $invoice->user->name }}</td>
                            <td class="py-3 px-4 text-left">Rp {{ number_format($invoice->amount, 2, ',', '.') }}</td>
                            <td class="py-3 px-4 text-left text-yellow-500">{{ ucfirst($invoice->status) }}</td>
                            <td class="py-3 px-4 text-left">{{ $invoice->due_date }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
    $(document).ready(function() {
        $('#invoices-table').DataTable({
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