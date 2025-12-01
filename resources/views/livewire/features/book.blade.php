<section class="section mt-4">
    <div class="container">

        {{-- Flash Success --}}
        @if (session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show">
                <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- Flash Error --}}
        @if (session()->has('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="row" id="table-bordered">
            <div class="col-12">

                <div class="card shadow-sm border-0">

                    {{-- Header --}}
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0 fw-semibold">
                            <i class="bi bi-book me-2 text-primary"></i> Book Table
                        </h4>

                        <div class="d-flex gap-2">
                            <input type="text" wire:model.live.debounce.300ms="search"
                                   class="form-control w-50" placeholder="Search book...">

                            <button class="btn btn-primary"
                                    wire:click="create">
                                <i class="bi bi-plus-circle me-1"></i> Add Book
                            </button>
                        </div>
                    </div>

                    {{-- Table --}}
                    <div class="card-content">
                        <div class="table-responsive" style="max-height: 600px; overflow-y: auto;">
                            <table class="table table-bordered table-hover mb-0">
                                <thead class="table-light text-center">
                                    <tr>
                                        <th>No</th>
                                        <th>Image</th>
                                        <th>Title</th>
                                        <th>Description</th>
                                        <th>Author</th>
                                        <th>Publisher</th>
                                        <th>Year</th>
                                        <th>Stock</th>
                                        <th>Category</th>
                                        <th>QR</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @forelse ($books as $book)
                                        <tr class="align-middle">

                                            {{-- No --}}
                                            <td class="text-center">{{ $loop->iteration }}</td>

                                            {{-- Image --}}
                                            <td class="text-center">
                                                @if ($book->image && Storage::disk('public')->exists($book->image))
                                                    <img src="{{ asset('storage/'.$book->image) }}"
                                                         style="width: 60px; height:60px; object-fit:cover;"
                                                         class="rounded shadow-sm">
                                                @else
                                                    <span class="badge bg-secondary">No Image</span>
                                                @endif
                                            </td>

                                            {{-- Title --}}
                                            <td>{{ $book->title }}</td>

                                            {{-- Desc --}}
                                            <td style="max-width: 220px;">
                                                <div class="small text-muted">
                                                    {{ Str::limit($book->description, 80) }}
                                                </div>
                                            </td>

                                            {{-- Other --}}
                                            <td>{{ $book->author }}</td>
                                            <td>{{ $book->publisher }}</td>
                                            <td class="text-center">{{ $book->year }}</td>

                                            {{-- Stock --}}
                                            <td class="text-center">
                                                @if ($book->stock > 10)
                                                    <span class="badge bg-success">{{ $book->stock }}</span>
                                                @elseif ($book->stock > 0)
                                                    <span class="badge bg-warning text-dark">{{ $book->stock }}</span>
                                                @else
                                                    <span class="badge bg-danger">{{ $book->stock }}</span>
                                                @endif
                                            </td>

                                            {{-- Category --}}
                                            <td class="text-center">
                                                <span class="badge bg-secondary">
                                                    {{ $book->category->name ?? '-' }}
                                                </span>
                                            </td>

                                            {{-- QR --}}
                                            <td class="text-center">
                                                @if ($book->qrcode && Storage::disk('public')->exists($book->qrcode))
                                                    <img src="{{ asset('storage/' . $book->qrcode) }}"
                                                         class="img-thumbnail"
                                                         style="width: 80px">
                                                @else
                                                    <button class="btn btn-sm btn-warning"
                                                            wire:click="regenerateQRCode('{{ $book->id }}')">
                                                        <i class="bi bi-qr-code"></i> Generate
                                                    </button>
                                                @endif
                                            </td>

                                            {{-- Actions --}}
                                            <td class="text-center">
                                                <button wire:click="edit('{{ $book->id }}')"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#bookModal"
                                                        class="btn btn-sm btn-outline-primary">
                                                    <i class="bi bi-pencil-square"></i>
                                                </button>

                                                <button onclick="confirmDelete('{{ $book->id }}')"
                                                        class="btn btn-sm btn-outline-danger">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </td>

                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="11" class="text-center text-muted py-3">
                                                <i class="bi bi-inbox fs-1"></i>
                                                <p class="mb-0 mt-2">No books found.</p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        {{-- Pagination --}}
                        @if ($books->hasPages())
                            <div class="card-footer bg-light d-flex justify-content-end">
                                {{ $books->links() }}
                            </div>
                        @endif
                    </div>

                </div>

            </div>
        </div>
    </div>

    {{-- Modal Add/Edit --}}
    <div wire:ignore.self class="modal fade" id="bookModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                {{-- Header --}}
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">
                        <i class="bi bi-{{ $bookId ? 'pencil-square' : 'plus-circle' }} me-2"></i>
                        {{ $bookId ? 'Edit Book' : 'Add Book' }}
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="row">

                        {{-- Left form --}}
                        <div class="col-md-8">

                            {{-- Category --}}
                            <div class="mb-3">
                                <label class="form-label fw-semibold">
                                    <i class="bi bi-tag text-primary"></i> Category
                                </label>
                                <select class="form-select" wire:model="category_id">
                                    <option value="">-- Select Category --</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                @error('category_id') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            {{-- Title --}}
                            <div class="mb-3">
                                <label class="form-label fw-semibold">
                                    <i class="bi bi-book text-primary"></i> Title
                                </label>
                                <input type="text" class="form-control" wire:model="title">
                                @error('title') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            {{-- Description --}}
                            <div class="mb-3">
                                <label class="form-label fw-semibold">
                                    <i class="bi bi-card-text text-primary"></i> Description
                                </label>
                                <textarea class="form-control" rows="3" wire:model="description"></textarea>
                                @error('description') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            {{-- Author --}}
                            <div class="mb-3">
                                <label class="form-label fw-semibold">
                                    <i class="bi bi-person text-primary"></i> Author
                                </label>
                                <input type="text" class="form-control" wire:model="author">
                                @error('author') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            {{-- Publisher --}}
                            <div class="mb-3">
                                <label class="form-label fw-semibold">
                                    <i class="bi bi-building text-primary"></i> Publisher
                                </label>
                                <input type="text" class="form-control" wire:model="publisher">
                                @error('publisher') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            {{-- Year / Stock --}}
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">
                                        <i class="bi bi-calendar text-primary"></i> Year
                                    </label>
                                    <input type="number" class="form-control" wire:model="year">
                                    @error('year') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">
                                        <i class="bi bi-box-seam text-primary"></i> Stock
                                    </label>
                                    <input type="number" class="form-control" wire:model="stock">
                                    @error('stock') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>
                            </div>

                            {{-- Image upload --}}
                            <div class="mb-3">
                                <label class="form-label fw-semibold">
                                    <i class="bi bi-image text-primary"></i> Book Image
                                </label>
                                <input type="file" class="form-control" wire:model="image">

                                @error('image') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            {{-- Preview image new upload --}}
                            @if ($image && is_object($image))
                                <div class="mt-2">
                                    <p class="fw-semibold small">Preview Image (New Upload)</p>
                                    <img src="{{ $image->temporaryUrl() }}"
                                         style="width: 150px; height:150px; object-fit:cover;"
                                         class="rounded border shadow-sm">
                                </div>
                            @endif

                        </div>

                        {{-- Right: Preview image & QR --}}
                        <div class="col-md-4">

                            {{-- Preview Image Lama --}}
                            @if ($bookId && $image && !is_object($image))
                                <div class="text-center p-3 bg-light rounded mb-3">
                                    <p class="fw-semibold small mb-2">Current Book Image</p>
                                    <img src="{{ asset('storage/' . $image) }}"
                                         class="img-thumbnail shadow-sm"
                                         style="width:180px; height:180px; object-fit:cover;">
                                </div>
                            @else
                                <div class="text-center p-3 bg-light rounded mb-3">
                                    <i class="bi bi-image text-muted" style="font-size:4rem;"></i>
                                    <p class="small mb-0 text-muted">No image yet</p>
                                </div>
                            @endif

                            {{-- QR Code Preview --}}
                            @if ($bookId && $qrcode)
                                <div class="text-center p-3 bg-light rounded">
                                    <label class="form-label fw-semibold d-block mb-3">
                                        <i class="bi bi-qr-code"></i> QR Code
                                    </label>
                                    <img src="{{ asset('storage/'.$qrcode) }}"
                                         class="img-thumbnail"
                                         style="width:180px; height:180px;">
                                </div>
                            @endif

                        </div>

                    </div>
                </div>

                {{-- Footer --}}
                <div class="modal-footer">
                    <button class="btn btn-secondary" wire:click="cancel">
                        <i class="bi bi-x-circle"></i> Cancel
                    </button>

                    @if ($bookId)
                        <button class="btn btn-primary" wire:click="update">
                            <i class="bi bi-check-circle"></i> Save Changes
                        </button>
                    @else
                        <button class="btn btn-primary" wire:click="store">
                            <i class="bi bi-plus-circle"></i> Add Book
                        </button>
                    @endif
                </div>

            </div>
        </div>
    </div>
</section>

@push('scripts')
<script>
function confirmDelete(id) {
    Swal.fire({
        title: "Yakin mau hapus?",
        text: "Data buku akan dihapus permanen!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Ya, hapus",
        cancelButtonText: "Batal"
    }).then((result) => {
        if (result.isConfirmed) {
            Livewire.dispatch("delete", { id: id });
        }
    });
}

window.addEventListener('showModal', () => {
    new bootstrap.Modal('#bookModal').show();
});

window.addEventListener('closeModal', () => {
    const modalEl = document.getElementById('bookModal');
    const modal = bootstrap.Modal.getInstance(modalEl);
    if (modal) modal.hide();

    setTimeout(() => {
        document.querySelectorAll('.modal-backdrop').forEach(b => b.remove());
        document.body.classList.remove('modal-open');
        document.body.style.removeProperty('overflow');
    }, 200);
});
</script>
@endpush
