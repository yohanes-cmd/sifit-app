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

    @php
        $currentUser = auth()->user();
        $isSuperAdmin = $currentUser && $currentUser->isSuperAdmin();
        $isAdminOpd = $currentUser && $currentUser->isAdminOpd();
    @endphp

    <!--start startbar-menu-->
    <div class="startbar-menu" >
        <div class="startbar-collapse" id="startbarCollapse" data-simplebar>
            <div class="d-flex align-items-start flex-column w-100">
                <!-- Navigation -->
                <ul class="navbar-nav mb-auto w-100">

                    <li class="menu-label mt-2">
                        <span>{{ $isSuperAdmin ? 'Gudang Pusat (Super Admin)' : ($isAdminOpd ? 'Portal Admin OPD' : 'Main Menu') }}</span>
                    </li>

                    @if($isSuperAdmin)
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                            <i class="iconoir-report-columns menu-icon"></i>
                            <span>Dashboard Pusat</span>
                        </a>
                    </li>
                    @endif

                    <!-- MENU PERMOHONAN OBAT -->
                    <li class="nav-item">
                        <a class="nav-link" href="#sidebarPermohonan" data-bs-toggle="collapse" role="button" aria-expanded="{{ request()->is('permohonan*') ? 'true' : 'false' }}" aria-controls="sidebarPermohonan">
                            <i class="las la-file-signature menu-icon text-primary"></i>
                            <span> Permohonan Obat </span>
                        </a>
                        <div class="collapse {{ request()->is('permohonan*') ? 'show' : '' }}" id="sidebarPermohonan">
                            <ul class="nav flex-column sub-menu">
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('permohonan.index') ? 'active' : '' }}" href="{{ route('permohonan.index') }}">
                                        {{ $isAdminOpd ? 'Daftar Permohonan Saya' : 'Daftar Permohonan OPD' }}
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('permohonan.create') ? 'active' : '' }}" href="{{ route('permohonan.create') }}">
                                        Buat Permohonan Baru
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    @if($isAdminOpd)
                    <!-- MENU UNTUK ADMIN OPD -->
                    <li class="menu-label mt-2">
                        <span>Distribusi Farmasi OPD</span>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('pemasukan*') ? 'active' : '' }}" href="{{ route('pemasukan.index') }}">
                            <i class="las la-truck-loading menu-icon text-info"></i>
                            <span> Pemasukan Obat (Pusat) </span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#sidebarPengeluaranOpd" data-bs-toggle="collapse" role="button" aria-expanded="{{ request()->is('pengeluaran*') ? 'true' : 'false' }}" aria-controls="sidebarPengeluaranOpd">
                            <i class="las la-dolly menu-icon text-success"></i>
                            <span> Pengeluaran Obat </span>
                        </a>
                        <div class="collapse {{ request()->is('pengeluaran*') ? 'show' : '' }}" id="sidebarPengeluaranOpd">
                            <ul class="nav flex-column sub-menu">
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('pengeluaran.index') ? 'active' : '' }}" href="{{ route('pengeluaran.index') }}">Daftar Pengeluaran</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('pengeluaran.create') ? 'active' : '' }}" href="{{ route('pengeluaran.create') }}">Catat Pengeluaran Baru</a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#sidebarPemindahanOpd" data-bs-toggle="collapse" role="button" aria-expanded="{{ request()->is('pemindahan*') ? 'true' : 'false' }}" aria-controls="sidebarPemindahanOpd">
                            <i class="las la-exchange-alt menu-icon text-warning"></i>
                            <span> Pemindahan Obat </span>
                        </a>
                        <div class="collapse {{ request()->is('pemindahan*') ? 'show' : '' }}" id="sidebarPemindahanOpd">
                            <ul class="nav flex-column sub-menu">
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('pemindahan.index') ? 'active' : '' }}" href="{{ route('pemindahan.index') }}">Daftar Pemindahan</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('pemindahan.create') ? 'active' : '' }}" href="{{ route('pemindahan.create') }}">Tambah Mutasi Obat</a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('master-obat.*') ? 'active' : '' }}" href="{{ route('master-obat.index') }}">
                            <i class="las la-pills menu-icon"></i>
                            <span> Katalog Obat </span>
                        </a>
                    </li>
                    @endif

                    @if($isSuperAdmin)
                    <!-- MENU DATA MASTER GUDANG PUSAT -->
                    <li class="menu-label mt-2">
                        <span>Data Master Farmasi</span>
                    </li>

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

                    <!-- Menu Galeri Foto & Video -->
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('galleries*') ? 'active' : '' }}" href="{{ route('galleries.index') }}">
                            <i class="las la-photo-video menu-icon"></i>
                            <span>Galeri Foto & Video</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('master-obat.*') ? 'active' : '' }}" href="{{ route('master-obat.index') }}">
                            <i class="las la-pills menu-icon"></i>
                            <span> Master Obat </span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('stok-obat.*') ? 'active' : '' }}" href="{{ route('stok-obat.index') }}">
                            <i class="las la-boxes menu-icon"></i>
                            <span> Daftar Stok Gudang Pusat </span>
                        </a>
                    </li>

                    <li class="menu-label mt-2">
                        <span>Transaksi Distribusi Pusat</span>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#sidebarPemasukan" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarPemasukan">
                            <i class="las la-truck-loading menu-icon"></i>
                            <span> Pemasukan (Pemasok) </span>
                        </a>
                        <div class="collapse {{ request()->is('pemasukan*') ? 'show' : '' }}" id="sidebarPemasukan">
                            <ul class="nav flex-column sub-menu">
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('pemasukan.index') ? 'active' : '' }}" href="{{ route('pemasukan.index') }}">Daftar Pemasukan</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('pemasukan.create') ? 'active' : '' }}" href="{{ route('pemasukan.create') }}">Tambah Pemasukan</a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#sidebarPengeluaran" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarPengeluaran">
                            <i class="las la-dolly menu-icon"></i>
                            <span> Realisasi Pengeluaran (SBBK) </span>
                        </a>
                        <div class="collapse {{ request()->is('pengeluaran*') ? 'show' : '' }}" id="sidebarPengeluaran">
                            <ul class="nav flex-column sub-menu">
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('pengeluaran.index') ? 'active' : '' }}" href="{{ route('pengeluaran.index') }}">Daftar Pengeluaran (SBBK)</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('pengeluaran.create') ? 'active' : '' }}" href="{{ route('pengeluaran.create') }}">Proses SBBK Baru</a>
                                </li>
                            </ul>
                        </div>
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

                    <!-- Menu Pengguna Induk -->
                    <li class="nav-item">
                        <a class="nav-link" href="#sidebarPengguna" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarPengguna">
                            <i class="las la-users menu-icon"></i>
                            <span>Pengguna</span>
                        </a>
                        <div class="collapse {{ request()->is('users*') || request()->is('pemasok*') || request()->is('opd*') || request()->is('opds*') ? 'show' : '' }}" id="sidebarPengguna">
                            <ul class="nav flex-column sub-menu">
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}" href="{{ route('users.index') }}">Daftar User</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('pemasok.*') ? 'active' : '' }}" href="{{ route('pemasok.index') }}">Daftar Pemasok</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('opd.*') || request()->routeIs('opds.*') ? 'active' : '' }}" href="{{ route('opd.index') }}">Daftar Instansi / OPD</a>
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
                        <div class="collapse {{ request()->is('site-settings*') || request()->is('faq*') || request()->is('pejabat*') || request()->is('program*') || request()->is('categories*') || request()->is('subkategori*') || request()->is('gudang*') || request()->is('pengangkut*') || request()->is('backup*') || request()->is('status-kantor*') ? 'show' : '' }}" id="sidebarPengaturan">
                            <ul class="nav flex-column sub-menu">
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('site-settings.*') ? 'active' : '' }}" href="{{ route('site-settings.index') }}">Konten SIFIT & Kontak</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('faq.*') ? 'active' : '' }}" href="{{ route('faq.index') }}">FAQ / Tanya Jawab</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('pejabat.*') ? 'active' : '' }}" href="{{ route('pejabat.index') }}">Setting Pejabat</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('status-kantor.*') ? 'active' : '' }}" href="{{ route('status-kantor.index') }}">Status Kepemilikan</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('program.*') ? 'active' : '' }}" href="{{ route('program.index') }}">Program</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('categories.*') ? 'active' : '' }}" href="{{ route('categories.index') }}">Daftar Kategori</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('subkategori.*') ? 'active' : '' }}" href="{{ route('subkategori.index') }}">Daftar Sub Kategori</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('gudang.*') ? 'active' : '' }}" href="{{ route('gudang.index') }}">Gudang</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('pengangkut.*') ? 'active' : '' }}" href="{{ route('pengangkut.index') }}">Pengangkut/Pengantar</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('backup.*') ? 'active' : '' }}" href="{{ route('backup.index') }}">Backup Database</a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('roles*') ? 'active' : '' }}" href="{{ route('roles.index') }}">
                            <i class="iconoir-shield-check menu-icon"></i>
                            <span>Manajemen Role</span>
                        </a>
                    </li>
                    @endif

                    <li class="menu-label mt-2">
                        <span>Pengaturan Akun</span>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('profile.index') ? 'active' : '' }}" href="{{ route('profile.index') }}">
                            <i class="las la-user-circle menu-icon"></i>
                            <span>Profil Saya</span>
                        </a>
                    </li>

                </ul>
            </div>
        </div>
    </div>
</div>
<div class="startbar-overlay d-print-none"></div>
<!-- end leftbar-tab-menu-->
