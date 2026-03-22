<?php

use App\Http\Controllers\Admin\LogoutController;
use App\Http\Controllers\Pimpinan\LaporanPdfController;
use App\Livewire\Admin\Dashboard as AdminDashboard;
use App\Livewire\Admin\Profile;
use App\Livewire\Auth\Login;
use App\Livewire\Auth\Register;
use App\Livewire\Pimpinan\ArsipPenghuni as PimpinanArsipPenghuni;
use App\Livewire\Pimpinan\Dashboard as PimpinanDashboard;
use App\Livewire\Pimpinan\LaporanRumah as PimpinanLaporanRumah;
use App\Livewire\Warga\Dashboard as WargaDashboard;
use App\Livewire\Warga\InformasiUnit as WargaInformasiUnit;
use App\Livewire\Warga\Profile as WargaProfile;
use App\Livewire\Warga\RiwayatPengajuan as WargaRiwayatPengajuan;
use Illuminate\Support\Facades\Route;

// Guest Routes
Route::get('/', \App\Livewire\Guest\LandingPage::class)->name('home');

// Auth Routes
Route::get('/login', Login::class)->name('login');
Route::get('/register', Register::class)->name('register');

// Admin Routes
Route::prefix('admin')->middleware('auth:admin')->group(function () {
    Route::get('/dashboard', AdminDashboard::class)->name('dashboard');
    Route::get('/profile', Profile::class)->name('admin.profile');

    // Management Routes
    Route::get('/warga', App\Livewire\Admin\WargaManagement::class)->name('admin.warga');
    Route::get('/pengajuan', App\Livewire\Admin\PengajuanManagement::class)->name('admin.pengajuan');
    Route::get('/unit-rumah', App\Livewire\Admin\UnitRumahManagement::class)->name('admin.unitrumah');
    Route::get('/penempatan', App\Livewire\Admin\PenempatanManagement::class)->name('admin.penempatan');

    Route::post('/logout', [LogoutController::class, '__invoke'])->name('logout');
});

// Warga Routes
Route::prefix('warga')->middleware('auth:warga')->group(function () {
    Route::get('/dashboard', WargaDashboard::class)->name('warga.dashboard');
    Route::get('/unit', WargaInformasiUnit::class)->name('warga.unit');
    Route::get('/pengajuan', WargaRiwayatPengajuan::class)->name('warga.pengajuan');
    Route::get('/profile', WargaProfile::class)->name('warga.profile');
    Route::post('/logout', [LogoutController::class, '__invoke'])->name('warga.logout');
});

// Pimpinan Routes
Route::prefix('pimpinan')->middleware('auth:kepala_dinas')->group(function () {
    Route::get('/dashboard', PimpinanDashboard::class)->name('pimpinan.dashboard');
    Route::get('/laporan-rumah', PimpinanLaporanRumah::class)->name('pimpinan.laporan');
    Route::get('/laporan-rumah/pdf', [LaporanPdfController::class, 'downloadLaporanRumah'])->name('pimpinan.laporan.pdf');
    Route::get('/arsip-penghuni', PimpinanArsipPenghuni::class)->name('pimpinan.arsip');
    Route::post('/logout', [LogoutController::class, '__invoke'])->name('pimpinan.logout');
});
