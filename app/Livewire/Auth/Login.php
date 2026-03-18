<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.guest')]
#[Title('Login - SIRUKUN')]
class Login extends Component
{
    public string $role = 'admin';

    // Admin fields
    public string $username = '';

    // Warga fields
    public string $nik = '';

    // Shared fields
    public string $password = '';

    public bool $remember = false;

    public function updatedRole(): void
    {
        $this->resetValidation();
        $this->resetErrorBag();
        $this->username = '';
        $this->nik = '';
        $this->password = '';
    }

    public function submit()
    {
        if ($this->role === 'admin') {
            $this->validate([
                'username' => ['required', 'string'],
                'password' => ['required'],
            ]);

            $credentials = [
                'username' => $this->username,
                'password' => $this->password,
            ];

            if (Auth::guard('admin')->attempt($credentials, $this->remember)) {
                session()->regenerate();

                return redirect()->route('dashboard');
            }

            $this->addError('username', 'Username atau kata sandi salah.');
        } else {
            $this->validate([
                'nik' => ['required', 'string'],
                'password' => ['required'],
            ]);

            $credentials = [
                'nik' => $this->nik,
                'password' => $this->password,
            ];

            if (Auth::guard('warga')->attempt($credentials, $this->remember)) {
                session()->regenerate();

                return redirect()->route('warga.dashboard');
            }

            $this->addError('nik', 'NIK atau kata sandi salah.');
        }
    }

    public function render()
    {
        return view('livewire.auth.login');
    }
}
