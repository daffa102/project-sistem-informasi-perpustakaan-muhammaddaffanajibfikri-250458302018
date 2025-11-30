<section class="section mt-4">
    <div class="container">
        <div class="row" id="table-bordered">
            <div class="col-12">
                <div class="card shadow-sm border-0">

                    <!-- Header -->
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0 fw-semibold">
                            <i class="bi bi-people me-2 text-primary"></i> Category Table
                        </h4>

                        <div class="d-flex gap-2">
                            <input type="text"
                                   wire:model.live.debounce.300ms="search"
                                   class="form-control w-50"
                                   placeholder="Search category...">

                            <button type="button" class="btn btn-primary" wire:click="create">
                                <i class="bi bi-plus-circle me-1"></i> Add Category
                            </button>
                        </div>
                    </div>

                    <!-- Table -->
                    <div class="card-content">
                        <div class="table-responsive" style="max-height: 600px; overflow-y: auto;">
                            <table class="table table-bordered table-hover mb-0">
                                <thead class="table-light text-center">
                                    <tr>
                                        <th style="width: 40px;">No</th>
                                        <th style="width: 200px;">Name</th>
                                        <th style="width: 300px;">Description</th>
                                        <th style="width: 120px;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($categories as $category)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td>{{ $category->name }}</td>
                                            <td>{{ $category->description }}</td>
                                            <td class="text-center">
                                                <button class="btn btn-sm btn-outline-primary me-1"
                                                        wire:click="edit({{ $category->id }})">
                                                    <i class="bi bi-pencil-square"></i>
                                                </button>
                                                <button class="btn btn-sm btn-outline-danger"
                                                        onclick="confirmDelete({{ $category->id }})">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center text-muted py-3">
                                                No categories found.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        @if ($categories->hasPages())
                            <div class="card-footer d-flex justify-content-end bg-light">
                                {{ $categories->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Add/Edit -->
    <div wire:ignore.self class="modal fade" id="categoryModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h5 class="modal-title">{{ $categoryId ? 'Edit Category' : 'Add Category' }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input type="text" wire:model.defer="name" class="form-control">
                        @error('name') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea wire:model.defer="description" class="form-control"></textarea>
                        @error('description') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" wire:click="cancel" class="btn btn-secondary">Cancel</button>
                    @if ($categoryId)
                        <button type="button" wire:click="update" class="btn btn-primary">Save Changes</button>
                    @else
                        <button type="button" wire:click="store" class="btn btn-primary">Add Category</button>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script>
// Fungsi init yang akan dipanggil setiap kali halaman di-load
function initializeCategoryPage() {
    // Event Listeners untuk Modal
    Livewire.on('showModal', () => {
        const modalEl = document.getElementById('categoryModal');
        if (modalEl) {
            const modal = new bootstrap.Modal(modalEl);
            modal.show();
        }
    });

    Livewire.on('closeModal', () => {
        const modalEl = document.getElementById('categoryModal');
        if (modalEl) {
            const modal = bootstrap.Modal.getInstance(modalEl);
            if (modal) modal.hide();

            setTimeout(() => {
                document.querySelectorAll('.modal-backdrop').forEach(b => b.remove());
                document.body.classList.remove('modal-open');
                document.body.style.removeProperty('overflow');
                document.body.style.removeProperty('padding-right');
            }, 150);
        }
    });

    // Event Listener untuk Delete Category
    Livewire.on('deleteCategory', ({ id }) => {
        Livewire.find(document.querySelector('[wire\\:id]').getAttribute('wire:id')).call('delete', id);
    });
}

// Jalankan saat halaman pertama kali dimuat
document.addEventListener('livewire:init', () => {
    initializeCategoryPage();
});

// Jalankan ulang setelah navigasi wire:navigate
document.addEventListener('livewire:navigated', () => {
    initializeCategoryPage();
});

// Fungsi Confirm Delete (Global function)
function confirmDelete(id) {
    Swal.fire({
        title: "Are you sure?",
        text: "This category will be permanently deleted!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Delete",
        cancelButtonText: "Cancel"
    }).then((result) => {
        if (result.isConfirmed) {
            // Dispatch event ke Livewire
            Livewire.dispatch("deleteCategory", { id: id });

            Swal.fire({
                title: "Deleted!",
                text: "Category has been deleted.",
                icon: "success",
                timer: 1500,
                showConfirmButton: false
            });
        }
    });
}
</script>
@endpush
