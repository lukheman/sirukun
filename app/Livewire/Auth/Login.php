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
    public string $admin_email = '';

    // Warga fields
    public string $nik = '';

    // Pimpinan fields
    public string $email = '';

    // Shared fields
    public string $password = '';

    public bool $remember = false;

    public function updatedRole(): void
    {
        $this->resetValidation();
        $this->resetErrorBag();
        $this->admin_email = '';
        $this->nik = '';
        $this->email = '';
        $this->password = '';
    }

    public function submit()
    {
        if ($this->role === 'admin') {
            $this->validate([
                'admin_email' => ['required'],
                'password' => ['required'],
            ]);

            $credentials = [
                'email' => $this->admin_email,
                'password' => $this->password,
            ];

            if (Auth::guard('admin')->attempt($credentials, $this->remember)) {
                session()->regenerate();

                return redirect()->route('dashboard');
            }

            $this->addError('admin', 'Username atau kata sandi salah.');
        } elseif ($this->role === 'warga') {
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
        } elseif ($this->role === 'pimpinan') {
            $this->validate([
                'email' => ['required', 'email'],
                'password' => ['required'],
            ]);

            $credentials = [
                'email' => $this->email,
                'password' => $this->password,
            ];

            if (Auth::guard('kepala_dinas')->attempt($credentials, $this->remember)) {
                session()->regenerate();

                return redirect()->route('pimpinan.dashboard');
            }

            $this->addError('email', 'Email atau kata sandi salah.');
        }
    }

    public function render()
    {
        return view('livewire.auth.login');
    }
}
