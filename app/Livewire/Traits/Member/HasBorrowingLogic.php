<?php

namespace App\Livewire\Traits\Member;

use App\Models\Book;
use App\Models\Borrowing;
use App\Models\Fine;

trait HasBorrowingLogic
{
    public function quickBorrow($bookId)
    {
        if (!auth()->check()) {
            session()->flash('error', 'Anda harus login terlebih dahulu.');
            return;
        }

        $memberId = $this->getMemberId();
        if (!$memberId) {
            session()->flash('error', 'Akun Anda tidak terhubung ke data member.');
            return;
        }

        $book = Book::find($bookId);
        if (!$book) {
            session()->flash('error', 'Buku tidak ditemukan.');
            return;
        }

        $this->processBorrowing($book, $memberId);
    }

    public function submitQRCode()
    {
        $memberId = $this->getMemberId();
        if (!$memberId) {
            session()->flash('error', 'Akun Anda tidak punya data member.');
            return;
        }

        if (!$this->qrcode) {
            session()->flash('error', 'Silakan scan QR code terlebih dahulu.');
            return;
        }

        // Parse QR Code (UUID or Path)
        $uuid = $this->qrcode;
        if (str_contains($this->qrcode, '/')) {
             $uuid = pathinfo($this->qrcode, PATHINFO_FILENAME);
        }

        $book = Book::find($uuid);
        if (!$book) {
            session()->flash('error', 'Buku tidak ditemukan.');
            $this->qrcode = '';
            return;
        }

        $this->processBorrowing($book, $memberId);
        $this->qrcode = '';
    }

    protected function processBorrowing($book, $memberId)
    {
        // 0. Cek Denda Belum Dibayar (Rule Tambahan)
        $unpaidFines = Fine::whereHas('borrowing', function ($query) use ($memberId) {
            $query->where('member_id', $memberId);
        })->where('paid', false)->sum('amount');

        if ($unpaidFines > 0) {
            session()->flash('error', 'Anda masih memiliki denda sebesar Rp ' . number_format($unpaidFines, 0, ',', '.') . '. Harap lunasi terlebih dahulu.');
            return;
        }

        // 1. Cek Stok
        if ($book->stock <= 0) {
            session()->flash('error', 'Stok buku "' . $book->title . '" habis.');
            return;
        }

        // 2. Cek Pinjaman Aktif (Buku yang sama)
        $existingBorrow = Borrowing::where('member_id', $memberId)
            ->where('book_id', $book->id)
            ->whereIn('status', ['borrowed', 'late'])
            ->exists();

        if ($existingBorrow) {
            session()->flash('error', 'Anda sudah meminjam buku "' . $book->title . '".');
            return;
        }

        // 3. Cek Limit Peminjaman (Max 3)
        $activeCount = Borrowing::where('member_id', $memberId)
            ->whereIn('status', ['borrowed', 'late'])
            ->count();

        if ($activeCount >= 3) {
            session()->flash('error', 'Batas peminjaman maksimal 3 buku.');
            return;
        }

        // 4. Proses Simpan
        Borrowing::create([
            'member_id' => $memberId,
            'book_id' => $book->id,
            'borrow_date' => now(),
            'due_date' => now()->addDays(7),
            'status' => 'borrowed',
        ]);

        // 5. Update Stok
        $book->decrement('stock');
        
        // 6. Feedback & Refresh
        session()->flash('success', 'Berhasil meminjam buku: ' . $book->title);
        
        // Cek apakah method loadStats ada di component (optional)
        if (method_exists($this, 'loadStats')) {
            $this->loadStats();
        }
        
        $this->dispatch('refreshDashboard');
    }
}
