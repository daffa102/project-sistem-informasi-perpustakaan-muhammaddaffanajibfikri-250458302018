<?php

namespace App\Livewire\Features\Member;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Book;
use App\Models\Category;
use App\Models\Borrowing;
use Livewire\Attributes\Layout;
use Carbon\Carbon;
use App\Livewire\Traits\Member\HasBorrowingLogic;
use App\Livewire\Traits\Member\HasFineLogic;


#[Layout('layouts.appmember')]
class Dashboard extends Component
{
    use WithPagination;
    use HasBorrowingLogic;
    use HasFineLogic;

    public $search = '';
    public $qrcode = '';
    public $perPage = 12;

    public $totalBooks = 0;
    public $availableBooks = 0;
    public $categoriesCount = 0;

    public $fine = 0;
    public $filterCategory = null;

    protected $paginationTheme = 'tailwind';
    protected $listeners = ['refreshDashboard' => '$refresh'];

    public function mount()
    {
        $this->generateMemberFines();
        $this->loadStats();
        $this->calculateFine();
    }

    public function getMemberId()
    {
        return auth()->user()->member->id ?? null;
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function setCategory($categoryId)
    {
        $this->filterCategory = $categoryId;
        $this->resetPage();
    }

    public function resetFilter()
    {
        $this->filterCategory = null;
        $this->resetPage();
    }

    public function loadStats()
    {
        $this->totalBooks = Book::count();
        $this->availableBooks = Book::where('is_available', true)->count();
        $this->categoriesCount = Category::count();
    }

    public function getBooksProperty()
    {
        $query = Book::with('category')->latest();

        if ($this->search) {
            $query->where(function ($sub) {
                $sub->where('title', 'like', '%' . $this->search . '%')
                    ->orWhere('author', 'like', '%' . $this->search . '%')
                    ->orWhere('isbn', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->filterCategory) {
            $query->where('category_id', $this->filterCategory);
        }

        return $query->paginate($this->perPage);
    }


    public function render()
    {
        return view('livewire.features.member.dashboard', [
            'books' => $this->books,
            'categories' => Category::all(),
            'categoriesCount' => $this->categoriesCount,
            'totalBooks' => $this->totalBooks,
            'availableBooks' => $this->availableBooks,
        ]);
    }
}
