<?php

namespace App\Livewire\Pimpinan;

use App\Models\UnitRumah;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Arsip Riwayat Penghuni - SIRUKUN')]
class ArsipPenghuni extends Component
{
    public $selectedUnitId = '';

    public $showKtpModal = false;

    public $ktpImageUrl = '';

    public $ktpNama = '';

    public function updatedSelectedUnitId()
    {
        // Reset when unit changes
    }

    public function viewKtp($fotoKtp, $nama)
    {
        $this->ktpImageUrl = asset('storage/'.$fotoKtp);
        $this->ktpNama = $nama;
        $this->showKtpModal = true;
    }

    public function closeKtpModal()
    {
        $this->showKtpModal = false;
        $this->ktpImageUrl = '';
        $this->ktpNama = '';
    }

    public function render()
    {
        $units = UnitRumah::orderBy('blok')->orderBy('nomor')->get();

        $riwayat = collect();
        $selectedUnit = null;

        if ($this->selectedUnitId) {
            $selectedUnit = UnitRumah::with(['penempatans.pengajuan.warga'])
                ->find($this->selectedUnitId);

            if ($selectedUnit) {
                $riwayat = $selectedUnit->penempatans
                    ->sortByDesc('tanggal_masuk')
                    ->values();
            }
        }

        return view('livewire.pimpinan.arsip-penghuni', [
            'units' => $units,
            'riwayat' => $riwayat,
            'selectedUnit' => $selectedUnit,
            'pimpinan' => Auth::guard('kepala_dinas')->user(),
        ])->layout('layouts.app', ['title' => 'Arsip Riwayat Penghuni']);
    }
}
