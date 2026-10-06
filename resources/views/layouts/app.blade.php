<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <title>@yield('title', 'Dashboard SiFit')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta content="Sistem Informasi SiFit" name="description" />
    
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- App favicon SiFit -->
<link rel="shortcut icon" href="{{ asset('assets/images/logo-riau.png') }}">
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css" />

    <!-- Immediate Theme Initialization to Prevent Flash of Wrong Theme -->
    <script>
        (function() {
            const savedTheme = localStorage.getItem('sifit_theme') || 'light';
            document.documentElement.setAttribute('data-bs-theme', savedTheme);
            if (savedTheme === 'dark') {
                document.documentElement.setAttribute('data-startbar', 'dark');
            }
        })();
    </script>

    <style>
        /* Smooth Global Theme Transition */
        html.theme-transitioning,
        html.theme-transitioning *,
        html.theme-transitioning *:before,
        html.theme-transitioning *:after {
            transition: background-color 0.3s ease, border-color 0.3s ease, color 0.3s ease, box-shadow 0.3s ease, fill 0.3s ease !important;
        }

        /* Interactive Dark Mode Button */
        .theme-toggle-btn {
            position: relative;
            cursor: pointer;
            transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1), background-color 0.2s ease;
            border-radius: 50%;
            width: 38px;
            height: 38px;
            display: inline-flex !important;
            align-items: center;
            justify-content: center;
        }
        .theme-toggle-btn:hover {
            transform: scale(1.15) rotate(15deg);
            background: rgba(111, 106, 248, 0.15);
        }
        .theme-toggle-btn:active {
            transform: scale(0.9) rotate(-20deg);
        }
        .theme-toggle-btn i {
            font-size: 20px;
            transition: transform 0.4s ease, opacity 0.3s ease;
        }
        .theme-toggle-btn.animating i {
            transform: rotate(360deg) scale(1.2);
        }

        /* Icon Visibility for Light / Dark Mode */
        html[data-bs-theme="dark"] #light-dark-mode .light-mode {
            display: none !important;
        }
        html[data-bs-theme="dark"] #light-dark-mode .dark-mode {
            display: inline-block !important;
            color: #ffd47a;
        }
        html[data-bs-theme="light"] #light-dark-mode .light-mode {
            display: inline-block !important;
            color: #ff9800;
        }
        html[data-bs-theme="light"] #light-dark-mode .dark-mode {
            display: none !important;
        }

        /* ==========================================================================
           SiFit Brand Color Palette Overrides (#115566 & #4db6ac)
           ========================================================================== */
        :root, [data-bs-theme="light"] {
            --bs-primary: #115566;
            --bs-primary-rgb: 17, 85, 102;
            --bs-primary-text-emphasis: #0b3a46;
            --bs-primary-bg-subtle: rgba(17, 85, 102, 0.1);
            --bs-primary-border-subtle: rgba(17, 85, 102, 0.25);
            --bs-link-color: #115566;
            --bs-link-hover-color: #0b3a46;
            --bs-info: #4db6ac;
            --bs-info-rgb: 77, 182, 172;
            --bs-info-bg-subtle: rgba(77, 182, 172, 0.15);
            --bs-info-border-subtle: rgba(77, 182, 172, 0.3);
        }

        /* Primary Button */
        .btn-primary {
            background-color: #115566 !important;
            border-color: #115566 !important;
            color: #ffffff !important;
        }
        .btn-primary:hover, .btn-primary:focus, .btn-primary:active, .btn-primary.active {
            background-color: #0d4452 !important;
            border-color: #0d4452 !important;
            color: #ffffff !important;
            box-shadow: 0 0 0 0.25rem rgba(17, 85, 102, 0.25) !important;
        }

        /* Outline Primary Button */
        .btn-outline-primary {
            color: #115566 !important;
            border-color: #115566 !important;
            background-color: transparent !important;
        }
        .btn-outline-primary:hover, .btn-outline-primary:focus, .btn-outline-primary:active, .btn-outline-primary.active {
            background-color: #115566 !important;
            border-color: #115566 !important;
            color: #ffffff !important;
        }

        /* Info / Accent Button (#4db6ac) */
        .btn-info {
            background-color: #4db6ac !important;
            border-color: #4db6ac !important;
            color: #ffffff !important;
        }
        .btn-info:hover, .btn-info:focus, .btn-info:active, .btn-info.active {
            background-color: #3b9b91 !important;
            border-color: #3b9b91 !important;
            color: #ffffff !important;
        }

        /* Sidebar Nav Links & Active State */
        .startbar .startbar-menu .navbar-nav .nav-item .nav-link.active,
        .startbar .startbar-menu .navbar-nav .nav-item.active .nav-link.active {
            color: #115566 !important;
            font-weight: 600;
        }
        .startbar .startbar-menu .navbar-nav .nav-item .nav-link.active i,
        .startbar .startbar-menu .navbar-nav .nav-item.active .nav-link.active .menu-icon {
            color: #115566 !important;
        }
        .startbar .startbar-menu .navbar-nav .nav-item .nav-link:hover,
        .startbar .startbar-menu .navbar-nav .nav-item .nav-link:hover .menu-icon {
            color: #4db6ac !important;
        }

        /* Sidebar Vertical Indicator Bar (Left border) */
        .startbar .startbar-menu .navbar-nav .nav-item .nav-link:hover::before,
        .startbar .startbar-menu .navbar-nav .nav-item .nav-link.active::before,
        .startbar .startbar-menu .navbar-nav .nav-item.active .nav-link::before,
        .startbar .startbar-menu .navbar-nav .nav-item .nav-link[data-bs-toggle="collapse"][aria-expanded="true"]::before {
            border-color: #115566 !important;
            background-color: #115566 !important;
        }

        /* Sidebar Collapse / Dropdown Header when Expanded */
        .startbar .startbar-menu .navbar-nav .nav-item .nav-link[data-bs-toggle="collapse"][aria-expanded="true"] {
            background-color: rgba(17, 85, 102, 0.08) !important;
            color: #115566 !important;
        }
        .startbar .startbar-menu .navbar-nav .nav-item .nav-link[data-bs-toggle="collapse"][aria-expanded="true"]:after {
            color: #115566 !important;
        }
        .startbar .startbar-menu .navbar-nav .nav-item .nav-link[data-bs-toggle="collapse"][aria-expanded="true"] i,
        .startbar .startbar-menu .navbar-nav .nav-item .nav-link[data-bs-toggle="collapse"][aria-expanded="true"] span {
            color: #115566 !important;
            font-weight: 600;
        }

        /* Sidebar Submenu Links & Bullet Dots */
        .startbar .startbar-menu .navbar-nav .nav-item .nav .nav-item .nav-link {
            color: #555b7e !important;
        }
        .startbar .startbar-menu .navbar-nav .nav-item .nav .nav-item .nav-link:hover,
        .startbar .startbar-menu .navbar-nav .nav-item .nav .nav-item .nav-link.active {
            color: #115566 !important;
            font-weight: 600;
        }
        .startbar .startbar-menu .navbar-nav .nav-item .nav .nav-item .nav-link:before {
            border-color: #4db6ac !important;
            background: rgba(77, 182, 172, 0.3) !important;
        }
        .startbar .startbar-menu .navbar-nav .nav-item .nav .nav-item .nav-link.active:before,
        .startbar .startbar-menu .navbar-nav .nav-item .nav .nav-item .nav-link:hover:before {
            border-color: #115566 !important;
            background-color: #115566 !important;
        }

        /* Primary Badges & Accents */
        .badge.bg-primary, .bg-primary {
            background-color: #115566 !important;
            color: #ffffff !important;
        }
        .badge.bg-primary-subtle, .badge-primary-subtle,
        .bg-primary-subtle, .bg-soft-primary, .badge-soft-primary,
        .badge.bg-soft-primary, .badge.bg-primary-subtle {
            background-color: rgba(17, 85, 102, 0.12) !important;
            color: #115566 !important;
            border: 1px solid rgba(17, 85, 102, 0.25) !important;
        }
        .badge.bg-info-subtle, .badge-info-subtle,
        .bg-info-subtle, .bg-soft-info, .badge-soft-info,
        .badge.bg-soft-info, .badge.bg-info-subtle {
            background-color: rgba(77, 182, 172, 0.15) !important;
            color: #0b3a46 !important;
            border: 1px solid rgba(77, 182, 172, 0.3) !important;
        }
        .badge.bg-secondary-subtle, .badge-secondary-subtle,
        .bg-secondary-subtle, .bg-soft-secondary, .badge-soft-secondary,
        .badge.bg-soft-secondary, .badge.bg-secondary-subtle {
            background-color: rgba(100, 116, 139, 0.1) !important;
            color: #475569 !important;
            border: 1px solid rgba(100, 116, 139, 0.2) !important;
        }

        /* Links & Interactive Text */
        a.text-primary, .text-primary {
            color: #115566 !important;
        }
        a.text-primary:hover {
            color: #0b3a46 !important;
        }
        .text-info {
            color: #4db6ac !important;
        }

        /* Form Controls Focus State */
        .form-control:focus, .form-select:focus {
            border-color: #4db6ac !important;
            box-shadow: 0 0 0 0.25rem rgba(17, 85, 102, 0.2) !important;
        }
        .form-check-input:checked {
            background-color: #115566 !important;
            border-color: #115566 !important;
        }

        /* Nav Tabs Custom */
        .nav-tabs-custom .nav-link.active {
            color: #115566 !important;
            border-bottom-color: #115566 !important;
        }
        .page-item.active .page-link {
            background-color: #115566 !important;
            border-color: #115566 !important;
            color: #ffffff !important;
        }

        /* Breadcrumb Active */
        .breadcrumb-item.active {
            color: #115566;
            font-weight: 500;
        }

        /* Topbar Search Button / Icon */
        .topbar .app-search button i {
            color: #115566;
        }

        /* ==========================================
           GLOBAL INTERACTIVE UI ENHANCEMENTS
           ========================================== */
        
        /* Smooth Page Load Animation */
        .page-content {
            animation: fadeInContent 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }
        @keyframes fadeInContent {
            from { opacity: 0; transform: translateY(15px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Modern Cards */
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 16px rgba(17, 85, 102, 0.05);
            transition: box-shadow 0.3s ease, transform 0.3s ease;
        }
        .card:hover {
            box-shadow: 0 8px 24px rgba(17, 85, 102, 0.1);
        }
        .card-header {
            border-bottom: 1px solid rgba(17, 85, 102, 0.08);
            background-color: transparent;
            padding: 1.25rem 1.5rem;
        }
        .card-body {
            padding: 1.5rem;
        }

        /* Modern Buttons */
        .btn {
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.25s ease;
        }
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(17, 85, 102, 0.15);
        }
        .btn:active {
            transform: translateY(0);
        }

        /* Interactive Tables */
        .table {
            border-collapse: separate;
            border-spacing: 0;
        }
        .table thead th {
            border-bottom: 2px solid rgba(17, 85, 102, 0.1);
            color: #555b7e;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.5px;
            padding: 1rem;
        }
        .table tbody td {
            padding: 1rem;
            vertical-align: middle;
            border-bottom: 1px solid rgba(17, 85, 102, 0.05);
            transition: background-color 0.2s ease;
        }
        .table-hover tbody tr {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .table-hover tbody tr:hover {
            transform: scale(1.005);
            box-shadow: 0 4px 15px rgba(17, 85, 102, 0.08);
            background-color: #ffffff;
            z-index: 2;
            position: relative;
        }

        /* Inputs & Forms */
        .form-control, .form-select {
            border-radius: 8px;
            border: 1px solid rgba(17, 85, 102, 0.2);
            padding: 0.6rem 1rem;
            transition: border-color 0.2s ease, box-shadow 0.2s ease, background-color 0.2s ease;
        }
        .form-control:focus, .form-select:focus {
            background-color: #fff;
        }

        /* Page Title */
        .page-title-box {
            padding: 1.5rem 0;
        }
        .page-title {
            font-weight: 700;
            letter-spacing: -0.5px;
        }

        /* Dark Mode Theme Enhancements */
        html[data-bs-theme="dark"] {
            color-scheme: dark;
            --bs-body-bg: #0f111a;
            --bs-body-color: #d9e1ec;
            --bs-card-bg: #131621;
            --bs-primary: #4db6ac;
            --bs-primary-rgb: 77, 182, 172;
            --bs-link-color: #4db6ac;
            --bs-link-hover-color: #7ad4b5;
        }
        html[data-bs-theme="dark"] body {
            background-color: #0f111a !important;
            color: #d9e1ec;
        }
        html[data-bs-theme="dark"] .card {
            background-color: #131621 !important;
            border-color: #1c202b !important;
        }
        html[data-bs-theme="dark"] .card-header {
            background-color: transparent !important;
            border-color: #1c202b !important;
        }
        html[data-bs-theme="dark"] .topbar {
            background-color: #0f111a !important;
            border-bottom: 1px solid #171b27 !important;
        }
        html[data-bs-theme="dark"] .table {
            color: #d9e1ec;
            border-color: #1c202b;
        }
        html[data-bs-theme="dark"] .table > :not(caption) > * > * {
            background-color: transparent;
            color: #d9e1ec;
            border-color: #1c202b;
        }
        
        /* Dark Mode Override for Global Interactivity */
        html[data-bs-theme="dark"] .card {
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.2);
        }
        html[data-bs-theme="dark"] .card:hover {
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.3);
        }
        html[data-bs-theme="dark"] .table-hover tbody tr:hover {
            background-color: #1a1e2b !important;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.4);
        }
        html[data-bs-theme="dark"] .form-control,
        html[data-bs-theme="dark"] .form-select {
            background-color: #171b27 !important;
            border-color: #2b3040 !important;
            color: #d9e1ec !important;
        }
        html[data-bs-theme="dark"] .form-control:focus,
        html[data-bs-theme="dark"] .form-select:focus {
            background-color: #171b27 !important;
            border-color: #4db6ac !important;
            color: #ffffff !important;
        }
        html[data-bs-theme="dark"] .input-group-text {
            background-color: #1a1e2b !important;
            border-color: #2b3040 !important;
            color: #a1a8bd !important;
        }
        html[data-bs-theme="dark"] .dropdown-menu {
            background-color: #171b27 !important;
            border-color: #2b3040 !important;
            color: #d9e1ec !important;
        }
        html[data-bs-theme="dark"] .dropdown-item {
            color: #d9e1ec !important;
        }
        html[data-bs-theme="dark"] .dropdown-item:hover,
        html[data-bs-theme="dark"] .dropdown-item:focus {
            background-color: #1e2333 !important;
            color: #ffffff !important;
        }
        html[data-bs-theme="dark"] .dropdown-divider {
            border-color: #2b3040 !important;
        }
        html[data-bs-theme="dark"] .bg-light,
        html[data-bs-theme="dark"] .bg-light-subtle,
        html[data-bs-theme="dark"] .bg-secondary-subtle {
            background-color: #171b27 !important;
            color: #d9e1ec !important;
        }
        html[data-bs-theme="dark"] .text-dark {
            color: #f4f6f9 !important;
        }
        html[data-bs-theme="dark"] .text-muted {
            color: #8f97ab !important;
        }
        html[data-bs-theme="dark"] .nav-tabs-custom .nav-link.active {
            color: #4db6ac !important;
            border-bottom-color: #4db6ac !important;
        }
        html[data-bs-theme="dark"] .footer .card {
            background-color: #131621 !important;
        }
    </style>

    @stack('css')
