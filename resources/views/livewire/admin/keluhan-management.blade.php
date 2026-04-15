<div>
    {{-- Page Header --}}
    <x-page-header title="Manajemen Keluhan" subtitle="Tinjau dan balas keluhan yang dikirim oleh warga.">
    </x-page-header>

    {{-- Flash Messages --}}
    @if (session('success'))
        <x-alert variant="success" title="Berhasil!" class="mb-4">{{ session('success') }}</x-alert>
    @endif

    {{-- Stats Row --}}
    <div class="row g-3 mb-4">
        <div class="col-6 col-lg-3">
            <x-stat-card icon="fas fa-comments" label="Total Keluhan" value="{{ $stats['total'] }}" variant="primary" />
        </div>
        <div class="col-6 col-lg-3">
            <x-stat-card icon="fas fa-clock" label="Menunggu" value="{{ $stats['menunggu'] }}" variant="warning" />
        </div>
        <div class="col-6 col-lg-3">
            <x-stat-card icon="fas fa-spinner" label="Diproses" value="{{ $stats['diproses'] }}" variant="info" />
        </div>
        <div class="col-6 col-lg-3">
            <x-stat-card icon="fas fa-check-circle" label="Selesai" value="{{ $stats['selesai'] }}" variant="success" />
        </div>
    </div>

    {{-- Filter & Search --}}
    <div class="modern-card">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
            <div class="search-wrapper">
                <input type="text" class="form-control" placeholder="Cari judul / nama warga..."
                    wire:model.live="search" style="min-width: 280px;">
            </div>
            <div>
                <select class="form-select form-control" wire:model.live="filterStatus" style="min-width: 180px;">
                    <option value="">Semua Status</option>
                    @foreach (\App\Enums\StatusKeluhan::cases() as $s)
                        <option value="{{ $s->value }}">{{ $s->getLabel() }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-modern">
                <thead>
                    <tr>
                        <th style="width: 5%">No.</th>
                        <th style="width:30%">Warga Pengirim</th>
                        <th style="width:30%">Keluhan</th>
                        <th style="width:15%">Status</th>
                        <th style="width:20%" class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($query as $index => $keluhan)
                        <tr>
                            <td class="text-muted text-center">{{ $query->firstItem() + $index }}</td>
                            <td>
                                <div class="fw-semibold" style="color: var(--text-primary);">{{ $keluhan->warga->nama }}</div>
                                <small class="text-muted">NIK: {{ $keluhan->warga->nik }}</small>
                            </td>
                            <td>
                                <div class="fw-medium" style="color: var(--text-primary);">{{ Str::limit($keluhan->judul, 50) }}</div>
                                <small class="text-muted">{{ $keluhan->created_at->format('d M Y') }}</small>
                            </td>
                            <td>
                                <x-badge :variant="$keluhan->status->getColor()" :icon="$keluhan->status->getIcon()">
                                    {{ $keluhan->status->getLabel() }}
                                </x-badge>
                            </td>
                            <td class="text-end">
                                <div class="d-flex gap-1 justify-content-end flex-wrap">
                                    {{-- Tandai Diproses --}}
                                    @if ($keluhan->status === \App\Enums\StatusKeluhan::MENUNGGU)
                                        <button class="action-btn"
                                            wire:click="updateStatus({{ $keluhan->id_keluhan }}, 'Diproses')"
                                            title="Tandai Diproses"
                                            style="background: rgba(59, 150, 216, 0.1); color: #3B96D8;">
                                            <i class="fas fa-spinner"></i>
                                            Proses
                                        </button>
                                    @endif

                                    {{-- Balas / Detail --}}
                                    <button class="action-btn action-btn-edit"
                                        wire:click="openDetail({{ $keluhan->id_keluhan }})"
                                        title="{{ $keluhan->balasan ? 'Lihat / Edit Balasan' : 'Balas Keluhan' }}">
                                        <i class="fas fa-reply"></i>

                                        Balas
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4">
                                <div class="text-muted">
                                    <i class="fas fa-comment-slash mb-2" style="font-size: 2rem;"></i>
                                    <p class="mb-0">Tidak ada keluhan ditemukan.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($query->hasPages())
            <div class="d-flex justify-content-end mt-4">
                {{ $query->links() }}
            </div>
        @endif
    </div>

    {{-- Detail & Balas Modal --}}
    @if ($showDetailModal && $selectedKeluhan)
        <div class="modal-backdrop-custom" wire:click.self="closeDetail">
            <div class="modal-content-custom" wire:click.stop style="max-width: 660px;">
                <div class="modal-header-custom">
                    <h5 class="modal-title-custom">
                        <i class="fas fa-comment-dots me-2" style="color: var(--primary-color);"></i>
                        Detail &amp; Balas Keluhan
                    </h5>
                    <button type="button" class="modal-close-btn" wire:click="closeDetail">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                {{-- Info pengirim --}}
                <div class="p-3 rounded-3 mb-4"
                    style="background: var(--bg-tertiary); border: 1px solid var(--border-color);">
                    <div class="d-flex align-items-center gap-3">
                        <div class="user-avatar">{{ $selectedKeluhan->warga->initials() }}</div>
                        <div>
                            <div class="fw-bold" style="color: var(--text-primary);">{{ $selectedKeluhan->warga->nama }}</div>
                            <small class="text-muted">NIK: {{ $selectedKeluhan->warga->nik }} &bull;
                                {{ $selectedKeluhan->created_at->format('d M Y, H:i') }} WIB</small>
                        </div>
                        <div class="ms-auto">
                            <x-badge :variant="$selectedKeluhan->status->getColor()" :icon="$selectedKeluhan->status->getIcon()">
                                {{ $selectedKeluhan->status->getLabel() }}
                            </x-badge>
                        </div>
                    </div>
                </div>

                {{-- Judul + Isi keluhan --}}
                <h6 class="fw-bold mb-2" style="color: var(--text-primary);">{{ $selectedKeluhan->judul }}</h6>
                <div class="p-3 rounded-3 mb-4"
                    style="background: rgba(199, 91, 63, 0.04); border: 1px solid rgba(199, 91, 63, 0.15);">
                    <p class="mb-0" style="color: var(--text-secondary); line-height: 1.7; white-space: pre-line;">{{ $selectedKeluhan->isi }}</p>
                </div>

                {{-- Form Balasan --}}
                <form wire:submit="simpanBalasan">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            <i class="fas fa-reply me-1" style="color: var(--primary-color);"></i>
                            Balasan Admin <span class="text-danger">*</span>
                        </label>
                        <textarea
                            class="form-control @error('balasan') is-invalid @enderror"
                            wire:model="balasan"
                            rows="5"
                            placeholder="Tulis balasan untuk warga di sini..."></textarea>
                        @error('balasan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Menyimpan balasan akan otomatis mengubah status keluhan menjadi <strong>Selesai</strong>.</small>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <x-button type="button" variant="outline" wire:click="closeDetail">Batal</x-button>
                        <x-button type="submit" variant="primary" icon="fas fa-paper-plane"
                            wire:loading.attr="disabled">
                            <span wire:loading.remove>Kirim Balasan</span>
                            <span wire:loading><i class="fas fa-spinner fa-spin me-1"></i>Menyimpan...</span>
                        </x-button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
