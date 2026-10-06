<!-- leftbar-tab-menu -->
<div class="startbar d-print-none">
    <!--start brand-->
    <div class="brand">
        <a href="{{ route('dashboard') }}" class="logo">
            <span>
                <img src="{{ asset('assets/images/logo-riau.png') }}" alt="logo-small" class="logo-sm" style="height: 34px;">
            </span>
            <span class="">
                <img src="{{ asset('assets/images/logo-sifit.png') }}" alt="logo-large" class="logo-lg logo-light" style="height: 50px;">
                <img src="{{ asset('assets/images/logo-sifit.png') }}" alt="logo-large" class="logo-lg logo-dark" style="height: 50px;">
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
                        <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
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

                    <!-- Tambahkan Menu Kategori Dihapus (Dipindahkan ke Pengaturan) -->

                    <!-- Menu data obat
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('products.index') }}">
                            <i class="las la-pills menu-icon"></i>
                            <span>Data Obat / Produk</span>
                        </a>
                    </li> -->

                    <!-- Menu master obat -->
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('master-obat.index') }}">
                            <i class="las la-pills menu-icon"></i>
                            <span> Master Obat </span>
                        </a>
                    </li>

                    <li class="nav-item">
    <a class="nav-link" href="{{ route('stok-obat.index') }}">
        <i class="las la-boxes menu-icon"></i>
        <span> Daftar Stok Obat </span>
    </a>
</li>

                    <li class="nav-item">
    <a class="nav-link" href="{{ route('pemasukan.create') }}">
        <i class="las la-truck-loading menu-icon"></i>
        <span> Pemasukan Barang </span>
    </a>
</li>

<li class="nav-item">
    <a class="nav-link" href="{{ route('pengeluaran.create') }}">
        <i class="las la-dolly menu-icon"></i>
        <span> Pengeluaran Barang </span>
    </a>
</li>

<li class="nav-item">
    <a class="nav-link" href="#sidebarPemindahan" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarPemindahan">
        <i class="las la-exchange-alt menu-icon"></i>
        <span> Pemindahan Barang </span>
    </a>
    <div class="collapse {{ request()->is('pemindahan*') ? 'show' : '' }}" id="sidebarPemindahan">
        <ul class="nav flex-column sub-menu">
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('pemindahan.index') ? 'active' : '' }}" href="{{ route('pemindahan.index') }}">Daftar Pemindahan</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('pemindahan.create') ? 'active' : '' }}" href="{{ route('pemindahan.create') }}">Tambah Pemindahan</a>
            </li>
        </ul>
    </div>
</li>

<!-- Master Gudang dipindahkan ke Pengaturan -->

<!-- Menu Pengguna Induk (Terintegrasi) -->
<li class="nav-item">
    <a class="nav-link" href="#sidebarPengguna" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarPengguna">
        <i class="las la-users menu-icon"></i>
        <span>Pengguna</span>
    </a>
    <div class="collapse {{ request()->is('users*') || request()->is('pemasok*') || request()->is('opd*') || request()->is('opds*') ? 'show' : '' }}" id="sidebarPengguna">
        <ul class="nav flex-column sub-menu">
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('users.index') ? 'active' : '' }}" href="{{ route('users.index') }}">Daftar User</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('users.create') ? 'active' : '' }}" href="{{ route('users.create') }}">Tambahkan User Baru</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('pemasok.index') ? 'active' : '' }}" href="{{ route('pemasok.index') }}">Daftar Pemasok</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('pemasok.create') ? 'active' : '' }}" href="{{ route('pemasok.create') }}">Pemasok Baru</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('pemasok.import.form') ? 'active' : '' }}" href="{{ route('pemasok.import.form') }}">Tambahkan Pemasok dengan CSV</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('opd.index') || request()->routeIs('opds.index') ? 'active' : '' }}" href="{{ route('opd.index') }}">Daftar Instansi</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('opd.create') || request()->routeIs('opds.create') ? 'active' : '' }}" href="{{ route('opd.create') }}">Instansi Baru</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('opd.import.form') ? 'active' : '' }}" href="{{ route('opd.import.form') }}">Tambahkan Instansi dengan CSV</a>
            </li>
        </ul>
    </div>
</li>

<!-- Menu Pengaturan Induk -->
<li class="nav-item">
    <a class="nav-link" href="#sidebarPengaturan" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarPengaturan">
        <i class="las la-cog menu-icon"></i>
        <span>Pengaturan</span>
    </a>
    <div class="collapse {{ request()->is('pejabat*') || request()->is('program*') || request()->is('categories*') || request()->is('subkategori*') || request()->is('gudang*') || request()->is('pengangkut*') || request()->is('backup*') ? 'show' : '' }}" id="sidebarPengaturan">
        <ul class="nav flex-column sub-menu">
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('pejabat.*') ? 'active' : '' }}" href="{{ route('pejabat.index') }}">Setting Pejabat</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('program.*') ? 'active' : '' }}" href="{{ route('program.index') }}">Program</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('categories.index') ? 'active' : '' }}" href="{{ route('categories.index') }}">Daftar Kategori</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('categories.create') ? 'active' : '' }}" href="{{ route('categories.create') }}">Tambahkan Kategori Baru</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('subkategori.index') ? 'active' : '' }}" href="{{ route('subkategori.index') }}">Daftar Sub Kategori</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('subkategori.create') ? 'active' : '' }}" href="{{ route('subkategori.create') }}">Tambahkan Sub Kategori</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('gudang.index') ? 'active' : '' }}" href="{{ route('gudang.index') }}">Gudang</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('gudang.create') ? 'active' : '' }}" href="{{ route('gudang.create') }}">Tambahkan Gudang</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('pengangkut.index') ? 'active' : '' }}" href="{{ route('pengangkut.index') }}">Pengangkut/Pengantar</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('pengangkut.create') ? 'active' : '' }}" href="{{ route('pengangkut.create') }}">Tambahkan Pengangkut</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('backup.*') ? 'active' : '' }}" href="{{ route('backup.index') }}">Backup Database</a>
            </li>
        </ul>
    </div>
</li>



                    <!-- INI ADALAH MENU MANAJEMEN ROLE YANG KITA BUAT -->
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('roles*') ? 'active' : '' }}" href="{{ route('roles.index') }}">
                            <i class="iconoir-shield-check menu-icon"></i>
                            <span>Manajemen Role</span>
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
                        <div class="collapse" id="sidebarElements">
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