</head>

<body class="dark-sidenav">
    
    <!-- Memanggil File Header dan Sidebar -->
    @include('layouts.header')
    @include('layouts.sidebar')

    <div class="page-wrapper">
        <div class="page-content">
            <div class="container-fluid mt-4">
                
                <!-- KONTEN HALAMAN UTAMA -->
                @yield('content')

            </div>
            
            <!-- Footer -->
            <footer class="footer text-center text-sm-start d-print-none mt-4">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card mb-0 border-bottom-0 rounded-bottom-0">
                                <div class="card-body">
                                    <p class="text-muted mb-0">
                                        © <script> document.write(new Date().getFullYear()) </script> SiFit System.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <!-- Script Bawaan -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/libs/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/js/app.js') }}"></script>

    <!-- Reliable Interactive Dark Mode Handler with LocalStorage Persistence -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Apply current saved theme
            const savedTheme = localStorage.getItem('sifit_theme') || 'light';
            document.documentElement.setAttribute('data-bs-theme', savedTheme);
            if (savedTheme === 'dark') {
                document.documentElement.setAttribute('data-startbar', 'dark');
            } else {
                document.documentElement.removeAttribute('data-startbar');
            }

            const oldToggleBtn = document.getElementById('light-dark-mode');
            if (oldToggleBtn) {
                // Clone the node to cleanly remove conflicting legacy listeners from app.js
                const themeToggleBtn = oldToggleBtn.cloneNode(true);
                oldToggleBtn.parentNode.replaceChild(themeToggleBtn, oldToggleBtn);

                themeToggleBtn.setAttribute('title', savedTheme === 'dark' ? 'Beralih ke Mode Terang' : 'Beralih ke Mode Gelap');

                themeToggleBtn.addEventListener('click', function (e) {
                    e.preventDefault();
                    e.stopPropagation();

                    // Smooth transition animation
                    document.documentElement.classList.add('theme-transitioning');
                    themeToggleBtn.classList.add('animating');

                    const currentTheme = document.documentElement.getAttribute('data-bs-theme');
                    const nextTheme = (currentTheme === 'dark') ? 'light' : 'dark';

                    // Update DOM and Storage
                    document.documentElement.setAttribute('data-bs-theme', nextTheme);
                    if (nextTheme === 'dark') {
                        document.documentElement.setAttribute('data-startbar', 'dark');
                    } else {
                        document.documentElement.removeAttribute('data-startbar');
                    }
                    localStorage.setItem('sifit_theme', nextTheme);

                    // Update tooltip title
                    themeToggleBtn.setAttribute('title', nextTheme === 'dark' ? 'Beralih ke Mode Terang' : 'Beralih ke Mode Gelap');

                    setTimeout(function () {
                        document.documentElement.classList.remove('theme-transitioning');
                        themeToggleBtn.classList.remove('animating');
                    }, 350);
                });
            }
        });
    </script>

    @stack('scripts')
</body>
</html>