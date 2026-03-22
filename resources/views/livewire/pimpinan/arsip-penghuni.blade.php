<div>
    <x-page-header title="Arsip Riwayat Penghuni" subtitle="Riwayat lengkap penghuni setiap unit rumah nelayan">
    </x-page-header>

    <div class="modern-card mb-4">
        {{-- Pilih Unit --}}
        <div class="d-flex align-items-center gap-3 flex-wrap">
            <div class="d-flex align-items-center gap-2">
                <i class="fas fa-home" style="color: var(--primary-color); font-size: 1.1rem;"></i>
                <label class="fw-semibold mb-0" style="color: var(--text-primary);">Pilih Unit Rumah:</label>
            </div>
            <select class="form-select" wire:model.live="selectedUnitId" style="width: auto; min-width: 250px;">
                <option value="">-- Pilih Unit --</option>
                @foreach($units as $unit)
                    <option value="{{ $unit->id_unit }}">
                        Blok {{ $unit->blok }} - No. {{ $unit->nomor }} ({{ $unit->status_ketersediaan->getLabel() }})
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    @if($selectedUnit)
        {{-- Info Unit --}}
        <div class="modern-card mb-4">
            <div class="d-flex align-items-center gap-3 mb-3">
                <div class="icon-wrap"
                    style="width: 50px; height: 50px; border-radius: 14px; background: rgba(199, 91, 63, 0.1); color: var(--primary-color); display: flex; align-items: center; justify-content: center; font-size: 1.3rem;">
                    <i class="fas fa-home"></i>
                </div>
                <div>
                    <h5 class="mb-0" style="color: var(--text-primary); font-weight: 600;">
                        Blok {{ $selectedUnit->blok }} - No. {{ $selectedUnit->nomor }}
                    </h5>
                    <small class="text-muted">
                        Status saat ini:
                        <span class="text-{{ $selectedUnit->status_ketersediaan->getColor() }} fw-semibold">
                            {{ $selectedUnit->status_ketersediaan->getLabel() }}
                        </span>
                        &middot; Total riwayat penghuni: <strong>{{ $riwayat->count() }}</strong>
                    </small>
                </div>
            </div>
        </div>

        {{-- Tabel Riwayat --}}
        <div class="modern-card">
            <h6 class="mb-3 text-muted fw-bold text-uppercase" style="font-size: 0.8rem; letter-spacing: 1px;">
                <i class="fas fa-history me-2"></i>Riwayat Penghuni
            </h6>

            @if($riwayat->count() > 0)
                <div class="table-responsive">
                    <table class="table table-modern align-middle mb-0">
                        <thead>
                            <tr>
                                <th width="5%">No.</th>
                                <th>Nama Penghuni</th>
                                <th width="15%">NIK</th>
                                <th width="12%">Tgl. Masuk</th>
                                <th width="12%">Tgl. Keluar</th>
                                <th width="12%">Status</th>
                                <th width="10%">Foto KTP</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($riwayat as $index => $item)
                                @php
                                    $warga = $item->pengajuan?->warga;
                                    $masihTinggal = is_null($item->tanggal_keluar);
                                @endphp
                                <tr>
                                    <td class="text-muted">{{ $index + 1 }}</td>
                                    <td>
                                        @if($warga)
                                            <div class="d-flex align-items-center gap-2">
                                                <div class="user-avatar" style="width: 34px; height: 34px; font-size: 0.75rem;">
                                                    {{ substr($warga->nama, 0, 1) }}
                                                </div>
                                                <div>
                                                    <span class="fw-semibold"
                                                        style="color: var(--text-primary);">{{ $warga->nama }}</span>
                                                    <br><small class="text-muted">{{ $warga->telepon ?? '-' }}</small>
                                                </div>
                                            </div>
                                        @else
                                            <span class="text-muted fst-italic">Data tidak tersedia</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span style="font-size: 0.85rem;">{{ $warga?->nik ?? '-' }}</span>
                                    </td>
                                    <td>
                                        <span style="font-size: 0.85rem;">{{ $item->tanggal_masuk->format('d M Y') }}</span>
                                    </td>
                                    <td>
                                        @if($item->tanggal_keluar)
                                            <span style="font-size: 0.85rem;">{{ $item->tanggal_keluar->format('d M Y') }}</span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($masihTinggal)
                                            <x-badge variant="success" icon="fas fa-check-circle">Aktif</x-badge>
                                        @else
                                            <x-badge variant="secondary" icon="fas fa-sign-out-alt">Keluar</x-badge>
                                        @endif
                                    </td>
                                    <td>
                                        @if($warga?->foto_ktp)
                                            <button class="btn btn-sm btn-outline-primary d-flex align-items-center gap-1"
                                                wire:click="viewKtp('{{ $warga->foto_ktp }}', '{{ $warga->nama }}')"
                                                style="border-radius: 8px; font-size: 0.8rem;">
                                                <i class="fas fa-image"></i> Lihat
                                            </button>
                                        @else
                                            <span class="text-muted" style="font-size: 0.8rem;">Tidak ada</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-inbox mb-3" style="font-size: 3rem; color: var(--border-color);"></i>
                    <h5 class="text-muted">Belum ada riwayat penghuni</h5>
                    <p class="text-muted small">Unit ini belum pernah ditempati oleh siapapun.</p>
                </div>
            @endif
        </div>
    @else
        {{-- Empty State --}}
        <div class="modern-card text-center py-5">
            <i class="fas fa-search mb-3" style="font-size: 3rem; color: var(--border-color);"></i>
            <h5 class="text-muted">Pilih Unit Rumah</h5>
            <p class="text-muted small">Pilih unit rumah dari dropdown di atas untuk melihat riwayat penghuni.</p>
        </div>
    @endif

    {{-- Modal Foto KTP --}}
    @if($showKtpModal)
        <div class="modal-backdrop-custom" wire:click.self="closeKtpModal">
            <div class="modal-content-custom" wire:click.stop style="max-width: 600px;">
                <div class="modal-header-custom">
                    <h5 class="modal-title-custom">
                        <i class="fas fa-id-card me-2"></i>Foto KTP — {{ $ktpNama }}
                    </h5>
                    <button type="button" class="modal-close-btn" wire:click="closeKtpModal">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="text-center p-3">
                    <img src="{{ $ktpImageUrl }}" alt="Foto KTP {{ $ktpNama }}"
                        style="max-width: 100%; border-radius: 12px; border: 1px solid var(--border-color);">
                </div>
            </div>
        </div>
    @endif
</div>