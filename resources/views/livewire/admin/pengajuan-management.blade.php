<div>

    {{-- Page Header --}}
    <x-page-header title="Data Pengajuan" subtitle="Kelola informasi pengajuan sewa/hunian unit rumah dari warga.">

        {{--
        <x-slot:actions>
            <x-button variant="primary" icon="fas fa-plus" wire:click="openCreateModal">
                Tambah Pengajuan
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
                <input type="text" class="form-control" placeholder="Cari Nama/NIK Warga..." wire:model.live="search">
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-modern">
                <thead>
                    <tr>
                        <th style="width: 30%">Nama Warga (Pemohon)</th>
                        <th style="width: 25%">Tanggal Pengajuan</th>
                        <th style="width: 15%">Status</th>
                        <th style="width: 20%" class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pengajuans as $pengajuan)
                        <tr>
                            <td>
                                <div>
                                    <div class="fw-semibold text-dark-heading">{{ $pengajuan->warga->nama }}</div>
                                    <small class="text-muted">NIK: {{ $pengajuan->warga->nik }}</small>
                                    @if($pengajuan->jenis_pengajuan === App\Enums\JenisPengajuan::KELUAR)
                                        <div class="mt-1"><x-badge :variant="$pengajuan->jenis_pengajuan->getColor()"
                                                :icon="$pengajuan->jenis_pengajuan->getIcon()">{{ $pengajuan->jenis_pengajuan->getLabel() }}</x-badge>
                                        </div>
                                    @else
                                        <div class="mt-1"><x-badge :variant="$pengajuan->jenis_pengajuan->getColor()"
                                                :icon="$pengajuan->jenis_pengajuan->getIcon()">{{ $pengajuan->jenis_pengajuan->getLabel() }}</x-badge>
                                        </div>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <div class="text-dark-secondary">{{ $pengajuan->created_at->format('d M Y') }}</div>
                                <small class="text-muted">{{ $pengajuan->created_at->format('H:i') }} WIB</small>
                            </td>
                            <td>
                                <span
                                    class="badge badge-modern bg-{{ $pengajuan->status_pengajuan->getColor() }} {{ $pengajuan->status_pengajuan === App\Enums\StatusPengajuan::MENUNGGU ? 'text-dark' : 'text-white' }}"><i
                                        class="{{ $pengajuan->status_pengajuan->getIcon() }}"></i>
                                    {{ $pengajuan->status_pengajuan->getLabel() }}</span>
                            </td>
                            <td class="text-end">
                                <div class="d-flex gap-1 justify-content-end">
                                    @if($pengajuan->status_pengajuan === App\Enums\StatusPengajuan::MENUNGGU)
                                        @if($pengajuan->jenis_pengajuan === App\Enums\JenisPengajuan::MASUK && !$pengajuan->penempatan)


                                            <x-button wire:click="acceptPengajuan({{ $pengajuan->id_pengajuan}})" variant="success"
                                                icon="fas fa-home">
                                                Penempatan
                                            </x-button>

                                        @elseif($pengajuan->jenis_pengajuan === App\Enums\JenisPengajuan::KELUAR)
                                            <x-button wire:click="acceptPengajuanKeluar({{ $pengajuan->id_pengajuan}})"
                                                variant="success" icon="fas fa-door-open">
                                                Setujui Keluar
                                            </x-button>
                                        @endif
                                    @endif

                                    {{--
                                    <button class="action-btn action-btn-edit"
                                        wire:click="openEditModal({{ $pengajuan->id_pengajuan }})" title="Edit Status">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    --}}

                                    <x-action-btn-delete wire:click="confirmDelete({{ $pengajuan->id_pengajuan }})" />
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-4">
                                <div class="text-muted">
                                    <i class="fas fa-file-signature mb-2" style="font-size: 2rem;"></i>
                                    <p class="mb-0">Tidak ada pengajuan ditemukan</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($pengajuans->hasPages())
            <div class="d-flex justify-content-end mt-4">
                {{ $pengajuans->links() }}
            </div>
        @endif
    </div>

    {{-- Create/Edit Modal --}}
    @if ($showModal)
        <div class="modal-backdrop-custom" wire:click.self="closeModal">
            <div class="modal-content-custom" wire:click.stop style="max-width: 500px;">
                <div class="modal-header-custom">
                    <h5 class="modal-title-custom">
                        {{ $editingPengajuanId ? 'Edit Pengajuan' : 'Buat Pengajuan Baru' }}
                    </h5>
                    <button type="button" class="modal-close-btn" wire:click="closeModal">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                <form wire:submit="save">
                    <div class="mb-3">
                        <label class="form-label">Warga Pemohon <span class="text-danger">*</span></label>
                        <select class="form-select form-control @error('id_warga') is-invalid @enderror"
                            wire:model="id_warga" {{ $editingPengajuanId ? 'disabled' : '' }}>
                            <option value="">Pilih Warga...</option>
                            @foreach($wargas as $warga)
                                <option value="{{ $warga->id_warga }}">{{ $warga->nama }} ({{ $warga->nik }})</option>
                            @endforeach
                        </select>
                        @error('id_warga') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        @if($editingPengajuanId)
                            <small class="text-muted">Pemohon tidak bisa diubah setelah pengajuan dibuat.</small>
                        @endif
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Jenis Pengajuan <span class="text-danger">*</span></label>
                        <select class="form-select form-control @error('jenis_pengajuan') is-invalid @enderror"
                            wire:model="jenis_pengajuan">
                            @foreach(App\Enums\JenisPengajuan::cases() as $jenis)
                                <option value="{{ $jenis->value }}">{{ $jenis->getLabel() }}</option>
                            @endforeach
                        </select>
                        @error('jenis_pengajuan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Status Pengajuan <span class="text-danger">*</span></label>
                        <select class="form-select form-control @error('status_pengajuan') is-invalid @enderror"
                            wire:model="status_pengajuan">
                            @foreach(App\Enums\StatusPengajuan::cases() as $status)
                                <option value="{{ $status->value }}">{{ $status->getLabel() }}</option>
                            @endforeach
                        </select>
                        @error('status_pengajuan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <x-button type="button" variant="outline" wire:click="closeModal">Batal</x-button>
                        <x-button type="submit" variant="primary">
                            {{ $editingPengajuanId ? 'Simpan' : 'Buat Pengajuan' }}
                        </x-button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    {{-- Penempatan Modal --}}
    @if ($showPenempatanModal)
        @php
            $acceptingPengajuan = $pengajuans->firstWhere('id_pengajuan', $acceptingPengajuanId);
        @endphp
        <div class="modal-backdrop-custom" wire:click.self="closePenempatanModal">
            <div class="modal-content-custom" wire:click.stop style="max-width: 550px;">
                <div class="modal-header-custom">
                    <h5 class="modal-title-custom">
                        <i class="fas fa-home me-2"></i>Penempatan Unit Rumah
                    </h5>
                    <button type="button" class="modal-close-btn" wire:click="closePenempatanModal">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                @if($acceptingPengajuan)
                    <div class="alert"
                        style="background: rgba(46,125,50,.08); border: 1px solid rgba(46,125,50,.2); border-radius: 8px; color: var(--text-secondary);">
                        <div class="d-flex align-items-center gap-2 mb-1">
                            <i class="fas fa-user" style="color: var(--accent-success, #2e7d32);"></i>
                            <strong>{{ $acceptingPengajuan->warga->nama }}</strong>
                        </div>
                        <small class="text-muted">NIK: {{ $acceptingPengajuan->warga->nik }}</small>
                    </div>
                @endif

                <form wire:submit="savePenempatan">
                    <div class="mb-3">
                        <label class="form-label">Pilih Unit Rumah <span class="text-danger">*</span></label>
                        <select class="form-select form-control @error('id_unit') is-invalid @enderror"
                            wire:model="id_unit">
                            <option value="">Pilih Unit Tersedia...</option>
                            @foreach($unitRumahs as $unit)
                                <option value="{{ $unit->id_unit }}">
                                    Blok {{ $unit->blok }} - No. {{ $unit->nomor }}
                                    ({{ $unit->status_ketersediaan->getLabel() }})
                                </option>
                            @endforeach
                        </select>
                        @error('id_unit') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Tanggal Masuk <span class="text-danger">*</span></label>
                        <input type="date" class="form-control @error('tanggal_masuk') is-invalid @enderror"
                            wire:model="tanggal_masuk">
                        @error('tanggal_masuk') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <x-button type="button" variant="outline" wire:click="closePenempatanModal">Batal</x-button>
                        <x-button type="submit" variant="primary" icon="fas fa-check">
                            Terima & Simpan Penempatan
                        </x-button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    {{-- Terima Keluar Modal --}}
    @if ($showTerimaKeluarModal)
        @php
            $acceptingPengajuan = $pengajuans->firstWhere('id_pengajuan', $acceptingPengajuanId);
        @endphp
        <div class="modal-backdrop-custom" wire:click.self="closeTerimaKeluarModal">
            <div class="modal-content-custom" wire:click.stop style="max-width: 500px;">
                <div class="modal-header-custom">
                    <h5 class="modal-title-custom">
                        <i class="fas fa-sign-out-alt me-2"></i>Persetujuan Keluar Unit
                    </h5>
                    <button type="button" class="modal-close-btn" wire:click="closeTerimaKeluarModal">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                @if($acceptingPengajuan)
                    <div class="alert"
                        style="background: rgba(46,125,50,.08); border: 1px solid rgba(46,125,50,.2); border-radius: 8px; color: var(--text-secondary);">
                        <div class="d-flex align-items-center gap-2 mb-1">
                            <i class="fas fa-user" style="color: var(--accent-success, #2e7d32);"></i>
                            <strong>{{ $acceptingPengajuan->warga->nama }}</strong>
                        </div>
                        <small class="text-muted">Memohon untuk keluar dari unit yang dihuninya saat ini. Menyetujui ini akan
                            menghapus data penempatan dan mengubah status unit rumah menjadi kosong/tersedia.</small>
                    </div>
                @endif

                <form wire:submit="savePengajuanKeluar">
                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <x-button type="button" variant="outline" wire:click="closeTerimaKeluarModal">Batal</x-button>
                        <x-button type="submit" variant="primary" icon="fas fa-check">
                            Setujui Pengajuan Keluar
                        </x-button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    {{-- Delete Modal --}}
    <x-confirm-modal :show="$showDeleteModal" title="Konfirmasi Hapus"
        message="Apakah Anda yakin ingin menghapus data pengajuan ini? Tindakan ini tidak dapat diurungkan."
        on-confirm="deletePengajuan" on-cancel="cancelDelete" variant="danger" icon="fas fa-exclamation-triangle">
        <x-slot:confirmButton>
            <i class="fas fa-trash-alt me-2"></i>Hapus Pengajuan
        </x-slot:confirmButton>
    </x-confirm-modal>
</div>