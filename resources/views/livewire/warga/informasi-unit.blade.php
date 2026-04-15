<div>
    <x-page-header title="Informasi Unit" subtitle="Status penempatan dan detail unit rumah Anda">
        {{-- Slot Actions Kosong --}}
    </x-page-header>

    @if (session('success'))
        <x-alert variant="success" title="Berhasil!" class="mb-4">
            {{ session('success') }}
        </x-alert>
    @endif

    <div class="row justify-content-center">
        <div class="col-lg-8">
            {{-- STATE 1: Punya Penempatan Aktif --}}
            @if($penempatanAktif)
                <div class="modern-card text-center mb-4 border-top border-4 border-success">
                    <div class="mb-4 mt-2">
                        <div class="icon-wrap mx-auto"
                            style="width: 80px; height: 80px; border-radius: 20px; background: rgba(91, 168, 124, 0.1); color: var(--success-color); display: flex; align-items: center; justify-content: center; font-size: 2.5rem;">
                            <i class="fas fa-home"></i>
                        </div>
                    </div>

                    <h3 style="color: var(--text-primary); font-weight: 700; margin-bottom: 0.5rem;">Blok
                        {{ $penempatanAktif->unitRumah->blok }} - No. {{ $penempatanAktif->unitRumah->nomor }}</h3>
                    <div class="mb-4">
                        <x-badge variant="success" icon="fas fa-check-circle">Status: Dihuni</x-badge>
                    </div>

                    <div class="text-start"
                        style="background: var(--bg-tertiary); padding: 1.5rem; border-radius: 15px; border: 1px solid var(--border-light);">
                        <h6 class="mb-3 text-muted fw-bold text-uppercase" style="font-size: 0.8rem; letter-spacing: 1px;">
                            Detail Penempatan</h6>

                        <div class="row g-3">
                            <div class="col-sm-6">
                                <div class="text-muted small">Tanggal Masuk</div>
                                <div class="fw-semibold" style="color: var(--text-primary);">
                                    {{ $penempatanAktif->tanggal_masuk->format('d F Y') }}</div>
                            </div>
                            <div class="col-sm-6">
                                <div class="text-muted small">Tipe Unit</div>
                                <div class="fw-semibold" style="color: var(--text-primary);">Standar</div>
                            </div>
                            <div class="col-12 mt-3">
                                <div class="text-muted small">Alamat Lengkap / Keterangan</div>
                                <div class="fw-semibold" style="color: var(--text-primary);">Unit Rumah Blok
                                    {{ $penempatanAktif->unitRumah->blok }} Nomor {{ $penempatanAktif->unitRumah->nomor }},
                                    Kompleks SIRUKUN.</div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 pt-3 border-top">
                        @if($pengajuanKeluarMenunggu)
                            <x-alert variant="warning" class="text-start mb-0" icon="fas fa-clock">
                                Pengajuan keluar Anda sedang diproses oleh Admin.
                            </x-alert>
                        @else
                            <button
                                class="btn btn-outline-danger w-100 py-2 d-flex align-items-center justify-content-center gap-2"
                                wire:click="openAjukanKeluarModal" style="border-radius: 10px; font-weight: 500;">
                                <i class="fas fa-sign-out-alt"></i> Ajukan Keluar Unit
                            </button>
                        @endif
                    </div>
                </div>

                {{-- STATE 2: Punya Pengajuan Menunggu --}}
            @elseif($pengajuanMasukMenunggu)
                <div class="modern-card text-center mb-4 border-top border-4 border-warning">
                    <div class="mb-4 mt-2">
                        <div class="icon-wrap mx-auto"
                            style="width: 80px; height: 80px; border-radius: 20px; background: rgba(212, 148, 58, 0.1); color: var(--warning-color); display: flex; align-items: center; justify-content: center; font-size: 2.5rem;">
                            <i class="fas fa-hourglass-half"></i>
                        </div>
                    </div>

                    <h4 style="color: var(--text-primary); font-weight: 600; margin-bottom: 1rem;">Pengajuan Sedang Diproses
                    </h4>
                    <p class="text-muted mb-4">Permohonan penempatan unit Anda telah dikirim pada
                        <strong>{{ $pengajuanMasukMenunggu->created_at->format('d M Y') }}</strong> dan saat ini sedang
                        menunggu persetujuan dari Administrator. Silakan cek kembali nanti.</p>

                    <div class="p-3"
                        style="background: var(--bg-tertiary); border-radius: 10px; border: 1px dashed var(--warning-color);">
                        <div class="d-flex align-items-center justify-content-center gap-2"
                            style="color: var(--warning-color); font-weight: 500;">
                            <i class="fas fa-circle-notch fa-spin"></i> Status: Menunggu
                        </div>
                    </div>
                </div>

                {{-- STATE 3: Belum Punya Unit & Tidak Ada Pengajuan --}}
            @else
                <div class="modern-card text-center mb-4 text-muted border-top border-4"
                    style="border-top-color: var(--border-color) !important;">
                    <div class="mb-4 mt-3">
                        <i class="fas fa-home" style="font-size: 4rem; color: var(--border-color);"></i>
                    </div>

                    <h4 style="color: var(--text-primary); font-weight: 600;">Belum Menempati Unit</h4>
                    <p class="mb-4">Saat ini Anda tidak terdaftar sebagai penghuni di unit rumah mana pun. Anda dapat
                        mengajukan permohonan untuk menempati unit yang tersedia.</p>

                    <x-button variant="primary" icon="fas fa-plus" wire:click="openAjukanUnitModal"
                        style="border-radius: 12px;">
                        Ajukan Penempatan Unit
                    </x-button>
                </div>
            @endif
        </div>
    </div>

    {{-- Modal Ajukan Unit (dengan upload berkas) --}}
    @if($showAjukanUnitModal)
        @php $warga = Auth::guard('warga')->user(); @endphp
        <div class="modal-backdrop-custom" wire:click.self="closeAjukanUnitModal">
            <div class="modal-content-custom" wire:click.stop style="max-width: 600px;">
                <div class="modal-header-custom">
                    <h5 class="modal-title-custom">
                        <i class="fas fa-home me-2" style="color: var(--primary-color);"></i>Ajukan Penempatan Unit
                    </h5>
                    <button type="button" class="modal-close-btn" wire:click="closeAjukanUnitModal">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                <div class="p-3 rounded-3 mb-3" style="background: rgba(33,150,243,.06); border: 1px solid rgba(33,150,243,.15);">
                    <div class="d-flex gap-2 align-items-start">
                        <i class="fas fa-info-circle mt-1" style="color: #1976d2; flex-shrink:0;"></i>
                        <p class="mb-0 small" style="color: var(--text-secondary);">
                            Pengajuan ini akan diteruskan ke Admin untuk divalidasi. Anda dapat memperbarui berkas di bawah ini jika diperlukan (opsional). Berkas yang tidak diunggah ulang akan tetap menggunakan data sebelumnya.
                        </p>
                    </div>
                </div>

                <form wire:submit="submitPengajuanUnit">
                    {{-- Status Berkas Saat Ini --}}
                    <h6 class="fw-bold text-muted text-uppercase mb-3" style="font-size: 0.75rem; letter-spacing: 1px;">
                        <i class="fas fa-folder-open me-1"></i>Kelengkapan Berkas
                    </h6>

                    <div class="row g-3 mb-4">
                        {{-- Foto KTP --}}
                        <div class="col-md-4">
                            <div class="text-center">
                                <label class="form-label fw-semibold d-block mb-2" style="font-size: 0.85rem;">
                                    <i class="fas fa-id-card me-1"></i>Foto KTP
                                </label>
                                @if($upload_foto_ktp)
                                    <div style="border: 2px solid rgba(33,150,243,.3); border-radius: 8px; padding: 4px; background: #f8f9fa;">
                                        <img src="{{ $upload_foto_ktp->temporaryUrl() }}" class="img-fluid rounded"
                                            style="max-height: 120px; object-fit: contain; width: 100%;">
                                    </div>
                                    <span class="badge bg-info mt-1"><i class="fas fa-upload me-1"></i>Baru</span>
                                @elseif($warga->foto_ktp)
                                    <div style="border: 2px solid rgba(46,125,50,.3); border-radius: 8px; padding: 4px; background: #f8f9fa;">
                                        <img src="{{ asset('storage/' . $warga->foto_ktp) }}" class="img-fluid rounded"
                                            style="max-height: 120px; object-fit: contain; width: 100%;">
                                    </div>
                                    <span class="badge bg-success mt-1"><i class="fas fa-check me-1"></i>Ada</span>
                                @else
                                    <div style="border: 2px dashed rgba(220,53,69,.3); border-radius: 8px; padding: 20px 10px; background: rgba(220,53,69,.03);">
                                        <i class="fas fa-image text-muted" style="font-size: 1.5rem;"></i>
                                        <p class="text-muted mb-0 mt-1" style="font-size: 0.7rem;">Belum ada</p>
                                    </div>
                                @endif
                            </div>
                        </div>

                        {{-- Foto KK --}}
                        <div class="col-md-4">
                            <div class="text-center">
                                <label class="form-label fw-semibold d-block mb-2" style="font-size: 0.85rem;">
                                    <i class="fas fa-users me-1"></i>Kartu Keluarga
                                </label>
                                @if($upload_foto_kk)
                                    <div style="border: 2px solid rgba(33,150,243,.3); border-radius: 8px; padding: 4px; background: #f8f9fa;">
                                        <img src="{{ $upload_foto_kk->temporaryUrl() }}" class="img-fluid rounded"
                                            style="max-height: 120px; object-fit: contain; width: 100%;">
                                    </div>
                                    <span class="badge bg-info mt-1"><i class="fas fa-upload me-1"></i>Baru</span>
                                @elseif($warga->foto_kk)
                                    <div style="border: 2px solid rgba(46,125,50,.3); border-radius: 8px; padding: 4px; background: #f8f9fa;">
                                        <img src="{{ asset('storage/' . $warga->foto_kk) }}" class="img-fluid rounded"
                                            style="max-height: 120px; object-fit: contain; width: 100%;">
                                    </div>
                                    <span class="badge bg-success mt-1"><i class="fas fa-check me-1"></i>Ada</span>
                                @else
                                    <div style="border: 2px dashed rgba(220,53,69,.3); border-radius: 8px; padding: 20px 10px; background: rgba(220,53,69,.03);">
                                        <i class="fas fa-image text-muted" style="font-size: 1.5rem;"></i>
                                        <p class="text-muted mb-0 mt-1" style="font-size: 0.7rem;">Belum ada</p>
                                    </div>
                                @endif
                            </div>
                        </div>

                        {{-- Foto Kusuka --}}
                        <div class="col-md-4">
                            <div class="text-center">
                                <label class="form-label fw-semibold d-block mb-2" style="font-size: 0.85rem;">
                                    <i class="fas fa-address-card me-1"></i>Kartu Kusuka
                                </label>
                                @if($upload_foto_kusuka)
                                    <div style="border: 2px solid rgba(33,150,243,.3); border-radius: 8px; padding: 4px; background: #f8f9fa;">
                                        <img src="{{ $upload_foto_kusuka->temporaryUrl() }}" class="img-fluid rounded"
                                            style="max-height: 120px; object-fit: contain; width: 100%;">
                                    </div>
                                    <span class="badge bg-info mt-1"><i class="fas fa-upload me-1"></i>Baru</span>
                                @elseif($warga->foto_kusuka)
                                    <div style="border: 2px solid rgba(46,125,50,.3); border-radius: 8px; padding: 4px; background: #f8f9fa;">
                                        <img src="{{ asset('storage/' . $warga->foto_kusuka) }}" class="img-fluid rounded"
                                            style="max-height: 120px; object-fit: contain; width: 100%;">
                                    </div>
                                    <span class="badge bg-success mt-1"><i class="fas fa-check me-1"></i>Ada</span>
                                @else
                                    <div style="border: 2px dashed rgba(220,53,69,.3); border-radius: 8px; padding: 20px 10px; background: rgba(220,53,69,.03);">
                                        <i class="fas fa-image text-muted" style="font-size: 1.5rem;"></i>
                                        <p class="text-muted mb-0 mt-1" style="font-size: 0.7rem;">Belum ada</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Upload Inputs --}}
                    <h6 class="fw-bold text-muted text-uppercase mb-3" style="font-size: 0.75rem; letter-spacing: 1px;">
                        <i class="fas fa-cloud-upload-alt me-1"></i>Upload Ulang Berkas (Opsional)
                    </h6>

                    <div class="mb-3">
                        <label class="form-label small">Foto KTP</label>
                        <input type="file" class="form-control form-control-sm @error('upload_foto_ktp') is-invalid @enderror"
                            wire:model="upload_foto_ktp" accept="image/*">
                        @error('upload_foto_ktp') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label small">Foto Kartu Keluarga</label>
                        <input type="file" class="form-control form-control-sm @error('upload_foto_kk') is-invalid @enderror"
                            wire:model="upload_foto_kk" accept="image/*">
                        @error('upload_foto_kk') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label small">Foto Kartu Kusuka</label>
                        <input type="file" class="form-control form-control-sm @error('upload_foto_kusuka') is-invalid @enderror"
                            wire:model="upload_foto_kusuka" accept="image/*">
                        @error('upload_foto_kusuka') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <small class="text-muted d-block mb-3"><i class="fas fa-info-circle me-1"></i>Format: JPG, PNG, maks 2MB per file. Kosongkan jika tidak ingin mengubah.</small>

                    <div class="d-flex justify-content-end gap-2">
                        <x-button type="button" variant="outline" wire:click="closeAjukanUnitModal">Batal</x-button>
                        <x-button type="submit" variant="primary" icon="fas fa-paper-plane" wire:loading.attr="disabled">
                            <span wire:loading.remove wire:target="submitPengajuanUnit">Kirim Pengajuan</span>
                            <span wire:loading wire:target="submitPengajuanUnit"><i class="fas fa-spinner fa-spin me-1"></i>Mengirim...</span>
                        </x-button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    {{-- Modal Ajukan Keluar (Sama dengan Dashboard & Riwayat) --}}
    <x-confirm-modal :show="$showAjukanKeluarModal" title="Konfirmasi Pengajuan Keluar"
        message="Apakah Anda yakin ingin mengajukan permohonan untuk keluar dari unit rumah saat ini? Pengajuan ini akan menghindari tagihan selanjutnya dan unit akan dijadikan kosong/tersedia."
        on-confirm="submitPengajuanKeluar" on-cancel="closeAjukanKeluarModal" variant="danger"
        icon="fas fa-sign-out-alt">
        <x-slot:confirmButton>
            <i class="fas fa-paper-plane me-2"></i>Kirim Pengajuan Keluar
        </x-slot:confirmButton>
    </x-confirm-modal>
</div>
