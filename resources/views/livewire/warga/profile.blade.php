<div>
    {{-- Page Header --}}
    <x-page-header title="Profile Saya" subtitle="Kelola informasi pribadi dan akun Anda">
        <x-slot:actions>
            <x-badge variant="info" icon="fas fa-user">Warga</x-badge>
        </x-slot:actions>
    </x-page-header>

    {{-- Flash Messages --}}
    @if (session('success'))
        <x-alert variant="success" title="Berhasil!" class="mb-4">
            {{ session('success') }}
        </x-alert>
    @endif

    @if (session('error'))
        <x-alert variant="danger" title="Error!" class="mb-4">
            {{ session('error') }}
        </x-alert>
    @endif

    <div class="row g-4">
        {{-- Profile Info Card --}}
        <div class="col-lg-4">
            <div class="modern-card text-center">
                <div class="position-relative d-inline-block mb-3">
                    <div class="user-avatar mx-auto"
                        style="width: 120px; height: 120px; font-size: 3rem; background-color: var(--secondary-color);">
                        {{ substr(Auth::guard('warga')->user()->nama, 0, 1) }}
                    </div>
                </div>

                <h4 style="color: var(--text-primary); font-weight: 600;">{{ Auth::guard('warga')->user()->nama }}</h4>
                <div class="text-muted small mb-2">NIK: {{ Auth::guard('warga')->user()->nik }}</div>

                <x-badge variant="info" icon="fas fa-home">Penghuni / Warga</x-badge>

                <hr style="border-color: var(--border-color); margin: 1.5rem 0;">

                <div class="text-start">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Bergabung</span>
                        <span
                            style="color: var(--text-primary);">{{ Auth::guard('warga')->user()->created_at->format('d M Y') }}</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-muted">Terakhir diperbarui</span>
                        <span
                            style="color: var(--text-primary);">{{ Auth::guard('warga')->user()->updated_at->diffForHumans() }}</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Edit Profile Card --}}
        <div class="col-lg-8">
            {{-- Profile Information --}}
            <div class="modern-card mb-4">
                <div class="preview-title d-flex align-items-center gap-2">
                    <i class="fas fa-user-edit" style="color: var(--primary-color);"></i>
                    Informasi Profile
                </div>

                <form wire:submit="updateProfile">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label text-muted">Nomor Induk Kependudukan (NIK)</label>
                            <input type="text" class="form-control" wire:model="nik" readonly disabled>
                            <small class="text-muted" style="font-size: 0.75rem;">*Hubungi admin jika ada kesalahan
                                NIK.</small>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-muted">Nomor Kartu Keluarga (NKK)</label>
                            <input type="text" class="form-control" wire:model="nkk" readonly disabled>
                            <small class="text-muted" style="font-size: 0.75rem;">*Hubungi admin jika ada kesalahan
                                NKK.</small>
                        </div>

                        <div class="col-12 mt-4">
                            <label for="nama" class="form-label">Nama Lengkap <span
                                    style="color: var(--danger-color);">*</span></label>
                            <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama"
                                wire:model="nama" placeholder="Masukkan nama lengkap">
                            @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="telepon" class="form-label">No. Telepon / HP <span
                                    style="color: var(--danger-color);">*</span></label>
                            <input type="text" class="form-control @error('telepon') is-invalid @enderror" id="telepon"
                                wire:model="telepon" placeholder="Contoh: 08123456789">
                            @error('telepon')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="alamat" class="form-label">Alamat Lengkap <span
                                    style="color: var(--danger-color);">*</span></label>
                            <input type="text" class="form-control @error('alamat') is-invalid @enderror" id="alamat"
                                wire:model="alamat" placeholder="Masukkan detail alamat">
                            @error('alamat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="d-flex justify-content-end mt-4">
                        <x-button type="submit" variant="primary" icon="fas fa-save">
                            Simpan Perubahan
                        </x-button>
                    </div>
                </form>
            </div>

            {{-- Change Password --}}
            <div class="modern-card">
                <div class="preview-title d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center gap-2">
                        <i class="fas fa-lock" style="color: var(--warning-color);"></i>
                        Ubah Password
                    </div>
                    <x-button type="button" variant="{{ $showPasswordSection ? 'danger' : 'outline' }}" size="sm"
                        wire:click="togglePasswordSection">
                        {{ $showPasswordSection ? 'Batal' : 'Ubah Password' }}
                    </x-button>
                </div>

                @if($showPasswordSection)
                    <form wire:submit="updatePassword" class="mt-3">
                        <div class="row g-3">
                            <div class="col-12">
                                <label for="current_password" class="form-label">Password Saat Ini <span
                                        style="color: var(--danger-color);">*</span></label>
                                <input type="password" class="form-control @error('current_password') is-invalid @enderror"
                                    id="current_password" wire:model="current_password"
                                    placeholder="Masukkan password saat ini">
                                @error('current_password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="password" class="form-label">Password Baru <span
                                        style="color: var(--danger-color);">*</span></label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                    id="password" wire:model="password" placeholder="Masukkan password baru">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="password_confirmation" class="form-label">Konfirmasi Password <span
                                        style="color: var(--danger-color);">*</span></label>
                                <input type="password" class="form-control" id="password_confirmation"
                                    wire:model="password_confirmation" placeholder="Konfirmasi password baru">
                            </div>
                        </div>

                        <x-alert variant="info" class="mt-3">
                            <i class="fas fa-info-circle me-2"></i>
                            Password harus minimal 8 karakter.
                        </x-alert>

                        <div class="d-flex justify-content-end mt-4">
                            <x-button type="submit" variant="warning" icon="fas fa-key">
                                Perbarui Password
                            </x-button>
                        </div>
                    </form>
                @else
                    <p class="text-muted mb-0">
                        <i class="fas fa-shield-alt me-2"></i>
                        Klik tombol "Ubah Password" untuk memperbarui password Anda untuk login.
                    </p>
                @endif
            </div>
        </div>
    </div>
</div>