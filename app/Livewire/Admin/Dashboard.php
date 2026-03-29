<?php

namespace App\Livewire\Admin;

use App\Models\Warga;
use App\Models\UnitRumah;
use App\Models\Pengajuan;
use App\Models\Penempatan;
use App\Enums\StatusKetersediaan;
use App\Enums\StatusPengajuan;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Dashboard Overview - SIRUKUN')]
class Dashboard extends Component
{
    public function render()
    {
        $totalWarga = Warga::count();

        $totalUnitRumah = UnitRumah::count();
        $unitRumahTersedia = UnitRumah::where('status_ketersediaan', StatusKetersediaan::TERSEDIA)->count();
        $unitRumahDihuni = UnitRumah::where('status_ketersediaan', StatusKetersediaan::DIHUNI)->count();
        $unitRumahRenovasi = UnitRumah::where('status_ketersediaan', StatusKetersediaan::RENOVASI)->count();

        $pengajuanMenunggu = Pengajuan::where('status_pengajuan', StatusPengajuan::MENUNGGU)->count();
        $pengajuanDisetujui = Pengajuan::where('status_pengajuan', StatusPengajuan::DISETUJUI)->count();

        $penempatanAktif = Penempatan::whereNull('tanggal_keluar')->count();

        $recentPengajuan = Pengajuan::with('warga')
            ->latest()
            ->take(6)
            ->get();

        return view('livewire.admin.dashboard', compact(
            'totalWarga',
            'totalUnitRumah',
            'unitRumahTersedia',
            'unitRumahDihuni',
            'unitRumahRenovasi',
            'pengajuanMenunggu',
            'pengajuanDisetujui',
            'penempatanAktif',
            'recentPengajuan'
        ));
    }
}
