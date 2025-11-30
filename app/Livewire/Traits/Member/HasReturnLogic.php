<?php

namespace App\Livewire\Traits\Member;

use App\Models\Book;
use App\Models\Fine;
use Carbon\Carbon;

trait HasReturnLogic
{
    public function returnBook()
    {
        if (!$this->activeBorrowing) {
            session()->flash('error', 'Data peminjaman tidak ditemukan');
            return redirect()->route('member.borrow.scanner');
        }

        // Update borrowing status
        $this->activeBorrowing->update([
            'return_date' => Carbon::today(),
            'status' => 'returned',
        ]);

        // Update book stock
        $book = Book::find($this->activeBorrowing->book_id);
        $book->stock += 1;
        $book->is_available = true;
        $book->save();

        // Simpan denda KE DATABASE jika ada keterlambatan
        if ($this->daysLate > 0 && $this->fineAmount > 0) {
            $existingFine = Fine::where('borrowing_id', $this->activeBorrowing->id)->first();

            if (!$existingFine) {
                // Buat fine baru hanya jika belum ada
                Fine::create([
                    'borrowing_id' => $this->activeBorrowing->id,
                    'amount' => $this->fineAmount,
                    'paid' => false
                ]);
            } else {
                // Update fine yang sudah ada
                $existingFine->update([
                    'amount' => $this->fineAmount,
                    'paid' => false
                ]);
            }

            session()->flash('warning',
                '⚠️ Anda terlambat ' . $this->daysLate . ' hari. ' .
                'Denda: Rp ' . number_format($this->fineAmount, 0, ',', '.') .
                '. Silakan bayar di kasir.'
            );
        } else {
            session()->flash('success', '✅ Buku berhasil dikembalikan tepat waktu!');
        }

        return redirect()->route('member.borrow.scanner');
    }
}
