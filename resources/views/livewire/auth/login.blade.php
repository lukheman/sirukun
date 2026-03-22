<div class="auth-page">
    <div class="auth-particles">
        <span class="auth-particle ap1"></span>
        <span class="auth-particle ap2"></span>
        <span class="auth-particle ap3"></span>
    </div>

    <div class="auth-wrapper">
        <!-- Left Panel - Branding -->
        <div class="auth-brand-panel">
            <div class="brand-inner">
                <div class="brand-icon-wrap">
                    <i class="fas fa-home"></i>
                </div>
                <h2>Selamat Datang di <span>SIRUKUN</span></h2>
                <p>Sistem Informasi Rukun Warga & Perumahan untuk pengelolaan data warga yang lebih baik dan
                    terintegrasi.</p>
                <div class="brand-features">
                    <div class="brand-feat-item">
                        <i class="fas fa-check-circle"></i>
                        <span>Pengelolaan Data Warga</span>
                    </div>
                    <div class="brand-feat-item">
                        <i class="fas fa-check-circle"></i>
                        <span>Inventori Unit Rumah</span>
                    </div>
                    <div class="brand-feat-item">
                        <i class="fas fa-check-circle"></i>
                        <span>Pengajuan Hunian Online</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Panel - Form -->
        <div class="auth-form-panel">
            <div class="auth-form-inner">
                <div class="auth-form-header">
                    <h1>Masuk</h1>
                    <p>Pilih jenis akun dan masukkan kredensial Anda</p>
                </div>

                <!-- Role Tabs -->
                <div class="auth-role-tabs">
                    <button type="button" class="auth-role-tab {{ $role === 'admin' ? 'active' : '' }}"
                        wire:click="$set('role', 'admin')">
                        <i class="fas fa-user-shield"></i>
                        Admin
                    </button>
                    <button type="button" class="auth-role-tab {{ $role === 'warga' ? 'active' : '' }}"
                        wire:click="$set('role', 'warga')">
                        <i class="fas fa-users"></i>
                        Warga
                    </button>
                    <button type="button" class="auth-role-tab {{ $role === 'pimpinan' ? 'active' : '' }}"
                        wire:click="$set('role', 'pimpinan')">
                        <i class="fas fa-user-tie"></i>
                        Pimpinan
                    </button>
                </div>

                <form wire:submit="submit">
                    @if($role === 'admin')
                        <!-- Username (Admin) -->
                        <div class="auth-field">
                            <label for="admin">Username</label>
                            <div class="auth-input-wrap">
                                <i class="fas fa-user"></i>
                                <input type="text" wire:model="admin" class="@error('admin') is-invalid @enderror"
                                    id="admin" placeholder="Masukkan username" autofocus>
                            </div>
                            @error('admin')
                                <span class="auth-error">{{ $message }}</span>
                            @enderror
                        </div>
                    @elseif($role === 'warga')
                        <!-- NIK (Warga) -->
                        <div class="auth-field">
                            <label for="nik">Nomor Induk Kependudukan (NIK)</label>
                            <div class="auth-input-wrap">
                                <i class="fas fa-id-card"></i>
                                <input type="text" wire:model="nik" class="@error('nik') is-invalid @enderror" id="nik"
                                    placeholder="Masukkan 16 digit NIK" autofocus>
                            </div>
                            @error('nik')
                                <span class="auth-error">{{ $message }}</span>
                            @enderror
                        </div>
                    @elseif($role === 'pimpinan')
                        <!-- Email (Pimpinan) -->
                        <div class="auth-field">
                            <label for="email">Email</label>
                            <div class="auth-input-wrap">
                                <i class="fas fa-envelope"></i>
                                <input type="email" wire:model="email" class="@error('email') is-invalid @enderror"
                                    id="email" placeholder="Masukkan alamat email" autofocus>
                            </div>
                            @error('email')
                                <span class="auth-error">{{ $message }}</span>
                            @enderror
                        </div>
                    @endif

                    <!-- Password -->
                    <div class="auth-field">
                        <label for="password">Kata Sandi</label>
                        <div class="auth-input-wrap">
                            <i class="fas fa-lock"></i>
                            <input type="password" wire:model="password" class="@error('password') is-invalid @enderror"
                                id="password" placeholder="••••••••">
                            <button type="button" class="toggle-pw" onclick="togglePassword()">
                                <i class="fas fa-eye" id="toggleIcon"></i>
                            </button>
                        </div>
                        @error('password')
                            <span class="auth-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Remember -->
                    <div class="auth-options">
                        <label class="auth-checkbox">
                            <input type="checkbox" wire:model="remember" id="remember">
                            <span class="checkmark"></span>
                            Ingat saya
                        </label>
                    </div>

                    <!-- Submit -->
                    <button type="submit" class="auth-submit" wire:loading.attr="disabled">
                        <span wire:loading.remove>
                            Masuk
                            <i class="fas fa-arrow-right"></i>
                        </span>
                        <span wire:loading>
                            <i class="fas fa-spinner fa-spin"></i> Memproses...
                        </span>
                    </button>
                </form>

                <div class="auth-footer">
                    Belum punya akun? <a href="{{ route('register') }}" wire:navigate>Daftar Sekarang</a>
                </div>
            </div>
        </div>
    </div>

    <x-slot:styles>
        <style>
            /* Hide default footer on auth pages */
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
                grid-template-columns: 1fr 1fr;
                max-width: 950px;
                width: 100%;
                background: var(--bg-white);
                border-radius: 28px;
                box-shadow: 0 25px 80px rgba(0, 0, 0, 0.08);
                border: 1px solid var(--border-color);
                overflow: hidden;
                position: relative;
                z-index: 1;
            }

            /* Brand Panel */
            .auth-brand-panel {
                background: linear-gradient(160deg, #C75B3F 0%, #A8472E 60%, #8B3A24 100%);
                padding: 3rem;
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
                width: 60px;
                height: 60px;
                border-radius: 18px;
                background: rgba(255, 255, 255, 0.15);
                backdrop-filter: blur(10px);
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 1.5rem;
                color: white;
                margin-bottom: 1.5rem;
            }

            .auth-brand-panel h2 {
                font-size: 1.75rem;
                font-weight: 700;
                color: white;
                margin-bottom: 0.75rem;
                line-height: 1.3;
            }

            .auth-brand-panel h2 span {
                color: rgba(255, 255, 255, 0.9);
            }

            .auth-brand-panel>.brand-inner>p {
                color: rgba(255, 255, 255, 0.7);
                font-size: 0.95rem;
                line-height: 1.6;
                margin-bottom: 2rem;
            }

            .brand-features {
                display: flex;
                flex-direction: column;
                gap: 0.85rem;
            }

            .brand-feat-item {
                display: flex;
                align-items: center;
                gap: 10px;
                color: rgba(255, 255, 255, 0.85);
                font-size: 0.9rem;
                font-weight: 500;
            }

            .brand-feat-item i {
                color: rgba(255, 255, 255, 0.6);
                font-size: 0.85rem;
            }

            /* Form Panel */
            .auth-form-panel {
                padding: 3rem;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .auth-form-inner {
                width: 100%;
                max-width: 380px;
            }

            .auth-form-header {
                margin-bottom: 1.5rem;
            }

            .auth-form-header h1 {
                font-size: 1.75rem;
                font-weight: 700;
                color: var(--text-primary);
                margin-bottom: 0.4rem;
            }

            .auth-form-header p {
                color: var(--text-muted);
                font-size: 0.9rem;
            }

            /* Role Tabs */
            .auth-role-tabs {
                display: grid;
                grid-template-columns: 1fr 1fr 1fr;
                gap: 0.5rem;
                margin-bottom: 1.5rem;
                background: var(--bg-light, #f5f0e8);
                border-radius: 14px;
                padding: 0.35rem;
                border: 1px solid var(--border-color, #E8DFD3);
            }

            .auth-role-tab {
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 8px;
                padding: 0.7rem 1rem;
                border: none;
                border-radius: 11px;
                font-size: 0.9rem;
                font-weight: 600;
                cursor: pointer;
                transition: all 0.25s ease;
                background: transparent;
                color: var(--text-muted, #A89F93);
                font-family: inherit;
            }

            .auth-role-tab:hover {
                color: var(--text-primary, #3D2C1E);
                background: rgba(255, 255, 255, 0.5);
            }

            .auth-role-tab.active {
                background: white;
                color: var(--primary-color, #C75B3F);
                box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
            }

            .auth-role-tab i {
                font-size: 0.85rem;
            }

            .auth-field {
                margin-bottom: 1.25rem;
            }

            .auth-field label {
                display: block;
                font-size: 0.85rem;
                font-weight: 600;
                color: var(--text-primary);
                margin-bottom: 0.4rem;
            }

            .auth-input-wrap {
                display: flex;
                align-items: center;
                gap: 10px;
                background: var(--bg-light);
                border: 1.5px solid var(--border-color);
                border-radius: 12px;
                padding: 0 1rem;
                transition: all 0.25s;
            }

            .auth-input-wrap:focus-within {
                border-color: var(--primary-color);
                box-shadow: 0 0 0 3px rgba(199, 91, 63, 0.08);
            }

            .auth-input-wrap i {
                color: var(--text-muted);
                font-size: 0.9rem;
                flex-shrink: 0;
            }

            .auth-input-wrap input {
                flex: 1;
                border: none;
                background: transparent;
                padding: 0.8rem 0;
                font-size: 0.95rem;
                color: var(--text-primary);
                outline: none;
                font-family: inherit;
            }

            .auth-input-wrap input::placeholder {
                color: var(--text-muted);
            }

            .auth-input-wrap input.is-invalid~.toggle-pw,
            .auth-input-wrap:has(.is-invalid) {
                border-color: var(--danger-color);
            }

            .toggle-pw {
                background: transparent;
                border: none;
                cursor: pointer;
                color: var(--text-muted);
                padding: 0.3rem;
                font-size: 0.9rem;
                transition: color 0.2s;
            }

            .toggle-pw:hover {
                color: var(--primary-color);
            }

            .auth-error {
                display: block;
                font-size: 0.8rem;
                color: var(--danger-color);
                margin-top: 0.35rem;
                font-weight: 500;
            }

            .auth-options {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 1.75rem;
            }

            .auth-checkbox {
                display: flex;
                align-items: center;
                gap: 8px;
                font-size: 0.85rem;
                color: var(--text-secondary);
                cursor: pointer;
                position: relative;
                padding-left: 26px;
            }

            .auth-checkbox input {
                position: absolute;
                opacity: 0;
                cursor: pointer;
            }

            .checkmark {
                position: absolute;
                left: 0;
                top: 50%;
                transform: translateY(-50%);
                width: 18px;
                height: 18px;
                border-radius: 5px;
                border: 1.5px solid var(--border-color);
                background: var(--bg-light);
                transition: all 0.2s;
            }

            .auth-checkbox input:checked~.checkmark {
                background: var(--primary-color);
                border-color: var(--primary-color);
            }

            .auth-checkbox input:checked~.checkmark::after {
                content: '';
                position: absolute;
                left: 5px;
                top: 2px;
                width: 5px;
                height: 9px;
                border: solid white;
                border-width: 0 2px 2px 0;
                transform: rotate(45deg);
            }

            .auth-submit {
                width: 100%;
                padding: 0.85rem;
                border: none;
                border-radius: 12px;
                background: linear-gradient(135deg, #C75B3F, #A8472E);
                color: white;
                font-size: 1rem;
                font-weight: 600;
                cursor: pointer;
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 8px;
                transition: all 0.3s;
                box-shadow: 0 4px 15px rgba(199, 91, 63, 0.25);
                font-family: inherit;
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

            /* Responsive */
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
            }
        </style>
    </x-slot:styles>
</div>

<script>
    function togglePassword() {
        const input = document.getElementById('password');
        const icon = document.getElementById('toggleIcon');
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.replace('fa-eye', 'fa-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.replace('fa-eye-slash', 'fa-eye');
        }
    }
</script>