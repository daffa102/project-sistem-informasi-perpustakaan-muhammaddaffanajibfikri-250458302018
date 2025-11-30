<?php

namespace App\Livewire\Traits\Member;

use App\Models\Borrowing as BorrowingModel;
use App\Models\Book;
use App\Models\Fine;
use Carbon\Carbon;

trait HasScannerLogic
{
    public function scanBook()
    {
        $this->validate();
        $this->reset(['scannedBook', 'activeBorrowing', 'fineAmount', 'daysLate']);

        $this->scannedBook = Book::find($this->bookUuid);
        if (!$this->scannedBook) {
            session()->flash('error', 'Buku tidak ditemukan');
            return redirect()->route('member.borrow.scanner');
        }

        $memberId = $this->getMemberId();
        if (!$memberId) {
            session()->flash('error', 'Data member tidak ditemukan.');
            return redirect()->route('member.borrow.scanner');
        }

        $this->activeBorrowing = BorrowingModel::where('book_id', $this->bookUuid)
            ->where('member_id', $memberId)
            ->whereIn('status', ['borrowed', 'late'])
            ->first();

        if ($this->activeBorrowing) {
            $this->handleReturnMode();
        } else {
            $this->handleBorrowMode($memberId);
        }
    }

    protected function handleReturnMode()
    {
        $this->mode = 'return';

        $existingFine = Fine::where('borrowing_id', $this->activeBorrowing->id)->first();
        
        if ($existingFine) {
            $this->fineAmount = $existingFine->amount;
            
            $dueDate = Carbon::parse($this->activeBorrowing->due_date);
            $today = Carbon::today();
            $this->daysLate = $today->greaterThan($dueDate) ? $dueDate->diffInDays($today) : 0;
        } else {
            $this->fineAmount = 0;
            $this->daysLate = 0;
        }

        if ($this->daysLate > 0 && $this->activeBorrowing->status !== 'late') {
            $this->activeBorrowing->update(['status' => 'late']);
        }
    }

    protected function handleBorrowMode($memberId)
    {
        if ($this->scannedBook->stock <= 0) {
            session()->flash('error', 'Stok buku habis. Semua salinan sedang dipinjam.');
            return redirect()->route('member.borrow.scanner');
        }

        $unpaidFines = Fine::whereHas('borrowing', function ($query) use ($memberId) {
            $query->where('member_id', $memberId);
        })->where('paid', false)->sum('amount');

        if ($unpaidFines > 0) {
            session()->flash('warning',
                '⚠️ Anda masih memiliki denda sebesar Rp ' .
                number_format($unpaidFines, 0, ',', '.') .
                ' yang belum dibayar.'
            );
        }

        $this->mode = 'borrow';
    }

    public function getMemberStats()
    {
        $memberId = auth()->user()->member->id ?? null;

        $stats = [
            'active_borrowings' => 0,
            'total_fines' => 0,
        ];

        if ($memberId) {
            $stats['active_borrowings'] = BorrowingModel::where('member_id', $memberId)
                ->whereIn('status', ['borrowed', 'late'])
                ->count();

            $stats['total_fines'] = Fine::whereHas('borrowing', function ($query) use ($memberId) {
                $query->where('member_id', $memberId);
            })->where('paid', false)->sum('amount');
        }

        return $stats;
    }
}
