<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class Login extends Component
{
     #[Layout('layouts.auth.applogin')]

     public $email ='';
     public $password ='';

     protected $rules = [
        'email' => 'required|email|exists:users,email',
        'password' => 'required|min:4',
    ];

    protected $messages = [
        'email.required' => 'Email is required',
        'email.email' => 'Email is not valid',
        'email.exists' => 'Email is not registered',
        'password.required' => 'Password is required',
        'password.min' => 'Password must be at least 4 characters',
    ];

    public function login (){
        $this->validate();

        if(Auth::attempt(['email'=>$this->email,'password'=>$this->password])){
            session()->regenerate();

            if(Auth::user()->role == 'admin'){
                return redirect()->route('admin.dashboard');
            }else{
                return redirect()->route('member.dashboard');
            }
        }else {
            return redirect()->route('login')->with('error','Email or Password is incorrect');
        }
    }

        public function render()
    {
        return view('livewire.auth.login');
    }
}
