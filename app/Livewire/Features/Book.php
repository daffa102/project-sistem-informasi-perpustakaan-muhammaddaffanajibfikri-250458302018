<?php

namespace App\Livewire\Features;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Livewire\WithFileUploads;
use App\Models\Book as BookModel;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class Book extends Component
{
    use WithPagination, WithFileUploads;

    public $search = '';
    protected $paginationTheme = 'bootstrap';

    public $bookId, $category_id, $title, $description, $author, $publisher, $year, $stock = 0;
    public $qrcode, $image;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    #[Layout('layouts.app')]
    public function render()
    {
        $books = BookModel::query()
            ->where(function ($q) {
                $q->where('title', 'like', "%{$this->search}%")
                    ->orWhere('author', 'like', "%{$this->search}%")
                    ->orWhere('publisher', 'like', "%{$this->search}%")
                    ->orWhere('year', 'like', "%{$this->search}%");
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $categories = Category::all();

        return view('livewire.features.book', compact('books', 'categories'));
    }

    public function store()
    {
        $this->validate([
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'author' => 'required|string|max:255',
            'publisher' => 'required|string|max:255',
            'year' => 'required|digits:4',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|max:2048',
        ]);

        $imagePath = null;
        if ($this->image) {
            $imagePath = $this->image->store('books', 'public');
        }

        $book = BookModel::create([
            'id' => (string) Str::uuid(),
            'category_id' => $this->category_id,
            'title' => $this->title,
            'description' => $this->description,
            'author' => $this->author,
            'publisher' => $this->publisher,
            'year' => $this->year,
            'stock' => $this->stock,
            'image' => $imagePath,
        ]);

        $this->generateQRCode($book);

        $this->resetInput();
        $this->dispatch('$refresh');
        $this->dispatch('closeModal');

        session()->flash('success', 'Book added successfully with image & QR Code!');
    }

    public function edit($id)
    {
        $book = BookModel::findOrFail($id);

        $this->bookId = $book->id;
        $this->category_id = $book->category_id;
        $this->title = $book->title;
        $this->description = $book->description;
        $this->author = $book->author;
        $this->publisher = $book->publisher;
        $this->year = $book->year;
        $this->stock = $book->stock;
        $this->qrcode = $book->qrcode;
        $this->image = $book->image;

        $this->dispatch('showModal');
    }

    public function update()
    {
        $this->validate([
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'author' => 'required|string|max:255',
            'publisher' => 'required|string|max:255',
            'year' => 'required|digits:4',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|max:2048',
        ]);

        $book = BookModel::findOrFail($this->bookId);

        // update data text
        $book->update([
            'category_id' => $this->category_id,
            'title' => $this->title,
            'description' => $this->description,
            'author' => $this->author,
            'publisher' => $this->publisher,
            'year' => $this->year,
            'stock' => $this->stock,
        ]);

        // update image jika upload baru
        if ($this->image && is_object($this->image)) {
            if ($book->image && Storage::disk('public')->exists($book->image)) {
                Storage::disk('public')->delete($book->image);
            }

            $imagePath = $this->image->store('books', 'public');
            $book->update(['image' => $imagePath]);
        }

        $this->resetInput();
        $this->dispatch('$refresh');
        $this->dispatch('closeModal');

        session()->flash('success', 'Book updated successfully!');
    }

    public function delete($id)
    {
        $book = BookModel::findOrFail($id);

        if ($book->image && Storage::disk('public')->exists($book->image)) {
            Storage::disk('public')->delete($book->image);
        }

        if ($book->qrcode && Storage::disk('public')->exists($book->qrcode)) {
            Storage::disk('public')->delete($book->qrcode);
        }

        $book->delete();

        $this->dispatch('$refresh');

        $this->dispatch('swal:success', [
            'title' => 'Berhasil!',
            'message' => 'Buku berhasil dihapus.'
        ]);
    }


    private function generateQRCode($book)
    {
        try {
            $qrDir = 'qrcodes';

            if (!Storage::disk('public')->exists($qrDir)) {
                Storage::disk('public')->makeDirectory($qrDir);
            }

            $filename = $book->id . '.svg';
            $storagePath = $qrDir . '/' . $filename;


            $qrContent = $book->id;

            $qrCodeSvg = QrCode::format('svg')
                ->size(300)
                ->margin(2)
                ->generate($qrContent);

            Storage::disk('public')->put($storagePath, $qrCodeSvg);

            $book->update(['qrcode' => $storagePath]);

            return true;
        } catch (\Exception $e) {
            \Log::error('QR Code Generation Failed: ' . $e->getMessage());
            return false;
        }
    }

    public function regenerateQRCode($id)
    {
        $book = BookModel::findOrFail($id);

        if ($book->qrcode && Storage::disk('public')->exists($book->qrcode)) {
            Storage::disk('public')->delete($book->qrcode);
        }

        if ($this->generateQRCode($book)) {
            $this->dispatch('$refresh');
            session()->flash('success', 'QR Code regenerated successfully!');
        } else {
            session()->flash('error', 'Failed to regenerate QR Code.');
        }
    }



    private function resetInput()
    {
        $this->bookId = null;
        $this->category_id = '';
        $this->title = '';
        $this->description = '';
        $this->author = '';
        $this->publisher = '';
        $this->year = '';
        $this->stock = 0;
        $this->qrcode = null;
        $this->image = null;
    }

    public function create()
    {
        $this->resetInput();
        $this->dispatch('showModal');
    }
}
