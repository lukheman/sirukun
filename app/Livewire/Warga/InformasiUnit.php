<?php

namespace App\Livewire\Warga;

use App\Enums\JenisPengajuan;
use App\Enums\StatusPengajuan;
use App\Models\Pengajuan;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Informasi Unit - SIRUKUN')]
class InformasiUnit extends Component
{
    public $showAjukanUnitModal = false;

    public $showAjukanKeluarModal = false;

    // Functions for Ajukan Unit (Masuk)
    public function openAjukanUnitModal()
    {
        $this->showAjukanUnitModal = true;
    }

    public function closeAjukanUnitModal()
    {
        $this->showAjukanUnitModal = false;
    }

    public function submitPengajuanUnit()
    {
        $warga = Auth::guard('warga')->user();

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
            ->whereHas('penempatan')
            ->with('penempatan.unitRumah')
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
