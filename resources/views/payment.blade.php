<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Pembayaran') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900">Halaman Pembayaran</h3>
                <div id="snap-button"></div>

                <script type="text/javascript" src="https://app.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
                <script type="text/javascript">
                    snap.pay('{{ $snapToken }}', {
                        onSuccess: function(result) {
                            window.location.href = '{{ route("payment.success") }}?order_id=' + result.order_id;
                        },
                        onPending: function(result) {
                            alert('Pembayaran masih dalam proses');
                        },
                        onError: function(result) {
                            alert('Pembayaran gagal');
                        }
                    });
                </script>
            </div>
        </div>
    </div>
</x-app-layout>
