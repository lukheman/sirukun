<div class="auth-page">
    <div class="auth-particles">
        <span class="auth-particle ap1"></span>
        <span class="auth-particle ap2"></span>
        <span class="auth-particle ap3"></span>
    </div>

    <div class="auth-wrapper auth-wrapper-wide">
        <!-- Left Panel - Branding -->
        <div class="auth-brand-panel">
            <div class="brand-inner">
                <div class="brand-icon-wrap">
                    <i class="fas fa-home"></i>
                </div>
                <h2>Bergabung dengan <span>SIRUKUN</span></h2>
                <p>Daftarkan diri Anda untuk mengajukan hunian dan mengakses layanan pengelolaan data warga.</p>
                <div class="brand-features">
                    <div class="brand-feat-item">
                        <i class="fas fa-check-circle"></i>
                        <span>Pendaftaran Cepat</span>
                    </div>
                    <div class="brand-feat-item">
                        <i class="fas fa-check-circle"></i>
                        <span>Pengajuan Hunian Otomatis</span>
                    </div>
                    <div class="brand-feat-item">
                        <i class="fas fa-check-circle"></i>
                        <span>Aman & Terpercaya</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Panel - Form -->
        <div class="auth-form-panel">
            <div class="auth-form-inner auth-form-inner-wide">
                <div class="auth-form-header">
                    <h1>Registrasi Warga</h1>
                    <p>Isi data diri Anda untuk mendaftar</p>
                </div>

                <form wire:submit="submit">
                    <div class="auth-form-grid">
                        <!-- NIK -->
                        <div class="auth-field">
                            <label for="nik">NIK <span class="req">*</span></label>
                            <div class="auth-input-wrap">
                                <i class="fas fa-id-card"></i>
                                <input type="text" wire:model="nik" class="@error('nik') is-invalid @enderror" id="nik"
                                    placeholder="16 digit NIK" maxlength="16" autofocus>
                            </div>
                            @error('nik')
                                <span class="auth-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- NKK -->
                        <div class="auth-field">
                            <label for="nkk">No. KK <span class="req">*</span></label>
                            <div class="auth-input-wrap">
                                <i class="fas fa-file-alt"></i>
                                <input type="text" wire:model="nkk" class="@error('nkk') is-invalid @enderror" id="nkk"
                                    placeholder="16 digit No. KK" maxlength="16">
                            </div>
                            @error('nkk')
                                <span class="auth-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Nama -->
                        <div class="auth-field">
                            <label for="nama">Nama Lengkap <span class="req">*</span></label>
                            <div class="auth-input-wrap">
                                <i class="fas fa-user"></i>
                                <input type="text" wire:model="nama" class="@error('nama') is-invalid @enderror"
                                    id="nama" placeholder="Nama lengkap sesuai KTP">
                            </div>
                            @error('nama')
                                <span class="auth-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Telepon -->
                        <div class="auth-field">
                            <label for="telepon">No. Telepon <span class="req">*</span></label>
                            <div class="auth-input-wrap">
                                <i class="fas fa-phone"></i>
                                <input type="text" wire:model="telepon" class="@error('telepon') is-invalid @enderror"
                                    id="telepon" placeholder="08xxxxxxxxxx">
                            </div>
                            @error('telepon')
                                <span class="auth-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Tempat Lahir -->
                        <div class="auth-field">
                            <label for="tempat_lahir">Tempat Lahir <span class="req">*</span></label>
                            <div class="auth-input-wrap">
                                <i class="fas fa-map-marker-alt"></i>
                                <input type="text" wire:model="tempat_lahir"
                                    class="@error('tempat_lahir') is-invalid @enderror" id="tempat_lahir"
                                    placeholder="Kota tempat lahir">
                            </div>
                            @error('tempat_lahir')
                                <span class="auth-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Tanggal Lahir -->
                        <div class="auth-field">
                            <label for="tanggal_lahir">Tanggal Lahir <span class="req">*</span></label>
                            <div class="auth-input-wrap">
                                <i class="fas fa-calendar"></i>
                                <input type="date" wire:model="tanggal_lahir"
                                    class="@error('tanggal_lahir') is-invalid @enderror" id="tanggal_lahir">
                            </div>
                            @error('tanggal_lahir')
                                <span class="auth-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Agama -->
                        <div class="auth-field">
                            <label for="agama">Agama <span class="req">*</span></label>
                            <div class="auth-input-wrap auth-select-wrap">
                                <i class="fas fa-pray"></i>
                                <select wire:model="agama" class="@error('agama') is-invalid @enderror" id="agama">
                                    <option value="">Pilih Agama</option>
                                    <option value="Islam">Islam</option>
                                    <option value="Kristen">Kristen</option>
                                    <option value="Katolik">Katolik</option>
                                    <option value="Hindu">Hindu</option>
                                    <option value="Buddha">Buddha</option>
                                    <option value="Konghucu">Konghucu</option>
                                </select>
                            </div>
                            @error('agama')
                                <span class="auth-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Alamat (full width) -->
                        <div class="auth-field auth-field-full">
                            <label for="alamat">Alamat <span class="req">*</span></label>
                            <div class="auth-input-wrap">
                                <i class="fas fa-home"></i>
                                <input type="text" wire:model="alamat" class="@error('alamat') is-invalid @enderror"
                                    id="alamat" placeholder="Alamat lengkap">
                            </div>
                            @error('alamat')
                                <span class="auth-error">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Upload Berkas (full width header) --}}
                        <div class="auth-field auth-field-full">
                            <div style="display: flex; align-items: center; gap: 8px; padding: 0.6rem 0; border-bottom: 1.5px solid var(--border-color); margin-bottom: 0.25rem;">
                                <i class="fas fa-folder-open" style="color: var(--primary-color);"></i>
                                <span style="font-size: 0.8rem; font-weight: 700; color: var(--text-primary); text-transform: uppercase; letter-spacing: 0.5px;">Berkas Dokumen</span>
                            </div>
                        </div>

                        {{-- Upload Foto KTP (full width) --}}
                        <div class="auth-field auth-field-full">
                            <label for="foto_ktp">Foto KTP <small style="font-weight:400; color:var(--text-muted);">(opsional, maks 2MB)</small></label>
                            <div class="auth-file-wrap @error('foto_ktp') is-invalid-file @enderror">
                                <label for="foto_ktp" class="auth-file-label">
                                    <i class="fas fa-id-card"></i>
                                    <span wire:loading.remove wire:target="foto_ktp">
                                        @if ($foto_ktp)
                                            <span style="color: var(--primary-color);">{{ $foto_ktp->getClientOriginalName() }}</span>
                                        @else
                                            Klik untuk unggah Foto KTP
                                        @endif
                                    </span>
                                    <span wire:loading wire:target="foto_ktp" style="color:var(--primary-color);"><i class="fas fa-spinner fa-spin"></i> Mengupload...</span>
                                </label>
                                <input type="file" wire:model="foto_ktp"
                                    id="foto_ktp" accept="image/*" class="auth-file-input">
                            </div>
                            @error('foto_ktp')
                                <span class="auth-error">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Upload Foto KK --}}
                        <div class="auth-field">
                            <label for="foto_kk">Foto Kartu Keluarga <span class="req">*</span> <small style="font-weight:400; color:var(--text-muted);">(maks 2MB)</small></label>
                            <div class="auth-file-wrap @error('foto_kk') is-invalid-file @enderror">
                                <label for="foto_kk" class="auth-file-label">
                                    <i class="fas fa-users"></i>
                                    <span wire:loading.remove wire:target="foto_kk">
                                        @if ($foto_kk)
                                            <span style="color: var(--primary-color);">{{ $foto_kk->getClientOriginalName() }}</span>
                                        @else
                                            Klik untuk unggah Foto KK
                                        @endif
                                    </span>
                                    <span wire:loading wire:target="foto_kk" style="color:var(--primary-color);"><i class="fas fa-spinner fa-spin"></i> Mengupload...</span>
                                </label>
                                <input type="file" wire:model="foto_kk"
                                    id="foto_kk" accept="image/*" class="auth-file-input">
                            </div>
                            @error('foto_kk')
                                <span class="auth-error">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Upload Foto Kartu Kusuka --}}
                        <div class="auth-field">
                            <label for="foto_kusuka">Foto Kartu Kusuka <span class="req">*</span> <small style="font-weight:400; color:var(--text-muted);">(maks 2MB)</small></label>
                            <div class="auth-file-wrap @error('foto_kusuka') is-invalid-file @enderror">
                                <label for="foto_kusuka" class="auth-file-label">
                                    <i class="fas fa-address-card"></i>
                                    <span wire:loading.remove wire:target="foto_kusuka">
                                        @if ($foto_kusuka)
                                            <span style="color: var(--primary-color);">{{ $foto_kusuka->getClientOriginalName() }}</span>
                                        @else
                                            Klik untuk unggah Kartu Kusuka
                                        @endif
                                    </span>
                                    <span wire:loading wire:target="foto_kusuka" style="color:var(--primary-color);"><i class="fas fa-spinner fa-spin"></i> Mengupload...</span>
                                </label>
                                <input type="file" wire:model="foto_kusuka"
                                    id="foto_kusuka" accept="image/*" class="auth-file-input">
                            </div>
                            @error('foto_kusuka')
                                <span class="auth-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div class="auth-field">
                            <label for="password">Kata Sandi <span class="req">*</span></label>
                            <div class="auth-input-wrap">
                                <i class="fas fa-lock"></i>
                                <input type="password" wire:model="password"
                                    class="@error('password') is-invalid @enderror" id="password"
                                    placeholder="Min. 6 karakter">
                                <button type="button" class="toggle-pw"
                                    onclick="togglePassword('password', 'toggleIcon1')">
                                    <i class="fas fa-eye" id="toggleIcon1"></i>
                                </button>
                            </div>
                            @error('password')
                                <span class="auth-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div class="auth-field">
                            <label for="password_confirmation">Konfirmasi Kata Sandi <span class="req">*</span></label>
                            <div class="auth-input-wrap">
                                <i class="fas fa-lock"></i>
                                <input type="password" wire:model="password_confirmation" id="password_confirmation"
                                    placeholder="Ulangi kata sandi">
                                <button type="button" class="toggle-pw"
                                    onclick="togglePassword('password_confirmation', 'toggleIcon2')">
                                    <i class="fas fa-eye" id="toggleIcon2"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Submit -->
                    <button type="submit" class="auth-submit" wire:loading.attr="disabled">
                        <span wire:loading.remove>
                            Daftar & Ajukan Hunian
                            <i class="fas fa-arrow-right"></i>
                        </span>
                        <span wire:loading>
                            <i class="fas fa-spinner fa-spin"></i> Memproses...
                        </span>
                    </button>
                </form>

                <div class="auth-footer">
                    Sudah punya akun? <a href="{{ route('login') }}" wire:navigate>Masuk</a>
                </div>
            </div>
        </div>
    </div>

    <x-slot:styles>
        <style>
            .footer {
                display: none;
            }

            .navbar {
                position: relative;
            }

            .auth-page {
                min-height: calc(100vh - 70px);
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 2rem;
                position: relative;
                overflow: hidden;
                background: linear-gradient(160deg, #FDF8F3 0%, #F5F0E8 50%, #EDE4D6 100%);
            }

            [data-theme="dark"] .auth-page {
                background: linear-gradient(160deg, #2C1E16 0%, #3D2C1E 50%, #2C1E16 100%);
            }

            .auth-particles {
                position: absolute;
                inset: 0;
                pointer-events: none;
                z-index: 0;
            }

            .auth-particle {
                position: absolute;
                border-radius: 50%;
                opacity: 0.5;
                animation: auth-drift 16s ease-in-out infinite alternate;
            }

            .ap1 {
                width: 280px;
                height: 280px;
                background: radial-gradient(circle, rgba(199, 91, 63, 0.1), transparent 70%);
                top: -60px;
                right: 5%;
            }

            .ap2 {
                width: 220px;
                height: 220px;
                background: radial-gradient(circle, rgba(107, 142, 90, 0.1), transparent 70%);
                bottom: 5%;
                left: 10%;
                animation-delay: -6s;
            }

            .ap3 {
                width: 160px;
                height: 160px;
                background: radial-gradient(circle, rgba(212, 148, 58, 0.08), transparent 70%);
                top: 50%;
                left: 40%;
                animation-delay: -12s;
            }

            @keyframes auth-drift {
                0% {
                    transform: translate(0, 0) scale(1);
                }

                100% {
                    transform: translate(20px, -15px) scale(1.08);
                }
            }

            .auth-wrapper {
                display: grid;
                grid-template-columns: 380px 1fr;
                max-width: 1050px;
                width: 100%;
                background: var(--bg-white);
                border-radius: 28px;
                box-shadow: 0 25px 80px rgba(0, 0, 0, 0.08);
                border: 1px solid var(--border-color);
                overflow: hidden;
                position: relative;
                z-index: 1;
            }

            .auth-brand-panel {
                background: linear-gradient(160deg, #C75B3F 0%, #A8472E 60%, #8B3A24 100%);
                padding: 2.5rem;
                display: flex;
                align-items: center;
                position: relative;
                overflow: hidden;
            }

            .auth-brand-panel::before {
                content: '';
                position: absolute;
                width: 300px;
                height: 300px;
                border-radius: 50%;
                background: rgba(255, 255, 255, 0.05);
                top: -80px;
                right: -80px;
            }

            .auth-brand-panel::after {
                content: '';
                position: absolute;
                width: 200px;
                height: 200px;
                border-radius: 50%;
                background: rgba(255, 255, 255, 0.04);
                bottom: -60px;
                left: -40px;
            }

            .brand-inner {
                position: relative;
                z-index: 1;
            }

            .brand-icon-wrap {
                width: 56px;
                height: 56px;
                border-radius: 16px;
                background: rgba(255, 255, 255, 0.15);
                backdrop-filter: blur(10px);
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 1.4rem;
                color: white;
                margin-bottom: 1.25rem;
            }

            .auth-brand-panel h2 {
                font-size: 1.5rem;
                font-weight: 700;
                color: white;
                margin-bottom: 0.6rem;
                line-height: 1.3;
            }

            .auth-brand-panel h2 span {
                color: rgba(255, 255, 255, 0.9);
            }

            .auth-brand-panel>.brand-inner>p {
                color: rgba(255, 255, 255, 0.7);
                font-size: 0.9rem;
                line-height: 1.5;
                margin-bottom: 1.5rem;
            }

            .brand-features {
                display: flex;
                flex-direction: column;
                gap: 0.75rem;
            }

            .brand-feat-item {
                display: flex;
                align-items: center;
                gap: 10px;
                color: rgba(255, 255, 255, 0.85);
                font-size: 0.85rem;
                font-weight: 500;
            }

            .brand-feat-item i {
                color: rgba(255, 255, 255, 0.6);
                font-size: 0.8rem;
            }

            .auth-form-panel {
                padding: 2.5rem;
                display: flex;
                align-items: flex-start;
                justify-content: center;
                overflow-y: auto;
                max-height: calc(100vh - 140px);
            }

            .auth-form-inner-wide {
                width: 100%;
                max-width: 560px;
            }

            .auth-form-header {
                margin-bottom: 1.25rem;
            }

            .auth-form-header h1 {
                font-size: 1.5rem;
                font-weight: 700;
                color: var(--text-primary);
                margin-bottom: 0.3rem;
            }

            .auth-form-header p {
                color: var(--text-muted);
                font-size: 0.85rem;
            }

            .auth-form-grid {
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 0.75rem 1rem;
            }

            .auth-field-full {
                grid-column: 1 / -1;
            }

            .req {
                color: var(--danger-color, #D94F4F);
            }

            .auth-field {
                margin-bottom: 0;
            }

            .auth-field label {
                display: block;
                font-size: 0.8rem;
                font-weight: 600;
                color: var(--text-primary);
                margin-bottom: 0.3rem;
            }

            .auth-input-wrap {
                display: flex;
                align-items: center;
                gap: 8px;
                background: var(--bg-light);
                border: 1.5px solid var(--border-color);
                border-radius: 10px;
                padding: 0 0.85rem;
                transition: all 0.25s;
            }

            .auth-input-wrap:focus-within {
                border-color: var(--primary-color);
                box-shadow: 0 0 0 3px rgba(199, 91, 63, 0.08);
            }

            .auth-input-wrap i {
                color: var(--text-muted);
                font-size: 0.85rem;
                flex-shrink: 0;
            }

            .auth-input-wrap input,
            .auth-input-wrap select {
                flex: 1;
                border: none;
                background: transparent;
                padding: 0.65rem 0;
                font-size: 0.9rem;
                color: var(--text-primary);
                outline: none;
                font-family: inherit;
            }

            .auth-input-wrap input::placeholder {
                color: var(--text-muted);
            }

            .auth-select-wrap select {
                cursor: pointer;
                appearance: none;
            }

            .toggle-pw {
                background: transparent;
                border: none;
                cursor: pointer;
                color: var(--text-muted);
                padding: 0.3rem;
                font-size: 0.85rem;
                transition: color 0.2s;
            }

            .toggle-pw:hover {
                color: var(--primary-color);
            }

            .auth-error {
                display: block;
                font-size: 0.75rem;
                color: var(--danger-color);
                margin-top: 0.25rem;
                font-weight: 500;
            }

            /* ==================== FILE UPLOAD ==================== */
            .auth-file-wrap {
                position: relative;
                border: 1.5px dashed var(--border-color);
                border-radius: 10px;
                background: var(--bg-light);
                transition: all 0.25s;
                overflow: hidden;
            }

            .auth-file-wrap:hover {
                border-color: var(--primary-color);
                background: rgba(199, 91, 63, 0.04);
            }

            .auth-file-wrap.is-invalid-file {
                border-color: var(--danger-color);
            }

            .auth-file-label {
                display: flex;
                align-items: center;
                gap: 8px;
                padding: 0.6rem 0.85rem;
                cursor: pointer;
                font-size: 0.85rem;
                color: var(--text-muted);
                font-weight: 500;
                width: 100%;
                margin: 0;
            }

            .auth-file-label i {
                color: var(--text-muted);
                font-size: 0.9rem;
                flex-shrink: 0;
                width: 18px;
                text-align: center;
            }

            .auth-file-input {
                position: absolute;
                inset: 0;
                width: 100%;
                height: 100%;
                opacity: 0;
                cursor: pointer;
            }

            .auth-submit {
                width: 100%;
                padding: 0.8rem;
                border: none;
                border-radius: 12px;
                background: linear-gradient(135deg, #C75B3F, #A8472E);
                color: white;
                font-size: 0.95rem;
                font-weight: 600;
                cursor: pointer;
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 8px;
                transition: all 0.3s;
                box-shadow: 0 4px 15px rgba(199, 91, 63, 0.25);
                font-family: inherit;
                margin-top: 1.25rem;
            }

            .auth-submit:hover {
                transform: translateY(-2px);
                box-shadow: 0 8px 25px rgba(199, 91, 63, 0.35);
            }

            .auth-submit:disabled {
                opacity: 0.7;
                transform: none;
                cursor: not-allowed;
            }

            .auth-submit i {
                transition: transform 0.3s;
            }

            .auth-submit:hover i {
                transform: translateX(3px);
            }

            .auth-footer {
                text-align: center;
                margin-top: 1.25rem;
                font-size: 0.85rem;
                color: var(--text-secondary);
            }

            .auth-footer a {
                color: var(--primary-color);
                font-weight: 600;
                text-decoration: none;
                transition: opacity 0.2s;
            }

            .auth-footer a:hover {
                opacity: 0.8;
            }

            @media (max-width:768px) {
                .auth-wrapper {
                    grid-template-columns: 1fr;
                }

                .auth-brand-panel {
                    display: none;
                }

                .auth-page {
                    padding: 1rem;
                }

                .auth-form-grid {
                    grid-template-columns: 1fr;
                }
            }
        </style>
    </x-slot:styles>
</div>

<script>
    function togglePassword(inputId, iconId) {
        const input = document.getElementById(inputId);
        const icon = document.getElementById(iconId);
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.replace('fa-eye', 'fa-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.replace('fa-eye-slash', 'fa-eye');
        }
    }
</script>