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

    @stack('scripts')
</body>
</html>