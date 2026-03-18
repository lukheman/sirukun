<?php

namespace App\Livewire\Auth;

use App\Models\Pengajuan;
use App\Models\Warga;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.guest')]
#[Title('Registrasi Warga - SIRUKUN')]
class Register extends Component
{
    public string $nik = '';

    public string $nkk = '';

    public string $nama = '';

    public string $alamat = '';

    public string $telepon = '';

    public string $tempat_lahir = '';

    public string $tanggal_lahir = '';

    public string $agama = '';

    public string $password = '';

    public string $password_confirmation = '';

    protected function rules(): array
    {
        return [
            'nik' => ['required', 'string', 'size:16', 'unique:warga,nik'],
            'nkk' => ['required', 'string', 'size:16'],
            'nama' => ['required', 'string', 'max:255'],
            'alamat' => ['required', 'string', 'max:255'],
            'telepon' => ['required', 'string', 'max:20'],
            'tempat_lahir' => ['required', 'string', 'max:100'],
            'tanggal_lahir' => ['required', 'date'],
            'agama' => ['required', 'string'],
            'password' => ['required', 'confirmed', 'min:6'],
        ];
    }

    protected $messages = [
        'nik.size' => 'NIK harus 16 digit.',
        'nik.unique' => 'NIK sudah terdaftar.',
        'nkk.size' => 'NKK harus 16 digit.',
        'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
        'password.min' => 'Kata sandi minimal 6 karakter.',
    ];

    public function submit()
    {
        $validated = $this->validate();

        $warga = Warga::create([
            'nik' => $validated['nik'],
            'nkk' => $validated['nkk'],
            'nama' => $validated['nama'],
            'alamat' => $validated['alamat'],
            'telepon' => $validated['telepon'],
            'tempat_lahir' => $validated['tempat_lahir'],
            'tanggal_lahir' => $validated['tanggal_lahir'],
            'password' => Hash::make($validated['password']),
            'agama' => $validated['agama'],
        ]);

        // Auto-create pengajuan
        Pengajuan::create([
            'id_warga' => $warga->id_warga,
            'jenis_pengajuan' => 'Masuk',
            'status_pengajuan' => 'Menunggu',
        ]);

        // Login as warga
        Auth::guard('warga')->login($warga);
        session()->regenerate();

        return redirect()->route('warga.dashboard');
    }

    public function render()
    {
        return view('livewire.auth.register');
    }
}
