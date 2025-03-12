<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Login extends Component
{
    public string $email;

    public string $password;

    public function rules()
    {
        return [
            'email' => 'required|email',
            'password' => 'required|min:6',
        ];
    }
    public function messages()
    {
        return [
            'email.required' => 'Email is required',
            'password.required' => 'Password is required',
        ];
    }

    public function submit()
    {
        $fields = $this->validate();
        if (! Auth::attempt($fields)) {
            $this->addError('email', 'Invalid email or password');
            return;
        }
        session()->regenerate();
        return redirect()->route('dashboard');
    }
    public function render()
    {
        return view('livewire.auth.login');
    }
}
