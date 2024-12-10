<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Pembayaran Invoice
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-md sm:rounded-lg overflow-hidden">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-xl font-semibold text-gray-800">Invoice ID: {{ $invoice->order_id }}</h3>
                    <p class="mt-2 text-lg text-gray-700">Jumlah: Rp {{ number_format($invoice->amount, 2, ',', '.') }}</p>
                    <p class="mt-2 text-gray-500">Silakan bayar tagihan Anda dengan tombol di bawah.</p>

                    <!-- Tombol untuk memulai pembayaran -->
                    <button id="pay-button" class="mt-6 w-full sm:w-auto px-6 py-3 bg-blue-600 text-white rounded-lg shadow-md hover:bg-blue-700 transition-colors">
                        Bayar Sekarang
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Link to Midtrans snap.js library -->
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>

    <script type="text/javascript">
        window.onload = function () {
            var snapToken = "{{ $snapToken }}";  // Fetch the Snap Token passed from the controller

            document.getElementById('pay-button').onclick = function () {
                // Inisialisasi Midtrans Snap
                if (window.snap) {
                    window.snap.pay(snapToken, {
                        onSuccess: function (result) {
                            // Success: Redirect to payment success route
                            window.location.href = "/payment/success?order_id=" + result.order_id;
                        },
                        onPending: function (result) {
                            // Pending: Redirect to payment pending route
                            window.location.href = "/payment/pending?order_id=" + result.order_id;
                        },
                        onError: function (result) {
                            // Error: Redirect to payment failed route
                            window.location.href = "/payment/failed?order_id=" + result.order_id;
                        }
                    });
                } else {
                    console.error("Midtrans Snap tidak terdefinisi.");
                }
            };
        };
    </script>

</x-app-layout>
