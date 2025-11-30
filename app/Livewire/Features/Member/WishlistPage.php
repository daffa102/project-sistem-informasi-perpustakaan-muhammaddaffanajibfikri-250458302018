<?php

namespace App\Livewire\Features\Member;

use App\Models\Wishlist;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class WishlistPage extends Component
{
    use WithPagination;

    protected $listeners = ['wishlist-updated' => '$refresh'];

    public function removeFromWishlist($wishlistId)
    {
        try {
            $wishlist = Wishlist::where('id', $wishlistId)
                ->where('member_id', Auth::user()->member->id)
                ->first();

            if ($wishlist) {
                $wishlist->delete();
                session()->flash('message', 'Buku berhasil dihapus dari wishlist');
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function clearAllWishlist()
    {
        try {
            Wishlist::where('member_id', Auth::user()->member->id)->delete();
            session()->flash('message', 'Semua wishlist berhasil dihapus');
        } catch (\Exception $e) {
            session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function render()
    {
        $wishlists = Wishlist::with('book.category')
            ->where('member_id', Auth::user()->member->id)
            ->latest()
            ->paginate(12);

        return view('livewire.features.member.wishlist-page', [
            'wishlists' => $wishlists
        ])->layout('layouts.appmember');
    }
}
