<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Pembayaran Pending
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-yellow-50 border-l-4 border-yellow-400 text-yellow-700 p-6 sm:rounded-lg shadow-md">
                <h3 class="text-2xl font-semibold">Pembayaran Sedang Diproses</h3>
                <p class="mt-2 text-gray-700">
                    Terima kasih telah melakukan pembayaran. Status pembayaran Anda saat ini adalah <span
                        class="font-bold">Pending</span>.
                </p>
                <p class="mt-4 text-gray-700">
                    Silakan cek kembali status pembayaran Anda di beberapa saat atau hubungi kami jika ada kendala.
                </p>
            </div>

            <div class="mt-6 bg-white p-6 rounded-lg shadow-md">
                <h4 class="text-xl font-semibold text-gray-800">Detail Pembayaran</h4>
                <ul class="mt-4 space-y-2">
                    <li class="text-gray-700">
                        <span class="font-bold">Invoice ID:</span> {{ $invoice->order_id ?? 'Tidak Tersedia' }}
                    </li>
                    <li class="text-gray-700">
                        <span class="font-bold">Jumlah:</span> Rp
                        {{ number_format($invoice->amount ?? 0, 2, ',', '.') }}
                    </li>
                    <li class="text-gray-700">
                        <span class="font-bold">Tanggal Transaksi:</span>
                        {{ \Carbon\Carbon::now()->setTimezone('Asia/Jakarta')->format('d M Y') }}
                    </li>
                    <li class="text-gray-700">
                        <span class="font-bold">Waktu Transaksi:</span>
                        {{ \Carbon\Carbon::now()->setTimezone('Asia/Jakarta')->format('H:i:s') }}
                    </li>
                </ul>
            </div>

            <div class="mt-6 text-center">
                <a href="{{ route('dashboard') }}"
                    class="px-6 py-3 bg-blue-600 text-white rounded-lg shadow-md hover:bg-blue-700 transition-colors">
                    Kembali ke Dashboard
                </a>
            </div>
        </div>
    </div>
</x-app-layout>