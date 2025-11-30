<?php

namespace App\Livewire\Features\Member;

use Livewire\Component;
use App\Models\Fine;
use App\Models\Payment;
use Livewire\Attributes\Layout;

#[Layout('layouts.appmember')]
class FinePayment extends Component
{
    public $unpaidFines = [];
    public $paidPayments = [];
    public $totalFines = 0;

    public function mount()
    {
        $this->loadFines();
        $this->loadPaymentHistory();
    }

    public function loadFines()
    {
        $memberId = auth()->user()->member->id;

        $this->unpaidFines = Fine::with('borrowing.book', 'borrowing.member')
            ->whereHas('borrowing', function ($query) use ($memberId) {
                $query->where('member_id', $memberId);
            })
            ->where('paid', false)
            ->get();

        $this->totalFines = $this->unpaidFines->sum('amount');
    }

    public function loadPaymentHistory()
    {
        $memberId = auth()->user()->member->id;

        $this->paidPayments = Payment::with('fine.borrowing.book')
            ->where('member_id', $memberId)
            ->where('transaction_status', 'settlement')
            ->latest()
            ->take(10)
            ->get();
    }

    public function render()
    {
        $this->loadFines();
        $this->loadPaymentHistory();
        
        return view('livewire.features.member.fine-payment');
    }
}
