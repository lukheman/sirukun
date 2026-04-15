<?php

namespace App\Http\Controllers;

use App\Enums\StatusKeluhan;
use App\Models\Keluhan;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LaporanKeluhanPdfController extends Controller
{
    public function download(Request $request)
    {
        // Resolve nama pencetak dari guard yang aktif
        $nama = 'Administrator';
        if (Auth::guard('kepala_dinas')->check()) {
            $nama = Auth::guard('kepala_dinas')->user()->nama;
        } elseif (Auth::guard('admin')->check()) {
            $nama = Auth::guard('admin')->user()->nama ?? 'Admin';
        }

        $query = Keluhan::with('warga')->latest();

        // Apply filter status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Apply search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                  ->orWhereHas('warga', function ($w) use ($search) {
                      $w->where('nama', 'like', "%{$search}%");
                  });
            });
        }

        $keluhans = $query->get();

        $totalKeluhan  = $keluhans->count();
        $menunggu      = $keluhans->where('status', StatusKeluhan::MENUNGGU)->count();
        $diproses      = $keluhans->where('status', StatusKeluhan::DIPROSES)->count();
        $selesai       = $keluhans->where('status', StatusKeluhan::SELESAI)->count();

        // Build filter description
        $filterInfo = [];
        if ($request->filled('status')) {
            $filterInfo[] = 'Status: ' . $request->status;
        }
        if ($request->filled('search')) {
            $filterInfo[] = 'Pencarian: "' . $request->search . '"';
        }

        $pdf = Pdf::loadView('pdf.laporan-keluhan', [
            'keluhans'      => $keluhans,
            'totalKeluhan'  => $totalKeluhan,
            'menunggu'      => $menunggu,
            'diproses'      => $diproses,
            'selesai'       => $selesai,
            'namaPencetak'  => $nama,
            'tanggalCetak'  => now()->format('d F Y, H:i') . ' WIB',
            'filterInfo'    => $filterInfo,
        ]);

        $pdf->setPaper('A4', 'landscape');

        return $pdf->download('Laporan_Keluhan_Warga_' . date('Y-m-d') . '.pdf');
    }
}
