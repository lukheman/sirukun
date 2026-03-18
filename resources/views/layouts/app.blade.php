@props([
    'title' => 'Sirukun Dashboard',
    'brandName' => 'Sirukun',
    'brandIcon' => 'fas fa-leaf'
])

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @livewireStyles
    <style>
        :root {
            --sidebar-width: 260px;
            --topbar-height: 70px;
            --primary-color: #C75B3F;
            --primary-dark: #A8472E;
            --primary-light: #E07A5F;
            --secondary-color: #6B8E5A;
            --success-color: #5BA87C;
            --warning-color: #D4943A;
            --danger-color: #D94F4F;
            --card-shadow: 0 2px 12px rgba(0,0,0,0.06);

            --bg-primary: #F5F0E8;
            --bg-secondary: #ffffff;
            --bg-tertiary: #FDF8F3;
            --text-primary: #3D2C1E;
            --text-secondary: #7A6B5D;
            --text-muted: #A89F93;
            --border-color: #E8DFD3;
            --border-light: #F0EAE0;
            --input-bg: #FBF7F2;
            --hover-bg: #FAF5EE;
            --sidebar-bg: #FDF5ED;
            --sidebar-active-bg: #C75B3F;
            --sidebar-hover-bg: rgba(199, 91, 63, 0.08);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: var(--bg-primary);
            color: var(--text-primary);
        }

        /* ==================== SCROLLBAR ==================== */
        ::-webkit-scrollbar {
            width: 6px;
        }
        ::-webkit-scrollbar-track {
            background: transparent;
        }
        ::-webkit-scrollbar-thumb {
            background: var(--border-color);
            border-radius: 10px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: var(--text-muted);
        }

        /* ==================== SIDEBAR ==================== */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: var(--sidebar-width);
            background: var(--sidebar-bg);
            border-right: 1px solid var(--border-color);
            transition: all 0.3s;
            z-index: 1000;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
        }

        .sidebar-brand {
            padding: 1.5rem 1.25rem;
            font-size: 1.35rem;
            font-weight: 700;
            color: var(--primary-color);
            border-bottom: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            gap: 10px;
            letter-spacing: -0.5px;
        }

        .sidebar-brand i {
            font-size: 1.5rem;
            color: var(--secondary-color);
        }

        .sidebar-menu {
            padding: 1rem 0;
            flex: 1;
        }

        .menu-section-title {
            padding: 0.75rem 1.25rem 0.35rem;
            font-size: 0.7rem;
            font-weight: 600;
            text-transform: uppercase;
            color: var(--text-muted);
            letter-spacing: 1px;
        }

        .sidebar-menu a {
            display: flex;
            align-items: center;
            padding: 0.7rem 1.25rem;
            color: var(--text-secondary);
            text-decoration: none;
            transition: all 0.2s ease;
            margin: 0.15rem 0.75rem;
            border-radius: 10px;
            font-weight: 500;
            font-size: 0.9rem;
        }

        .sidebar-menu a:hover {
            background: var(--sidebar-hover-bg);
            color: var(--primary-color);
        }

        .sidebar-menu a.active {
            background: var(--sidebar-active-bg);
            color: white;
            box-shadow: 0 4px 12px rgba(199, 91, 63, 0.3);
        }

        .sidebar-menu a i {
            width: 22px;
            margin-right: 10px;
            font-size: 1rem;
            text-align: center;
        }

        /* ==================== MAIN CONTENT ==================== */
        .main-content {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            background: var(--bg-primary);
        }

        /* ==================== TOPBAR ==================== */
        .topbar {
            background: var(--bg-secondary);
            height: var(--topbar-height);
            box-shadow: 0 1px 4px rgba(0,0,0,0.04);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 2rem;
            position: sticky;
            top: 0;
            z-index: 999;
            border-bottom: 1px solid var(--border-light);
        }

        .topbar .search-wrapper {
            position: relative;
            max-width: 360px;
        }

        .topbar .search-wrapper .search-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            font-size: 0.9rem;
        }

        .topbar .search-wrapper input {
            background: var(--input-bg);
            border: 1px solid var(--border-color);
            color: var(--text-primary);
            border-radius: 50px;
            padding: 0.6rem 1rem 0.6rem 2.5rem;
            font-size: 0.875rem;
            width: 300px;
            transition: all 0.2s;
        }

        .topbar .search-wrapper input:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(199, 91, 63, 0.08);
            outline: none;
        }

        .topbar .search-wrapper input::placeholder {
            color: var(--text-muted);
        }

        .topbar .form-control {
            background: var(--input-bg);
            border-color: var(--border-color);
            color: var(--text-primary);
        }

        .topbar .form-control::placeholder {
            color: var(--text-muted);
        }

        .topbar .input-group-text {
            background: var(--input-bg);
            border-color: var(--border-color);
        }

        /* ==================== CONTENT AREA ==================== */
        .content-area {
            padding: 1.75rem 2rem;
        }

        /* ==================== CARDS ==================== */
        .modern-card {
            background: var(--bg-secondary);
            border-radius: 20px;
            padding: 1.75rem;
            box-shadow: var(--card-shadow);
            transition: all 0.3s ease;
            border: 1px solid var(--border-light);
        }

        .modern-card:hover {
            box-shadow: 0 8px 24px rgba(0,0,0,0.08);
            transform: translateY(-2px);
        }

        /* ==================== STAT CARDS ==================== */
        .stat-card {
            background: var(--bg-secondary);
            border-radius: 20px;
            padding: 1.5rem;
            box-shadow: var(--card-shadow);
            transition: all 0.3s;
            border: 1px solid var(--border-light);
            position: relative;
            overflow: hidden;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            background: var(--accent-color);
            border-radius: 4px 0 0 4px;
        }

        .stat-card:hover {
            box-shadow: 0 8px 24px rgba(0,0,0,0.08);
            transform: translateY(-3px);
        }

        .stat-icon {
            width: 52px;
            height: 52px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.35rem;
            margin-bottom: 0.85rem;
        }

        /* ==================== USER AVATAR ==================== */
        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--primary-color);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 0.875rem;
        }

        /* ==================== BADGES ==================== */
        .badge-modern {
            padding: 0.4rem 0.85rem;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        /* ==================== PREVIEW ==================== */
        .preview-title {
            font-size: 1.05rem;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 1.25rem;
            padding-bottom: 0.75rem;
            border-bottom: 2px solid var(--border-light);
        }

        /* ==================== BUTTONS ==================== */
        .btn-modern {
            padding: 0.6rem 1.4rem;
            border-radius: 10px;
            font-weight: 500;
            transition: all 0.2s;
            font-size: 0.875rem;
        }

        .btn-primary-modern {
            background: var(--primary-color);
            color: white;
            border: none;
        }

        .btn-primary-modern:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(199, 91, 63, 0.3);
        }

        /* ==================== ALERTS ==================== */
        .alert-modern {
            border-radius: 14px;
            border: none;
            padding: 1rem 1.25rem;
            display: flex;
            align-items: start;
            gap: 12px;
        }

        /* ==================== PROGRESS ==================== */
        .progress-modern {
            height: 8px;
            border-radius: 50px;
            background: var(--border-light);
        }

        .progress-bar-modern {
            border-radius: 50px;
        }

        /* ==================== RESPONSIVE ==================== */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }

            .mobile-toggle {
                display: block !important;
            }

            .topbar .search-wrapper input {
                width: 200px;
            }
        }

        .mobile-toggle {
            display: none;
        }

        /* ==================== TABLES ==================== */
        .table-modern {
            border-collapse: separate;
            border-spacing: 0 0.4rem;
        }

        .table-modern thead th {
            border: none;
            background: transparent;
            color: var(--text-muted);
            font-weight: 600;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 0.75rem 1rem;
        }

        .table-modern tbody tr {
            background: var(--bg-secondary);
            box-shadow: var(--card-shadow);
            border-radius: 10px;
        }

        .table-modern tbody td {
            padding: 0.9rem 1rem;
            border: none;
            vertical-align: middle;
            color: var(--text-primary);
            font-size: 0.9rem;
        }

        .table-modern tbody tr td:first-child {
            border-top-left-radius: 10px;
            border-bottom-left-radius: 10px;
        }

        .table-modern tbody tr td:last-child {
            border-top-right-radius: 10px;
            border-bottom-right-radius: 10px;
        }

        /* ==================== BOOTSTRAP TABLE OVERRIDE ==================== */
        .table {
            --bs-table-bg: var(--bg-secondary);
            --bs-table-color: var(--text-primary);
            --bs-table-border-color: var(--border-color);
            --bs-table-striped-bg: var(--bg-tertiary);
            --bs-table-striped-color: var(--text-primary);
            --bs-table-hover-bg: var(--hover-bg);
            --bs-table-hover-color: var(--text-primary);
        }

        .table > :not(caption) > * > * {
            background-color: var(--bg-secondary);
            color: var(--text-primary);
            border-bottom-color: var(--border-color);
        }

        .table-modern tbody tr {
            background: var(--bg-secondary) !important;
        }

        .table-modern tbody tr:hover {
            background: var(--hover-bg) !important;
        }

        /* ==================== TEXT ==================== */
        .text-muted {
            color: var(--text-muted) !important;
        }

        .topbar .user-name {
            color: var(--text-primary);
            font-weight: 600;
            font-size: 0.9rem;
        }

        .topbar .user-role {
            color: var(--text-muted);
            font-size: 0.75rem;
        }

        /* ==================== MODALS ==================== */
        .modal-backdrop-custom {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(61, 44, 30, 0.4);
            backdrop-filter: blur(4px);
            z-index: 1050;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .modal-content-custom {
            background: var(--bg-secondary);
            border-radius: 20px;
            padding: 2rem;
            width: 100%;
            max-width: 500px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
            border: 1px solid var(--border-color);
        }

        .modal-header-custom {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .modal-title-custom {
            font-size: 1.2rem;
            font-weight: 600;
            color: var(--text-primary);
        }

        .modal-close-btn {
            background: transparent;
            border: none;
            color: var(--text-secondary);
            font-size: 1.5rem;
            cursor: pointer;
            padding: 0;
            line-height: 1;
        }

        .modal-close-btn:hover {
            color: var(--danger-color);
        }

        /* ==================== FORMS ==================== */
        .form-label {
            color: var(--text-primary);
            font-weight: 500;
            margin-bottom: 0.5rem;
            font-size: 0.875rem;
        }

        .form-control {
            background: var(--input-bg);
            border: 1px solid var(--border-color);
            color: var(--text-primary);
            border-radius: 10px;
            padding: 0.7rem 1rem;
            font-size: 0.9rem;
        }

        .form-control:focus {
            background: var(--input-bg);
            border-color: var(--primary-color);
            color: var(--text-primary);
            box-shadow: 0 0 0 3px rgba(199, 91, 63, 0.1);
        }

        .form-control::placeholder {
            color: var(--text-muted);
        }

        .input-group-text {
            background: var(--input-bg);
            border: 1px solid var(--border-color);
            color: var(--text-muted);
            border-radius: 10px;
        }

        .input-group .form-control {
            background: var(--input-bg);
            border: 1px solid var(--border-color);
            color: var(--text-primary);
        }

        .input-group .form-control:focus {
            background: var(--input-bg);
            border-color: var(--primary-color);
            color: var(--text-primary);
        }

        .invalid-feedback {
            color: var(--danger-color);
            font-size: 0.8rem;
            margin-top: 0.25rem;
        }

        /* ==================== ACTION BUTTONS ==================== */
        .action-btn {
            background: transparent;
            border: none;
            padding: 0.5rem;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.2s;
        }

        .action-btn:hover {
            background: var(--hover-bg);
        }

        .action-btn-edit {
            color: var(--primary-color);
        }

        .action-btn-delete {
            background-color: var(--danger-color);
        }


        /* ==================== PAGINATION ==================== */
        .pagination {
            --bs-pagination-bg: var(--bg-secondary);
            --bs-pagination-color: var(--text-primary);
            --bs-pagination-border-color: var(--border-color);
            --bs-pagination-hover-bg: var(--hover-bg);
            --bs-pagination-hover-color: var(--primary-color);
            --bs-pagination-focus-bg: var(--hover-bg);
            --bs-pagination-active-bg: var(--primary-color);
            --bs-pagination-active-border-color: var(--primary-color);
            --bs-pagination-disabled-bg: var(--bg-tertiary);
            --bs-pagination-disabled-color: var(--text-muted);
        }

        .page-link {
            border-radius: 8px !important;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <x-sidebar :brand-name="$brandName" :brand-icon="$brandIcon">
        @if(Auth::guard('admin')->check())
            <x-sidebar-section title="Menu">
                <x-sidebar-link href="{{ route('dashboard') }}" icon="fas fa-th-large" :active="request()->routeIs('dashboard')">Dashboard</x-sidebar-link>
            </x-sidebar-section>

            <x-sidebar-section title="Data Master">
                <x-sidebar-link href="{{ route('admin.warga') }}" icon="fas fa-users" :active="request()->routeIs('admin.warga')">Data Warga</x-sidebar-link>
                <x-sidebar-link href="{{ route('admin.unitrumah') }}" icon="fas fa-home" :active="request()->routeIs('admin.unitrumah')">Data Unit Rumah</x-sidebar-link>
            </x-sidebar-section>

            <x-sidebar-section title="Transaksi">
                <x-sidebar-link href="{{ route('admin.pengajuan') }}" icon="fas fa-file-signature" :active="request()->routeIs('admin.pengajuan')">Data Pengajuan</x-sidebar-link>
                <x-sidebar-link href="{{ route('admin.penempatan') }}" icon="fas fa-key" :active="request()->routeIs('admin.penempatan')">Data Penempatan</x-sidebar-link>
            </x-sidebar-section>

            <x-sidebar-section title="Account">
                <x-sidebar-link href="{{ route('admin.profile') }}" icon="fas fa-user-circle" :active="request()->routeIs('admin.profile')">Profile</x-sidebar-link>
                <x-sidebar-link href="#settings" icon="fas fa-cog">Settings</x-sidebar-link>
            </x-sidebar-section>

        @elseif(Auth::guard('warga')->check())
            <x-sidebar-section title="Menu Utama">
                <x-sidebar-link href="{{ route('warga.dashboard') }}" icon="fas fa-th-large" :active="request()->routeIs('warga.dashboard')">Dashboard</x-sidebar-link>
                <x-sidebar-link href="{{ route('warga.unit') }}" icon="fas fa-home" :active="request()->routeIs('warga.unit')">Informasi Unit</x-sidebar-link>
            </x-sidebar-section>

            <x-sidebar-section title="Aktivitas">
                <x-sidebar-link href="{{ route('warga.pengajuan') }}" icon="fas fa-file-signature" :active="request()->routeIs('warga.pengajuan')">Riwayat Pengajuan</x-sidebar-link>
            </x-sidebar-section>

            <x-sidebar-section title="Account">
                <x-sidebar-link href="{{ route('warga.profile') }}" icon="fas fa-user-circle" :active="request()->routeIs('warga.profile')">Profile Saya</x-sidebar-link>
            </x-sidebar-section>
        @endif
    </x-sidebar>

    @php
        // Determine current user and role
        $activeUser = null;
        $activeRole = 'Guest';
        $logoutUrl = '#';

        if (Auth::guard('admin')->check()) {
            $activeUser = Auth::guard('admin')->user();
            $activeRole = 'Administrator';
            $logoutUrl = route('logout');
        } elseif (Auth::guard('warga')->check()) {
            $activeUser = Auth::guard('warga')->user();
            $activeRole = 'Warga';
            $logoutUrl = route('warga.logout');
        }

        // Coba ambil nama (dari warga) atau username (dari admin)
        $displayName = $activeUser ? ($activeUser->nama ?? $activeUser->username ?? 'User') : 'Guest';
    @endphp

    <!-- Main Content -->
    <div class="main-content">
        <!-- Top Bar -->
        <x-topbar
            :user-name="$displayName"
            :user-role="$activeRole"
            :notification-count="0"
            :show-logout="true"
            :logout-url="$logoutUrl"
            :show-theme-toggle="false"
        />

        <!-- Content Area -->
        <div class="content-area">
            {{ $slot }}
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('show');
        }
    </script>
    @livewireScripts
</body>
</html>
