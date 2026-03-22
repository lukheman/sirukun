<?php

namespace App\Livewire\Pimpinan;

use App\Enums\StatusKetersediaan;
use App\Models\UnitRumah;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Laporan Rumah Nelayan - SIRUKUN')]
class LaporanRumah extends Component
{
    use WithPagination;

    public $filterStatus = '';

    protected $paginationTheme = 'bootstrap';

    public function updatingFilterStatus()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = UnitRumah::with(['penempatan.pengajuan.warga'])
            ->orderBy('blok')
            ->orderBy('nomor');

        if ($this->filterStatus) {
            $query->where('status_ketersediaan', $this->filterStatus);
        }

        $units = $query->paginate(15);

        // Statistik
        $totalUnit = UnitRumah::count();
        $unitDihuni = UnitRumah::where('status_ketersediaan', StatusKetersediaan::DIHUNI)->count();
        $unitTersedia = UnitRumah::where('status_ketersediaan', StatusKetersediaan::TERSEDIA)->count();

        return view('livewire.pimpinan.laporan-rumah', [
            'units' => $units,
            'totalUnit' => $totalUnit,
            'unitDihuni' => $unitDihuni,
            'unitTersedia' => $unitTersedia,
            'pimpinan' => Auth::guard('kepala_dinas')->user(),
        ])->layout('layouts.app', ['title' => 'Laporan Rumah Nelayan']);
    }
}
