<?php

namespace App\Http\Controllers\Pimpinan;

use App\Enums\StatusKetersediaan;
use App\Http\Controllers\Controller;
use App\Models\UnitRumah;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class LaporanPdfController extends Controller
{
    public function downloadLaporanRumah()
    {
        $pimpinan = Auth::guard('kepala_dinas')->user();

        $units = UnitRumah::with(['penempatan.pengajuan.warga'])
            ->orderBy('blok')
            ->orderBy('nomor')
            ->get();

        $totalUnit = $units->count();
        $unitDihuni = $units->where('status_ketersediaan', StatusKetersediaan::DIHUNI)->count();
        $unitTersedia = $units->where('status_ketersediaan', StatusKetersediaan::TERSEDIA)->count();

        $pdf = Pdf::loadView('pdf.laporan-rumah', [
            'units' => $units,
            'totalUnit' => $totalUnit,
            'unitDihuni' => $unitDihuni,
            'unitTersedia' => $unitTersedia,
            'namaPimpinan' => $pimpinan->nama,
            'tanggalCetak' => now()->format('d F Y, H:i').' WIB',
        ]);

        $pdf->setPaper('A4', 'landscape');

        return $pdf->download('Laporan_Rumah_Nelayan_'.date('Y-m-d').'.pdf');
    }
}
