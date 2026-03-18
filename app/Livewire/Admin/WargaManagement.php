<?php

namespace App\Livewire\Admin;

use App\Models\Pengajuan;
use App\Models\Warga;
use Livewire\Component;
use Livewire\WithPagination;

class WargaManagement extends Component
{
    use WithPagination;

    public $search = '';

    public $showModal = false;

    public $showDeleteModal = false;

    public $editingWargaId = null;

    // Form fields
    public $nik;

    public $nkk;

    public $nama;

    public $alamat;

    public $telepon;

    public $tempat_lahir;

    public $tanggal_lahir;

    public $agama;

    public $password;

    protected $paginationTheme = 'bootstrap';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function rules()
    {
        return [
            'nik' => 'required|string|max:16|unique:warga,nik,'.$this->editingWargaId.',id_warga',
            'nkk' => 'required|string|max:16',
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'telepon' => 'required|string|max:20',
            'tempat_lahir' => 'required|string|max:100',
            'tanggal_lahir' => 'required|date',
            'agama' => 'required|string|max:50',
            'password' => $this->editingWargaId ? 'nullable|min:6' : 'required|min:6',
        ];
    }

    public function openCreateModal()
    {
        $this->resetValidation();
        $this->resetForm();
        $this->showModal = true;
    }

    public function openEditModal($id)
    {
        $this->resetValidation();
        $this->resetForm();

        $warga = Warga::findOrFail($id);
        $this->editingWargaId = $warga->id_warga;

        $this->nik = $warga->nik;
        $this->nkk = $warga->nkk;
        $this->nama = $warga->nama;
        $this->alamat = $warga->alamat;
        $this->telepon = $warga->telepon;
        $this->tempat_lahir = $warga->tempat_lahir;
        $this->tanggal_lahir = $warga->tanggal_lahir ? $warga->tanggal_lahir->format('Y-m-d') : null;
        $this->agama = $warga->agama;

        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->editingWargaId = null;
        $this->nik = null;
        $this->nkk = null;
        $this->nama = null;
        $this->alamat = null;
        $this->telepon = null;
        $this->tempat_lahir = null;
        $this->tanggal_lahir = null;
        $this->agama = null;
        $this->password = null;
    }

    public function save()
    {
        $validatedData = $this->validate();

        if (empty($validatedData['password'])) {
            unset($validatedData['password']);
        }

        if ($this->editingWargaId) {
            Warga::findOrFail($this->editingWargaId)->update($validatedData);
        } else {
            $warga = Warga::create($validatedData);

            // Auto-create pengajuan for new warga
            Pengajuan::create([
                'id_warga' => $warga->id_warga,
                'jenis_pengajuan' => 'Masuk',
                'status_pengajuan' => 'Menunggu',
            ]);
        }

        $this->closeModal();
    }

    public function confirmDelete($id)
    {
        $this->editingWargaId = $id;
        $this->showDeleteModal = true;
    }

    public function cancelDelete()
    {
        $this->showDeleteModal = false;
        $this->editingWargaId = null;
    }

    public function deleteWarga()
    {
        if ($this->editingWargaId) {
            Warga::findOrFail($this->editingWargaId)->delete();
            $this->showDeleteModal = false;
            $this->editingWargaId = null;
        }
    }

    public function render()
    {
        $wargaQuery = Warga::query()
            ->when($this->search, function ($query) {
                $query->where('nama', 'like', '%'.$this->search.'%')
                    ->orWhere('nik', 'like', '%'.$this->search.'%')
                    ->orWhere('nkk', 'like', '%'.$this->search.'%');
            })
            ->latest('created_at')
            ->paginate(10);

        return view('livewire.admin.warga-management', [
            'wargas' => $wargaQuery,
        ])->layout('layouts.app', ['title' => 'Data Warga']);
    }
}
