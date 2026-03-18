<div>

    {{-- Page Header --}}
    <x-page-header title="Data Warga" subtitle="Kelola informasi warga, NIK, dan akun sistem.">
        <x-slot:actions>
            <x-button variant="primary" icon="fas fa-plus" wire:click="openCreateModal">
                Tambah Warga
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
                <input type="text" class="form-control" placeholder="Cari NIK, NKK, atau Nama..."
                    wire:model.live="search">
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-modern">
                <thead>
                    <tr>
                        <th>NIK</th>
                        <th>Nama Warga</th>
                        <th>Kontak</th>
                        <th>Agama</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($wargas as $warga)
                        <tr>
                            <td>
                                <div class="fw-semibold text-dark-secondary">{{ $warga->nik }}</div>
                            </td>
                            <td>
                                <div class="fw-semibold text-dark-secondary">{{ $warga->nama }}</div>
                            </td>
                            <td>
                                <div class="fw-semibold text-dark-secondary">{{ $warga->telepon }}</div>
                            </td>
                            <td>
                                <div class="fw-semibold text-dark-secondary">{{ $warga->agama }}</div>
                            </td>
                            <td class="text-end">
                                <div class="d-flex gap-1 justify-content-end">
                                    <x-action-btn-edit wire:click="openEditModal({{ $warga->id_warga }})" />

                                    <x-action-btn-delete wire:click="confirmDelete({{ $warga->id_warga }})" />
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4">
                                <div class="text-muted">
                                    <i class="fas fa-users mb-2" style="font-size: 2rem;"></i>
                                    <p class="mb-0">Tidak ada data warga ditemukan</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($wargas->hasPages())
            <div class="d-flex justify-content-end mt-4">
                {{ $wargas->links() }}
            </div>
        @endif
    </div>

    {{-- Create/Edit Modal --}}
    @if ($showModal)
        <div class="modal-backdrop-custom" wire:click.self="closeModal">
            <div class="modal-content-custom" wire:click.stop style="max-width: 700px;">
                <div class="modal-header-custom">
                    <h5 class="modal-title-custom">
                        {{ $editingWargaId ? 'Edit Data Warga' : 'Tambah Warga Baru' }}
                    </h5>
                    <button type="button" class="modal-close-btn" wire:click="closeModal">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                <form wire:submit="save">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">NIK <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nik') is-invalid @enderror" wire:model="nik"
                                placeholder="16 Digit NIK">
                            @error('nik') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">NKK <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nkk') is-invalid @enderror" wire:model="nkk"
                                placeholder="16 Digit NKK">
                            @error('nkk') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('nama') is-invalid @enderror" wire:model="nama"
                            placeholder="Nama sesuai KTP">
                        @error('nama') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tempat Lahir <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('tempat_lahir') is-invalid @enderror"
                                wire:model="tempat_lahir" placeholder="Kota Kelahiran">
                            @error('tempat_lahir') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tanggal Lahir <span class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('tanggal_lahir') is-invalid @enderror"
                                wire:model="tanggal_lahir">
                            @error('tanggal_lahir') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nomor Telepon <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('telepon') is-invalid @enderror"
                                wire:model="telepon" placeholder="Nomor HP/WA Aktif">
                            @error('telepon') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Agama <span class="text-danger">*</span></label>
                            <select class="form-control @error('agama') is-invalid @enderror" wire:model="agama">
                                <option value="">Pilih Agama</option>
                                <option value="Islam">Islam</option>
                                <option value="Kristen">Kristen</option>
                                <option value="Katolik">Katolik</option>
                                <option value="Hindu">Hindu</option>
                                <option value="Buddha">Buddha</option>
                                <option value="Konghucu">Konghucu</option>
                            </select>
                            @error('agama') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Alamat Lengkap <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('alamat') is-invalid @enderror" wire:model="alamat" rows="2"
                            placeholder="Alamat Domisili"></textarea>
                        @error('alamat') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Password Akses Sistem
                            @if(!$editingWargaId) <span class="text-danger">*</span> @else <small
                            class="text-muted">(Kosongkan jika tidak ingin mengubah)</small> @endif
                        </label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                            wire:model="password" placeholder="Minimal 6 karakter">
                        @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <x-button type="button" variant="outline" wire:click="closeModal">Batal</x-button>
                        <x-button type="submit" variant="primary">
                            {{ $editingWargaId ? 'Simpan Perubahan' : 'Tambah Warga' }}
                        </x-button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    {{-- Delete Modal --}}
    <x-confirm-modal :show="$showDeleteModal" title="Konfirmasi Hapus"
        message="Apakah Anda yakin ingin menghapus data warga ini? Semua data pengajuan dan penempatan yang terhubung juga akan terhapus secara permanen."
        on-confirm="deleteWarga" on-cancel="cancelDelete" variant="danger" icon="fas fa-exclamation-triangle">
        <x-slot:confirmButton>
            <i class="fas fa-trash-alt me-2"></i>Hapus Warga
        </x-slot:confirmButton>
    </x-confirm-modal>
</div>
