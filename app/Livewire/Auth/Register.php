<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeEmail;
use Livewire\Attributes\Layout;

class Register extends Component
{
    #[Layout('layouts.auth.appregister')]

    public $name, $email, $password, $confirm_password;

    public function register()
    {
        $this->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:4',
            'confirm_password' => 'required|same:password',
        ]);

        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'role' => 'member', 
        ]);

        $user->member()->create([
            'name' => $this->name,
            'nim' => 'NIM-' . time(), 
            'phone' => '-',
            'address' => '-',
        ]);

        // 3. Login
        Auth::login($user);

        try {
            Mail::to($user->email)->send(new WelcomeEmail($user));
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Gagal mengirim email welcome: ' . $e->getMessage());
        }

        return redirect()->route('member.dashboard');
    }


    public function render()
    {
        return view('livewire.auth.register');
    }
}
