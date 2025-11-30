<?php

namespace App\Livewire\Features;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use App\Models\User as UserModel;

class User extends Component
{
    use WithPagination;

    public $search = '';

    protected $paginationTheme = 'bootstrap';

    public $userId, $name, $email, $role;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    #[Layout('layouts.app')]
    public function render()
    {
        $users = UserModel::query()
            ->where(function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('email', 'like', '%' . $this->search . '%');
            })
            ->orderByRaw("CASE WHEN role = 'admin' THEN 0 ELSE 1 END") // admin di atas
            ->orderBy('id', 'asc')
            ->paginate(10);

        return view('livewire.features.user', [
            'users' => $users
        ]);
    }
 public function edit($id)
    {
        $user = UserModel::findOrFail($id);
        $this->userId = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->role = $user->role;
    }

    public function update()
    {
        $this->validate([
            'name' => 'required|string|min:3',
            'email' => 'required|email',
            'role' => 'required|string'
        ]);

        $user = UserModel::findOrFail($this->userId);
        $user->update([
            'name' => $this->name,
            'email' => $this->email,
            'role' => $this->role,
        ]);

        session()->flash('success', 'User updated successfully.');

        // Tutup modal & reset input
        $this->dispatch('closeModal');
        $this->reset(['userId', 'name', 'email', 'role']);
    }

   #[On('deleteUser')]
    public function deleteUser($id)
{
    UserModel::find($id)?->delete();

    $this->dispatch('user-deleted'); 
}

}
