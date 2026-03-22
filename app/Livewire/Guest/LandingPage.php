<?php
namespace App\Livewire\Guest;

use App\Enums\StatusKetersediaan;
use App\Enums\StatusPengajuan;
use App\Models\Pengajuan;
use App\Models\UnitRumah;
use App\Models\Warga;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.guest')]
#[Title('SIRUKUN - Sistem Informasi Rukun Warga & Perumahan')]
class LandingPage extends Component
{
    public function render()
    {
        $stats = [
            'total_warga' => Warga::count(),
            'total_unit' => UnitRumah::count(),
            'unit_tersedia' => UnitRumah::where('status_ketersediaan', StatusKetersediaan::TERSEDIA)->count(),
            'pengajuan_disetujui' => Pengajuan::where('status_pengajuan', StatusPengajuan::DISETUJUI)->count(),
        ];

        return view('livewire.guest.landing-page', compact('stats'));
    }
}
