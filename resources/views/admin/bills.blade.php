<x-admin-layout>
    @section('title', 'Tagihan')
    <div class="flex">
        <!-- Sidebar Component -->
        <x-admin-sidebar :active="__('bills')" />

        <!-- Main Content Area -->
        <div class="flex-1 bg-gray-100 p-4">

            <!-- Success or Error message -->
            <x-success-alert />
            <x-error-alert />

            <!-- Cards Section (Optional - you can add your stats here if needed) -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mt-6">
                <!-- Pending Invoices Card -->
                <div class="bg-white p-6 shadow-md rounded-lg">
                    <h2 class="text-xl font-semibold text-gray-700">Pending Invoices</h2>
                    <p class="text-2xl font-bold text-blue-600 mt-2">{{ $pendingInvoices->count() }}</p>
                </div>

                <!-- Paid Invoices Card -->
                <div class="bg-white p-6 shadow-md rounded-lg">
                    <h2 class="text-xl font-semibold text-gray-700">Paid Invoices</h2>
                    <p class="text-2xl font-bold text-green-600 mt-2">{{ $paidInvoices->count() }}</p>
                </div>

                <!-- Failed Invoices Card -->
                <div class="bg-white p-6 shadow-md rounded-lg">
                    <h2 class="text-xl font-semibold text-gray-700">Failed Invoices</h2>
                    <p class="text-2xl font-bold text-red-600 mt-2">{{ $failedInvoices->count() }}</p>
                </div>

                <!-- Button to generate invoices -->
                <form action="{{ route('generate.invoices') }}" method="POST" class="bg-white shadow-md rounded-lg">
                    @csrf
                    <button type="submit" class="btn bg-gradient-to-r from-blue-600 to-indigo-600 hover:bg-gradient-to-r hover:from-indigo-600 hover:to-blue-600  text-base-200 w-full h-full">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                        <span class="text-lg font-medium">Buat Tagihan Bulanan</span>
                    </button>
                </form>
            </div>

            <div class="collapse collapse-arrow bg-base-200 mt-8">
                <input type="radio" name="my-accordion-2" checked="checked" />
                <div class="collapse-title text-xl font-medium">
                    <h1 class="text-2xl font-semibold">Daftar Invoice Pending</h1>
                    <hr class="bg-gray-700 border-1 rounded my-2">
                </div>
                    <div class="collapse-content">
                        <!-- Pending Invoices Table -->
                        <div class="bg-white shadow-md rounded-lg p-6">
                            <table id="pendingInvoices" class="stripe hover text-sm w-full">
                                <thead>
                                    <tr class="bg-gray-100 text-gray-600 uppercase text-sm leading-normal">
                                        <th class="py-3 px-4 text-left">No.</th>
                                        <th class="py-3 px-4 text-left">User</th>
                                        <th class="py-3 px-4 text-left">Amount</th>
                                        <th class="py-3 px-4 text-left">Status</th>
                                        <th class="py-3 px-4 text-left">Terbit Tagihan</th>
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
                                        <td class="py-3 px-4 text-left">{{ $invoice->bulan }}</td>
                                        <td class="py-3 px-4 text-left">{{ $invoice->due_date }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="collapse collapse-arrow bg-base-200">
                    <input type="radio" name="my-accordion-2" />
                    <div class="collapse-title text-xl font-medium">
                        <h1 class="text-2xl font-semibold">Daftar Invoice Paid</h1>
                        <hr class="bg-gray-700 border-1 rounded my-2">
                    </div>
                    <div class="collapse-content">
                        <!-- Paid Invoices Table -->
                        <div class="bg-white shadow-md rounded-lg p-6">
                            <table id="paidInvoices" class="stripe hover text-sm w-full">
                                <thead>
                                    <tr class="bg-gray-100 text-gray-600 uppercase text-sm leading-normal">
                                        <th class="py-3 px-4 text-left">No.</th>
                                        <th class="py-3 px-4 text-left">User</th>
                                        <th class="py-3 px-4 text-left">Amount</th>
                                        <th class="py-3 px-4 text-left">Status</th>
                                        <th class="py-3 px-4 text-left">Terbit Tagihan</th>
                                        <th class="py-3 px-4 text-left">Jatuh Tempo</th>
                                        <th class=" py-3 px-4 text-left">Pelunasan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($paidInvoices as $invoice)
                                    <tr class="border-b border-gray-200 hover:bg-gray-50">
                                        <td class="py-3 px-4 text-left">{{ $loop->iteration }}</td>
                                        <td class="py-3 px-4 text-left">{{ $invoice->user->name }}</td>
                                        <td class="py-3 px-4 text-left">Rp {{ number_format($invoice->amount, 2, ',', '.') }}</td>
                                        <td class="py-3 px-4 text-left text-yellow-500">{{ ucfirst($invoice->status) }}</td>
                                        <td class="py-3 px-4 text-left">{{ $invoice->bulan }}</td>
                                        <td class="py-3 px-4 text-left">{{ $invoice->due_date }}</td>
                                        <td class="py-3 px-4 text-left">{{ $invoice->updated_at }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="collapse collapse-arrow bg-base-200">
                    <input type="radio" name="my-accordion-2" />
                    <div class="collapse-title text-xl font-medium">
                        <h1 class="text-2xl font-semibold">Daftar Invoice Failed</h1>
                        <hr class="bg-gray-700 border-1 rounded my-2">
                    </div>
                    <div class="collapse-content">
                        <!-- Failed Invoices Table -->
                        <div class="bg-white shadow-md rounded-lg p-6">
                            <table id="failedInvoices" class="stripe hover text-sm w-full">
                                <thead>
                                    <tr class="bg-gray-100 text-gray-600 uppercase text-sm leading-normal">
                                        <th class="py-3 px-4 text-left">No.</th>
                                        <th class="py-3 px-4 text-left">User</th>
                                        <th class="py-3 px-4 text-left">Amount</th>
                                        <th class="py-3 px-4 text-left">Status</th>
                                        <th class="py-3 px-4 text-left">Terbit Tagihan</th>
                                        <th class="py-3 px-4 text-left">Jatuh Tempo</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($failedInvoices as $invoice)
                                    <tr class="border-b border-gray-200 hover:bg-gray-50">
                                        <td class="py-3 px-4 text-left">{{ $loop->iteration }}</td>
                                        <td class="py-3 px-4 text-left">{{ $invoice->user->name }}</td>
                                        <td class="py-3 px-4 text-left">Rp {{ number_format($invoice->amount, 2, ',', '.') }}</td>
                                        <td class="py-3 px-4 text-left text-yellow-500">{{ ucfirst($invoice->status) }}</td>
                                        <td class="py-3 px-4 text-left">{{ $invoice->bulan }}</td>
                                        <td class="py-3 px-4 text-left">{{ $invoice->due_date }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
            </div>
        </div>
    </div>

    <script>
    $(document).ready(function() {
        $('#pendingInvoices').DataTable({
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
            }],
        });

        $('#paidInvoices').DataTable({
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
            }],
        });

        $('#failedInvoices').DataTable({
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
            }],
        });
    });
    </script>
</x-admin-layout>