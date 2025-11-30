<section class="section mt-4">
    <div class="container">
        <div class="row" id="table-bordered">
            <div class="col-12">
                <div class="card shadow-sm border-0">
                    <!-- 🟦 Header -->
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0 fw-semibold">
                            <i class="bi bi-journal-bookmark-fill me-2 text-primary"></i> Borrowing Table
                        </h4>
                        <div class="d-flex gap-2">
                            <input type="text" wire:model.live.debounce.300ms="search"
                                   class="form-control w-50"
                                   placeholder="Search member or book">
                            <button class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#borrowingModal" wire:click="create">
                                <i class="bi bi-plus-circle me-1"></i> Add Borrowing
                            </button>
                        </div>
                    </div>

                    <!-- 🟩 Table Content -->
                    <div class="card-content">
                        <div class="table-responsive" style="max-height: 600px; overflow-y: auto;">
                            <table class="table table-bordered table-hover mb-0">
                                <thead class="table-light text-center">
                                    <tr>
                                        <th style="width: 50px;">No</th>
                                        <th style="width: 150px;">Member</th>
                                        <th style="width: 200px;">Book</th>
                                        <th style="width: 120px;">Borrow Date</th>
                                        <th style="width: 120px;">Due Date</th>
                                        <th style="width: 120px;">Return Date</th>
                                        <th style="width: 100px;">Status</th>
                                        <th style="width: 120px;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($borrowings as $b)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td>{{ $b->member->name ?? '-' }}</td>
                                            <td>{{ $b->book->title ?? '-' }}</td>
                                            <td class="text-center">{{ $b->borrow_date }}</td>
                                            <td class="text-center">
                                                <span class="badge bg-warning text-dark">{{ $b->due_date ?? '-' }}</span>
                                            </td>
                                            <td class="text-center">{{ $b->return_date ?? '-' }}</td>
                                            <td class="text-center">
                                                <span class="badge bg-{{
                                                    $b->status == 'borrowed' ? 'primary' :
                                                    ($b->status == 'late' ? 'danger' : 'success')
                                                }}">
                                                    {{ ucfirst($b->status) }}
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <button wire:click="edit({{ $b->id }})"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#borrowingModal"
                                                    class="btn btn-sm btn-outline-primary me-1">
                                                    <i class="bi bi-pencil-square"></i>
                                                </button>
                                                <button type="button"
                                                        onclick="confirmDelete({{ $b->id }})"
                                                        class="btn btn-sm btn-outline-danger">
                                                    <i class="bi bi-trash"></i>
                                                </button>

                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center text-muted py-3">
                                                No borrowing records found.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        @if ($borrowings->hasPages())
                            <div class="card-footer d-flex justify-content-end bg-light">
                                {{ $borrowings->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 🟦 Modal Add/Edit Borrowing -->
    <div wire:ignore.self class="modal fade" id="borrowingModal" tabindex="-1"
         aria-labelledby="borrowingModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg ">
            <div class="modal-content  text-dark">
                <div class="modal-header bg-light">
                    <h5 class="modal-title" id="borrowingModalLabel">
                        {{ $borrowingId ? 'Edit Borrowing' : 'Add Borrowing' }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Member</label>
                            <select wire:model="member_id" class="form-select">
                                <option value="">-- Select Member --</option>
                                @foreach ($members as $member)
                                    <option value="{{ $member->id }}">{{ $member->name }}</option>
                                @endforeach
                            </select>
                            @error('member_id') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Book</label>
                            <select wire:model="book_id" class="form-select">
                                <option value="">-- Select Book --</option>
                                @foreach ($books as $book)
                                    <option value="{{ $book->id }}">{{ $book->title }}</option>
                                @endforeach
                            </select>
                            @error('book_id') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Borrow Date</label>
                            <input type="date" wire:model="borrow_date" class="form-control">
                            @error('borrow_date') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Due Date <small class="text-muted">(Jatuh Tempo)</small></label>
                            <input type="date" wire:model="due_date" class="form-control">
                            @error('due_date') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Return Date <small class="text-muted">(Optional)</small></label>
                            <input type="date" wire:model="return_date" class="form-control">
                            @error('return_date') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Status</label>
                            <select wire:model="status" class="form-select">
                                <option value="borrowed">Borrowed</option>
                                <option value="late">Late</option>
                                <option value="returned">Returned</option>
                            </select>
                            @error('status') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Cancel
                    </button>
                    @if ($borrowingId)
                        <button type="button" wire:click="update" class="btn btn-primary">
                            Save Changes
                        </button>
                    @else
                        <button type="button" wire:click="store" class="btn btn-primary">
                            Add Borrowing
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script>

    window.addEventListener('showModal', () => {
        const modal = new bootstrap.Modal(document.getElementById('borrowingModal'));
        modal.show();
    });


    window.addEventListener('closeModal', () => {
        const modalEl = document.getElementById('borrowingModal');
        const modal = bootstrap.Modal.getInstance(modalEl);
        if (modal) modal.hide();


        setTimeout(() => {
            document.querySelectorAll('.modal-backdrop').forEach(backdrop => backdrop.remove());
            document.body.classList.remove('modal-open');
            document.body.style.removeProperty('overflow');
            document.body.style.removeProperty('padding-right');
        }, 200);
    });

    document.addEventListener("DOMContentLoaded", function () {

    window.confirmDelete = function(id) {
        Swal.fire({
            title: 'Yakin mau hapus?',
            text: "Data peminjaman akan dihapus permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                @this.call('delete', id);
                Swal.fire(
                    'Terhapus!',
                    'Data peminjaman berhasil dihapus.',
                    'success'
                );
            }
        });
    }

});
</script>
@endpush

