<?php

namespace App\Livewire\Admin;

use App\Enums\StatusKeluhan;
use App\Models\Keluhan;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Laporan Keluhan - SIRUKUN')]
class LaporanKeluhan extends Component
{
    use WithPagination;

    public string $filterStatus = '';
    public string $search = '';

    protected $paginationTheme = 'bootstrap';

    public function updatingFilterStatus()
    {
        $this->resetPage();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = Keluhan::with('warga')->latest();

        if ($this->filterStatus) {
            $query->where('status', $this->filterStatus);
        }

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('judul', 'like', "%{$this->search}%")
                  ->orWhereHas('warga', function ($w) {
                      $w->where('nama', 'like', "%{$this->search}%");
                  });
            });
        }

        $keluhans = $query->paginate(10);

        $stats = [
            'total'    => Keluhan::count(),
            'menunggu' => Keluhan::where('status', StatusKeluhan::MENUNGGU)->count(),
            'diproses' => Keluhan::where('status', StatusKeluhan::DIPROSES)->count(),
            'selesai'  => Keluhan::where('status', StatusKeluhan::SELESAI)->count(),
        ];

        return view('livewire.admin.laporan-keluhan', [
            'keluhans' => $keluhans,
            'stats'    => $stats,
            'pdfRoute' => route('admin.keluhan.pdf', [
                'status' => $this->filterStatus,
                'search' => $this->search,
            ]),
        ]);
    }
}
