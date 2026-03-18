<?php

namespace App\Livewire\Warga;

use App\Models\UnitRumah;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.app')]
#[Title('Dashboard Warga - SIRUKUN')]
class Dashboard extends Component
{
    public $showAjukanKeluarModal = false;

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

        // Buat pengajuan baru dengan tipe Keluar
        $warga->pengajuan()->create([
            'jenis_pengajuan' => 'Keluar',
            'status_pengajuan' => 'Menunggu',
        ]);

        $this->closeAjukanKeluarModal();
        session()->flash('success', 'Pengajuan keluar berhasil dikirim dan sedang menunggu persetujuan.');
    }

    public function render()
    {
        $warga = Auth::guard('warga')->user();
        $pengajuans = $warga->pengajuan()->with('penempatan.unitRumah')->latest()->get();

        // Unit info
        $totalUnit = UnitRumah::count();
        $unitTerisi = UnitRumah::where('status_ketersediaan', 'Terisi')->count();
        $unitKosong = UnitRumah::where('status_ketersediaan', 'Tersedia')->count();

        // All units with penempatan and warga info
        $units = UnitRumah::with('penempatan.pengajuan.warga')->get();

        // Cek apakah warga sedang menghuni (punya penempatan aktif)
        $punyaPenempatan = $pengajuans->where('status_pengajuan', 'Disetujui')
            ->whereNotNull('penempatan')
            ->isNotEmpty();

        // Cek apakah warga sudah punya pengajuan keluar yang masih Menunggu
        $punyaPengajuanKeluarMenunggu = $pengajuans->where('jenis_pengajuan', 'Keluar')
            ->where('status_pengajuan', 'Menunggu')
            ->isNotEmpty();

        $bisaAjukanKeluar = $punyaPenempatan && ! $punyaPengajuanKeluarMenunggu;

        return view('livewire.warga.dashboard', [
            'warga' => $warga,
            'pengajuans' => $pengajuans,
            'totalUnit' => $totalUnit,
            'unitTerisi' => $unitTerisi,
            'unitKosong' => $unitKosong,
            'units' => $units,
            'bisaAjukanKeluar' => $bisaAjukanKeluar,
        ]);
    }
}
