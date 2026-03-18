<?php

namespace App\Livewire\Warga;

use App\Models\Pengajuan;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Riwayat Pengajuan - SIRUKUN')]
class RiwayatPengajuan extends Component
{
    use WithPagination;

    public $showAjukanKeluarModal = false;

    protected $paginationTheme = 'bootstrap';

    public function openAjukanKeluarModal()
    {
        $this->showAjukanKeluarModal = true;
    }

    public function closeAjukanKeluarModal()
    {
        $this->showAjukanKeluarModal = false;
    }

    public function submitPengajuanKeluar()
    {
        $warga = Auth::guard('warga')->user();

        // Buat pengajuan baru dengan tipe Keluar
        $warga->pengajuan()->create([
            'jenis_pengajuan' => 'Keluar',
            'status_pengajuan' => 'Menunggu',
        ]);

        $this->closeAjukanKeluarModal();
        session()->flash('success', 'Pengajuan keluar berhasil dikirim dan sedang menunggu persetujuan.');
    }

    public function render()
    {
        $warga = Auth::guard('warga')->user();

        // Ambil semua pengajuan warga untuk pagination
        $pengajuansPagination = Pengajuan::with('penempatan.unitRumah')
            ->where('id_warga', $warga->id_warga)
            ->latest('created_at')
            ->paginate(10);

        // Ambil semua untuk cek status
        $allPengajuans = Pengajuan::where('id_warga', $warga->id_warga)->get();

        // Cek apakah warga sedang menghuni (punya penempatan aktif)
        $punyaPenempatan = $allPengajuans->where('status_pengajuan', 'Disetujui')
            ->whereNotNull('penempatan')
            ->isNotEmpty();

        // Cek apakah warga sudah punya pengajuan keluar yang masih Menunggu
        $punyaPengajuanKeluarMenunggu = $allPengajuans->where('jenis_pengajuan', 'Keluar')
            ->where('status_pengajuan', 'Menunggu')
            ->isNotEmpty();

        $bisaAjukanKeluar = $punyaPenempatan && ! $punyaPengajuanKeluarMenunggu;

        return view('livewire.warga.riwayat-pengajuan', [
            'pengajuans' => $pengajuansPagination,
            'bisaAjukanKeluar' => $bisaAjukanKeluar,
        ]);
    }
}
