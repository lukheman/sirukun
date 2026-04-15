<?php

namespace App\Livewire\Admin;

use App\Enums\StatusKeluhan;
use App\Models\Keluhan;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Manajemen Keluhan - SIRUKUN')]
class KeluhanManagement extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public string $search       = '';
    public string $filterStatus = '';

    public bool $showDetailModal = false;
    public ?int $selectedId      = null;
    public string $balasan       = '';

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingFilterStatus(): void
    {
        $this->resetPage();
    }

    public function openDetail(int $id): void
    {
        $this->selectedId      = $id;
        $this->balasan         = Keluhan::find($id)?->balasan ?? '';
        $this->showDetailModal = true;
        $this->resetValidation();
    }

    public function closeDetail(): void
    {
        $this->showDetailModal = false;
        $this->selectedId      = null;
        $this->balasan         = '';
    }

    public function updateStatus(int $id, string $status): void
    {
        $keluhan = Keluhan::findOrFail($id);
        $keluhan->update(['status' => $status]);
        session()->flash('success', 'Status keluhan berhasil diperbarui.');
    }

    public function simpanBalasan(): void
    {
        $this->validate([
            'balasan' => 'required|string|min:5',
        ], [
            'balasan.required' => 'Balasan tidak boleh kosong.',
            'balasan.min'      => 'Balasan minimal 5 karakter.',
        ]);

        $keluhan = Keluhan::findOrFail($this->selectedId);
        $keluhan->update([
            'balasan'      => $this->balasan,
            'dibalas_pada' => now(),
            'status'       => StatusKeluhan::SELESAI,
        ]);

        $this->closeDetail();
        session()->flash('success', 'Balasan berhasil dikirim dan keluhan ditandai Selesai.');
    }

    public function render()
    {
        $query = Keluhan::with('warga')
            ->when($this->search, function ($q) {
                $q->where('judul', 'like', '%' . $this->search . '%')
                  ->orWhereHas('warga', fn($q2) => $q2->where('nama', 'like', '%' . $this->search . '%'));
            })
            ->when($this->filterStatus, fn($q) => $q->where('status', $this->filterStatus))
            ->latest()
            ->paginate(10);

        $selectedKeluhan = $this->selectedId ? Keluhan::with('warga')->find($this->selectedId) : null;

        $stats = [
            'total'     => Keluhan::count(),
            'menunggu'  => Keluhan::where('status', StatusKeluhan::MENUNGGU)->count(),
            'diproses'  => Keluhan::where('status', StatusKeluhan::DIPROSES)->count(),
            'selesai'   => Keluhan::where('status', StatusKeluhan::SELESAI)->count(),
        ];

        return view('livewire.admin.keluhan-management', compact('query', 'selectedKeluhan', 'stats'))
            ->layout('layouts.app', ['title' => 'Manajemen Keluhan']);
    }
}
