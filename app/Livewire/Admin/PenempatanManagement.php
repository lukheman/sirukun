<?php

namespace App\Livewire\Admin;

use App\Enums\StatusPengajuan;
use App\Models\Penempatan;
use App\Models\Pengajuan;
use App\Models\UnitRumah;
use Livewire\Component;
use Livewire\WithPagination;

class PenempatanManagement extends Component
{
    use WithPagination;

    public $search = '';

    public $showModal = false;

    public $showDeleteModal = false;

    public $editingPenempatanId = null;

    // Form fields
    public $id_pengajuan;

    public $id_unit;

    public $tanggal_masuk;

    protected $paginationTheme = 'bootstrap';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function rules()
    {
        return [
            'id_pengajuan' => 'required|exists:pengajuan,id_pengajuan|unique:penempatan,id_pengajuan,' . $this->editingPenempatanId . ',id_penempatan',
            'id_unit' => 'required|exists:unit_rumah,id_unit',
            'tanggal_masuk' => 'required|date',
        ];
    }

    public function messages()
    {
        return [
            'id_pengajuan.unique' => 'Pengajuan warga ini sudah memiliki data penempatan aktif.',
        ];
    }

    public function openCreateModal()
    {
        $this->resetValidation();
        $this->resetForm();
        $this->tanggal_masuk = date('Y-m-d');
        $this->showModal = true;
    }

    public function openEditModal($id)
    {
        $this->resetValidation();
        $this->resetForm();

        $penempatan = Penempatan::findOrFail($id);
        $this->editingPenempatanId = $penempatan->id_penempatan;

        $this->id_pengajuan = $penempatan->id_pengajuan;
        $this->id_unit = $penempatan->id_unit;
        $this->tanggal_masuk = $penempatan->tanggal_masuk ? $penempatan->tanggal_masuk->format('Y-m-d') : null;

        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->editingPenempatanId = null;
        $this->id_pengajuan = null;
        $this->id_unit = null;
        $this->tanggal_masuk = null;
    }

    public function save()
    {
        $validatedData = $this->validate();

        if ($this->editingPenempatanId) {
            Penempatan::findOrFail($this->editingPenempatanId)->update($validatedData);
        } else {
            Penempatan::create($validatedData);
        }

        $this->closeModal();
    }

    public function confirmDelete($id)
    {
        $this->editingPenempatanId = $id;
        $this->showDeleteModal = true;
    }

    public function cancelDelete()
    {
        $this->showDeleteModal = false;
        $this->editingPenempatanId = null;
    }

    public function deletePenempatan()
    {
        if ($this->editingPenempatanId) {
            Penempatan::findOrFail($this->editingPenempatanId)->delete();
            $this->showDeleteModal = false;
            $this->editingPenempatanId = null;
        }
    }

    public function render()
    {
        $penempatanQuery = Penempatan::with(['pengajuan.warga', 'unitRumah'])
            ->when($this->search, function ($query) {
                // Search via relationship
                $query->whereHas('pengajuan.warga', function ($q) {
                    $q->where('nama', 'like', '%' . $this->search . '%')
                        ->orWhere('nik', 'like', '%' . $this->search . '%');
                })->orWhereHas('unitRumah', function ($q) {
                    $q->where('blok', 'like', '%' . $this->search . '%')
                        ->orWhere('nomor', 'like', '%' . $this->search . '%');
                });
            })
            ->latest('tanggal_masuk')
            ->paginate(10);

        // Required data for dropdowns
        $pengajuans = Pengajuan::with('warga')
            ->where('status_pengajuan', StatusPengajuan::DISETUJUI)
            ->get();

        $unitRumahs = UnitRumah::orderBy('blok')->orderBy('nomor')->get();

        return view('livewire.admin.penempatan-management', [
            'penempatans' => $penempatanQuery,
            'pengajuans' => $pengajuans,
            'unitRumahs' => $unitRumahs,
        ])->layout('layouts.app', ['title' => 'Data Penempatan']);
    }
}
