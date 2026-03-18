<?php

namespace App\Livewire\Warga;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Profile Saya - SIRUKUN')]
class Profile extends Component
{
    public string $nama = '';

    public string $telepon = '';

    public string $alamat = '';

    // NIK dan NKK hanya untuk display (read-only)
    public string $nik = '';

    public string $nkk = '';

    public string $current_password = '';

    public string $password = '';

    public string $password_confirmation = '';

    public bool $showPasswordSection = false;

    public function mount(): void
    {
        $warga = Auth::guard('warga')->user();
        $this->nama = $warga->nama;
        $this->telepon = $warga->telepon;
        $this->alamat = $warga->alamat;
        $this->nik = $warga->nik;
        $this->nkk = $warga->nkk;
    }

    protected function rules(): array
    {
        $rules = [
            'nama' => ['required', 'string', 'max:255'],
            'telepon' => ['required', 'string', 'max:20'],
            'alamat' => ['required', 'string', 'max:255'],
        ];

        if ($this->showPasswordSection && $this->password) {
            $rules['password'] = ['required', 'confirmed', Password::defaults()];
        }

        return $rules;
    }

    public function togglePasswordSection(): void
    {
        $this->showPasswordSection = ! $this->showPasswordSection;
        $this->current_password = '';
        $this->password = '';
        $this->password_confirmation = '';
        $this->resetValidation(['current_password', 'password', 'password_confirmation']);
    }

    public function updateProfile(): void
    {
        $validated = $this->validate();

        $warga = Auth::guard('warga')->user();
        $warga->nama = $validated['nama'];
        $warga->telepon = $validated['telepon'];
        $warga->alamat = $validated['alamat'];
        $warga->save();

        session()->flash('success', 'Profile berhasil diperbarui.');
    }

    public function updatePassword(): void
    {
        $this->validate([
            'current_password' => ['required'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        $warga = Auth::guard('warga')->user();

        if (! Hash::check($this->current_password, $warga->password)) {
            $this->addError('current_password', 'Password saat ini tidak sesuai.');

            return;
        }

        $warga->password = Hash::make($this->password);
        $warga->save();

        $this->current_password = '';
        $this->password = '';
        $this->password_confirmation = '';
        $this->showPasswordSection = false;

        session()->flash('success', 'Password berhasil diperbarui.');
    }

    public function render()
    {
        return view('livewire.warga.profile');
    }
}
