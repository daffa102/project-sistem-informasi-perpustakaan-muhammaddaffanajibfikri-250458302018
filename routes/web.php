<?php

use App\Livewire\Auth\Login;
use App\Livewire\Auth\Register;
use App\Livewire\Features\Book;
use App\Livewire\Features\User;
use App\Livewire\Features\Fines;
use App\Livewire\Features\Member;
use App\Livewire\Features\Category;
use App\Livewire\Features\Dashboard;
use App\Livewire\Features\Borrowing;
use App\Livewire\Features\Member\BorrowScanner;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// PUBLIC ROUTES
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/home', function () {
    if (Auth::check()) {
        if (Auth::user()->role == 'admin') {
            return redirect()->route('admin.dashboard');
        } else {
            return redirect()->route('member.dashboard');
        }
    }
    return redirect()->route('login');
})->name('home');

// AUTH ROUTES
Route::prefix('auth')->middleware('guest')->group(function () {
    Route::get('/register', Register::class)->name('register');
    Route::get('/login', Login::class)->name('login');
});

Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect()->route('login');
})->middleware('auth')->name('logout');


Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('dashboard', Dashboard::class)->name('admin.dashboard');
    Route::get('user', User::class)->name('admin.user.dashboard');
    Route::get('member', Member::class)->name('admin.member.dashboard');
    Route::get('book', Book::class)->name('admin.book.dashboard');
    Route::get('category', Category::class)->name('admin.category.dashboard');
    Route::get('borrowing', Borrowing::class)->name('admin.borrowing.dashboard');
    Route::get('fines', Fines::class)->name('admin.fines.dashboard');
});


Route::middleware(['auth', 'role:member'])->prefix('member')->group(function () {
    Route::get('dashboard', \App\Livewire\Features\Member\Dashboard::class)->name('member.dashboard');
    Route::get('dashboard/book/{id}', \App\Livewire\Features\Member\BookDetail::class)->name('member.book.detail');
    Route::get('profile', \App\Livewire\Features\Member\Profile::class)->name('member.profile');
    Route::get('borrow-scanner', BorrowScanner::class)->name('member.borrow.scanner');
    Route::get('wishlist', \App\Livewire\Features\Member\WishlistPage::class)->name('member.wishlist');
    
   
    Route::get('fines/payment', \App\Livewire\Features\Member\FinePayment::class)->name('member.fines.payment');
});

// =========================
// PAYMENT ROUTES (Midtrans)
// =========================
Route::middleware('auth')->group(function () {
    Route::post('/payment/create', [PaymentController::class, 'createPayment'])->name('payment.create');
});

Route::post('/payment/callback', [PaymentController::class, 'callback'])->name('payment.callback');

Route::get('/payment/finish', [PaymentController::class, 'finish'])->name('payment.finish');
Route::get('/payment/unfinish', [PaymentController::class, 'unfinish'])->name('payment.unfinish');
Route::get('/payment/error', [PaymentController::class, 'error'])->name('payment.error');


