<div class="container mt-4">
    <h2 class="mb-3">Fines Management</h2>

    @if (session()->has('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="d-flex justify-content-between mb-3">
        <input type="text" wire:model.live="search" class="form-control w-25" placeholder="Search member or book...">
        <button class="btn btn-primary" wire:click="create">+ Add Fine</button>
    </div>

    <table class="table table-bordered table-hover align-middle">
        <thead class="table-light text-center">
            <tr>
                <th>No</th>
                <th>Member</th>
                <th>Book</th>
                <th>Amount</th>
                <th>Status</th>
                <th>Return Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($fines as $index => $fine)
                <tr>
                    <td class="text-center">{{ $fines->firstItem() + $index }}</td>
                    <td>{{ $fine->borrowing->member->name ?? '-' }}</td>
                    <td>{{ $fine->borrowing->book->title ?? '-' }}</td>
                    <td class="text-end">Rp {{ number_format($fine->amount, 0, ',', '.') }}</td>
                    <td class="text-center">
                        @if ($fine->paid)
                            <span class="badge bg-success">Paid</span>
                        @else
                            <span class="badge bg-danger">Unpaid</span>
                        @endif
                    </td>
                    <td class="text-center">
                        {{ $fine->borrowing->return_date ? \Carbon\Carbon::parse($fine->borrowing->return_date)->format('d M Y') : 'Not returned' }}
                    </td>
                    <td class="text-center">
                        <button wire:click="edit({{ $fine->id }})" class="btn btn-sm btn-warning">Edit</button>

                        @if ($fine->paid)
                            <button wire:click="togglePaid({{ $fine->id }})" class="btn btn-sm btn-outline-secondary">
                                Mark as Unpaid
                            </button>
                        @else
                            <button wire:click="togglePaid({{ $fine->id }})" class="btn btn-sm btn-outline-success">
                                Mark as Paid
                            </button>
                        @endif

                        <button type="button" onclick="confirmDelete({{ $fine->id }})" class="btn btn-sm btn-danger">Delete</button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center text-muted">No fines found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-2">
        {{ $fines->links() }}
    </div>

    <!-- 🟢 Modal -->
    <div wire:ignore.self class="modal fade" id="fineModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content  text-light">
                <div class="modal-header bg-light">
                    <h5 class="modal-title">{{ $fineId ? 'Edit Fine' : 'Add Fine' }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <form wire:submit.prevent="{{ $fineId ? 'update' : 'store' }}">
                        <div class="mb-3">
                            <label>Borrowing</label>
                            <select wire:model="borrowing_id" class="form-select">
                                <option value="">-- Select Borrowing --</option>
                                @foreach ($borrowings as $borrowing)
                                    <option value="{{ $borrowing->id }}">
                                        {{ $borrowing->member->name ?? '-' }} — {{ $borrowing->book->title ?? '-' }}
                                    </option>
                                @endforeach
                            </select>
                            @error('borrowing_id') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label>Amount</label>
                            <input type="number" wire:model="amount" class="form-control" readonly>
                            @error('amount') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-check mb-3">
                            <input type="checkbox" wire:model="paid" class="form-check-input" id="paid">
                            <label for="paid" class="form-check-label">Mark as Paid</label>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">
                            {{ $fineId ? 'Update' : 'Save' }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- 🔧 Fix modal backdrop -->
    @push('scripts')
    <script>
        function confirmDelete(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.dispatch('delete-fine', { id: id });
                }
            })
        }

        window.addEventListener('showModal', () => {
            const modal = new bootstrap.Modal(document.getElementById('fineModal'));
            modal.show();
        });

        window.addEventListener('closeModal', () => {
            const modalEl = document.getElementById('fineModal');
            const modal = bootstrap.Modal.getInstance(modalEl);
            if (modal) modal.hide();

            // Hapus backdrop gelap
            setTimeout(() => {
                document.querySelectorAll('.modal-backdrop').forEach(b => b.remove());
                document.body.classList.remove('modal-open');
                document.body.style.removeProperty('overflow');
                document.body.style.removeProperty('padding-right');
            }, 200);
        });
    </script>
    @endpush
</div>
