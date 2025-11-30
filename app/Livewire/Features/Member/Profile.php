<?php

namespace App\Livewire\Features\Member;

use Livewire\Component;
use App\Models\Member;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;

 #[Layout('layouts.appmember')]
class Profile extends Component
{

    public $nim;
    public $name;
    public $phone;
    public $address;

    public function mount()
    {
        $member = Member::where('user_id', Auth::id())->first();

        if ($member) {
            $this->nim = $member->nim;
            $this->name = $member->name;
            $this->phone = $member->phone;
            $this->address = $member->address;
        }
    }

    public function save()
    {
        $this->validate([
            'nim' => 'required|unique:members,nim,' . (Auth::user()->member->id ?? 'NULL'),
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
        ]);

        $member = Member::updateOrCreate(
            ['user_id' => Auth::id()],
            [
                'nim' => $this->nim,
                'name' => $this->name,
                'slug' => Str::slug($this->name) . '-' . Str::random(5),
                'phone' => $this->phone,
                'address' => $this->address,
            ]
        );

        session()->flash('success', 'Profil berhasil disimpan!');
    }
    public function render()
    {
        return view('livewire.features.member.profile');
    }
}
