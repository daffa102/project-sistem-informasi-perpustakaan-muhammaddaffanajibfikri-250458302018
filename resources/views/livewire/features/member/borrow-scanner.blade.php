<div class="max-w-2xl mx-auto p-6">
    {{-- Statistik Member --}}
    @if($memberStats['active_borrowings'] > 0 || $memberStats['total_fines'] > 0)
        <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 mb-4">
            <h3 class="text-sm font-semibold text-gray-700 mb-2">📊 Status Peminjaman Anda</h3>
            <div class="flex justify-between items-center text-sm">
                <div class="flex-1">
                    <div class="mb-2">
                        <span class="text-gray-600">Buku Dipinjam:</span>
                        <span class="font-semibold ml-2">{{ $memberStats['active_borrowings'] }} / {{ $maxBorrowLimit }}</span>
                    </div>
                    @if($memberStats['total_fines'] > 0)
                        <div>
                            <span class="text-red-600">Denda Belum Dibayar:</span>
                            <span class="font-semibold text-red-700 ml-2">Rp {{ number_format($memberStats['total_fines'], 0, ',', '.') }}</span>
                        </div>
                    @endif
                </div>
                @if($memberStats['total_fines'] > 0)
                    <div>
                        <a href="{{ route('member.fines.payment') }}" wire:navigate
                           class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-lg transition-colors duration-200">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                    d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                            </svg>
                            Bayar Denda
                        </a>
                    </div>
                @endif
            </div>
        </div>
    @endif

    <div class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-2xl font-bold mb-6 text-gray-800">Sistem Peminjaman Buku</h2>



        {{-- Alert Messages --}}
       @if (session()->has('success'))
            <div  class="alert-box bg-green-100 text-green-700 p-3 rounded-lg mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if (session()->has('error'))
            <div  class="alert-box bg-red-100 text-red-700 p-3 rounded-lg mb-4">
                {{ session('error') }}
            </div>
        @endif

        @if (session()->has('warning'))
            <div  class="alert-box bg-yellow-100 text-yellow-700 p-3 rounded-lg mb-4">
                {{ session('warning') }}
            </div>
        @endif


        {{-- Mode: Scan QR Code --}}
        @if($mode === 'scan')
            <div class="space-y-4">
                <div>
                    <label for="bookUuid" class="block text-sm font-medium text-gray-700 mb-2">
                        Masukkan Kode QR Buku (UUID)
                    </label>
                    <input
                        type="text"
                        id="bookUuid"
                        wire:model="bookUuid"
                        wire:keydown.enter="scanBook"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        placeholder="Contoh: 550e8400-e29b-41d4-a716-446655440000"
                        autofocus
                    >
                    @error('bookUuid')
                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <button
                    wire:click="scanBook"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-4 rounded-lg transition duration-200"
                >
                    Scan Buku
                </button>

                <p class="text-sm text-gray-600 text-center">
                    Scan QR code atau masukkan UUID buku secara manual
                </p>
            </div>
        @endif

        {{-- Mode: Peminjaman Baru --}}
        @if($mode === 'borrow' && $scannedBook)
            <div class="space-y-4">
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <h3 class="text-lg font-semibold text-blue-800 mb-2">Detail Buku</h3>
                    <div class="space-y-1 text-sm">
                        <p><span class="font-medium">Judul:</span> {{ $scannedBook->title }}</p>
                        <p><span class="font-medium">Penulis:</span> {{ $scannedBook->author }}</p>

                    </div>
                </div>

                <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                    <p class="text-green-800 font-medium">✓ Buku tersedia untuk dipinjam</p>
                    <p class="text-sm text-gray-600 mt-1">Batas pengembalian: {{ \Carbon\Carbon::today()->addDays(7)->format('d M Y') }}</p>
                </div>

                <div class="flex space-x-3">
                    <button
                        wire:click="borrowBook"
                        class="flex-1 bg-green-600 hover:bg-green-700 text-white font-semibold py-3 px-4 rounded-lg transition duration-200"
                    >
                        Pinjam Buku
                    </button>
                    <button
                        wire:click="resetScan"
                        class="flex-1 bg-gray-500 hover:bg-gray-600 text-white font-semibold py-3 px-4 rounded-lg transition duration-200"
                    >
                        Batal
                    </button>
                </div>
            </div>
        @endif

        @if($mode === 'return' && $activeBorrowing)
            <div class="space-y-4">
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <h3 class="text-lg font-semibold text-blue-800 mb-2">Detail Peminjaman</h3>
                    <div class="space-y-1 text-sm">
                        <p><span class="font-medium">Judul:</span> {{ $scannedBook->title }}</p>
                        <p><span class="font-medium">Tanggal Pinjam:</span> {{ \Carbon\Carbon::parse($activeBorrowing->borrow_date)->format('d M Y') }}</p>
                        <p><span class="font-medium">Batas Kembali:</span> {{ \Carbon\Carbon::parse($activeBorrowing->due_date)->format('d M Y') }}</p>
                    </div>
                </div>

                @if($fineAmount > 0)
                    <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                        <h3 class="text-lg font-semibold text-red-800 mb-2">⚠️ Terlambat!</h3>
                        <div class="space-y-1 text-sm">
                            <p><span class="font-medium">Keterlambatan:</span> {{ $daysLate }} hari</p>
                            <p><span class="font-medium">Denda:</span> Rp {{ number_format($fineAmount, 0, ',', '.') }}</p>
                        </div>
                    </div>
                @else
                    <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                        <p class="text-green-800 font-medium">✓ Pengembalian tepat waktu</p>
                        <p class="text-sm text-gray-600">Tidak ada denda</p>
                    </div>
                @endif

                <div class="flex space-x-3">
                    <button
                        wire:click="returnBook"
                        class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-4 rounded-lg transition duration-200"
                    >
                        Kembalikan Buku
                    </button>
                    <button
                        wire:click="resetScan"
                        class="flex-1 bg-gray-500 hover:bg-gray-600 text-white font-semibold py-3 px-4 rounded-lg transition duration-200"
                        >
                        Batal
                    </button>
                </div>
            </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const alerts = document.querySelectorAll('.alert-box');
    alerts.forEach((alert) => {
        setTimeout(() => {
            alert.classList.add('opacity-0', 'transition', 'duration-700');
            setTimeout(() => alert.remove(), 700);
        }, 3000);
    });
});
</script>
@endpush
