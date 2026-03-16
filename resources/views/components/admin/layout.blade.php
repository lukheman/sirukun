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

        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: var(--border-color); border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: var(--text-muted); }

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

        .main-content {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            background: var(--bg-primary);
        }

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

        .topbar .user-name {
            color: var(--text-primary);
            font-weight: 600;
            font-size: 0.9rem;
        }

        .topbar .user-role {
            color: var(--text-muted);
            font-size: 0.75rem;
        }

        .content-area {
            padding: 1.75rem 2rem;
        }

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

        .badge-modern {
            padding: 0.4rem 0.85rem;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .component-preview {
            background: var(--bg-secondary);
            border-radius: 20px;
            padding: 2rem;
            box-shadow: var(--card-shadow);
            margin-bottom: 2rem;
        }

        .preview-section {
            margin-bottom: 2.5rem;
        }

        .preview-section:last-child {
            margin-bottom: 0;
        }

        .preview-title {
            font-size: 1.05rem;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 1.25rem;
            padding-bottom: 0.75rem;
            border-bottom: 2px solid var(--border-light);
        }

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

        .alert-modern {
            border-radius: 14px;
            border: none;
            padding: 1rem 1.25rem;
            display: flex;
            align-items: start;
            gap: 12px;
        }

        .progress-modern {
            height: 8px;
            border-radius: 50px;
            background: var(--border-light);
        }

        .progress-bar-modern {
            border-radius: 50px;
        }

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

        .input-group .form-control::placeholder {
            color: var(--text-muted);
        }

        .text-dark-heading {
            color: var(--text-primary) !important;
        }

        .text-dark-secondary {
            color: var(--text-secondary) !important;
        }

        .text-muted {
            color: var(--text-muted) !important;
        }

        .pagination {
            --bs-pagination-bg: var(--bg-secondary);
            --bs-pagination-color: var(--text-primary);
            --bs-pagination-border-color: var(--border-color);
            --bs-pagination-hover-bg: var(--hover-bg);
            --bs-pagination-hover-color: var(--primary-color);
            --bs-pagination-active-bg: var(--primary-color);
            --bs-pagination-active-border-color: var(--primary-color);
        }

        .page-link {
            border-radius: 8px !important;
        }
    </style>
    {{ $styles ?? '' }}
</head>
<body>
    <!-- Sidebar -->
    <x-admin.sidebar :brand-name="$brandName" :brand-icon="$brandIcon">
        {{ $sidebar }}
    </x-admin.sidebar>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Top Bar -->
        {{ $topbar }}

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

        // Add smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                document.querySelectorAll('.sidebar-menu a').forEach(link => {
                    link.classList.remove('active');
                });
                this.classList.add('active');
            });
        });
    </script>
    {{ $scripts ?? '' }}
</body>
</html>

