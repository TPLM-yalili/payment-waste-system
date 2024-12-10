<x-app-layout>

    <div class="py-12 bg-gray w-screen h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200 text-center">
                    <!-- Icon dengan desain menarik -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-16 h-16 text-green-500 mx-auto" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M16.293 4.293a1 1 0 011.414 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 111.414-1.414L9 11.586l7.293-7.293z" clip-rule="evenodd" />
                    </svg>
                    
                    <!-- Teks Pembayaran Berhasil -->
                    <h3 class="mt-4 text-2xl font-semibold text-green-700">Pembayaran Berhasil Dilakukan!</h3>
                    
                    <p class="mt-2 text-lg text-gray-700">Terima kasih telah melakukan pembayaran untuk invoice ID: <strong>{{ $invoice->order_id }}</strong>.</p>
                    <p class="mt-2 text-lg text-green-600">Jumlah yang dibayar: <strong>Rp {{ number_format($invoice->amount, 2, ',', '.') }}</strong></p>
                    
                    <!-- Tombol Kembali ke Dashboard -->
                    <div class="mt-6">
                        <a href="{{ route('dashboard') }}" class="inline-block px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                            Kembali ke Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
