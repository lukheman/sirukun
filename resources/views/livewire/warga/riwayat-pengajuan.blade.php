<div>
    <x-page-header title="Riwayat Pengajuan" subtitle="Daftar histori permohonan masuk dan keluar unit Anda">
    </x-page-header>

    @if (session('success'))
        <x-alert variant="success" title="Berhasil!" class="mb-4">
            {{ session('success') }}
        </x-alert>
    @endif

    <div class="modern-card">
        <div class="table-responsive">
            <table class="table table-modern align-middle mb-0">
                <thead>
                    <tr>
                        <th width="5%">No.</th>
                        <th width="20%">Jenis Pengajuan</th>
                        <th>Tanggal Pengajuan</th>
                        <th>Keterangan / Unit</th>
                        <th width="15%">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pengajuans as $index => $pengajuan)
                        <tr>
                            <td class="text-muted text-center">{{ $pengajuans->firstItem() + $index }}</td>
                            <td>
                                @if($pengajuan->jenis_pengajuan === App\Enums\JenisPengajuan::KELUAR)
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="icon-wrap"
                                            style="width: 32px; height: 32px; border-radius: 8px; background: rgba(199, 91, 63, 0.1); color: var(--primary-color); display: flex; align-items: center; justify-content: center; font-size: 0.9rem;">
                                            <i class="fas fa-sign-out-alt"></i>
                                        </div>
                                        <span class="fw-medium">Keluar</span>
                                    </div>
                                @else
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="icon-wrap"
                                            style="width: 32px; height: 32px; border-radius: 8px; background: rgba(91, 168, 124, 0.1); color: var(--success-color); display: flex; align-items: center; justify-content: center; font-size: 0.9rem;">
                                            <i class="fas fa-sign-in-alt"></i>
                                        </div>
                                        <span class="fw-medium">Masuk</span>
                                    </div>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex align-items-center gap-2 text-muted">
                                    <i class="fas fa-calendar-alt"></i>
                                    {{ $pengajuan->created_at->format('d M Y, H:i') }}
                                </div>
                            </td>
                            <td>
                                @if($pengajuan->penempatan)
                                    <div class="d-flex flex-column">
                                        <span class="text-muted small">Ditempatkan di Unit:</span>
                                        <strong>Blok {{ $pengajuan->penempatan->unitRumah->blok ?? '-' }} No.
                                            {{ $pengajuan->penempatan->unitRumah->nomor ?? '-' }}</strong>
                                    </div>
                                @else
                                    <span class="text-muted fst-italic">-</span>
                                @endif
                            </td>
                            <td>
                                <x-badge :variant="$pengajuan->status_pengajuan->getColor()"
                                    :icon="$pengajuan->status_pengajuan->getIcon()">
                                    {{ $pengajuan->status_pengajuan->getLabel() }}
                                </x-badge>
                                @if($pengajuan->status_pengajuan === App\Enums\StatusPengajuan::DITOLAK && $pengajuan->alasan_tolak)
                                    <div class="mt-2 p-2 rounded" style="background: rgba(220,53,69,.06); border: 1px solid rgba(220,53,69,.15); border-radius: 6px;">
                                        <small class="text-danger d-flex align-items-start gap-1">
                                            <i class="fas fa-info-circle mt-1" style="flex-shrink:0;"></i>
                                            <span><strong>Alasan:</strong> {{ $pengajuan->alasan_tolak }}</span>
                                        </small>
                                    </div>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <div class="empty-state">
                                    <i class="fas fa-folder-open mb-3"
                                        style="font-size: 3rem; color: var(--border-color);"></i>
                                    <h5 class="text-muted">Belum ada riwayat pengajuan</h5>
                                    <p class="text-muted small mb-0">Semua riwayat pengajuan masuk dan keluar akan tampil di
                                        sini.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($pengajuans->hasPages())
            <div class="mt-4 border-top pt-4">
                {{ $pengajuans->links() }}
            </div>
        @endif
    </div>

    {{-- Ajukan Keluar Modal --}}
    <x-confirm-modal :show="$showAjukanKeluarModal" title="Konfirmasi Pengajuan Keluar"
        message="Apakah Anda yakin ingin mengajukan permohonan untuk keluar dari unit rumah saat ini? Pengajuan ini akan diteruskan ke Admin untuk disetujui."
        on-confirm="submitPengajuanKeluar" on-cancel="closeAjukanKeluarModal" variant="danger"
        icon="fas fa-sign-out-alt">
        <x-slot:confirmButton>
            <i class="fas fa-paper-plane me-2"></i>Kirim Pengajuan Keluar
        </x-slot:confirmButton>
    </x-confirm-modal>
</div>