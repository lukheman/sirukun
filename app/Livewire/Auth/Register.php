<?php

namespace App\Livewire\Auth;

use App\Enums\JenisPengajuan;
use App\Enums\StatusPengajuan;
use App\Models\Pengajuan;
use App\Models\Warga;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('layouts.guest')]
#[Title('Registrasi Warga - SIRUKUN')]
class Register extends Component
{
    use WithFileUploads;

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
    public $foto_ktp = null;

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
            'foto_ktp' => ['nullable', 'image', 'max:2048'],
        ];
    }

    protected $messages = [
        'nik.size' => 'NIK harus 16 digit.',
        'nik.unique' => 'NIK sudah terdaftar.',
        'nkk.size' => 'NKK harus 16 digit.',
        'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
        'password.min' => 'Kata sandi minimal 6 karakter.',
        'foto_ktp.image' => 'File harus berupa gambar.',
        'foto_ktp.max' => 'Ukuran file maksimal 2MB.',
    ];

    public function submit()
    {
        $validated = $this->validate();

        $fotoKtpPath = null;
        if ($this->foto_ktp) {
            $fotoKtpPath = $this->foto_ktp->store('ktp', 'public');
        }

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
            'foto_ktp' => $fotoKtpPath,
        ]);

        // Auto-create pengajuan
        Pengajuan::create([
            'id_warga' => $warga->id_warga,
            'jenis_pengajuan' => JenisPengajuan::MASUK,
            'status_pengajuan' => StatusPengajuan::MENUNGGU,
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
