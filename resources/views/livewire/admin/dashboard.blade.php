<div>
    {{-- Page Header --}}
    <x-page-header title="Dashboard Overview"
        subtitle="Selamat datang kembali! Berikut ringkasan data SIRUKUN hari ini.">
        <x-slot:actions>
            <a href="{{ route('admin.pengajuan') }}" wire:navigate
                class="btn btn-primary d-flex align-items-center gap-2">
                <i class="fas fa-arrow-right"></i>
                <span>Lihat Pengajuan</span>
            </a>
        </x-slot:actions>
    </x-page-header>

    {{-- Stats Cards --}}
    <div class="row g-4 mb-4">
        <div class="col-md-6 col-lg-3">
            <x-stat-card icon="fas fa-users" label="Total Warga" value="{{ number_format($totalWarga) }}"
                variant="primary" />
        </div>
        <div class="col-md-6 col-lg-3">
            <x-stat-card icon="fas fa-home" label="Unit Rumah Dihuni" value="{{ number_format($unitRumahDihuni) }}"
                trend-value="Dari {{ number_format($totalUnitRumah) }} Total Unit" trend-direction="up"
                variant="success" />
        </div>
        <div class="col-md-6 col-lg-3">
            <x-stat-card icon="fas fa-door-open" label="Unit Rumah Tersedia"
                value="{{ number_format($unitRumahTersedia) }}" variant="info" />
        </div>
        <div class="col-md-6 col-lg-3">
            <x-stat-card icon="fas fa-clock" label="Pengajuan Menunggu" value="{{ number_format($pengajuanMenunggu) }}"
                variant="warning" />
        </div>
    </div>

    {{-- Recent Pengajuan Table --}}
    <x-table-card title="Pengajuan Terbaru" view-all-href="{{ route('admin.pengajuan') }}" :headers="['Warga', 'Jenis Pengajuan', 'Status', 'Tanggal']">
        @forelse($recentPengajuan as $pengajuan)
            <tr>
                <td>
                    <div class="d-flex align-items-center">
                        <div class="avatar avatar-sm me-3"
                            style="background: rgba(199, 91, 63, 0.1); color: var(--primary-color); display: flex; align-items: center; justify-content: center; border-radius: 8px; width: 36px; height: 36px; font-weight: bold;">
                            {{ $pengajuan->warga->initials() }}
                        </div>
                        <div>
                            <strong style="color: var(--text-primary);">{{ $pengajuan->warga->nama }}</strong>
                            <div class="text-muted small" style="font-size: 0.8rem;">NIK: {{ $pengajuan->warga->nik }}</div>
                        </div>
                    </div>
                </td>
                <td>
                    <x-badge :variant="$pengajuan->jenis_pengajuan->getColor()"
                        :icon="$pengajuan->jenis_pengajuan->getIcon()">
                        {{ $pengajuan->jenis_pengajuan->getLabel() }}
                    </x-badge>
                </td>
                <td>
                    <x-badge :variant="$pengajuan->status_pengajuan->getColor()"
                        :icon="$pengajuan->status_pengajuan->getIcon()">
                        {{ $pengajuan->status_pengajuan->getLabel() }}
                    </x-badge>
                </td>
                <td class="text-muted">{{ $pengajuan->created_at->format('d M Y, H:i') }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="4" class="text-center py-4 text-muted">Belum ada data pengajuan terbaru.</td>
            </tr>
        @endforelse
    </x-table-card>

    <div class="row g-4 mt-1">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm rounded-4 h-100" style="background: var(--bg-secondary);">
                <div class="card-body p-4">
                    <h5 class="card-title fw-bold mb-4" style="color: var(--text-primary);">Informasi Perumahan</h5>
                    <div class="d-flex justify-content-between align-items-center mb-3 p-3 rounded-3 border"
                        style="background: var(--bg-white); border-color: var(--border-color) !important;">
                        <span class="text-muted"><i class="fas fa-building me-3"></i>Total Unit Rumah</span>
                        <span class="fw-bold fs-5" style="color: var(--text-primary);">{{ $totalUnitRumah }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-3 p-3 rounded-3 border"
                        style="background: var(--bg-white); border-color: var(--border-color) !important;">
                        <span class="text-muted"><i class="fas fa-check-circle text-success me-3"></i>Unit Dihuni</span>
                        <span class="fw-bold" style="color: var(--text-primary);">{{ $unitRumahDihuni }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-3 p-3 rounded-3 border"
                        style="background: var(--bg-white); border-color: var(--border-color) !important;">
                        <span class="text-muted"><i class="fas fa-door-open text-primary me-3"></i>Unit Tersedia</span>
                        <span class="fw-bold" style="color: var(--text-primary);">{{ $unitRumahTersedia }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center p-3 rounded-3 border"
                        style="background: var(--bg-white); border-color: var(--border-color) !important;">
                        <span class="text-muted"><i class="fas fa-tools text-warning me-3"></i>Sedang Renovasi</span>
                        <span class="fw-bold" style="color: var(--text-primary);">{{ $unitRumahRenovasi }}</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card border-0 shadow-sm rounded-4 h-100" style="background: var(--bg-secondary);">
                <div class="card-body p-4">
                    <h5 class="card-title fw-bold mb-4" style="color: var(--text-primary);">Pintasan Admin</h5>
                    <div class="d-grid gap-3">
                        <a href="{{ route('admin.warga') }}" wire:navigate
                            class="btn text-start p-3 rounded-3 d-flex align-items-center justify-content-between border transition-all"
                            style="background: var(--bg-white); border-color: var(--border-color) !important; text-decoration: none;">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-users-cog text-primary me-3 fs-5"></i>
                                <span class="fw-medium" style="color: var(--text-primary);">Kelola Data Warga</span>
                            </div>
                            <i class="fas fa-chevron-right text-muted small"></i>
                        </a>
                        <a href="{{ route('admin.unitrumah') }}" wire:navigate
                            class="btn text-start p-3 rounded-3 d-flex align-items-center justify-content-between border transition-all"
                            style="background: var(--bg-white); border-color: var(--border-color) !important; text-decoration: none;">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-home text-success me-3 fs-5"></i>
                                <span class="fw-medium" style="color: var(--text-primary);">Manajemen Unit Rumah</span>
                            </div>
                            <i class="fas fa-chevron-right text-muted small"></i>
                        </a>
                        <a href="{{ route('admin.pengajuan') }}" wire:navigate
                            class="btn text-start p-3 rounded-3 d-flex align-items-center justify-content-between border transition-all"
                            style="background: var(--bg-white); border-color: var(--border-color) !important; text-decoration: none;">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-file-signature text-warning me-3 fs-5"></i>
                                <span class="fw-medium" style="color: var(--text-primary);">Tinjau Pengajuan
                                    Masuk</span>
                            </div>
                            <i class="fas fa-chevron-right text-muted small"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>