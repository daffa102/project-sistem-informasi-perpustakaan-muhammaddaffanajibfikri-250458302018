<?php

namespace App\Livewire\Traits;

use App\Models\Borrowing;
use App\Models\Fine;
use Carbon\Carbon;

trait HasFineLogic
{
    private function generateMemberFines()
    {
        $memberId = $this->getMemberId();

        if (!$memberId) {
            return;
        }

        // Update status borrowing yang terlambat
        Borrowing::where('member_id', $memberId)
            ->where('status', 'borrowed')
            ->where('due_date', '<', Carbon::today())
            ->whereNull('return_date')
            ->update(['status' => 'late']);

        // Generate/update fines untuk peminjaman yang terlambat
        $lateBorrowings = Borrowing::where('member_id', $memberId)
            ->whereIn('status', ['borrowed', 'late'])
            ->get();

        foreach ($lateBorrowings as $borrowing) {
            if (!$borrowing->due_date) continue;

            $dueDate = Carbon::parse($borrowing->due_date);
            $today = Carbon::today();

            if ($today->greaterThan($dueDate)) {
                $daysLate = $dueDate->diffInDays($today);
                $fineAmount = $daysLate * 1000;

                Fine::updateOrCreate(
                    ['borrowing_id' => $borrowing->id],
                    ['amount' => $fineAmount, 'paid' => false]
                );
            }
        }
    }

    public function calculateFine()
    {
        $memberId = $this->getMemberId();

        if (!$memberId) {
            $this->fine = 0;
            return;
        }

        // Ambil total denda yang belum dibayar dari tabel fines
        $this->fine = Fine::whereHas('borrowing', function ($query) use ($memberId) {
            $query->where('member_id', $memberId);
        })
        ->where('paid', false)
        ->sum('amount');
    }
}
