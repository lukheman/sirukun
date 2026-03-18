<div>
    <x-page-header title="Informasi Unit" subtitle="Status penempatan dan detail unit rumah Anda">
        {{-- Slot Actions Kosong --}}
    </x-page-header>

    @if (session('success'))
        <x-alert variant="success" title="Berhasil!" class="mb-4">
            {{ session('success') }}
        </x-alert>
    @endif

    <div class="row justify-content-center">
        <div class="col-lg-8">
            {{-- STATE 1: Punya Penempatan Aktif --}}
            @if($penempatanAktif)
                <div class="modern-card text-center mb-4 border-top border-4 border-success">
                    <div class="mb-4 mt-2">
                        <div class="icon-wrap mx-auto"
                            style="width: 80px; height: 80px; border-radius: 20px; background: rgba(91, 168, 124, 0.1); color: var(--success-color); display: flex; align-items: center; justify-content: center; font-size: 2.5rem;">
                            <i class="fas fa-home"></i>
                        </div>
                    </div>

                    <h3 style="color: var(--text-primary); font-weight: 700; margin-bottom: 0.5rem;">Blok
                        {{ $penempatanAktif->unitRumah->blok }} - No. {{ $penempatanAktif->unitRumah->nomor }}</h3>
                    <div class="mb-4">
                        <x-badge variant="success" icon="fas fa-check-circle">Status: Dihuni</x-badge>
                    </div>

                    <div class="text-start"
                        style="background: var(--bg-tertiary); padding: 1.5rem; border-radius: 15px; border: 1px solid var(--border-light);">
                        <h6 class="mb-3 text-muted fw-bold text-uppercase" style="font-size: 0.8rem; letter-spacing: 1px;">
                            Detail Penempatan</h6>

                        <div class="row g-3">
                            <div class="col-sm-6">
                                <div class="text-muted small">Tanggal Masuk</div>
                                <div class="fw-semibold" style="color: var(--text-primary);">
                                    {{ $penempatanAktif->tanggal_masuk->format('d F Y') }}</div>
                            </div>
                            <div class="col-sm-6">
                                <div class="text-muted small">Tipe Unit</div>
                                <div class="fw-semibold" style="color: var(--text-primary);">Standar</div>
                            </div>
                            <div class="col-12 mt-3">
                                <div class="text-muted small">Alamat Lengkap / Keterangan</div>
                                <div class="fw-semibold" style="color: var(--text-primary);">Unit Rumah Blok
                                    {{ $penempatanAktif->unitRumah->blok }} Nomor {{ $penempatanAktif->unitRumah->nomor }},
                                    Kompleks SIRUKUN.</div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 pt-3 border-top">
                        @if($pengajuanKeluarMenunggu)
                            <x-alert variant="warning" class="text-start mb-0" icon="fas fa-clock">
                                Pengajuan keluar Anda sedang diproses oleh Admin.
                            </x-alert>
                        @else
                            <button
                                class="btn btn-outline-danger w-100 py-2 d-flex align-items-center justify-content-center gap-2"
                                wire:click="openAjukanKeluarModal" style="border-radius: 10px; font-weight: 500;">
                                <i class="fas fa-sign-out-alt"></i> Ajukan Keluar Unit
                            </button>
                        @endif
                    </div>
                </div>

                {{-- STATE 2: Punya Pengajuan Menunggu --}}
            @elseif($pengajuanMasukMenunggu)
                <div class="modern-card text-center mb-4 border-top border-4 border-warning">
                    <div class="mb-4 mt-2">
                        <div class="icon-wrap mx-auto"
                            style="width: 80px; height: 80px; border-radius: 20px; background: rgba(212, 148, 58, 0.1); color: var(--warning-color); display: flex; align-items: center; justify-content: center; font-size: 2.5rem;">
                            <i class="fas fa-hourglass-half"></i>
                        </div>
                    </div>

                    <h4 style="color: var(--text-primary); font-weight: 600; margin-bottom: 1rem;">Pengajuan Sedang Diproses
                    </h4>
                    <p class="text-muted mb-4">Permohonan penempatan unit Anda telah dikirim pada
                        <strong>{{ $pengajuanMasukMenunggu->created_at->format('d M Y') }}</strong> dan saat ini sedang
                        menunggu persetujuan dari Administrator. Silakan cek kembali nanti.</p>

                    <div class="p-3"
                        style="background: var(--bg-tertiary); border-radius: 10px; border: 1px dashed var(--warning-color);">
                        <div class="d-flex align-items-center justify-content-center gap-2"
                            style="color: var(--warning-color); font-weight: 500;">
                            <i class="fas fa-circle-notch fa-spin"></i> Status: Menunggu
                        </div>
                    </div>
                </div>

                {{-- STATE 3: Belum Punya Unit & Tidak Ada Pengajuan --}}
            @else
                <div class="modern-card text-center mb-4 text-muted border-top border-4"
                    style="border-top-color: var(--border-color) !important;">
                    <div class="mb-4 mt-3">
                        <i class="fas fa-home" style="font-size: 4rem; color: var(--border-color);"></i>
                    </div>

                    <h4 style="color: var(--text-primary); font-weight: 600;">Belum Menempati Unit</h4>
                    <p class="mb-4">Saat ini Anda tidak terdaftar sebagai penghuni di unit rumah mana pun. Anda dapat
                        mengajukan permohonan untuk menempati unit yang tersedia.</p>

                    <x-button variant="primary" icon="fas fa-plus" class="btn-lg px-4" wire:click="openAjukanUnitModal"
                        style="border-radius: 12px;">
                        Ajukan Penempatan Unit
                    </x-button>
                </div>
            @endif
        </div>
    </div>

    {{-- Modal Ajukan Unit --}}
    <x-confirm-modal :show="$showAjukanUnitModal" title="Konfirmasi Pengajuan Unit"
        message="Apakah Anda yakin ingin mengajukan permohonan untuk menempati unit rumah? Pengajuan ini akan diteruskan ke Admin untuk divalidasi dan diatur penempatannya."
        on-confirm="submitPengajuanUnit" on-cancel="closeAjukanUnitModal" variant="primary" icon="fas fa-home">
        <x-slot:confirmButton>
            <i class="fas fa-paper-plane me-2"></i>Kirim Pengajuan
        </x-slot:confirmButton>
    </x-confirm-modal>

    {{-- Modal Ajukan Keluar (Sama dengan Dashboard & Riwayat) --}}
    <x-confirm-modal :show="$showAjukanKeluarModal" title="Konfirmasi Pengajuan Keluar"
        message="Apakah Anda yakin ingin mengajukan permohonan untuk keluar dari unit rumah saat ini? Pengajuan ini akan menghindari tagihan selanjutnya dan unit akan dijadikan kosong/tersedia."
        on-confirm="submitPengajuanKeluar" on-cancel="closeAjukanKeluarModal" variant="danger"
        icon="fas fa-sign-out-alt">
        <x-slot:confirmButton>
            <i class="fas fa-paper-plane me-2"></i>Kirim Pengajuan Keluar
        </x-slot:confirmButton>
    </x-confirm-modal>
</div>
