<?php

namespace App\Livewire\Admin;

use App\Enums\JenisPengajuan;
use App\Enums\StatusKetersediaan;
use App\Enums\StatusPengajuan;
use App\Models\Penempatan;
use App\Models\Pengajuan;
use App\Models\UnitRumah;
use App\Models\Warga;
use Livewire\Component;
use Livewire\WithPagination;

class PengajuanManagement extends Component
{
    use WithPagination;

    public $search = '';

    public $showModal = false;

    public $showDeleteModal = false;

    public $showPenempatanModal = false;

    public $showTerimaKeluarModal = false;

    public $editingPengajuanId = null;

    public $acceptingPengajuanId = null;

    // Form fields — Pengajuan
    public $id_warga;

    public $jenis_pengajuan = 'Masuk'; // Livewire binding requires string; validated against enum

    public $status_pengajuan = 'Menunggu'; // Livewire binding requires string; validated against enum

    // Form fields — Penempatan
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
            'id_warga' => 'required|exists:warga,id_warga',
            'jenis_pengajuan' => 'required|in:'.implode(',', JenisPengajuan::values()),
            'status_pengajuan' => 'required|in:'.implode(',', StatusPengajuan::values()),
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

        $pengajuan = Pengajuan::findOrFail($id);
        $this->editingPengajuanId = $pengajuan->id_pengajuan;

        $this->id_warga = $pengajuan->id_warga;
        $this->jenis_pengajuan = $pengajuan->jenis_pengajuan instanceof JenisPengajuan
            ? $pengajuan->jenis_pengajuan->value
            : $pengajuan->jenis_pengajuan;
        $this->status_pengajuan = $pengajuan->status_pengajuan instanceof StatusPengajuan
            ? $pengajuan->status_pengajuan->value
            : $pengajuan->status_pengajuan;

        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->editingPengajuanId = null;
        $this->id_warga = null;
        $this->jenis_pengajuan = JenisPengajuan::MASUK->value;
        $this->status_pengajuan = StatusPengajuan::MENUNGGU->value;
    }

    public function save()
    {
        $validatedData = $this->validate();

        if ($this->editingPengajuanId) {
            Pengajuan::findOrFail($this->editingPengajuanId)->update($validatedData);
            session()->flash('success', 'Data pengajuan berhasil diperbarui.');
        } else {
            Pengajuan::create($validatedData);
            session()->flash('success', 'Data pengajuan berhasil ditambahkan.');
        }

        $this->closeModal();
    }

    // ── Accept & Penempatan ─────────────────────────────────

    public function acceptPengajuan($id)
    {
        $this->resetValidation();
        $this->acceptingPengajuanId = $id;
        $this->id_unit = null;
        $this->tanggal_masuk = date('Y-m-d');
        $this->showPenempatanModal = true;
    }

    public function closePenempatanModal()
    {
        $this->showPenempatanModal = false;
        $this->acceptingPengajuanId = null;
        $this->id_unit = null;
        $this->tanggal_masuk = null;
    }

    public function acceptPengajuanKeluar($id)
    {
        $this->acceptingPengajuanId = $id;
        $this->showTerimaKeluarModal = true;
    }

    public function closeTerimaKeluarModal()
    {
        $this->showTerimaKeluarModal = false;
        $this->acceptingPengajuanId = null;
    }

    public function savePengajuanKeluar()
    {
        $pengajuan = Pengajuan::findOrFail($this->acceptingPengajuanId);

        // Update status pengajuan
        $pengajuan->update(['status_pengajuan' => StatusPengajuan::DISETUJUI]);

        // Cari penempatan aktif warga ini dan arsipkan
        $penempatan = Penempatan::whereNull('tanggal_keluar')
            ->whereHas('pengajuan', function ($q) use ($pengajuan) {
                $q->where('id_warga', $pengajuan->id_warga);
            })->first();

        if ($penempatan) {
            // Arsipkan dengan tanggal keluar (bukan hapus)
            $penempatan->update(['tanggal_keluar' => now()]);

            UnitRumah::where('id_unit', $penempatan->id_unit)
                ->update(['status_ketersediaan' => StatusKetersediaan::TERSEDIA->value]);
        }

        $this->closeTerimaKeluarModal();
        session()->flash('success', 'Pengajuan keluar berhasil disetujui dan unit telah dikosongkan.');
    }

    public function savePenempatan()
    {
        $this->validate([
            'id_unit' => 'required|exists:unit_rumah,id_unit',
            'tanggal_masuk' => 'required|date',
        ]);

        // Update status pengajuan → Disetujui
        $pengajuan = Pengajuan::findOrFail($this->acceptingPengajuanId);
        $pengajuan->update(['status_pengajuan' => StatusPengajuan::DISETUJUI]);

        // Buat record penempatan
        Penempatan::create([
            'id_pengajuan' => $this->acceptingPengajuanId,
            'id_unit' => $this->id_unit,
            'tanggal_masuk' => $this->tanggal_masuk,
        ]);

        // Update status unit → Dihuni
        UnitRumah::where('id_unit', $this->id_unit)
            ->update(['status_ketersediaan' => StatusKetersediaan::DIHUNI->value]);

        $this->closePenempatanModal();
        session()->flash('success', 'Pengajuan masuk berhasil disetujui dan penempatan unit telah diatur.');
    }

    // ── Delete ──────────────────────────────────────────────

    public function confirmDelete($id)
    {
        $this->editingPengajuanId = $id;
        $this->showDeleteModal = true;
    }

    public function cancelDelete()
    {
        $this->showDeleteModal = false;
        $this->editingPengajuanId = null;
    }

    public function deletePengajuan()
    {
        if ($this->editingPengajuanId) {
            Pengajuan::findOrFail($this->editingPengajuanId)->delete();
            $this->showDeleteModal = false;
            $this->editingPengajuanId = null;
            session()->flash('success', 'Data pengajuan berhasil dihapus.');
        }
    }

    public function render()
    {
        $pengajuanQuery = Pengajuan::with(['warga', 'penempatan'])
            ->whereHas('warga', function ($query) {
                $query->where('nama', 'like', '%'.$this->search.'%')
                    ->orWhere('nik', 'like', '%'.$this->search.'%');
            })
            ->latest('created_at')
            ->paginate(10);

        // Unit rumah yang tersedia (belum dihuni)
        $unitRumahs = UnitRumah::where('status_ketersediaan', '!=', StatusKetersediaan::DIHUNI->value)
            ->where('status_ketersediaan', StatusKetersediaan::TERSEDIA)
            ->orderBy('blok')
            ->orderBy('nomor')
            ->get();

        return view('livewire.admin.pengajuan-management', [
            'pengajuans' => $pengajuanQuery,
            'wargas' => Warga::orderBy('nama')->get(),
            'unitRumahs' => $unitRumahs,
        ])->layout('layouts.app', ['title' => 'Data Pengajuan']);
    }
}
