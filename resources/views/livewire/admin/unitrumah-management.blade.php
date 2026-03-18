<div class="fade-in">

    {{-- Page Header --}}
    <x-page-header title="Data Unit Rumah" subtitle="Kelola blok, nomor, dan ketersediaan unit rumah di perumahan.">
        <x-slot:actions>
            <x-button variant="primary" icon="fas fa-plus" wire:click="openCreateModal">
                Tambah Unit Rumah
            </x-button>
        </x-slot:actions>
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
            <div class="search-wrapper" style="width: 300px;">
                <input type="text" class="form-control" placeholder="Cari Blok atau Nomor..." wire:model.live="search">
            </div>

        </div>

        <div class="table-responsive">
            <table class="table table-modern">
                <thead>
                    <tr>
                        <th style="width: 25%">Blok Unit</th>
                        <th style="width: 25%">Nomor Rumah</th>
                        <th style="width: 30%">Status Ketersediaan</th>
                        <th style="width: 20%" class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($units as $unit)
                        <tr>
                            <td>
                                <div class="fw-semibold text-dark-heading">Blok {{ $unit->blok }}</div>
                            </td>
                            <td>
                                <div class="text-dark-secondary">No. {{ $unit->nomor }}</div>
                            </td>
                            <td>
                                @if($unit->status_ketersediaan === 'Tersedia')
                                    <span class="badge badge-modern bg-success text-white"><i class="fas fa-check-circle"></i>
                                        Tersedia</span>
                                @elseif($unit->status_ketersediaan === 'Terisi')
                                    <span class="badge badge-modern bg-primary text-white"><i class="fas fa-home"></i>
                                        Terisi</span>
                                @else
                                    <span class="badge badge-modern bg-warning text-dark"><i class="fas fa-tools"></i>
                                        Renovasi</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <div class="d-flex gap-1 justify-content-end">

                                    <x-action-btn-edit wire:click="openEditModal({{ $unit->id_unit }})" />

                                    <x-action-btn-delete wire:click="confirmDelete({{ $unit->id_unit }})" />
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-4">
                                <div class="text-muted">
                                    <i class="fas fa-home mb-2" style="font-size: 2rem;"></i>
                                    <p class="mb-0">Tidak ada data unit rumah ditemukan</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($units->hasPages())
            <div class="d-flex justify-content-end mt-4">
                {{ $units->links() }}
            </div>
        @endif
    </div>

    {{-- Create/Edit Modal --}}
    @if ($showModal)
        <div class="modal-backdrop-custom" wire:click.self="closeModal">
            <div class="modal-content-custom" wire:click.stop style="max-width: 500px;">
                <div class="modal-header-custom">
                    <h5 class="modal-title-custom">
                        {{ $editingUnitId ? 'Edit Unit Rumah' : 'Tambah Unit Rumah' }}
                    </h5>
                    <button type="button" class="modal-close-btn" wire:click="closeModal">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                <form wire:submit="save">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Blok <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('blok') is-invalid @enderror" wire:model="blok"
                                placeholder="Contoh: A, B, C1" style="text-transform: uppercase">
                            @error('blok') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nomor <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nomor') is-invalid @enderror" wire:model="nomor"
                                placeholder="Contoh: 01, 12A">
                            @error('nomor') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Status Ketersediaan <span class="text-danger">*</span></label>
                        <select class="form-select form-control @error('status_ketersediaan') is-invalid @enderror"
                            wire:model="status_ketersediaan">
                            <option value="Tersedia">Tersedia</option>
                            <option value="Terisi">Terisi</option>
                            <option value="Renovasi">Renovasi</option>
                        </select>
                        @error('status_ketersediaan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <x-button type="button" variant="outline" wire:click="closeModal">Batal</x-button>
                        <x-button type="submit" variant="primary">
                            {{ $editingUnitId ? 'Simpan Perubahan' : 'Tambah Data' }}
                        </x-button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    {{-- Delete Modal --}}
    <x-confirm-modal :show="$showDeleteModal" title="Konfirmasi Hapus"
        message="Apakah Anda yakin ingin menghapus data unit rumah ini? Jika unit ini telah memiliki riwayat penempatan, sistem mungkin akan menolak penghapusan."
        on-confirm="deleteUnit" on-cancel="cancelDelete" variant="danger" icon="fas fa-exclamation-triangle">
        <x-slot:confirmButton>
            <i class="fas fa-trash-alt me-2"></i>Hapus Unit
        </x-slot:confirmButton>
    </x-confirm-modal>
</div>
