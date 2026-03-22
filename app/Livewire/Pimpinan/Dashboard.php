<?php

namespace App\Livewire\Pimpinan;

use App\Enums\StatusKetersediaan;
use App\Enums\StatusPengajuan;
use App\Models\Pengajuan;
use App\Models\UnitRumah;
use App\Models\Warga;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Dashboard Pimpinan - SIRUKUN')]
class Dashboard extends Component
{
    public function render()
    {
        $totalWarga = Warga::query()->count();
        $totalUnit = UnitRumah::query()->count();
        $unitDihuni = UnitRumah::query()->where('status_ketersediaan', StatusKetersediaan::DIHUNI)->count();
        $unitTersedia = UnitRumah::query()->where('status_ketersediaan', StatusKetersediaan::TERSEDIA)->count();
        $pengajuanMenunggu = Pengajuan::query()->where('status_pengajuan', StatusPengajuan::MENUNGGU)->count();
        $pengajuanDisetujui = Pengajuan::query()->where('status_pengajuan', StatusPengajuan::DISETUJUI)->count();

        return view('livewire.pimpinan.dashboard', [
            'totalWarga' => $totalWarga,
            'totalUnit' => $totalUnit,
            'unitDihuni' => $unitDihuni,
            'unitTersedia' => $unitTersedia,
            'pengajuanMenunggu' => $pengajuanMenunggu,
            'pengajuanDisetujui' => $pengajuanDisetujui,
            'pimpinan' => Auth::guard('kepala_dinas')->user(),
        ])->layout('layouts.app', ['title' => 'Dashboard Pimpinan']);
    }
}
