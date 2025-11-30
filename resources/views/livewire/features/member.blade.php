    <section class="section mt-4">
        <div class="container">
            <div class="row" id="table-bordered">
                <div class="col-12">
                    <div class="card shadow-sm border-0">
                        <div class="card-header d-flex justify-content-between align-items-center ">
                            <h4 class="card-title mb-0 fw-semibold">
                                <i class="bi bi-people me-2 text-primary"></i> Member Table
                            </h4>
                            <div class="d-flex gap-2">
                                <input type="text" wire:model.live.debounce.300ms="search"
                                    class="form-control w-50" placeholder="Search member...">
                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#memberModal"
                                    wire:click="create">
                                    <i class="bi bi-plus-circle me-1"></i> Add Member
                                </button>
                            </div>
                        </div>

                        <div class="card-content">
                            <div class="table-responsive" style="max-height: 600px; overflow-y: auto;">
                                <table class="table table-bordered table-hover mb-0">
                                    <thead class="table-light text-center">
                                        <tr>
                                            <th style="width: 40px;">No</th>
                                            <th style="width: 100px;">Name</th>
                                            <th style="width: 100px;">NIM</th>
                                            <th style="width: 100px;">Phone</th>
                                            <th style="width: 150px;">Address</th>
                                            <th style="width: 120px;">Actions</th>
                                        </tr>
                                    </thead>
                                <tbody>
                                    @forelse ($users as $index => $user)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td>{{ $user->name ?? '-' }}</td>
                                            <td>{{ $user->nim ?? '-' }}</td>
                                            <td>{{ $user->phone ?? '-' }}</td>
                                            <td>{{ $user->address ?? '-' }}</td>
                                            <td class="text-center">
                                                <button wire:click="edit({{ $user->id }})"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#memberModal"
                                                    class="btn btn-sm btn-outline-primary me-1">
                                                    <i class="bi bi-pencil-square"></i>
                                                </button>
                                                <button type="button"
                                                    onclick="confirmDelete({{ $user->id }})"
                                                    class="btn btn-sm btn-outline-danger">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center text-muted py-3">No members found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        @if ($users->hasPages())
                            <div class="card-footer d-flex justify-content-end bg-light">
                                {{ $users->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 🟦 Modal Add/Edit Member -->
    <div wire:ignore.self class="modal fade" id="memberModal" tabindex="-1" aria-labelledby="memberModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h5 class="modal-title" id="memberModalLabel">
                        {{ $memberId ? 'Edit Member' : 'Add Member' }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">User Account</label>
                        @if($memberId)
                            <input type="text" class="form-control" value="{{ $users->find($memberId)->user->name ?? 'Unknown' }}" disabled>
                            <small class="text-muted">User account cannot be changed.</small>
                        @else
                            <select wire:model="user_id" class="form-select">
                                <option value="">-- Select User --</option>
                                @foreach($availableUsers as $u)
                                    <option value="{{ $u->id }}">{{ $u->name }} ({{ $u->email }})</option>
                                @endforeach
                            </select>
                            @error('user_id') <span class="text-danger small">{{ $message }}</span> @enderror
                        @endif
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input type="text" wire:model="name" class="form-control">
                        @error('name') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">NIM</label>
                        <input type="text" wire:model="nim" class="form-control">
                        @error('nim') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Phone</label>
                        <input type="text" wire:model="phone" class="form-control">
                        @error('phone') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Address</label>
                        <textarea wire:model="address" class="form-control" rows="2"></textarea>
                        @error('address') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="modal-footer">
                        <button type="button" wire:click="cancel" class="btn btn-secondary">Cancel</button>
                    @if ($memberId)
                        <button type="button" wire:click="update" class="btn btn-primary">Save Changes</button>
                    @else
                        <button type="button" wire:click="store" class="btn btn-primary">Add Member</button>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>


@push('scripts')
<script>
    // Show modal
    window.addEventListener('showModal', () => {
        const modalEl = document.getElementById('memberModal');
        const modal = new bootstrap.Modal(modalEl);
        modal.show();
    });

    // Close modal
    window.addEventListener('closeModal', () => {
        const modalEl = document.getElementById('memberModal');
        const modal = bootstrap.Modal.getInstance(modalEl);

        if (modal) {
            modal.hide();
        }

        // Bersihkan backdrop Bootstrap (kadang ketinggalan)
        setTimeout(() => {
            document.querySelectorAll('.modal-backdrop').forEach(backdrop => backdrop.remove());
            document.body.classList.remove('modal-open');
            document.body.style.removeProperty('overflow');
            document.body.style.removeProperty('padding-right');
        }, 150);
    });

        function confirmDelete(id) {
        Swal.fire({
            title: 'Yakin ingin menghapus member?',
            text: "Data ini akan hilang permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // panggil Livewire delete method
                @this.delete(id);

                Swal.fire(
                    'Terhapus!',
                    'Member berhasil dihapus.',
                    'success'
                )
            }
        })
    }
</script>
@endpush



