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
                        <th style="width: 5%">No.</th>
                        <th style="width: 30%">Nama Warga (Pemohon)</th>
                        <th style="width: 25%">Tanggal Pengajuan</th>
                        <th style="width: 15%">Status</th>
                        <th style="width: 15%">Berkas</th>
                        <th style="width: 10%" class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pengajuans as $index => $pengajuan)
                        <tr>
                            <td class="text-muted text-center">{{ $pengajuans->firstItem() + $index }}</td>
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
                                @if($pengajuan->status_pengajuan === App\Enums\StatusPengajuan::DITOLAK && $pengajuan->alasan_tolak)
                                    <div class="mt-1">
                                        <small class="text-danger" style="font-size: 0.75rem;"><i class="fas fa-info-circle me-1"></i>{{ $pengajuan->alasan_tolak }}</small>
                                    </div>
                                @endif
                            </td>
            <td> 

                                    {{-- Tombol Tinjau Berkas --}}
                                    <x-button wire:click="openBerkasModal({{ $pengajuan->id_pengajuan }})" variant="info"
                                        icon="fas fa-folder-open">
                                        Tinjau Berkas
                                    </x-button>
            </td>
                            <td class="text-end">
                                <div class="d-flex gap-1 justify-content-end flex-wrap">

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

                                        {{-- Tombol Tolak --}}
                                        <x-button wire:click="openTolakModal({{ $pengajuan->id_pengajuan }})" variant="danger"
                                            icon="fas fa-times-circle">
                                            Tolak
                                        </x-button>
                                    @endif

                                    <x-action-btn-delete wire:click="confirmDelete({{ $pengajuan->id_pengajuan }})" />
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4">
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

    {{-- Tinjau Berkas Modal --}}
    @if ($showBerkasModal)
        @php
            $reviewingPengajuan = $pengajuans->firstWhere('id_pengajuan', $reviewingPengajuanId);
            $reviewingWarga = $reviewingPengajuan?->warga;
        @endphp
        <div class="modal-backdrop-custom" wire:click.self="closeBerkasModal">
            <div class="modal-content-custom" wire:click.stop style="max-width: 700px;">
                <div class="modal-header-custom">
                    <h5 class="modal-title-custom">
                        <i class="fas fa-folder-open me-2"></i>Tinjau Kelengkapan Berkas
                    </h5>
                    <button type="button" class="modal-close-btn" wire:click="closeBerkasModal">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                @if($reviewingWarga)
                    {{-- Info Warga --}}
                    <div class="alert"
                        style="background: rgba(33,150,243,.08); border: 1px solid rgba(33,150,243,.2); border-radius: 8px; color: var(--text-secondary);">
                        <div class="d-flex align-items-center gap-2 mb-1">
                            <i class="fas fa-user" style="color: #1976d2;"></i>
                            <strong>{{ $reviewingWarga->nama }}</strong>
                        </div>
                        <small class="text-muted d-block">NIK: {{ $reviewingWarga->nik }} &bull; NKK: {{ $reviewingWarga->nkk }}</small>
                        <small class="text-muted d-block">Alamat: {{ $reviewingWarga->alamat }}</small>
                        <small class="text-muted d-block">Telepon: {{ $reviewingWarga->telepon }}</small>
                    </div>

                    {{-- Berkas Section --}}
                    <div class="row g-3 mt-1">
                        {{-- Foto KTP --}}
                        <div class="col-md-4">
                            <div class="text-center">
                                <label class="form-label fw-semibold d-block mb-2">
                                    <i class="fas fa-id-card me-1"></i>Foto KTP
                                </label>
                                @if($reviewingWarga->foto_ktp)
                                    <div class="berkas-thumbnail" onclick="openLightbox('{{ asset('storage/' . $reviewingWarga->foto_ktp) }}', 'Foto KTP')" style="border: 2px solid rgba(46,125,50,.3); border-radius: 8px; padding: 4px; background: #f8f9fa; cursor: pointer; position: relative;">
                                        <img src="{{ asset('storage/' . $reviewingWarga->foto_ktp) }}"
                                            alt="Foto KTP" class="img-fluid rounded" style="max-height: 180px; object-fit: contain; width: 100%;">
                                        <div class="berkas-zoom-hint"><i class="fas fa-search-plus"></i></div>
                                    </div>
                                    <span class="badge bg-success mt-2"><i class="fas fa-check me-1"></i>Tersedia</span>
                                    <x-button variant="danger" size="sm" icon="fas fa-download"
                                        href="{{ asset('storage/' . $reviewingWarga->foto_ktp) }}"
                                        download="KTP_{{ $reviewingWarga->nik }}.{{ pathinfo($reviewingWarga->foto_ktp, PATHINFO_EXTENSION) }}"
                                        class="d-block mt-2">Download</x-button>
                                @else
                                    <div style="border: 2px dashed rgba(220,53,69,.3); border-radius: 8px; padding: 30px 10px; background: rgba(220,53,69,.03);">
                                        <i class="fas fa-image text-muted" style="font-size: 2rem;"></i>
                                        <p class="text-muted mb-0 mt-1" style="font-size: 0.8rem;">Belum diunggah</p>
                                    </div>
                                    <span class="badge bg-danger mt-2"><i class="fas fa-times me-1"></i>Tidak ada</span>
                                @endif
                            </div>
                        </div>

                        {{-- Foto KK --}}
                        <div class="col-md-4">
                            <div class="text-center">
                                <label class="form-label fw-semibold d-block mb-2">
                                    <i class="fas fa-users me-1"></i>Kartu Keluarga
                                </label>
                                @if($reviewingWarga->foto_kk)
                                    <div class="berkas-thumbnail" onclick="openLightbox('{{ asset('storage/' . $reviewingWarga->foto_kk) }}', 'Kartu Keluarga')" style="border: 2px solid rgba(46,125,50,.3); border-radius: 8px; padding: 4px; background: #f8f9fa; cursor: pointer; position: relative;">
                                        <img src="{{ asset('storage/' . $reviewingWarga->foto_kk) }}"
                                            alt="Foto KK" class="img-fluid rounded" style="max-height: 180px; object-fit: contain; width: 100%;">
                                        <div class="berkas-zoom-hint"><i class="fas fa-search-plus"></i></div>
                                    </div>
                                    <span class="badge bg-success mt-2"><i class="fas fa-check me-1"></i>Tersedia</span>
                                    <x-button variant="danger" size="sm" icon="fas fa-download"
                                        href="{{ asset('storage/' . $reviewingWarga->foto_kk) }}"
                                        download="KK_{{ $reviewingWarga->nik }}.{{ pathinfo($reviewingWarga->foto_kk, PATHINFO_EXTENSION) }}"
                                        class="d-block mt-2">Download</x-button>
                                @else
                                    <div style="border: 2px dashed rgba(220,53,69,.3); border-radius: 8px; padding: 30px 10px; background: rgba(220,53,69,.03);">
                                        <i class="fas fa-image text-muted" style="font-size: 2rem;"></i>
                                        <p class="text-muted mb-0 mt-1" style="font-size: 0.8rem;">Belum diunggah</p>
                                    </div>
                                    <span class="badge bg-danger mt-2"><i class="fas fa-times me-1"></i>Tidak ada</span>
                                @endif
                            </div>
                        </div>

                        {{-- Foto Kusuka --}}
                        <div class="col-md-4">
                            <div class="text-center">
                                <label class="form-label fw-semibold d-block mb-2">
                                    <i class="fas fa-address-card me-1"></i>Kartu Kusuka
                                </label>
                                @if($reviewingWarga->foto_kusuka)
                                    <div class="berkas-thumbnail" onclick="openLightbox('{{ asset('storage/' . $reviewingWarga->foto_kusuka) }}', 'Kartu Kusuka')" style="border: 2px solid rgba(46,125,50,.3); border-radius: 8px; padding: 4px; background: #f8f9fa; cursor: pointer; position: relative;">
                                        <img src="{{ asset('storage/' . $reviewingWarga->foto_kusuka) }}"
                                            alt="Foto Kusuka" class="img-fluid rounded" style="max-height: 180px; object-fit: contain; width: 100%;">
                                        <div class="berkas-zoom-hint"><i class="fas fa-search-plus"></i></div>
                                    </div>
                                    <span class="badge bg-success mt-2"><i class="fas fa-check me-1"></i>Tersedia</span>
                                    <x-button variant="danger" size="sm" icon="fas fa-download"
                                        href="{{ asset('storage/' . $reviewingWarga->foto_kusuka) }}"
                                        download="Kusuka_{{ $reviewingWarga->nik }}.{{ pathinfo($reviewingWarga->foto_kusuka, PATHINFO_EXTENSION) }}"
                                        class="d-block mt-2">Download</x-button>
                                @else
                                    <div style="border: 2px dashed rgba(220,53,69,.3); border-radius: 8px; padding: 30px 10px; background: rgba(220,53,69,.03);">
                                        <i class="fas fa-image text-muted" style="font-size: 2rem;"></i>
                                        <p class="text-muted mb-0 mt-1" style="font-size: 0.8rem;">Belum diunggah</p>
                                    </div>
                                    <span class="badge bg-danger mt-2"><i class="fas fa-times me-1"></i>Tidak ada</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Ringkasan Kelengkapan --}}
                    @php
                        $berkasLengkap = $reviewingWarga->foto_kk && $reviewingWarga->foto_kusuka;
                        $jumlahBerkas = ($reviewingWarga->foto_ktp ? 1 : 0) + ($reviewingWarga->foto_kk ? 1 : 0) + ($reviewingWarga->foto_kusuka ? 1 : 0);
                    @endphp
                    <div class="alert mt-3 {{ $berkasLengkap ? '' : '' }}"
                        style="background: {{ $berkasLengkap ? 'rgba(46,125,50,.08)' : 'rgba(255,152,0,.08)' }}; border: 1px solid {{ $berkasLengkap ? 'rgba(46,125,50,.2)' : 'rgba(255,152,0,.2)' }}; border-radius: 8px; color: var(--text-secondary);">
                        <div class="d-flex align-items-center gap-2">
                            <i class="fas {{ $berkasLengkap ? 'fa-check-circle' : 'fa-exclamation-triangle' }}"
                                style="color: {{ $berkasLengkap ? '#2e7d32' : '#f57c00' }}; font-size: 1.2rem;"></i>
                            <div>
                                <strong>{{ $berkasLengkap ? 'Berkas Lengkap' : 'Berkas Belum Lengkap' }}</strong>
                                <small class="d-block text-muted">{{ $jumlahBerkas }}/3 dokumen telah diunggah</small>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="text-center py-4 text-muted">
                        <i class="fas fa-exclamation-circle" style="font-size: 2rem;"></i>
                        <p class="mt-2">Data warga tidak ditemukan.</p>
                    </div>
                @endif

                <div class="d-flex justify-content-end gap-2 mt-3">
                    <x-button type="button" variant="outline" wire:click="closeBerkasModal">Tutup</x-button>
                </div>
            </div>
        </div>
    @endif

    {{-- Tolak Pengajuan Modal --}}
    @if ($showTolakModal)
        @php
            $tolakPengajuan = $pengajuans->firstWhere('id_pengajuan', $acceptingPengajuanId);
        @endphp
        <div class="modal-backdrop-custom" wire:click.self="closeTolakModal">
            <div class="modal-content-custom" wire:click.stop style="max-width: 500px;">
                <div class="modal-header-custom">
                    <h5 class="modal-title-custom">
                        <i class="fas fa-times-circle me-2"></i>Tolak Pengajuan
                    </h5>
                    <button type="button" class="modal-close-btn" wire:click="closeTolakModal">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                @if($tolakPengajuan)
                    <div class="alert"
                        style="background: rgba(220,53,69,.08); border: 1px solid rgba(220,53,69,.2); border-radius: 8px; color: var(--text-secondary);">
                        <div class="d-flex align-items-center gap-2 mb-1">
                            <i class="fas fa-user" style="color: #dc3545;"></i>
                            <strong>{{ $tolakPengajuan->warga->nama }}</strong>
                        </div>
                        <small class="text-muted">NIK: {{ $tolakPengajuan->warga->nik }} &bull; Jenis: {{ $tolakPengajuan->jenis_pengajuan->getLabel() }}</small>
                    </div>
                @endif

                <form wire:submit="tolakPengajuan">
                    <div class="mb-4">
                        <label class="form-label">Alasan Penolakan <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('alasan_tolak') is-invalid @enderror"
                            wire:model="alasan_tolak" rows="4"
                            placeholder="Tuliskan alasan penolakan pengajuan, misalnya: Berkas KK belum diunggah, dokumen tidak jelas, dll."></textarea>
                        @error('alasan_tolak') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        <small class="text-muted">Minimal 10 karakter. Alasan ini akan ditampilkan kepada warga.</small>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <x-button type="button" variant="outline" wire:click="closeTolakModal">Batal</x-button>
                        <x-button type="submit" variant="danger" icon="fas fa-times-circle">
                            Tolak Pengajuan
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
    {{-- Lightbox Preview --}}
    <div id="berkasLightbox" onclick="closeLightbox(event)" style="display:none; position:fixed; inset:0; z-index:99999; background:rgba(0,0,0,.85); backdrop-filter:blur(4px); justify-content:center; align-items:center; flex-direction:column; cursor:pointer;">
        <div style="position:absolute; top:20px; right:24px; display:flex; gap:8px;">
            <a id="berkasLightboxDownload" href="" download="" onclick="event.stopPropagation()" style="background:rgba(255,255,255,.15); border:none; color:#fff; font-size:1.1rem; width:44px; height:44px; border-radius:50%; cursor:pointer; display:flex; align-items:center; justify-content:center; transition:background .2s; text-decoration:none;" onmouseover="this.style.background='rgba(255,255,255,.3)'" onmouseout="this.style.background='rgba(255,255,255,.15)'">
                <i class="fas fa-download"></i>
            </a>
            <button onclick="closeLightbox(event, true)" style="background:rgba(255,255,255,.15); border:none; color:#fff; font-size:1.5rem; width:44px; height:44px; border-radius:50%; cursor:pointer; display:flex; align-items:center; justify-content:center; transition:background .2s;" onmouseover="this.style.background='rgba(255,255,255,.3)'" onmouseout="this.style.background='rgba(255,255,255,.15)'">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <p id="berkasLightboxTitle" style="color:#fff; font-size:1rem; font-weight:600; margin-bottom:12px; text-shadow:0 1px 4px rgba(0,0,0,.5);"></p>
        <img id="berkasLightboxImg" src="" alt="Preview" style="max-width:90vw; max-height:80vh; object-fit:contain; border-radius:8px; box-shadow:0 8px 32px rgba(0,0,0,.5); cursor:default;" onclick="event.stopPropagation()">
        <p style="color:rgba(255,255,255,.5); font-size:0.8rem; margin-top:12px;"><i class="fas fa-mouse-pointer me-1"></i>Klik di luar gambar untuk menutup</p>
    </div>

    <style>
        .berkas-thumbnail { transition: transform .2s, box-shadow .2s; }
        .berkas-thumbnail:hover { transform: scale(1.03); box-shadow: 0 4px 16px rgba(0,0,0,.12); }
        .berkas-zoom-hint {
            position: absolute; inset: 0;
            background: rgba(0,0,0,.35);
            border-radius: 6px;
            display: flex; align-items: center; justify-content: center;
            opacity: 0; transition: opacity .2s;
            color: #fff; font-size: 1.5rem;
            pointer-events: none;
        }
        .berkas-thumbnail:hover .berkas-zoom-hint { opacity: 1; }
    </style>

    <script>
        function openLightbox(src, title) {
            const lb = document.getElementById('berkasLightbox');
            document.getElementById('berkasLightboxImg').src = src;
            document.getElementById('berkasLightboxTitle').textContent = title;
            const dlBtn = document.getElementById('berkasLightboxDownload');
            dlBtn.href = src;
            dlBtn.download = title.replace(/\s+/g, '_') + '.' + src.split('.').pop();
            lb.style.display = 'flex';
            document.body.style.overflow = 'hidden';
        }
        function closeLightbox(e, force) {
            if (force || e.target === document.getElementById('berkasLightbox')) {
                document.getElementById('berkasLightbox').style.display = 'none';
                document.body.style.overflow = '';
            }
        }
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                document.getElementById('berkasLightbox').style.display = 'none';
                document.body.style.overflow = '';
            }
        });
    </script>
</div>
