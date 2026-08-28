<!-- leftbar-tab-menu -->
<div class="startbar d-print-none">
    <!--start brand-->
    <div class="brand">
        <a href="{{ url('/') }}" class="logo">
            <span>
                <img src="{{ asset('assets/images/logo-sm.png') }}" alt="logo-small" class="logo-sm">
            </span>
            <span class="">
                <img src="{{ asset('assets/images/logo-light.png') }}" alt="logo-large" class="logo-lg logo-light">
                <img src="{{ asset('assets/images/logo-dark.png') }}" alt="logo-large" class="logo-lg logo-dark">
            </span>
        </a>
    </div>
    <!--end brand-->
    <!--start startbar-menu-->
    <div class="startbar-menu" >
        <div class="startbar-collapse" id="startbarCollapse" data-simplebar>
            <div class="d-flex align-items-start flex-column w-100">
                <!-- Navigation -->
                <ul class="navbar-nav mb-auto w-100">
                    <li class="menu-label mt-2">
                        <span>Main Menu</span>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/') }}"> 
                            <i class="iconoir-report-columns menu-icon"></i>                                       
                            <span>Dashboard</span>
                        </a>
                    </li>
                    
                    <li class="menu-label mt-2">
                        <span>Data Master</span>
                    </li>

                    <!-- Menu Dropdown Berita & Informasi -->
<li class="nav-item">
    <a class="nav-link" href="#sidebarNews" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarNews">
        <i class="ti-files menu-icon"></i>
        <span>Berita & Informasi</span>
    </a>
    <div class="collapse" id="sidebarNews">
        <ul class="nav flex-column sub-menu">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('news.index') }}">Daftar Berita</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('categories.index') }}">Kategori Berita</a>
            </li>
        </ul>
    </div>
</li>

                    <!-- Tambahkan Menu Kategori -->
<li class="nav-item">
    <a class="nav-link" href="{{ route('categories.index') }}">
        <i class="las la-tags menu-icon"></i>
        <span>Data Kategori</span>
    </a>
</li>


                    <!-- Menu data obat -->
                    <li class="nav-item">
                         <a class="nav-link" href="{{ route('products.index') }}">
                             <i class="las la-pills menu-icon"></i>
                             <span>Data Obat / Produk</span>
                         </a>
                    </li>
                    <!-- INI ADALAH MENU MANAJEMEN ROLE YANG KITA BUAT -->
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('roles*') ? 'active' : '' }}" href="{{ route('roles.index') }}">
                            <i class="iconoir-shield-check menu-icon"></i> 
                            <span>Manajemen Role</span>
                        </a>
                    </li>

                    <li class="nav-item">
    <a class="nav-link" href="{{ route('opds.index') }}">
        <i class="las la-building menu-icon"></i>
        <span>Manajemen OPD</span>
    </a>
</li>


                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('users*') ? 'active' : '' }}" href="{{ route('users.index') }}">
                            <i class="iconoir-community menu-icon"></i> 
                            <span>Data Pengguna</span>
                        </a>
                    </li>

                    <li class="menu-label mt-2">
                        <small class="label-border">
                            <div class="border_left hidden-xs"></div>
                            <div class="border_right"></div>
                        </small>
                        <span>Template Components</span>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#sidebarElements" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarElements">
                            <i class="iconoir-compact-disc menu-icon"></i>
                            <span>UI Elements</span>
                        </a>
                        <div class="collapse " id="sidebarElements">
                            <ul class="nav flex-column">
                                <li class="nav-item"><a class="nav-link" href="#">Alerts</a></li>
                                <li class="nav-item"><a class="nav-link" href="#">Buttons</a></li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<div class="startbar-overlay d-print-none"></div>
<!-- end leftbar-tab-menu-->