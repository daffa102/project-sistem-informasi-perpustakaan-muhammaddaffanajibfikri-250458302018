<section class="section mt-4">
    <div class="container">
        <div class="row" id="table-bordered">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0">User Table</h4>
                        <input type="text" wire:model.live.debounce.300ms="search"
                            class="form-control w-25"
                            placeholder="Search user...">
                    </div>

                    <div class="card-content">
                        <div class="table-responsive" style="max-height: 600px; overflow-y: auto;">
                            <table class="table table-bordered table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="text-center" style="width: 40px;">No</th>
                                        <th class="text-center" style="width: 150px;">Name</th>
                                        <th class="text-center" style="width: 150px;">Email</th>
                                        <th class="text-center" style="width: 100px;">Role</th>
                                        <th class="text-center" style="width: 150px;">Created At</th>
                                        <th class="text-center" style="width: 120px;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($users as $index => $user)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td class="fw-bold">{{ $user->name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td class="text-center">
                                                <span class="badge text-white {{ $user->role === 'admin' ? 'bg-danger' : 'bg-secondary' }}">
                                                    {{ ucfirst($user->role) }}
                                                </span>
                                            </td>
                                            <td class="text-center">{{ $user->created_at->format('d M Y') }}</td>
                                            <td class="text-center">
                                                <button wire:click="edit({{ $user->id }})"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#editModal"
                                                    class="btn btn-sm btn-outline-primary me-1">
                                                    <i class="bi bi-pencil-square"></i>
                                                </button>

                                                <button onclick="confirmDelete({{ $user->id }})"
                                                    class="btn btn-sm btn-outline-danger">
                                                    <i class="bi bi-trash"></i>
                                                </button>

                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center text-muted py-3">No users found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        @if ($users->hasPages())
                            <div class="card-footer d-flex justify-content-end">
                                {{ $users->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 🔵 Modal Edit -->
    <div wire:ignore.self class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h5 class="modal-title" id="editModalLabel">Edit User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input type="text" wire:model="name" class="form-control">
                        @error('name') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" wire:model="email" class="form-control">
                        @error('email') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Role</label>
                        <select wire:model="role" class="form-select">
                            <option value="">-- Select Role --</option>
                            <option value="admin">Admin</option>
                            <option value="member">Member</option>
                        </select>
                        @error('role') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" wire:click="update" class="btn btn-primary">Save Changes</button>
                </div>
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script>
    window.addEventListener('closeModal', () => {
        const modal = bootstrap.Modal.getInstance(document.getElementById('editModal'));
        modal.hide();
    });

      function confirmDelete(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "This user will be deleted permanently!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                Livewire.dispatch('deleteUser', { id: id });
            }
        });
    }

    // Optional: SweetAlert success message dari Livewire
    window.addEventListener('user-deleted', () => {
        Swal.fire({
            title: 'Deleted!',
            text: 'User has been removed.',
            icon: 'success',
            timer: 1500,

        });
    });
</script>
@endpush
