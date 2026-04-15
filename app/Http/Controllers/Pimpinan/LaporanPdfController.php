<?php

namespace App\Http\Controllers\Pimpinan;

use App\Enums\StatusKetersediaan;
use App\Http\Controllers\Controller;
use App\Models\UnitRumah;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LaporanPdfController extends Controller
{
    public function downloadLaporanRumah(Request $request)
    {
        $pimpinan = Auth::guard('kepala_dinas')->user();

        $query = UnitRumah::with(['penempatan.pengajuan.warga'])
            ->orderBy('blok')
            ->orderBy('nomor');

        // Apply filter status
        if ($request->filled('status')) {
            $query->where('status_ketersediaan', $request->status);
        }

        $units = $query->get();

        $totalUnit = $units->count();
        $unitDihuni = $units->where('status_ketersediaan', StatusKetersediaan::DIHUNI)->count();
        $unitTersedia = $units->where('status_ketersediaan', StatusKetersediaan::TERSEDIA)->count();

        // Build filter description
        $filterInfo = [];
        if ($request->filled('status')) {
            $filterInfo[] = 'Status: ' . $request->status;
        }

        $pdf = Pdf::loadView('pdf.laporan-rumah', [
            'units' => $units,
            'totalUnit' => $totalUnit,
            'unitDihuni' => $unitDihuni,
            'unitTersedia' => $unitTersedia,
            'namaPimpinan' => $pimpinan->nama,
            'tanggalCetak' => now()->format('d F Y, H:i').' WIB',
            'filterInfo' => $filterInfo,
        ]);

        $pdf->setPaper('A4', 'landscape');

        return $pdf->download('Laporan_Rumah_Nelayan_'.date('Y-m-d').'.pdf');
    }
}
