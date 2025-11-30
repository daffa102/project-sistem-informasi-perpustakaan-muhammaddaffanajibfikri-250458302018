<?php

namespace App\Livewire\Features;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use App\Models\Member as MemberModel;
use App\Models\User;

class Member extends Component
{
    use WithPagination;

    public $search = '';
    protected $paginationTheme = 'bootstrap';

    public $memberId, $name, $nim, $phone, $address, $user_id;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    #[Layout('layouts.app')]
    public function render()
    {
        $users = MemberModel::query()
            ->where(function ($q) {
                $q->where('name', 'like', "%{$this->search}%")
                  ->orWhere('nim', 'like', "%{$this->search}%")
                  ->orWhere('phone', 'like', "%{$this->search}%")
                  ->orWhere('address', 'like', "%{$this->search}%");
            })
            ->orderBy('id', 'asc')
            ->paginate(10);

        $availableUsers = User::doesntHave('member')->where('role', '!=', 'admin')->get();

        return view('livewire.features.member', compact('users', 'availableUsers'));
    }


    private function resetInput()
    {
        $this->reset(['memberId', 'name', 'nim', 'phone', 'address', 'user_id']);
    }


    public function create()
    {
        $this->resetInput();
        $this->dispatch('showModal');
    }


    public function store()
    {
        $this->validate([
            'user_id' => 'required|exists:users,id|unique:members,user_id',
            'name' => 'required|string|max:255',
            'nim' => 'required|string|max:50|unique:members,nim',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:255',
        ]);

        MemberModel::create([
            'user_id' => $this->user_id,
            'name' => $this->name,
            'nim' => $this->nim,
            'phone' => $this->phone,
            'address' => $this->address,
        ]);

        session()->flash('success', 'Member added successfully.');

        $this->dispatch('closeModal');
        $this->resetInput();
        $this->resetPage();
    }


    public function edit($id)
    {
        $member = MemberModel::findOrFail($id);

        $this->memberId = $member->id;
        $this->name = $member->name;
        $this->nim = $member->nim;
        $this->phone = $member->phone;
        $this->address = $member->address;

        $this->dispatch('showModal');
    }


    public function update()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'nim' => 'required|string|max:50',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:255',
        ]);

        $member = MemberModel::findOrFail($this->memberId);

        $member->update([
            'name' => $this->name,
            'nim' => $this->nim,
            'phone' => $this->phone,
            'address' => $this->address,
        ]);

        session()->flash('success', 'Member updated successfully.');

        $this->dispatch('closeModal');
        $this->resetInput();
        $this->resetPage();
    }


    public function delete($id)
    {
        MemberModel::findOrFail($id)->delete();
        session()->flash('success', 'Member deleted successfully.');
        $this->resetPage();
    }


    public function cancel()
    {
        $this->resetInput();
        $this->dispatch('closeModal');
    }
}
