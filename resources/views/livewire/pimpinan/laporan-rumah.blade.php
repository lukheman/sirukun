<div>
    <x-page-header title="Laporan Rumah Nelayan" subtitle="Laporan lengkap status unit rumah dan data penghuni">
        <x-slot:actions>
            <a href="{{ route('pimpinan.laporan.pdf', ['status' => $filterStatus]) }}" class="btn btn-primary d-flex align-items-center gap-2"
                style="border-radius: 10px; font-weight: 500; padding: 0.5rem 1.25rem;">
                <i class="fas fa-file-pdf"></i> Download PDF
            </a>
        </x-slot:actions>
    </x-page-header>

    {{-- Statistik Ringkasan --}}
    <div class="row g-3 mb-4 print-stats">
        <div class="col-sm-4">
            <x-stat-card label="Total Unit" :value="$totalUnit" icon="fas fa-home" color="primary" />
        </div>
        <div class="col-sm-4">
            <x-stat-card label="Unit Dihuni" :value="$unitDihuni" icon="fas fa-door-closed" color="success" />
        </div>
        <div class="col-sm-4">
            <x-stat-card label="Unit Tersedia" :value="$unitTersedia" icon="fas fa-door-open" color="warning" />
        </div>
    </div>

    {{-- Filter & Tabel --}}
    <div class="modern-card">
        {{-- Filter --}}
        <div class="d-flex justify-content-between align-items-center mb-4 no-print">
            <div class="d-flex align-items-center gap-2">
                <span class="text-muted fw-medium" style="font-size: 0.9rem;">Filter Status:</span>
                <select class="form-select form-select-sm" wire:model.live="filterStatus"
                    style="width: auto; min-width: 160px;">
                    <option value="">Semua Unit</option>
                    @foreach(App\Enums\StatusKetersediaan::cases() as $status)
                        <option value="{{ $status->value }}">{{ $status->getLabel() }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        {{-- Print Header (hanya muncul saat cetak) --}}
        <div class="print-header" style="display: none;">
            <h3 style="text-align: center; margin-bottom: 5px; font-weight: 700;">LAPORAN RUMAH NELAYAN</h3>
            <h5 style="text-align: center; margin-bottom: 5px; color: #666;">Sistem Informasi Rukun Warga & Perumahan
                (SIRUKUN)</h5>
            <p style="text-align: center; font-size: 0.85rem; color: #999; margin-bottom: 15px;">
                Dicetak pada: {{ now()->format('d F Y, H:i') }} WIB
                — Oleh: {{ $pimpinan->nama }}
            </p>
            <hr style="border-top: 2px solid #333; margin-bottom: 15px;">
        </div>

        {{-- Tabel Laporan --}}
        <div class="table-responsive">
            <table class="table table-modern align-middle mb-0" id="tabel-laporan">
                <thead>
                    <tr>
                        <th width="5%">No.</th>
                        <th width="12%">Blok</th>
                        <th width="10%">Nomor</th>
                        <th width="13%">Status</th>
                        <th>Nama Penghuni</th>
                        <th width="15%">NIK</th>
                        <th width="13%">Tgl. Masuk</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($units as $index => $unit)
                        @php
                            $penghuni = $unit->penempatan?->pengajuan?->warga;
                            $tanggalMasuk = $unit->penempatan?->tanggal_masuk;
                        @endphp
                        <tr>
                            <td class="text-muted">{{ $units->firstItem() + $index }}</td>
                            <td>
                                <span class="fw-semibold" style="color: var(--text-primary);">{{ $unit->blok }}</span>
                            </td>
                            <td>
                                <span class="fw-semibold" style="color: var(--text-primary);">{{ $unit->nomor }}</span>
                            </td>
                            <td>
                                <x-badge variant="{{ $unit->status_ketersediaan->getColor() }}"
                                    icon="{{ $unit->status_ketersediaan->getIcon() }}">
                                    {{ $unit->status_ketersediaan->getLabel() }}
                                </x-badge>
                            </td>
                            <td>
                                @if($penghuni)
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="user-avatar" style="width: 32px; height: 32px; font-size: 0.75rem;">
                                            {{ substr($penghuni->nama, 0, 1) }}
                                        </div>
                                        <span class="fw-medium">{{ $penghuni->nama }}</span>
                                    </div>
                                @else
                                    <span class="text-muted fst-italic">— Kosong —</span>
                                @endif
                            </td>
                            <td>
                                @if($penghuni)
                                    <span class="text-muted" style="font-size: 0.85rem;">{{ $penghuni->nik }}</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                @if($tanggalMasuk)
                                    <span style="font-size: 0.85rem;">{{ $tanggalMasuk->format('d M Y') }}</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <i class="fas fa-home mb-3" style="font-size: 3rem; color: var(--border-color);"></i>
                                <h5 class="text-muted">Belum ada data unit rumah</h5>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($units->hasPages())
            <div class="mt-4 border-top pt-4 no-print">
                {{ $units->links() }}
            </div>
        @endif
    </div>

    {{-- Print Styles --}}
    <style>
        @media print {

            /* Hide non-print elements */
            .sidebar,
            .topbar,
            .no-print,
            .page-header .btn,
            nav[aria-label="pagination"],
            .pagination {
                display: none !important;
            }

            .main-content {
                margin-left: 0 !important;
                padding: 0 !important;
            }

            .print-header {
                display: block !important;
            }

            .modern-card {
                box-shadow: none !important;
                border: none !important;
                padding: 0 !important;
            }

            .table-modern th {
                background: #f0f0f0 !important;
                color: #333 !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            .table-modern td,
            .table-modern th {
                border: 1px solid #ddd !important;
                padding: 8px !important;
                font-size: 0.8rem !important;
            }

            .user-avatar {
                display: none !important;
            }

            .badge {
                border: 1px solid #999 !important;
                color: #333 !important;
                background: transparent !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            body {
                font-size: 12px !important;
            }

            @page {
                size: landscape;
                margin: 1cm;
            }
        }
    </style>
</div>