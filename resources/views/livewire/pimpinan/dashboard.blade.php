<div>
    <x-page-header title="Dashboard Pimpinan"
        subtitle="Selamat datang, {{ $pimpinan->nama }}. Berikut ringkasan data sistem SIRUKUN.">
    </x-page-header>

    <div class="row g-4 mb-4">
        {{-- Total Warga --}}
        <div class="col-sm-6 col-lg-3">
            <x-stat-card label="Total Warga" :value="$totalWarga" icon="fas fa-users" color="primary" />
        </div>

        {{-- Total Unit Rumah --}}
        <div class="col-sm-6 col-lg-3">
            <x-stat-card label="Total Unit Rumah" :value="$totalUnit" icon="fas fa-home" color="info" />
        </div>

        {{-- Unit Dihuni --}}
        <div class="col-sm-6 col-lg-3">
            <x-stat-card label="Unit Dihuni" :value="$unitDihuni" icon="fas fa-door-closed" color="success" />
        </div>

        {{-- Unit Tersedia --}}
        <div class="col-sm-6 col-lg-3">
            <x-stat-card label="Unit Tersedia" :value="$unitTersedia" icon="fas fa-door-open" color="warning" />
        </div>
    </div>

    <div class="row g-4">
        {{-- Pengajuan Menunggu --}}
        <div class="col-sm-6">
            <div class="modern-card">
                <div class="d-flex align-items-center gap-3 mb-3">
                    <div class="icon-wrap"
                        style="width: 50px; height: 50px; border-radius: 14px; background: rgba(212, 148, 58, 0.1); color: var(--warning-color); display: flex; align-items: center; justify-content: center; font-size: 1.3rem;">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div>
                        <h5 class="mb-0" style="color: var(--text-primary); font-weight: 600;">Pengajuan Menunggu</h5>
                        <small class="text-muted">Permohonan yang belum diproses</small>
                    </div>
                </div>
                <h2 style="color: var(--warning-color); font-weight: 700; font-size: 2.5rem;">{{ $pengajuanMenunggu }}
                </h2>
            </div>
        </div>

        {{-- Pengajuan Disetujui --}}
        <div class="col-sm-6">
            <div class="modern-card">
                <div class="d-flex align-items-center gap-3 mb-3">
                    <div class="icon-wrap"
                        style="width: 50px; height: 50px; border-radius: 14px; background: rgba(91, 168, 124, 0.1); color: var(--success-color); display: flex; align-items: center; justify-content: center; font-size: 1.3rem;">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div>
                        <h5 class="mb-0" style="color: var(--text-primary); font-weight: 600;">Pengajuan Disetujui</h5>
                        <small class="text-muted">Total permohonan yang telah disetujui</small>
                    </div>
                </div>
                <h2 style="color: var(--success-color); font-weight: 700; font-size: 2.5rem;">{{ $pengajuanDisetujui }}
                </h2>
            </div>
        </div>
    </div>
</div>
