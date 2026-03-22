<div>
    {{-- Page Header --}}
    <x-page-header title="Data Penempatan" subtitle="Kelola riwayat penempatan dan hunian unit rumah oleh warga.">

        {{--
        <x-slot:actions>
            <x-button variant="primary" icon="fas fa-plus" wire:click="openCreateModal">
                Tambah Pengguna
            </x-button>
        </x-slot:actions>

        --}}

    </x-page-header>

    {{-- Flash Messages --}}
    @if (session('success'))
        <x-alert variant="success" title="Success!" class="mb-4">
            {{ session('success') }}
        </x-alert>
    @endif

    @if (session('error'))
        <x-alert variant="danger" title="Error!" class="mb-4">
            {{ session('error') }}
        </x-alert>
    @endif

    <div class="modern-card">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="search-wrapper">
                <input type="text" class="form-control" placeholder="Cari Nama Warga atau Unit..."
                    wire:model.live="search">
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-modern">
                <thead>
                    <tr>
                        <th style="width: 30%">Warga Penghuni</th>
                        <th style="width: 25%">Unit Rumah</th>
                        <th style="width: 25%">Tanggal Masuk</th>
                        <th style="width: 20%" class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($penempatans as $penempatan)
                        <tr>
                            <td>
                                <div>
                                    <div class="fw-semibold text-dark-heading">{{ $penempatan->pengajuan->warga->nama }}
                                    </div>
                                    <small class="text-muted">NIK: {{ $penempatan->pengajuan->warga->nik }}</small>
                                </div>
                            </td>
                            <td>
                                <div>
                                    <div class="fw-semibold text-dark-secondary">Blok {{ $penempatan->unitRumah->blok }}
                                    </div>
                                    <small class="text-muted">No. {{ $penempatan->unitRumah->nomor }}</small>
                                </div>
                            </td>
                            <td>
                                <div class="text-dark-secondary">
                                    <i class="fas fa-calendar-alt text-muted me-2"></i>
                                    {{ \Carbon\Carbon::parse($penempatan->tanggal_masuk)->format('d M Y') }}
                                </div>
                            </td>
                            <td class="text-end">
                                <div class="d-flex gap-1 justify-content-end">
                                    <x-action-btn-edit wire:click="openEditModal({{ $penempatan->id_penempatan }})" />

                                    <x-action-btn-delete wire:click="confirmDelete({{ $penempatan->id_penempatan }})" />
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-4">
                                <div class="text-muted">
                                    <i class="fas fa-key mb-2" style="font-size: 2rem;"></i>
                                    <p class="mb-0">Tidak ada data penempatan ditemukan</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($penempatans->hasPages())
            <div class="d-flex justify-content-end mt-4">
                {{ $penempatans->links() }}
            </div>
        @endif
    </div>

    {{-- Create/Edit Modal --}}
    @if ($showModal)
        <div class="modal-backdrop-custom" wire:click.self="closeModal">
            <div class="modal-content-custom" wire:click.stop style="max-width: 600px;">
                <div class="modal-header-custom">
                    <h5 class="modal-title-custom">
                        {{ $editingPenempatanId ? 'Edit Data Penempatan' : 'Tambah Penempatan Baru' }}
                    </h5>
                    <button type="button" class="modal-close-btn" wire:click="closeModal">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                <form wire:submit="save">
                    <div class="mb-3">
                        <label class="form-label">Pilih Pengajuan (Disetujui) <span class="text-danger">*</span></label>
                        <select class="form-select form-control @error('id_pengajuan') is-invalid @enderror"
                            wire:model="id_pengajuan" {{ $editingPenempatanId ? 'disabled' : '' }}>
                            <option value="">Pilih Data Pengajuan...</option>
                            @foreach($pengajuans as $pengajuan)
                                <option value="{{ $pengajuan->id_pengajuan }}">
                                    {{ $pengajuan->warga->nama }} - Tgl: {{ $pengajuan->created_at->format('d/m/Y') }}
                                </option>
                            @endforeach
                        </select>
                        @error('id_pengajuan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label class="form-label">Pilih Unit Rumah <span class="text-danger">*</span></label>
                            <select class="form-select form-control @error('id_unit') is-invalid @enderror"
                                wire:model="id_unit">
                                <option value="">Pilih Unit...</option>
                                @foreach($unitRumahs as $unit)
                                    <option value="{{ $unit->id_unit }}">
                                        Blok {{ $unit->blok }} - No. {{ $unit->nomor }}
                                        ({{ $unit->status_ketersediaan->getLabel() }})
                                    </option>
                                @endforeach
                            </select>
                            @error('id_unit') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6 mb-4">
                            <label class="form-label">Tanggal Masuk <span class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('tanggal_masuk') is-invalid @enderror"
                                wire:model="tanggal_masuk">
                            @error('tanggal_masuk') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <x-button type="button" variant="outline" wire:click="closeModal">Batal</x-button>
                        <x-button type="submit" variant="primary">
                            {{ $editingPenempatanId ? 'Simpan Perubahan' : 'Simpan Penempatan' }}
                        </x-button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    {{-- Delete Modal --}}
    <x-confirm-modal :show="$showDeleteModal" title="Konfirmasi Hapus"
        message="Apakah Anda yakin ingin menghapus data penempatan ini? Tindakan ini tidak akan menghapus data warga atau unit rumah terkait, hanya riwayat penghuniannya saja."
        on-confirm="deletePenempatan" on-cancel="cancelDelete" variant="danger" icon="fas fa-exclamation-triangle">
        <x-slot:confirmButton>
            <i class="fas fa-trash-alt me-2"></i>Hapus Penempatan
        </x-slot:confirmButton>
    </x-confirm-modal>
</div>