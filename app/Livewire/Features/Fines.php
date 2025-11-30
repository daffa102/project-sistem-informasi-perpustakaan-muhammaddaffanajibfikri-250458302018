<?php

namespace App\Livewire\Features;

use App\Models\Borrowing;
use App\Models\Fine as FineModel;
use Carbon\Carbon;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Fines extends Component
{
    use WithPagination;

    public $search = '';

    protected $paginationTheme = 'bootstrap';

    // Input modal
    public $fineId;

    public $borrowing_id;

    public $amount;

    public $paid = false;

    public function mount()
    {
        // 🔥 Auto-generate fines saat mount
        $this->generateAutomaticFines();
    }

    #[Layout('layouts.app')]
    public function render()
    {

        $fines = FineModel::with('borrowing.member', 'borrowing.book')
            ->where(function ($query) {
                $query->whereHas('borrowing.member', function ($q) {
                    $q->where('name', 'like', "%{$this->search}%");
                })
                    ->orWhereHas('borrowing.book', function ($q) {
                        $q->where('title', 'like', "%{$this->search}%");
                    });
            })
            ->orderBy('id', 'desc')
            ->paginate(10);

        $borrowings = Borrowing::with('member', 'book')->get();

        return view('livewire.features.fines', compact('fines', 'borrowings'));
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function create()
    {
        $this->resetInput();
        $this->dispatch('showModal');
    }

    public function store()
    {
        $this->validate([
            'borrowing_id' => 'required|exists:borrowings,id',
        ]);

        $borrowing = Borrowing::find($this->borrowing_id);
        $fineAmount = $this->calculateFine($borrowing);

        FineModel::create([
            'borrowing_id' => $this->borrowing_id,
            'amount' => $fineAmount,
            'paid' => false,
        ]);

        session()->flash('success', 'Fine added successfully.');
        $this->dispatch('closeModal');
        $this->resetInput();
    }

    public function edit($id)
    {
        $fine = FineModel::findOrFail($id);
        $this->fineId = $fine->id;
        $this->borrowing_id = $fine->borrowing_id;
        $this->amount = $fine->amount;
        $this->paid = $fine->paid;

        $this->dispatch('showModal');
    }

    public function update()
    {
        $this->validate([
            'borrowing_id' => 'required|exists:borrowings,id',
            'amount' => 'required|numeric|min:0',
        ]);

        $fine = FineModel::findOrFail($this->fineId);
        $fine->update([
            'borrowing_id' => $this->borrowing_id,
            'amount' => $this->amount,
            'paid' => $this->paid,
        ]);

        session()->flash('success', 'Fine updated successfully.');
        $this->dispatch('closeModal');
        $this->resetInput();
    }

    #[On('delete-fine')]
    public function delete($id)
    {
        FineModel::findOrFail($id)->delete();
        session()->flash('success', 'Fine deleted successfully.');
    }

    public function togglePaid($id)
    {
        $fine = FineModel::findOrFail($id);
        $fine->update(['paid' => ! $fine->paid]);

        $status = $fine->paid ? 'paid' : 'unpaid';
        session()->flash('success', "Fine marked as {$status}.");
    }

    private function calculateFine($borrowing)
    {
        if (! $borrowing->due_date) {
            return 0;
        }

        $dueDate = Carbon::parse($borrowing->due_date);

        $compareDate = $borrowing->return_date
            ? Carbon::parse($borrowing->return_date)
            : Carbon::today();

        if ($compareDate->lessThanOrEqualTo($dueDate)) {
            return 0;
        }

        $daysLate = $compareDate->diffInDays($dueDate);

        return $daysLate * 1000;
    }

    private function generateAutomaticFines()
    {
        $this->updateBorrowingStatus();

        $borrowings = Borrowing::whereIn('status', ['borrowed', 'late'])
            ->with('member')
            ->get();

        foreach ($borrowings as $borrowing) {
            $fineAmount = $this->calculateFine($borrowing);

            if ($fineAmount > 0) {
                $existingFine = FineModel::where('borrowing_id', $borrowing->id)->first();

                if (! $existingFine) {
                    FineModel::create([
                        'borrowing_id' => $borrowing->id,
                        'amount' => $fineAmount,
                        'paid' => false,
                    ]);
                } elseif (! $existingFine->paid && $existingFine->amount != $fineAmount) {
                    $existingFine->update(['amount' => $fineAmount]);
                }
            }
        }
    }

    private function updateBorrowingStatus()
    {
        Borrowing::where('status', 'borrowed')
            ->where('due_date', '<', Carbon::today())
            ->whereNull('return_date')
            ->update(['status' => 'late']);
    }

    private function resetInput()
    {
        $this->reset(['fineId', 'borrowing_id', 'amount', 'paid']);
        $this->resetValidation();
    }
}
