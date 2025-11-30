<?php

namespace App\Livewire\Features\Member;

use Livewire\Component;
use App\Models\Book;
use App\Models\Borrowing;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;
use App\Livewire\Traits\Member\HasBorrowingLogic;

class BookDetail extends Component
{
    use HasBorrowingLogic;
    public $bookId;
    public $book;
    public $relatedBooks = [];
    public $isInWishlist = false;

    public function mount($id)
    {
        $this->bookId = $id;
        $this->book = Book::with('category')->findOrFail($id);

        $this->relatedBooks = Book::with('category')
            ->where('category_id', $this->book->category_id)
            ->where('id', '!=', $this->book->id)
            ->where('is_available', true)
            ->limit(4)
            ->get();

        $this->checkWishlistStatus();
    }

public function checkWishlistStatus()
{
    if (Auth::check()) {
        $memberId = Auth::user()->member->id;

        $this->isInWishlist = Wishlist::where('member_id', $memberId)
            ->where('book_id', $this->book->id)
            ->exists();
    }
}


public function toggleWishlist()
{
    try {
        if (!Auth::check()) {
            session()->flash('error', 'Silakan login terlebih dahulu untuk menambahkan ke wishlist.');
            return redirect()->route('login');
        }

        $memberId = Auth::user()->member->id;

        if ($this->isInWishlist) {
            Wishlist::where('member_id', $memberId)
                ->where('book_id', $this->book->id)
                ->delete();

            $this->isInWishlist = false;
            session()->flash('message', 'Buku dihapus dari wishlist.');
        } else {
            Wishlist::create([
    'member_id' => Auth::user()->member->id,
    'book_id' => $this->book->id,
]);

            $this->isInWishlist = true;
            session()->flash('message', 'Buku ditambahkan ke wishlist!');
        }

        $this->dispatch('wishlist-updated');

    } catch (\Exception $e) {
        session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
    }
}


    public function getMemberId()
    {
        return Auth::user()->member->id ?? null;
    }

    public function borrowBook()
    {
        if (!Auth::check()) {
            session()->flash('error', 'Silakan login terlebih dahulu untuk meminjam buku.');
            return redirect()->route('login');
        }

        $memberId = $this->getMemberId();
        
        // Gunakan method dari Trait
        $this->processBorrowing($this->book, $memberId);
    }

    public function render()
    {
        return view('livewire.features.member.book-detail')
            ->layout('layouts.appmember');
    }
}
