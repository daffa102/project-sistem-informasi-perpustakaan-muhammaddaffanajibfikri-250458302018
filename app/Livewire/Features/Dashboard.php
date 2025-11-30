<?php

namespace App\Livewire\Features;

use Livewire\Component;
use App\Models\Book;
use App\Models\Member;
use App\Models\Category;
use App\Models\Borrowing;
use Carbon\Carbon;
use Livewire\Attributes\Layout;



class Dashboard extends Component
{
    #[Layout('layouts.app')]
    public function render()
    {
        // Stats yang sudah ada
        $booksCount = Book::count();
        $membersCount = Member::count();
        $categoriesCount = Category::count();
        $borrowingsCount = Borrowing::count();

        // Hitung buku terlambat (status = 'late' atau sudah melewati due_date)
        $overdueBorrowings = Borrowing::where(function($query) {
                $query->where('status', 'late')
                      ->orWhere(function($q) {
                          $q->where('status', 'borrowed')
                            ->where('due_date', '<', now()->format('Y-m-d'));
                      });
            })
            ->count();

        // Hitung buku yang jatuh tempo dalam 3 hari
        $dueSoonBorrowings = Borrowing::where('status', 'borrowed')
            ->whereBetween('due_date', [
                now()->format('Y-m-d'),
                now()->addDays(3)->format('Y-m-d')
            ])
            ->count();

        // Top 5 Buku Terpopuler
        $topBooks = Book::withCount('borrowings')
            ->with('category')
            ->having('borrowings_count', '>', 0)
            ->orderBy('borrowings_count', 'desc')
            ->take(5)
            ->get();

        // Chart data kategori
        $chartData = Category::withCount('books')
            ->get()
            ->map(function($category) {
                return [
                    'name' => $category->name,
                    'count' => $category->books_count
                ];
            });

        $chartCategories = $chartData->pluck('name')->toArray();
        $chartData = $chartData->pluck('count')->toArray();

        // Member chart (7 hari terakhir)
        $memberChartData = collect();
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $count = Member::whereDate('created_at', $date->format('Y-m-d'))->count();
            $memberChartData->push([
                'date' => $date->format('d M'),
                'count' => $count
            ]);
        }

        $memberChartDates = $memberChartData->pluck('date')->toArray();
        $memberChartCounts = $memberChartData->pluck('count')->toArray();

        return view('livewire.features.dashboard', [
            'booksCount' => $booksCount,
            'membersCount' => $membersCount,
            'categoriesCount' => $categoriesCount,
            'borrowingsCount' => $borrowingsCount,
            'overdueBorrowings' => $overdueBorrowings,
            'dueSoonBorrowings' => $dueSoonBorrowings,
            'topBooks' => $topBooks,
            'chartCategories' => $chartCategories,
            'chartData' => $chartData,
            'memberChartDates' => $memberChartDates,
            'memberChartCounts' => $memberChartCounts,
        ]);
    }
}
