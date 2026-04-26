<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class Register extends Component
{
    public string $name = '';
    public string $email = '';
    public string $no_hp = '';
    public string $role = '';
    public string $password = '';
    public string $password_confirmation = '';

    protected array $rules = [
        'name'     => 'required|min:3',
        'email'    => 'required|email|unique:users,email',
        'no_hp'    => 'required|min:10',
        'role'     => 'required|in:siswa,tutor',
        'password' => 'required|min:8|confirmed',
    ];

    protected array $messages = [
        'name.required'      => 'Nama wajib diisi.',
        'name.min'           => 'Nama minimal 3 karakter.',
        'email.required'     => 'Email wajib diisi.',
        'email.email'        => 'Format email tidak valid.',
        'email.unique'       => 'Email sudah terdaftar.',
        'no_hp.required'     => 'No. HP wajib diisi.',
        'no_hp.min'          => 'No. HP minimal 10 digit.',
        'role.required'      => 'Pilih role terlebih dahulu.',
        'role.in'            => 'Role tidak valid.',
        'password.required'  => 'Password wajib diisi.',
        'password.min'       => 'Password minimal 8 karakter.',
        'password.confirmed' => 'Konfirmasi password tidak cocok.',
    ];

    public function register()
    {
        $this->validate();

        $user = User::create([
            'name'     => $this->name,
            'email'    => $this->email,
            'no_hp'    => $this->no_hp,
            'role'     => $this->role,
            'password' => Hash::make($this->password),
        ]);

        Auth::login($user);
        session()->regenerate();

        return match ($user->role) {
            'tutor' => redirect('/tutor/dashboard'),
            default => redirect('/siswa/dashboard'),
        };
    }

    public function render()
    {
        return view('livewire.auth.register')
            ->layout('layouts.auth', ['title' => 'Daftar - Al Ilmi Center']);
    }
}