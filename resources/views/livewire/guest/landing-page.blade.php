<div>
    <!-- Hero Section -->
    <section class="hero" id="beranda">
        <div class="hero-bg">
            <div class="hero-shape shape-1"></div>
            <div class="hero-shape shape-2"></div>
            <div class="hero-shape shape-3"></div>
        </div>
        <div class="container hero-container">
            <div class="hero-content">
                <span class="hero-badge">
                    <i class="fas fa-home"></i>
                    Sistem Terpadu
                </span>
                <h1 class="hero-title">
                    Sistem Informasi
                    <span class="gradient-text">Rukun Warga</span> & Perumahan
                </h1>
                <p class="hero-description">
                    Kelola data warga, pendataan unit rumah, dan pengajuan hunian dengan lebih transparan, mudah, dan
                    efisien dalam satu platform terintegrasi.
                </p>
                <div class="hero-actions">
                    <a href="{{ route('login') }}" class="btn btn-primary btn-lg">
                        <i class="fas fa-sign-in-alt"></i>
                        Masuk Sistem
                    </a>
                    <a href="#layanan" class="btn btn-outline btn-lg">
                        <i class="fas fa-info-circle"></i>
                        Pelajari Lebih Lanjut
                    </a>
                </div>
            </div>
            <div class="hero-image">
                <div class="dashboard-preview">
                    <div class="preview-header">
                        <div class="preview-dots">
                            <span class="dot red"></span>
                            <span class="dot yellow"></span>
                            <span class="dot green"></span>
                        </div>
                    </div>
                    <div class="preview-content">
                        <div class="preview-sidebar">
                            <div class="sidebar-item active"></div>
                            <div class="sidebar-item"></div>
                            <div class="sidebar-item"></div>
                            <div class="sidebar-item"></div>
                        </div>
                        <div class="preview-main">
                            <div class="preview-cards">
                                <div class="preview-card card-1"></div>
                                <div class="preview-card card-2"></div>
                                <div class="preview-card card-3"></div>
                            </div>
                            <div class="preview-chart"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="section pt-0" id="statistik">
        <div class="container">
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon" style="background: linear-gradient(135deg, #6366f1, #8b5cf6);">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stat-info">
                        <h3 class="stat-number">{{ number_format($stats['total_warga']) }}</h3>
                        <p class="stat-label">Total Warga</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon" style="background: linear-gradient(135deg, #0ea5e9, #06b6d4);">
                        <i class="fas fa-building"></i>
                    </div>
                    <div class="stat-info">
                        <h3 class="stat-number">{{ number_format($stats['total_unit']) }}</h3>
                        <p class="stat-label">Total Unit Rumah</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon" style="background: linear-gradient(135deg, #10b981, #34d399);">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="stat-info">
                        <h3 class="stat-number">{{ number_format($stats['unit_tersedia']) }}</h3>
                        <p class="stat-label">Unit Tersedia</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon" style="background: linear-gradient(135deg, #f59e0b, #fbbf24);">
                        <i class="fas fa-file-signature"></i>
                    </div>
                    <div class="stat-info">
                        <h3 class="stat-number">{{ number_format($stats['pengajuan_disetujui']) }}</h3>
                        <p class="stat-label">Pengajuan Disetujui</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="section features-section" id="layanan">
        <div class="container">
            <div class="section-header">
                <span class="section-badge">Layanan Utama</span>
                <h2 class="section-title">Solusi Terpadu Pengelolaan Perumahan</h2>
                <p class="section-description">
                    Semua fitur yang Anda butuhkan untuk manajemen rukun warga dan pendataan properti.
                </p>
            </div>
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon" style="background: linear-gradient(135deg, #6366f1, #8b5cf6);">
                        <i class="fas fa-address-card"></i>
                    </div>
                    <h3>Manajemen Warga</h3>
                    <p>Pendataan warga yang valid terintegrasi dengan NIK dan Kartu Keluarga memudahkan identifikasi
                        demografi perumahan.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon" style="background: linear-gradient(135deg, #0ea5e9, #06b6d4);">
                        <i class="fas fa-city"></i>
                    </div>
                    <h3>Inventori Unit Rumah</h3>
                    <p>Pemantauan real-time ketersediaan dan status setiap blok serta nomor rumah yang ada pada
                        perumahan.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon" style="background: linear-gradient(135deg, #10b981, #34d399);">
                        <i class="fas fa-file-contract"></i>
                    </div>
                    <h3>Pengajuan Hunian</h3>
                    <p>Sistem pengajuan otomatis bagi warga yang ingin menempati atau menyewa unit, disertai tracking
                        status approval.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon" style="background: linear-gradient(135deg, #f59e0b, #fbbf24);">
                        <i class="fas fa-house-user"></i>
                    </div>
                    <h3>Riwayat Penempatan</h3>
                    <p>Mencatat secara historis penempatan unit oleh masing-masing kepala keluarga dengan rekam jejak
                        yang jelas.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon" style="background: linear-gradient(135deg, #ef4444, #f87171);">
                        <i class="fas fa-lock"></i>
                    </div>
                    <h3>Keamanan Data</h3>
                    <p>Dibangun menggunakan framework terbaru dengan keamanan tingkat tinggi yang memastikan privasi
                        dari setiap warga.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon" style="background: linear-gradient(135deg, #8b5cf6, #a78bfa);">
                        <i class="fas fa-mobile-alt"></i>
                    </div>
                    <h3>Akses Responsif</h3>
                    <p>Desain aplikasi yang ramah digunakan di semua perangkat. Mudah diakses melalui Smartphone maupun
                        Desktop.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="section cta-section">
        <div class="container">
            <div class="cta-card">
                <div class="cta-content">
                    <h2>Siap Bergabung dengan SIRUKUN?</h2>
                    <p>Optimalkan pengelolaan rukun warga dan perumahan Anda mulai hari ini juga.</p>
                    <div class="cta-actions">
                        <a href="{{ route('login') }}" class="btn btn-white btn-lg">
                            <i class="fas fa-sign-in-alt"></i>
                            Masuk Sekarang
                        </a>
                    </div>
                </div>
                <div class="cta-decoration">
                    <div class="decoration-circle"></div>
                    <div class="decoration-circle small"></div>
                </div>
            </div>
        </div>
    </section>

    <x-slot:styles>
        <style>
            /* Hero Section */
            .hero {
                min-height: 90vh;
                display: flex;
                align-items: center;
                position: relative;
                overflow: hidden;
                padding-top: 100px;
                padding-bottom: 50px;
            }

            .hero-bg {
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                z-index: 0;
            }

            .hero-shape {
                position: absolute;
                border-radius: 50%;
                animation: float 20s ease-in-out infinite;
            }

            .shape-1 {
                width: 600px;
                height: 600px;
                background: linear-gradient(135deg, rgba(99, 102, 241, 0.1), rgba(139, 92, 246, 0.1));
                top: -200px;
                right: -200px;
            }

            .shape-2 {
                width: 400px;
                height: 400px;
                background: linear-gradient(135deg, rgba(14, 165, 233, 0.1), rgba(6, 182, 212, 0.1));
                bottom: -100px;
                left: -100px;
                animation-delay: -7s;
            }

            .shape-3 {
                width: 300px;
                height: 300px;
                background: linear-gradient(135deg, rgba(16, 185, 129, 0.1), rgba(52, 211, 153, 0.1));
                top: 50%;
                left: 30%;
                animation-delay: -14s;
            }

            @keyframes float {

                0%,
                100% {
                    transform: translateY(0) rotate(0deg);
                }

                33% {
                    transform: translateY(-30px) rotate(5deg);
                }

                66% {
                    transform: translateY(20px) rotate(-5deg);
                }
            }

            .hero-container {
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 4rem;
                align-items: center;
                position: relative;
                z-index: 1;
            }

            .hero-badge {
                display: inline-flex;
                align-items: center;
                gap: 8px;
                background: linear-gradient(135deg, rgba(99, 102, 241, 0.1), rgba(139, 92, 246, 0.1));
                color: var(--primary-color);
                padding: 0.5rem 1rem;
                border-radius: 50px;
                font-size: 0.9rem;
                font-weight: 600;
                margin-bottom: 1.5rem;
                border: 1px solid rgba(99, 102, 241, 0.2);
            }

            .hero-title {
                font-size: 3.5rem;
                font-weight: 800;
                line-height: 1.1;
                margin-bottom: 1.5rem;
            }

            .gradient-text {
                background: linear-gradient(135deg, var(--primary-color), #8b5cf6);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                background-clip: text;
            }

            .hero-description {
                font-size: 1.25rem;
                color: var(--text-secondary);
                margin-bottom: 2rem;
                line-height: 1.7;
            }

            .hero-actions {
                display: flex;
                gap: 1rem;
                margin-bottom: 3rem;
            }

            /* Dashboard Preview styles (same as before) */
            .dashboard-preview {
                background: var(--bg-white);
                border-radius: 20px;
                box-shadow: 0 25px 80px rgba(0, 0, 0, 0.15);
                overflow: hidden;
                border: 1px solid var(--border-color);
            }

            .preview-header {
                background: linear-gradient(135deg, #1e293b, #334155);
                padding: 1rem 1.5rem;
            }

            .preview-dots {
                display: flex;
                gap: 8px;
            }

            .dot {
                width: 12px;
                height: 12px;
                border-radius: 50%;
            }

            .dot.red {
                background: #ef4444;
            }

            .dot.yellow {
                background: #f59e0b;
            }

            .dot.green {
                background: #10b981;
            }

            .preview-content {
                display: flex;
                min-height: 300px;
            }

            .preview-sidebar {
                width: 60px;
                background: #1e293b;
                padding: 1rem;
                display: flex;
                flex-direction: column;
                gap: 0.75rem;
            }

            .sidebar-item {
                height: 8px;
                background: #334155;
                border-radius: 4px;
            }

            .sidebar-item.active {
                background: var(--primary-color);
            }

            .preview-main {
                flex: 1;
                padding: 1.5rem;
                background: #f8fafc;
            }

            [data-theme="dark"] .preview-main {
                background: #0f172a;
            }

            .preview-cards {
                display: grid;
                grid-template-columns: repeat(3, 1fr);
                gap: 1rem;
                margin-bottom: 1.5rem;
            }

            .preview-card {
                height: 60px;
                border-radius: 10px;
            }

            .card-1 {
                background: linear-gradient(135deg, #6366f1, #8b5cf6);
            }

            .card-2 {
                background: linear-gradient(135deg, #0ea5e9, #06b6d4);
            }

            .card-3 {
                background: linear-gradient(135deg, #10b981, #34d399);
            }

            .preview-chart {
                height: 120px;
                background: var(--bg-white);
                border-radius: 10px;
                border: 1px solid var(--border-color);
            }

            /* Stats Grid */
            .stats-grid {
                display: grid;
                grid-template-columns: repeat(4, 1fr);
                gap: 1.5rem;
                position: relative;
                z-index: 10;
                margin-top: -2rem;
            }

            .stat-card {
                background: var(--bg-white);
                padding: 1.5rem;
                border-radius: 16px;
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
                border: 1px solid var(--border-color);
                display: flex;
                align-items: center;
                gap: 1.2rem;
                transition: transform 0.3s ease;
            }

            .stat-card:hover {
                transform: translateY(-5px);
            }

            .stat-icon {
                width: 50px;
                height: 50px;
                border-radius: 12px;
                display: flex;
                align-items: center;
                justify-content: center;
                color: white;
                font-size: 1.3rem;
                flex-shrink: 0;
            }

            .stat-info {
                display: flex;
                flex-direction: column;
            }

            .stat-number {
                font-size: 1.5rem;
                font-weight: 700;
                color: var(--text-primary);
                line-height: 1.2;
            }

            .stat-label {
                font-size: 0.85rem;
                color: var(--text-secondary);
                margin: 0;
            }

            /* Section Header */
            .section-header {
                text-align: center;
                max-width: 700px;
                margin: 0 auto 4rem;
            }

            .section-badge {
                display: inline-block;
                background: linear-gradient(135deg, rgba(99, 102, 241, 0.1), rgba(139, 92, 246, 0.1));
                color: var(--primary-color);
                padding: 0.5rem 1.25rem;
                border-radius: 50px;
                font-size: 0.85rem;
                font-weight: 600;
                margin-bottom: 1rem;
                text-transform: uppercase;
                letter-spacing: 1px;
            }

            .section-title {
                font-size: 2.5rem;
                font-weight: 700;
                margin-bottom: 1rem;
            }

            .section-description {
                font-size: 1.15rem;
                color: var(--text-secondary);
            }

            /* Features Grid */
            .features-section {
                background: var(--bg-light);
            }

            .features-grid {
                display: grid;
                grid-template-columns: repeat(3, 1fr);
                gap: 2rem;
            }

            .feature-card {
                background: var(--bg-white);
                padding: 2.5rem;
                border-radius: 16px;
                transition: all 0.3s ease;
                border: 1px solid var(--border-color);
            }

            .feature-card:hover {
                transform: translateY(-5px);
                box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            }

            .feature-icon {
                width: 60px;
                height: 60px;
                border-radius: 14px;
                display: flex;
                align-items: center;
                justify-content: center;
                margin-bottom: 1.5rem;
            }

            .feature-icon i {
                font-size: 1.5rem;
                color: white;
            }

            .feature-card h3 {
                font-size: 1.25rem;
                font-weight: 600;
                margin-bottom: 0.75rem;
                color: var(--text-primary);
            }

            .feature-card p {
                color: var(--text-secondary);
                font-size: 0.95rem;
                line-height: 1.6;
            }

            /* CTA Section */
            .cta-section {
                background: var(--bg-white);
                padding-bottom: 8rem;
            }

            .cta-card {
                background: linear-gradient(135deg, #6366f1, #8b5cf6);
                border-radius: 24px;
                padding: 4rem;
                position: relative;
                overflow: hidden;
            }

            .cta-content {
                position: relative;
                z-index: 1;
                text-align: center;
                max-width: 600px;
                margin: 0 auto;
            }

            .cta-content h2 {
                font-size: 2.5rem;
                font-weight: 700;
                color: white;
                margin-bottom: 1rem;
            }

            .cta-content p {
                font-size: 1.15rem;
                color: rgba(255, 255, 255, 0.8);
                margin-bottom: 2rem;
            }

            .cta-actions {
                display: flex;
                justify-content: center;
                gap: 1rem;
            }

            .btn-white {
                background: white;
                color: #6366f1;
            }

            .btn-white:hover {
                background: #f8fafc;
                transform: translateY(-2px);
                box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            }

            .cta-decoration {
                position: absolute;
                top: 0;
                right: 0;
                bottom: 0;
                width: 50%;
            }

            .decoration-circle {
                position: absolute;
                border-radius: 50%;
                background: rgba(255, 255, 255, 0.1);
            }

            .decoration-circle:first-child {
                width: 400px;
                height: 400px;
                right: -100px;
                top: -100px;
            }

            .decoration-circle.small {
                width: 200px;
                height: 200px;
                right: 50px;
                bottom: -50px;
            }

            /* Responsive */
            @media (max-width: 1024px) {
                .hero-container {
                    grid-template-columns: 1fr;
                    text-align: center;
                }

                .hero-actions {
                    justify-content: center;
                }

                .hero-image {
                    max-width: 600px;
                    margin: 0 auto;
                }

                .stats-grid {
                    grid-template-columns: repeat(2, 1fr);
                }

                .features-grid {
                    grid-template-columns: repeat(2, 1fr);
                }
            }

            @media (max-width: 768px) {
                .hero-title {
                    font-size: 2.5rem;
                }

                .stats-grid {
                    grid-template-columns: 1fr;
                }

                .features-grid {
                    grid-template-columns: 1fr;
                }

                .cta-card {
                    padding: 3rem 2rem;
                }

                .cta-content h2 {
                    font-size: 2rem;
                }
            }
        </style>
    </x-slot:styles>
</div>
