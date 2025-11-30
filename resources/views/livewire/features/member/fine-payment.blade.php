<div class="max-w-7xl mx-auto px-6 py-10" wire:poll.10s>
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">💳 Pembayaran Denda</h1>
        <p class="text-gray-600">Bayar denda keterlambatan Anda dengan mudah menggunakan Midtrans</p>
        
        @if(session()->has('success'))
            <div class="mt-4 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-xl">
                {{ session('success') }}
            </div>
        @endif
        
        @if(session()->has('info'))
            <div class="mt-4 bg-blue-50 border border-blue-200 text-blue-800 px-4 py-3 rounded-xl">
                {{ session('info') }}
            </div>
        @endif
        
        @if(session()->has('error'))
            <div class="mt-4 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-xl">
                {{ session('error') }}
            </div>
        @endif
    </div>

    <!-- Total Denda -->
    @if($totalFines > 0)
    <div class="bg-gradient-to-r from-red-500 to-pink-500 rounded-2xl p-6 mb-8 text-white shadow-xl">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm opacity-90 mb-1">Total Denda Belum Dibayar</p>
                <h2 class="text-4xl font-bold">Rp {{ number_format($totalFines, 0, ',', '.') }}</h2>
            </div>
            <div>
                <button onclick="payAll()" 
                        class="bg-white text-red-600 px-6 py-3 rounded-xl font-semibold hover:bg-gray-100 transition shadow-lg">
                    Bayar Semua
                </button>
            </div>
        </div>
    </div>
    @else
    <div class="bg-green-50 border border-green-200 rounded-2xl p-6 mb-8">
        <div class="flex items-center gap-3">
            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <div>
                <h3 class="text-lg font-semibold text-green-900">Tidak Ada Denda</h3>
                <p class="text-green-700">Anda tidak memiliki denda yang belum dibayar</p>
            </div>
        </div>
    </div>
    @endif

    <!-- Denda Belum Dibayar -->
    @if($unpaidFines->count() > 0)
    <div class="bg-white rounded-2xl shadow-lg p-6 mb-8">
        <h3 class="text-xl font-bold text-gray-900 mb-4">📋 Daftar Denda Belum Dibayar</h3>
        
        <div class="space-y-4">
            @foreach($unpaidFines as $fine)
            <div class="border border-gray-200 rounded-xl p-4 hover:shadow-md transition">
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <h4 class="font-semibold text-gray-900">{{ $fine->borrowing->book->title ?? 'Buku' }}</h4>
                        <p class="text-sm text-gray-600 mt-1">
                            Terlambat: 
                            @php
                                $daysLate = \Carbon\Carbon::parse($fine->borrowing->return_date ?? now())->diffInDays(\Carbon\Carbon::parse($fine->borrowing->due_date));
                            @endphp
                            <span class="font-semibold text-red-600">{{ $daysLate }} hari</span>
                        </p>
                        <p class="text-xs text-gray-500 mt-1">
                            Jatuh tempo: {{ \Carbon\Carbon::parse($fine->borrowing->due_date)->format('d M Y') }}
                        </p>
                    </div>
                    <div class="text-right">
                        <p class="text-2xl font-bold text-red-600">Rp {{ number_format($fine->amount, 0, ',', '.') }}</p>
                        <button onclick="payNow({{ $fine->id }})" 
                                class="mt-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-semibold transition">
                            Bayar Sekarang
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Riwayat Pembayaran -->
    @if($paidPayments->count() > 0)
    <div class="bg-white rounded-2xl shadow-lg p-6">
        <h3 class="text-xl font-bold text-gray-900 mb-4">📜 Riwayat Pembayaran</h3>
        
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Tanggal</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Buku</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Metode</th>
                        <th class="px-4 py-3 text-right text-xs font-semibold text-gray-600 uppercase">Jumlah</th>
                        <th class="px-4 py-3 text-center text-xs font-semibold text-gray-600 uppercase">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($paidPayments as $payment)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 text-sm text-gray-900">
                            {{ $payment->paid_at->format('d M Y H:i') }}
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-900">
                            {{ $payment->fine->borrowing->book->title ?? '-' }}
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-600">
                            {{ ucfirst($payment->payment_type ?? 'Midtrans') }}
                        </td>
                        <td class="px-4 py-3 text-sm font-semibold text-gray-900 text-right">
                            Rp {{ number_format($payment->amount, 0, ',', '.') }}
                        </td>
                        <td class="px-4 py-3 text-center">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                                ✓ Lunas
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif
</div>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Midtrans Snap.js -->
<script src="https://app.sandbox.midtrans.com/snap/snap.js" 
        data-client-key="{{ config('midtrans.client_key') }}"></script>

<script>
function payNow(fineId) {
    Swal.fire({
        title: 'Memproses...',
        text: 'Mohon tunggu sebentar',
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });

    fetch('/payment/create', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ fine_id: fineId })
    })
    .then(response => response.json())
    .then(data => {
        Swal.close();
        
        if (data.error) {
            Swal.fire('Error', data.error, 'error');
            return;
        }

        snap.pay(data.snap_token, {
            onSuccess: function(result) {
                Swal.fire({
                    icon: 'success',
                    title: 'Pembayaran Berhasil!',
                    text: 'Denda Anda telah dibayar',
                    confirmButtonText: 'OK'
                }).then(() => {
                    window.location.href = '/member/fines/payment';
                });
            },
            onPending: function(result) {
                Swal.fire({
                    icon: 'info',
                    title: 'Menunggu Pembayaran',
                    text: 'Silakan selesaikan pembayaran Anda',
                    confirmButtonText: 'OK'
                });
            },
            onError: function(result) {
                Swal.fire({
                    icon: 'error',
                    title: 'Pembayaran Gagal',
                    text: 'Terjadi kesalahan saat memproses pembayaran',
                    confirmButtonText: 'OK'
                });
            },
            onClose: function() {
                console.log('Payment popup closed');
            }
        });
    })
    .catch(error => {
        Swal.close();
        Swal.fire('Error', 'Terjadi kesalahan: ' + error.message, 'error');
    });
}

function payAll() {
    Swal.fire({
        title: 'Bayar Semua Denda?',
        text: 'Total: Rp {{ number_format($totalFines, 0, ',', '.') }}',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Ya, Bayar',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire('Info', 'Fitur bayar semua akan segera tersedia', 'info');
        }
    });
}
</script>

<script>
    document.addEventListener('livewire:navigated', () => {
        Livewire.dispatch('$refresh');
    });
</script>
