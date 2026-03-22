<?php

namespace App\Livewire\Admin;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Profile - SIRUKUN')]
class Profile extends Component
{
    public string $email = '';

    public string $current_password = '';

    public string $password = '';

    public string $password_confirmation = '';

    public bool $showPasswordSection = false;

    public function mount(): void
    {
        $admin = Auth::guard('admin')->user();
        $this->email = $admin->email;
    }

    protected function rules(): array
    {
        $admin = Auth::guard('admin')->user();

        $rules = [
            'email' => ['required', 'email', 'max:255', 'unique:admin,email,' . $admin->id_admin . ',id_admin'],
        ];

        if ($this->showPasswordSection && $this->password) {
            $rules['password'] = ['required', 'confirmed', Password::defaults()];
        }

        return $rules;
    }

    public function togglePasswordSection(): void
    {
        $this->showPasswordSection = !$this->showPasswordSection;
        $this->current_password = '';
        $this->password = '';
        $this->password_confirmation = '';
        $this->resetValidation(['current_password', 'password', 'password_confirmation']);
    }

    public function updateProfile(): void
    {
        $validated = $this->validate();

        $admin = Auth::guard('admin')->user();
        $admin->email = $validated['email'];
        $admin->save();

        session()->flash('success', 'Profile berhasil diperbarui.');
    }

    public function updatePassword(): void
    {
        $this->validate([
            'current_password' => ['required'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        $admin = Auth::guard('admin')->user();

        if (!Hash::check($this->current_password, $admin->password)) {
            $this->addError('current_password', 'Password saat ini tidak sesuai.');

            return;
        }

        $admin->password = Hash::make($this->password);
        $admin->save();

        $this->current_password = '';
        $this->password = '';
        $this->password_confirmation = '';
        $this->showPasswordSection = false;

        session()->flash('success', 'Password berhasil diperbarui.');
    }

    public function render()
    {
        return view('livewire.admin.profile');
    }
}
