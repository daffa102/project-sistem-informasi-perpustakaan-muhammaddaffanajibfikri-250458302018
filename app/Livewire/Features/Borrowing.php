<?php

namespace App\Livewire\Features;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use App\Models\Borrowing as BorrowingModel;
use App\Models\Book as BookModel;
use App\Models\Member as MemberModel;
use App\Models\Fine;
use Carbon\Carbon;

class Borrowing extends Component
{
    use WithPagination;

    public $search = '';
    public $borrowingId;
    public $member_id, $book_id, $borrow_date, $due_date, $return_date, $status = 'borrowed';

    protected $paginationTheme = 'bootstrap';

    protected $rules = [
        'member_id'   => 'required|exists:members,id',
        'book_id'     => 'required|exists:books,id',
        'borrow_date' => 'required|date',
        'due_date'    => 'nullable|date|after_or_equal:borrow_date',
        'return_date' => 'nullable|date|after_or_equal:borrow_date',
        'status'      => 'required|string|max:50',
    ];

    public function mount()
    {
        // Generate/update fines otomatis saat admin membuka halaman
        $this->generateAutomaticFines();
    }

    #[Layout('layouts.app')]
    public function render()
    {
        $borrowings = BorrowingModel::with(['member', 'book'])
            ->when($this->search, function ($query) {
                $query->whereHas('member', fn($q) =>
                    $q->where('name', 'like', "%{$this->search}%")
                )->orWhereHas('book', fn($q) =>
                    $q->where('title', 'like', "%{$this->search}%")
                );
            })
            ->orderBy('id', 'desc')
            ->paginate(10);

        $members = MemberModel::all();
        $books = BookModel::all();

        return view('livewire.features.borrowing', [
            'borrowings' => $borrowings,
            'members' => $members,
            'books' => $books,
        ]);
    }

    public function create()
    {
        $this->resetInput();
    }

    public function store()
    {
        $this->validate();

        $book = BookModel::find($this->book_id);

        if (!$book || $book->stock <= 0) {
            session()->flash('error', 'Stok buku habis atau buku tidak ditemukan!');
            return;
        }

        $borrowing = BorrowingModel::create([
            'member_id' => $this->member_id,
            'book_id' => $this->book_id,
            'borrow_date' => $this->borrow_date,
            'due_date' => Carbon::parse($this->borrow_date)->addDays(7), // Default 7 hari
            'return_date' => $this->return_date ?: null,
            'status' => $this->status ?? 'borrowed',
        ]);


        $book->decrement('stock');
        $book->refresh();

        $this->checkAndGenerateFine($borrowing);

        session()->flash('success', 'Data peminjaman berhasil ditambahkan!');
        $this->resetInput();
        $this->dispatch('closeModal');
    }

    public function edit($id)
    {
        $borrowing = BorrowingModel::findOrFail($id);

        $this->borrowingId = $borrowing->id;
        $this->member_id = $borrowing->member_id;
        $this->book_id = $borrowing->book_id;
        $this->borrow_date = $borrowing->borrow_date;
        $this->due_date = $borrowing->due_date;
        $this->return_date = $borrowing->return_date;
        $this->status = $borrowing->status;
    }

    public function update()
    {
        $this->validate();

        $borrowing = BorrowingModel::findOrFail($this->borrowingId);
        $oldStatus = $borrowing->status;

        $isReturning = ($this->status === 'returned' && $oldStatus !== 'returned') ||
                       ($this->return_date && !$borrowing->return_date);

        $borrowing->update([
            'member_id' => $this->member_id,
            'book_id' => $this->book_id,
            'borrow_date' => $this->borrow_date,
            'due_date' => $this->due_date,
            'return_date' => $this->return_date ?: null,
            'status' => $this->status,
        ]);

        if ($isReturning) {
            $book = BookModel::find($this->book_id);
            if ($book) {
                $book->increment('stock');
            }

            $borrowing->refresh();

            if ($this->return_date && $borrowing->due_date) {
                $returnDate = Carbon::parse($this->return_date);
                $dueDate = Carbon::parse($borrowing->due_date);

                if ($returnDate->gt($dueDate)) {
                    $daysLate = $returnDate->diffInDays($dueDate);
                    $fineAmount = $daysLate * 1000;

                    Fine::updateOrCreate(
                        ['borrowing_id' => $borrowing->id],
                        ['amount' => $fineAmount, 'paid' => false]
                    );
                }
            }
        }

        if (in_array($this->status, ['borrowed', 'late'])) {
            $this->checkAndGenerateFine($borrowing);
        }

        session()->flash('success', 'Data peminjaman berhasil diperbarui!');
        $this->resetInput();
        $this->dispatch('closeModal');
    }

    public function delete($id)
    {
        $borrowing = BorrowingModel::find($id);
        if ($borrowing) {
            if (in_array($borrowing->status, ['borrowed', 'late'])) {
                $book = BookModel::find($borrowing->book_id);
                if ($book) {
                    $book->increment('stock');
                }
            }

            $borrowing->delete();
            session()->flash('success', 'Data peminjaman berhasil dihapus.');
        }
    }

    private function resetInput()
    {
        $this->borrowingId = null;
        $this->member_id = '';
        $this->book_id = '';
        $this->borrow_date = '';
        $this->due_date = '';
        $this->return_date = '';
        $this->status = 'borrowed';
    }

    private function checkAndGenerateFine($borrowing)
    {
        if (!$borrowing->due_date || $borrowing->return_date) {
            return;
        }

        $dueDate = Carbon::parse($borrowing->due_date);
        $today = Carbon::today();

        if ($today->greaterThan($dueDate)) {
            if ($borrowing->status === 'borrowed') {
                $borrowing->update(['status' => 'late']);
            }

            $daysLate = $dueDate->diffInDays($today);
            $fineAmount = $daysLate * 1000;

            Fine::updateOrCreate(
                ['borrowing_id' => $borrowing->id],
                ['amount' => $fineAmount, 'paid' => false]
            );
        }
    }

    private function generateAutomaticFines()
    {
        BorrowingModel::where('status', 'borrowed')
            ->where('due_date', '<', Carbon::today())
            ->whereNull('return_date')
            ->update(['status' => 'late']);

        $lateBorrowings = BorrowingModel::whereIn('status', ['borrowed', 'late'])
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
}
