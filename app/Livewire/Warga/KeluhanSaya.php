<?php

namespace App\Livewire\Warga;

use App\Enums\StatusKeluhan;
use App\Models\Keluhan;
use App\Models\Penempatan;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Keluhan Saya - SIRUKUN')]
class KeluhanSaya extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public bool $showFormModal = false;
    public bool $showDetailModal = false;
    public bool $sudahDitempatkan = false;

    public string $judul = '';
    public string $isi = '';
    public ?int $viewingKeluhanId = null;

    public function openFormModal(): void
    {
        $this->resetValidation();
        $this->judul = '';
        $this->isi = '';
        $this->showFormModal = true;
    }

    public function closeFormModal(): void
    {
        $this->showFormModal = false;
    }

    public function openDetailModal(int $id): void
    {
        $this->viewingKeluhanId = $id;
        $this->showDetailModal = true;
    }

    public function closeDetailModal(): void
    {
        $this->showDetailModal = false;
        $this->viewingKeluhanId = null;
    }

    public function kirim(): void
    {
        if (! $this->sudahDitempatkan) {
            session()->flash('error', 'Anda belum ditempatkan di unit manapun. Keluhan tidak dapat dikirim.');
            return;
        }

        $this->validate([
            'judul' => 'required|string|min:5|max:150',
            'isi' => 'required|string|min:10',
        ], [
            'judul.required' => 'Judul keluhan wajib diisi.',
            'judul.min' => 'Judul minimal 5 karakter.',
            'isi.required' => 'Isi keluhan wajib diisi.',
            'isi.min' => 'Isi keluhan minimal 10 karakter.',
        ]);

        $warga = Auth::guard('warga')->user();

        Keluhan::create([
            'id_warga' => $warga->id_warga,
            'judul' => $this->judul,
            'isi' => $this->isi,
            'status' => StatusKeluhan::MENUNGGU,
        ]);

        $this->closeFormModal();
        session()->flash('success', 'Keluhan berhasil dikirim. Admin akan segera menindaklanjuti.');
        $this->resetPage();
    }

    public function render()
    {
        $warga = Auth::guard('warga')->user();

        // Cek apakah warga sudah ditempatkan di unit (penempatan aktif)
        $this->sudahDitempatkan = Penempatan::whereNull('tanggal_keluar')
            ->whereHas('pengajuan', function ($q) use ($warga) {
                $q->where('id_warga', $warga->id_warga);
            })->exists();

        $keluhans = Keluhan::where('id_warga', $warga->id_warga)
            ->latest()
            ->paginate(8);

        $viewingKeluhan = $this->viewingKeluhanId
            ? Keluhan::find($this->viewingKeluhanId)
            : null;

        return view('livewire.warga.keluhan-saya', compact('keluhans', 'viewingKeluhan'));
    }
}
