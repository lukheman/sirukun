<?php

namespace App\Livewire\Admin;

use App\Enums\StatusKetersediaan;
use App\Models\UnitRumah;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class UnitRumahManagement extends Component
{
    use WithPagination;

    public $search = '';

    public $showModal = false;

    public $showDeleteModal = false;

    public $editingUnitId = null;

    // Form fields
    public $blok;

    public $nomor;

    public $status_ketersediaan;

    protected $paginationTheme = 'bootstrap';

    public function mount()
    {
        $this->status_ketersediaan = StatusKetersediaan::TERSEDIA->value;
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function rules()
    {
        return [
            'blok' => 'required|string|max:10',
            'nomor' => [
                'required',
                'string',
                'max:10',
                Rule::unique('unit_rumah')->where(function ($query) {
                    return $query->where('blok', $this->blok)
                        ->where('nomor', $this->nomor);
                })->ignore($this->editingUnitId, 'id_unit'),
            ],
            'status_ketersediaan' => ['required', Rule::enum(StatusKetersediaan::class)],
        ];
    }

    public function messages()
    {
        return [
            'nomor.unique' => 'Kombinasi Blok dan Nomor unit rumah ini sudah ada.',
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

        $unit = UnitRumah::findOrFail($id);
        $this->editingUnitId = $unit->id_unit;

        $this->blok = $unit->blok;
        $this->nomor = $unit->nomor;
        $this->status_ketersediaan = $unit->status_ketersediaan->value;

        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->editingUnitId = null;
        $this->blok = null;
        $this->nomor = null;
        $this->status_ketersediaan = StatusKetersediaan::TERSEDIA->value;
    }

    public function save()
    {
        $validatedData = $this->validate();

        // Uppercase block for consistency
        $validatedData['blok'] = strtoupper($validatedData['blok']);

        if ($this->editingUnitId) {
            UnitRumah::findOrFail($this->editingUnitId)->update($validatedData);
        } else {
            UnitRumah::create($validatedData);
        }

        session()->flash('success', 'Unit rumah berhasil ditambahkan.');
        $this->closeModal();
    }

    public function confirmDelete($id)
    {
        $this->editingUnitId = $id;
        $this->showDeleteModal = true;
    }

    public function cancelDelete()
    {
        $this->showDeleteModal = false;
        $this->editingUnitId = null;
    }

    public function deleteUnit()
    {
        if ($this->editingUnitId) {
            // Might need a check to see if this unit is currently occupied
            UnitRumah::findOrFail($this->editingUnitId)->delete();
            $this->showDeleteModal = false;
            $this->editingUnitId = null;
        }
    }

    public function render()
    {
        $unitQuery = UnitRumah::query()
            ->when($this->search, function ($query) {
                $query->where('blok', 'like', '%' . $this->search . '%')
                    ->orWhere('nomor', 'like', '%' . $this->search . '%');
            })
            ->orderBy('blok')
            ->orderBy('nomor')
            ->paginate(12);

        return view('livewire.admin.unitrumah-management', [
            'units' => $unitQuery,
        ])->layout('layouts.app', ['title' => 'Data Unit Rumah']);
    }
}
