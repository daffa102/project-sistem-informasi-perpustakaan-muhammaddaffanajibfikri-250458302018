<?php

namespace App\Livewire\Features\Member;

use Livewire\Component;
use Livewire\Attributes\Layout;

use App\Livewire\Traits\Member\HasBorrowingLogic;
use App\Livewire\Traits\Member\HasFineLogic;
use App\Livewire\Traits\Member\HasReturnLogic;
use App\Livewire\Traits\Member\HasScannerLogic;

class BorrowScanner extends Component
{
    use HasBorrowingLogic;
    use HasFineLogic;
    use HasReturnLogic;
    use HasScannerLogic;

    public $bookUuid = '';
    public $scannedBook = null;
    public $activeBorrowing = null;
    public $mode = 'scan';
    public $fineAmount = 0;
    public $daysLate = 0;

    public $maxBorrowLimit = 3;
    public $borrowDays = 7;
    public $finePerDay = 1000;

    protected $rules = [
        'bookUuid' => 'required|exists:books,id',
    ];

    protected $messages = [
        'bookUuid.required' => 'Silakan masukkan kode QR buku',
        'bookUuid.exists' => 'Kode QR tidak valid atau buku tidak ditemukan',
    ];

    public function mount()
    {
        $this->generateMemberFines();

        // Cek apakah ada parameter UUID dari redirect Dashboard
        if (request()->has('uuid')) {
            $this->bookUuid = request()->query('uuid');
            $this->scanBook(); // Otomatis trigger scan logic
        }
    }

    public function getMemberId()
    {
        return auth()->user()->member->id ?? null;
    }

    public function borrowBook()
    {
        if (!$this->scannedBook) {
            session()->flash('error', 'Buku tidak ditemukan');
            return;
        }

        $memberId = $this->getMemberId();
        if (!$memberId) {
            session()->flash('error', 'Data member tidak ditemukan');
            return;
        }

        // Gunakan logic dari Trait
        $this->processBorrowing($this->scannedBook, $memberId);
        
        // Reset scanner state
        $this->resetScan();
    }

    public function resetScan()
    {
        $this->reset(['bookUuid', 'scannedBook', 'activeBorrowing', 'mode', 'fineAmount', 'daysLate']);
        $this->mode = 'scan';
    }

    #[Layout('layouts.appmember')]
    public function render()
    {
        return view('livewire.features.member.borrow-scanner', [
            'memberStats' => $this->getMemberStats(),
            'maxBorrowLimit' => $this->maxBorrowLimit,
        ]);
    }
}
