<?php

namespace App\Livewire\Warga;

use App\Enums\JenisPengajuan;
use App\Enums\StatusPengajuan;
use App\Models\Pengajuan;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Title('Informasi Unit - SIRUKUN')]
class InformasiUnit extends Component
{
    use WithFileUploads;

    public $showAjukanUnitModal = false;

    public $showAjukanKeluarModal = false;

    // File upload properties
    public $upload_foto_ktp = null;
    public $upload_foto_kk = null;
    public $upload_foto_kusuka = null;

    // Functions for Ajukan Unit (Masuk)
    public function openAjukanUnitModal()
    {
        $this->showAjukanUnitModal = true;
    }

    public function closeAjukanUnitModal()
    {
        $this->showAjukanUnitModal = false;
        $this->upload_foto_ktp = null;
        $this->upload_foto_kk = null;
        $this->upload_foto_kusuka = null;
        $this->resetValidation();
    }

    public function submitPengajuanUnit()
    {
        $this->validate([
            'upload_foto_ktp' => ['nullable', 'image', 'max:2048'],
            'upload_foto_kk' => ['nullable', 'image', 'max:2048'],
            'upload_foto_kusuka' => ['nullable', 'image', 'max:2048'],
        ], [
            'upload_foto_ktp.image' => 'Foto KTP harus berupa gambar.',
            'upload_foto_ktp.max' => 'Foto KTP maksimal 2MB.',
            'upload_foto_kk.image' => 'Foto KK harus berupa gambar.',
            'upload_foto_kk.max' => 'Foto KK maksimal 2MB.',
            'upload_foto_kusuka.image' => 'Foto Kusuka harus berupa gambar.',
            'upload_foto_kusuka.max' => 'Foto Kusuka maksimal 2MB.',
        ]);

        $warga = Auth::guard('warga')->user();

        // Update berkas jika ada yang diupload ulang
        $updateData = [];
        if ($this->upload_foto_ktp) {
            $updateData['foto_ktp'] = $this->upload_foto_ktp->store('ktp', 'public');
        }
        if ($this->upload_foto_kk) {
            $updateData['foto_kk'] = $this->upload_foto_kk->store('kk', 'public');
        }
        if ($this->upload_foto_kusuka) {
            $updateData['foto_kusuka'] = $this->upload_foto_kusuka->store('kusuka', 'public');
        }
        if (!empty($updateData)) {
            $warga->update($updateData);
        }

        $warga->pengajuan()->create([
            'jenis_pengajuan' => JenisPengajuan::MASUK,
            'status_pengajuan' => StatusPengajuan::MENUNGGU,
        ]);

        $this->closeAjukanUnitModal();
        session()->flash('success', 'Pengajuan penempatan unit berhasil dikirim. Silakan tunggu persetujuan Admin.');
    }

    // Functions for Ajukan Keluar
    public function openAjukanKeluarModal()
    {
        $this->showAjukanKeluarModal = true;
    }

    public function closeAjukanKeluarModal()
    {
        $this->showAjukanKeluarModal = false;
    }

    public function submitPengajuanKeluar()
    {
        $warga = Auth::guard('warga')->user();

        $warga->pengajuan()->create([
            'jenis_pengajuan' => JenisPengajuan::KELUAR,
            'status_pengajuan' => StatusPengajuan::MENUNGGU,
        ]);

        $this->closeAjukanKeluarModal();
        session()->flash('success', 'Pengajuan keluar berhasil dikirim dan sedang menunggu persetujuan.');
    }

    public function render()
    {
        $warga = Auth::guard('warga')->user();

        // Cari penempatan aktif (pengajuan 'disetujui' dan punya relasi penempatan)
$penempatanAktif = $warga->pengajuan()
    ->where('status_pengajuan', StatusPengajuan::DISETUJUI)
    ->whereHas('penempatan', function ($q) {
        $q->whereNull('tanggal_keluar');
    })
    ->with(['penempatan' => function ($q) {
        $q->whereNull('tanggal_keluar');
    }, 'penempatan.unitRumah'])
    ->first()
    ?->penempatan;

        // Cari pengajuan masuk yang masih menunggu
        $pengajuanMasukMenunggu = $warga->pengajuan()
            ->where('jenis_pengajuan', JenisPengajuan::MASUK)
            ->where('status_pengajuan', StatusPengajuan::MENUNGGU)
            ->latest()
            ->first();

        // Cari pengajuan keluar yang masih menunggu (untuk disable tombol keluar jika ada)
        $pengajuanKeluarMenunggu = $warga->pengajuan()
            ->where('jenis_pengajuan', JenisPengajuan::KELUAR)
            ->where('status_pengajuan', StatusPengajuan::MENUNGGU)
            ->exists();

        return view('livewire.warga.informasi-unit', [
            'penempatanAktif' => $penempatanAktif,
            'pengajuanMasukMenunggu' => $pengajuanMasukMenunggu,
            'pengajuanKeluarMenunggu' => $pengajuanKeluarMenunggu,
        ]);
    }
}
