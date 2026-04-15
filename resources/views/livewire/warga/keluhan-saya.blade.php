<div>
    {{-- Page Header --}}
    <x-page-header title="Keluhan Saya" subtitle="Sampaikan keluhan atau permintaan perbaikan kepada admin.">
        @if($sudahDitempatkan)
            <x-slot:actions>
                <x-button variant="primary" icon="fas fa-plus" wire:click="openFormModal">
                    Buat Keluhan Baru
                </x-button>
            </x-slot:actions>
        @endif
    </x-page-header>

    {{-- Flash Messages --}}
    @if (session('success'))
        <x-alert variant="success" title="Berhasil!" class="mb-4">
            {{ session('success') }}
        </x-alert>
    @endif

    @if (session('error'))
        <x-alert variant="danger" title="Gagal!" class="mb-4">
            {{ session('error') }}
        </x-alert>
    @endif

    {{-- Belum Ditempatkan Notice --}}
    @if(!$sudahDitempatkan)
        <div class="modern-card">
            <div class="text-center py-5">
                <div class="mb-3">
                    <i class="fas fa-house-circle-xmark" style="font-size: 3.5rem; color: var(--warning-color); opacity: 0.7;"></i>
                </div>
                <h5 class="fw-bold" style="color: var(--text-primary);">Fitur Keluhan Belum Tersedia</h5>
                <p class="text-muted mb-3" style="max-width: 480px; margin: 0 auto; line-height: 1.7;">
                    Anda belum ditempatkan di unit rumah manapun. Fitur keluhan hanya dapat diakses setelah pengajuan Anda disetujui dan Anda telah ditempatkan di sebuah unit.
                </p>
                <div class="d-inline-flex align-items-center gap-2 px-3 py-2 rounded-3"
                    style="background: rgba(212, 148, 58, 0.08); border: 1px solid rgba(212, 148, 58, 0.2);">
                    <i class="fas fa-info-circle" style="color: var(--warning-color);"></i>
                    <small class="text-muted">Silakan cek status pengajuan Anda di halaman <strong>Riwayat Pengajuan</strong>.</small>
                </div>
            </div>
        </div>
    @else

    {{-- Keluhan List --}}
    <div class="modern-card">
        @if ($keluhans->isEmpty())
            <x-empty-state
                icon="fas fa-comment-slash"
                title="Belum ada keluhan"
                message="Anda belum pernah mengirimkan keluhan. Klik tombol di atas untuk membuat keluhan baru." />
        @else
            <div class="d-flex flex-column gap-3">
                @foreach ($keluhans as $keluhan)
                    <div class="keluhan-card" style="
                        background: var(--bg-tertiary);
                        border: 1px solid var(--border-color);
                        border-radius: 14px;
                        padding: 1.25rem 1.5rem;
                        transition: box-shadow 0.2s;
                        border-left: 4px solid
                        @if ($keluhan->status === \App\Enums\StatusKeluhan::SELESAI) var(--success-color)
                        @elseif ($keluhan->status === \App\Enums\StatusKeluhan::DIPROSES) #3B96D8
                        @else var(--warning-color) @endif;
                    ">
                        <div class="d-flex justify-content-between align-items-start flex-wrap gap-2 mb-2">
                            <div>
                                <h6 class="fw-bold mb-0" style="color: var(--text-primary);">{{ $keluhan->judul }}</h6>
                                <small class="text-muted">
                                    <i class="fas fa-calendar-alt me-1"></i>
                                    {{ $keluhan->created_at->format('d M Y, H:i') }}
                                </small>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <x-badge :variant="$keluhan->status->getColor()" :icon="$keluhan->status->getIcon()">
                                    {{ $keluhan->status->getLabel() }}
                                </x-badge>
                                <button class="action-btn action-btn-view" wire:click="openDetailModal({{ $keluhan->id_keluhan }})" title="Lihat Detail">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>
                        <p class="mb-0 text-muted" style="font-size: 0.88rem; line-height: 1.6;">
                            {{ Str::limit($keluhan->isi, 140) }}
                        </p>

                        @if ($keluhan->balasan)
                            <div class="mt-3 p-3 rounded-3" style="background: rgba(91, 168, 124, 0.08); border: 1px solid rgba(91, 168, 124, 0.2);">
                                <div class="d-flex align-items-center gap-2 mb-1">
                                    <i class="fas fa-reply" style="color: var(--success-color);"></i>
                                    <span class="fw-semibold small" style="color: var(--success-color);">Balasan Admin</span>
                                    <span class="text-muted small">• {{ $keluhan->dibalas_pada?->format('d M Y') }}</span>
                                </div>
                                <p class="mb-0 small" style="color: var(--text-secondary);">{{ Str::limit($keluhan->balasan, 160) }}</p>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>

            @if ($keluhans->hasPages())
                <div class="d-flex justify-content-end mt-4">
                    {{ $keluhans->links() }}
                </div>
            @endif
        @endif
    </div>

    {{-- Buat Keluhan Modal --}}
    @if ($showFormModal)
        <div class="modal-backdrop-custom" wire:click.self="closeFormModal">
            <div class="modal-content-custom" wire:click.stop style="max-width: 560px;">
                <div class="modal-header-custom">
                    <h5 class="modal-title-custom">
                        <i class="fas fa-comment-alt me-2" style="color: var(--primary-color);"></i>
                        Buat Keluhan Baru
                    </h5>
                    <button type="button" class="modal-close-btn" wire:click="closeFormModal">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                <div class="mb-4 p-3 rounded-3" style="background: rgba(212, 148, 58, 0.08); border: 1px solid rgba(212, 148, 58, 0.25);">
                    <div class="d-flex gap-2 align-items-start">
                        <i class="fas fa-info-circle mt-1" style="color: var(--warning-color); flex-shrink: 0;"></i>
                        <p class="mb-0 small" style="color: var(--text-secondary);">
                            Gunakan form ini untuk menyampaikan keluhan atau permintaan perbaikan unit hunian (contoh: renovasi, kerusakan fasilitas, dll). Admin akan menindaklanjuti sesegera mungkin.
                        </p>
                    </div>
                </div>

                <form wire:submit="kirim">
                    <div class="mb-3">
                        <label class="form-label">Judul Keluhan <span class="text-danger">*</span></label>
                        <input type="text"
                            class="form-control @error('judul') is-invalid @enderror"
                            wire:model="judul"
                            placeholder="Contoh: Atap rumah bocor, Permohonan renovasi kamar mandi..."
                            maxlength="150">
                        @error('judul')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Isi Keluhan / Keterangan <span class="text-danger">*</span></label>
                        <textarea
                            class="form-control @error('isi') is-invalid @enderror"
                            wire:model="isi"
                            rows="5"
                            placeholder="Jelaskan keluhan Anda secara lengkap dan terperinci..."></textarea>
                        @error('isi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <x-button type="button" variant="outline" wire:click="closeFormModal">Batal</x-button>
                        <x-button type="submit" variant="primary" icon="fas fa-paper-plane" wire:loading.attr="disabled">
                            <span wire:loading.remove>Kirim Keluhan</span>
                            <span wire:loading><i class="fas fa-spinner fa-spin me-1"></i>Mengirim...</span>
                        </x-button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    {{-- Detail Keluhan Modal --}}
    @if ($showDetailModal && $viewingKeluhan)
        <div class="modal-backdrop-custom" wire:click.self="closeDetailModal">
            <div class="modal-content-custom" wire:click.stop style="max-width: 620px;">
                <div class="modal-header-custom">
                    <h5 class="modal-title-custom">
                        <i class="fas fa-comment-dots me-2" style="color: var(--primary-color);"></i>
                        Detail Keluhan
                    </h5>
                    <button type="button" class="modal-close-btn" wire:click="closeDetailModal">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                <div class="mb-3">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="fw-bold" style="color: var(--text-primary);">{{ $viewingKeluhan->judul }}</span>
                        <x-badge :variant="$viewingKeluhan->status->getColor()" :icon="$viewingKeluhan->status->getIcon()">
                            {{ $viewingKeluhan->status->getLabel() }}
                        </x-badge>
                    </div>
                    <small class="text-muted">
                        <i class="fas fa-calendar me-1"></i>
                        Dikirim pada: {{ $viewingKeluhan->created_at->format('d M Y, H:i') }} WIB
                    </small>
                </div>

                <div class="p-3 rounded-3 mb-4" style="background: var(--bg-tertiary); border: 1px solid var(--border-color);">
                    <p class="mb-0" style="color: var(--text-primary); line-height: 1.7; white-space: pre-line;">{{ $viewingKeluhan->isi }}</p>
                </div>

                @if ($viewingKeluhan->balasan)
                    <div class="p-3 rounded-3" style="background: rgba(91, 168, 124, 0.08); border: 1px solid rgba(91, 168, 124, 0.2);">
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <i class="fas fa-reply" style="color: var(--success-color);"></i>
                            <span class="fw-semibold" style="color: var(--success-color);">Balasan dari Admin</span>
                            <span class="text-muted small">• {{ $viewingKeluhan->dibalas_pada?->format('d M Y, H:i') }} WIB</span>
                        </div>
                        <p class="mb-0" style="color: var(--text-secondary); line-height: 1.7; white-space: pre-line;">{{ $viewingKeluhan->balasan }}</p>
                    </div>
                @else
                    <div class="text-center p-3 rounded-3" style="background: var(--bg-tertiary); border: 1px dashed var(--border-color);">
                        <i class="fas fa-hourglass-half text-muted mb-2" style="font-size: 1.5rem;"></i>
                        <p class="mb-0 text-muted small">Keluhan Anda sedang menunggu balasan dari admin.</p>
                    </div>
                @endif

                <div class="d-flex justify-content-end mt-4">
                    <x-button type="button" variant="outline" wire:click="closeDetailModal">Tutup</x-button>
                </div>
            </div>
        </div>
    @endif
    @endif
</div>
