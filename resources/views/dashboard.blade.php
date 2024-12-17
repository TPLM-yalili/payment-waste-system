@if (is_null(Auth::user()->no_kk) || is_null(Auth::user()->no_wa))
    <script>
        window.location.href = "{{ route('post-register') }}";
    </script>
@else
    <x-app-layout>
        <x-slot name="header">
            <div class="text-left mb-2 bg-white">
                <h3 class="text-2xl font-semibold text-gray-800">
                    Selamat datang, <span class="text-blue-500">{{ Auth::user()->name }}</span>
                </h3>
                <p class="text-gray-600 mt-2">Berikut adalah tagihan yang perlu Anda bayar bulan ini.</p>
            </div>
        </x-slot>


        <div class="py-6 bg-white h-screen">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white shadow-lg sm:rounded-lg p-6">
                    @if ($isVerified)
                        <!-- Sambutan User -->
                        @if ($invoices->every(fn($invoice) => $invoice->status === 'paid'))
                            <div class="bg-green-50 p-6 rounded-lg shadow-md mb-6">
                                <h4 class="text-xl font-semibold text-green-700">Terima Kasih!</h4>
                                <p class="text-gray-600">Anda telah berhasil membayar semua tagihan sampah bulan ini.
                                    Terima
                                    kasih
                                    atas perhatian Anda!</p>
                            </div>
                        @else
                            <div class="mb-6">
                                <h4 class="text-xl font-semibold text-gray-800">
                                    Tagihan Bulan {{ \Carbon\Carbon::now()->format('F Y') }}
                                </h4>
                            </div>

                            <!-- Daftar Tagihan -->
                            <div class="space-y-4">
                                @foreach ($invoices as $invoice)
                                    <div class="bg-gray-50 p-5 rounded-lg shadow-sm hover:shadow-md transition-shadow">
                                        <div class="flex justify-between items-center mb-3">
                                            <p class="text-lg font-medium text-gray-900">Order ID:
                                                {{ $invoice->order_id }}
                                            </p>
                                            <span class="text-sm text-gray-500">
                                                {{ \Carbon\Carbon::parse($invoice->due_date)->format('d M Y') }}
                                            </span>
                                        </div>
                                        <p class="text-xl font-semibold text-blue-600">
                                            Rp {{ number_format($invoice->amount, 0, ',', '.') }}
                                        </p>
                                        <p class="text-gray-600">
                                            Due Date: {{ \Carbon\Carbon::parse($invoice->due_date)->format('d M Y') }}
                                        </p>
                                        <form action="{{ route('invoice.pay', $invoice->id) }}" method="GET"
                                            class="mt-4">
                                            <button type="submit"
                                                class="w-full px-6 py-3 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700 transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500">
                                                Bayar Sekarang
                                            </button>
                                        </form>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    @else
                    <div class="bg-green-50 p-6 rounded-lg shadow-md mb-6">
                        <h4 class="text-xl font-semibold text-green-700">Dalam proses verifikasi!</h4>
                        <p class="text-gray-600">Akun anda sedang dalam proses verifikasi oleh admin, silahkan cek secara berkala :*</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </x-app-layout>
@endif
