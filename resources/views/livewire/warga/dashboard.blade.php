<div>
    <x-page-header title="Dashboard Warga">
        <x-slot:actions>
            <div class="welcome-badge"
                style="background: var(--bg-white); padding: 0.5rem 1rem; border-radius: 10px; border: 1px solid var(--border-color); display: flex; align-items: center; gap: 8px; font-weight: 500;">
                <i class="fas fa-id-card text-primary"></i>
                NIK: {{ $warga->nik }}
            </div>
        </x-slot:actions>
    </x-page-header>

    <div class="row mb-4">
        <div class="col-12">
            <x-modern-card class="bg-primary text-white"
                style="background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                    <div>
                        <h4 class="mb-1 text-white fw-bold">Selamat Datang, {{ $warga->nama }} 👋</h4>
                        <p class="mb-0 text-white-50">Berikut adalah ringkasan informasi data diri, pengajuan, dan unit
                            hunian Anda.</p>
                    </div>
                </div>
            </x-modern-card>
        </div>
    </div>

    <!-- Data Diri -->
    <div class="row mb-4">
        <div class="col-12">
            <x-modern-card title="Data Diri">
                <x-slot:actions>
                    <i class="fas fa-user text-primary"></i>
                </x-slot:actions>

                <div class="row g-3">
                    <div class="col-md-6 col-lg-4">
                        <div class="d-flex flex-column gap-1">
                            <span class="text-muted small fw-medium">Nama Lengkap</span>
                            <span class="text-primary fw-medium">{{ $warga->nama }}</span>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <div class="d-flex flex-column gap-1">
                            <span class="text-muted small fw-medium">NIK</span>
                            <span class="text-primary fw-medium">{{ $warga->nik }}</span>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <div class="d-flex flex-column gap-1">
                            <span class="text-muted small fw-medium">No. KK</span>
                            <span class="text-primary fw-medium">{{ $warga->nkk }}</span>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <div class="d-flex flex-column gap-1">
                            <span class="text-muted small fw-medium">No. Telepon</span>
                            <span class="text-primary fw-medium">{{ $warga->telepon }}</span>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <div class="d-flex flex-column gap-1">
                            <span class="text-muted small fw-medium">Tempat, Tanggal Lahir</span>
                            <span class="text-primary fw-medium">{{ $warga->tempat_lahir }},
                                {{ $warga->tanggal_lahir->format('d M Y') }}</span>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <div class="d-flex flex-column gap-1">
                            <span class="text-muted small fw-medium">Agama</span>
                            <span class="text-primary fw-medium">{{ $warga->agama }}</span>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="d-flex flex-column gap-1">
                            <span class="text-muted small fw-medium">Alamat</span>
                            <span class="text-primary fw-medium">{{ $warga->alamat }}</span>
                        </div>
                    </div>
                </div>
            </x-modern-card>
        </div>
    </div>

    <!-- Info Unit Cards -->
    <div class="row g-3 mb-4">
        <div class="col-12 col-sm-6 col-xl-3">
            <x-stat-card icon="fas fa-building" label="Total Unit" value="{{ $totalUnit }}" variant="primary" />
        </div>
        <div class="col-12 col-sm-6 col-xl-3">
            <x-stat-card icon="fas fa-house-user" label="Unit Terisi" value="{{ $unitTerisi }}" variant="success" />
        </div>
        <div class="col-12 col-sm-6 col-xl-3">
            <x-stat-card icon="fas fa-door-open" label="Unit Kosong" value="{{ $unitKosong }}" variant="warning" />
        </div>
        <div class="col-12 col-sm-6 col-xl-3">
            <x-stat-card icon="fas fa-file-signature" label="Pengajuan Saya" value="{{ $pengajuans->count() }}"
                variant="secondary" />
        </div>
    </div>

    <!-- Riwayat Pengajuan -->
    <div class="row mb-4">
        <div class="col-12">
            <x-modern-card title="Riwayat Pengajuan Saya">
                <x-slot:actions>
                    @if($bisaAjukanKeluar)
                        <x-button variant="danger" icon="fas fa-sign-out-alt" wire:click="openAjukanKeluarModal" class="btn-sm">
                            Ajukan Keluar
                        </x-button>
                    @else
                        <i class="fas fa-file-alt text-primary"></i>
                    @endif
                </x-slot:actions>

                @if($pengajuans->isEmpty())
                    <x-empty-state icon="fas fa-folder-open" title="Belum ada pengajuan"
                        message="Anda belum memiliki riwayat pengajuan hunian." />
                @else
                    <div class="d-flex flex-column gap-3">
                        @foreach($pengajuans as $pengajuan)
                            <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 p-3 text-start bg-light"
                                style="border: 1px solid var(--border-color); border-radius: 12px; transition: all 0.2s;">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="icon-wrap"
                                        style="width: 42px; height: 42px; border-radius: 10px; background: rgba(199, 91, 63, 0.1); color: var(--primary-color); display: flex; align-items: center; justify-content: center; font-size: 1.1rem;">
                                        @if($pengajuan->jenis_pengajuan === 'Keluar')
                                            <i class="fas fa-sign-out-alt"></i>
                                        @else
                                            <i class="fas fa-file-contract"></i>
                                        @endif
                                    </div>
                                    <div>
                                        <div class="fw-bold" style="color: var(--text-primary); font-size: 0.95rem;">Pengajuan {{ $pengajuan->jenis_pengajuan }}
                                            #{{ $pengajuan->id_pengajuan }}</div>
                                        <div class="small text-muted d-flex align-items-center gap-1">
                                            <i class="fas fa-calendar-alt"></i>
                                            {{ $pengajuan->created_at->format('d M Y, H:i') }}
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center gap-3">
                                    @php
                                        $statusClass = match ($pengajuan->status_pengajuan) {
                                            'Disetujui' => 'success',
                                            'Ditolak' => 'danger',
                                            default => 'warning',
                                        };
                                        $statusIcon = match ($pengajuan->status_pengajuan) {
                                            'Disetujui' => 'fas fa-check-circle',
                                            'Ditolak' => 'fas fa-times-circle',
                                            default => 'fas fa-clock',
                                        };
                                    @endphp
                                    <x-badge :variant="$statusClass" :icon="$statusIcon">
                                        {{ $pengajuan->status_pengajuan }}
                                    </x-badge>
                                    @if($pengajuan->jenis_pengajuan === 'Keluar')
                                        <x-badge variant="info" icon="fas fa-sign-out-alt">
                                            Keluar
                                        </x-badge>
                                    @endif
                                </div>
                                @if($pengajuan->penempatan)
                                    <div class="w-100 pt-2 mt-2 border-top d-flex align-items-center gap-2 small"
                                        style="border-color: var(--border-color) !important;">
                                        <i class="fas fa-home text-secondary"></i>
                                        <span class="text-muted">Unit: <strong>Blok
                                                {{ $pengajuan->penempatan->unitRumah->blok ?? '-' }} No.
                                                {{ $pengajuan->penempatan->unitRumah->nomor ?? '-' }}</strong> — Masuk:
                                            {{ $pengajuan->penempatan->tanggal_masuk->format('d M Y') }}</span>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @endif
            </x-modern-card>
        </div>
    </div>

    <!-- Informasi Unit Rumah -->
    <div class="row">
        <div class="col-12">
            <x-table-card title="Informasi Unit Rumah" :headers="['Blok', 'Nomor', 'Status', 'Penghuni', 'Tanggal Masuk']">
                <x-slot:actions>
                    <i class="fas fa-building text-primary"></i>
                </x-slot:actions>

                @forelse($units as $unit)
                    <tr>
                        <td><strong>{{ $unit->blok }}</strong></td>
                        <td>{{ $unit->nomor }}</td>
                        <td>
                            @if($unit->status_ketersediaan === 'Terisi')
                                <x-badge variant="success" icon="fas fa-house-user">Terisi</x-badge>
                            @else
                                <x-badge variant="secondary" icon="fas fa-door-open">Tersedia</x-badge>
                            @endif
                        </td>
                        <td>
                            @if($unit->penempatan && $unit->penempatan->pengajuan && $unit->penempatan->pengajuan->warga)
                                <div class="d-flex align-items-center gap-2">
                                    <x-avatar :name="$unit->penempatan->pengajuan->warga->nama" />
                                    <div>
                                        <div class="fw-medium text-primary" style="font-size: 0.88rem;">
                                            {{ $unit->penempatan->pengajuan->warga->nama }}</div>
                                        <div class="text-muted" style="font-size: 0.75rem;">
                                            {{ $unit->penempatan->pengajuan->warga->nik }}</div>
                                    </div>
                                </div>
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>
                        <td>
                            @if($unit->penempatan)
                                {{ $unit->penempatan->tanggal_masuk->format('d M Y') }}
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted" style="padding: 2rem;">Belum ada data unit.</td>
                    </tr>
                @endforelse
            </x-table-card>
        </div>
    </div>

    {{-- Ajukan Keluar Modal --}}
    <x-confirm-modal :show="$showAjukanKeluarModal" title="Konfirmasi Pengajuan Keluar"
        message="Apakah Anda yakin ingin mengajukan permohonan untuk keluar dari unit rumah saat ini? Pengajuan ini akan diteruskan ke Admin untuk disetujui."
        on-confirm="submitPengajuanKeluar" on-cancel="closeAjukanKeluarModal" variant="danger" icon="fas fa-sign-out-alt">
        <x-slot:confirmButton>
            <i class="fas fa-paper-plane me-2"></i>Kirim Pengajuan Keluar
        </x-slot:confirmButton>
    </x-confirm-modal>
</div>