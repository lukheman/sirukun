<div>
    <x-page-header title="Laporan Keluhan Warga" subtitle="Rekap data keluhan warga untuk keperluan pelaporan.">
        <x-slot:actions>
            <x-button variant="primary" icon="fas fa-file-pdf" href="{{ $pdfRoute }}">
                Download PDF
            </x-button>
        </x-slot:actions>
    </x-page-header>

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

        {{-- Data Table --}}
        <div class="table-responsive">
            <table class="table table-modern">
                <thead>
                    <tr>
                        <th style="width:5%">No</th>
                        <th style="width:18%">Warga</th>
                        <th style="width:18%">Judul Keluhan</th>
                        <th style="width:22%">Isi Keluhan</th>
                        <th style="width:10%">Status</th>
                        <th style="width:17%">Balasan</th>
                        <th style="width:10%">Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($keluhans as $index => $keluhan)
                        <tr>
                            <td class="text-muted">{{ $keluhans->firstItem() + $index }}</td>
                            <td>
                                <div class="fw-semibold" style="color: var(--text-primary);">{{ $keluhan->warga->nama }}</div>
                                <small class="text-muted">NIK: {{ $keluhan->warga->nik }}</small>
                            </td>
                            <td>
                                <div class="fw-medium" style="color: var(--text-primary);">{{ Str::limit($keluhan->judul, 40) }}</div>
                            </td>
                            <td>
                                <span class="text-muted" style="font-size: 0.85rem;">{{ Str::limit($keluhan->isi, 60) }}</span>
                            </td>
                            <td>
                                <x-badge :variant="$keluhan->status->getColor()" :icon="$keluhan->status->getIcon()">
                                    {{ $keluhan->status->getLabel() }}
                                </x-badge>
                            </td>
                            <td>
                                @if($keluhan->balasan)
                                    <div class="p-2 rounded" style="background: rgba(91, 168, 124, 0.06); border: 1px solid rgba(91, 168, 124, 0.15); font-size: 0.8rem;">
                                        <small class="text-muted">{{ Str::limit($keluhan->balasan, 50) }}</small>
                                        @if($keluhan->dibalas_pada)
                                            <br><small class="text-muted fst-italic">{{ $keluhan->dibalas_pada->format('d/m/Y') }}</small>
                                        @endif
                                    </div>
                                @else
                                    <span class="text-muted fst-italic">—</span>
                                @endif
                            </td>
                            <td>
                                <div style="font-size: 0.85rem;">{{ $keluhan->created_at->format('d M Y') }}</div>
                                <small class="text-muted">{{ $keluhan->created_at->format('H:i') }}</small>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4">
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

        @if ($keluhans->hasPages())
            <div class="d-flex justify-content-end mt-4">
                {{ $keluhans->links() }}
            </div>
        @endif
    </div>
</div>
