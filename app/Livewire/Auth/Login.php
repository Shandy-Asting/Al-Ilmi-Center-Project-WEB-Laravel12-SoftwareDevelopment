<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Login extends Component
{
    public string $email = '';
    public string $password = '';

    protected array $rules = [
        'email' => 'required|email',
        'password' => 'required|min:8',
    ];

    protected array $messages = [
        'email.required' => 'Email wajib diisi.',
        'email.email' => 'Format email tidak valid.',
        'password.required' => 'Password wajib diisi.',
        'password.min' => 'Password minimal 8 karakter.',
    ];

    public function login()
    {
        $this->validate();

        if (Auth::attempt(['email' => $this->email, 'password' => $this->password])) {
            session()->regenerate();

            $role = Auth::user()->role;

            if ($role === 'admin') {
                return redirect()->intended('/admin/dashboard');
            } elseif ($role === 'tutor') {
                return redirect()->intended('/tutor/dashboard');
            } else {
                return redirect()->intended('/siswa/dashboard');
            }
        }

        $this->addError('email', 'Email atau password salah.');
    }

    public function render()
    {
    return view('livewire.auth.login')
        ->layout('layouts.auth', ['title' => 'Login - Al Ilmi Center']);
    }
}