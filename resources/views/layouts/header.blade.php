<!-- Top Bar Start -->
<div class="topbar d-print-none">
    <div class="container-fluid">
        <nav class="topbar-custom d-flex justify-content-between" id="topbar-custom">    
            <ul class="topbar-item list-unstyled d-inline-flex align-items-center mb-0">                        
                <li>
                    <button class="nav-link mobile-menu-btn nav-icon" id="togglemenu">
                        <i class="iconoir-menu"></i>
                    </button>
                </li> 
            </ul>
            <ul class="topbar-item list-unstyled d-inline-flex align-items-center mb-0">
                <li class="hide-phone app-search">
                    <form role="search" action="#" method="get">
                        <input type="search" name="search" class="form-control top-search mb-0" placeholder="Search here...">
                        <button type="submit"><i class="iconoir-search"></i></button>
                    </form>
                </li>     
                <li class="topbar-item">
                    <a class="nav-link nav-icon theme-toggle-btn" href="javascript:void(0);" id="light-dark-mode" title="Ganti Mode Gelap/Terang">
                        <i class="iconoir-half-moon dark-mode"></i>
                        <i class="iconoir-sun-light light-mode"></i>
                    </a>                    
                </li>
                <li class="dropdown topbar-item">
                    <a class="nav-link dropdown-toggle arrow-none nav-icon d-flex align-items-center" data-bs-toggle="dropdown" href="#" role="button"
                        aria-haspopup="false" aria-expanded="false" data-bs-offset="0,19">
                        <img src="{{ auth()->check() ? auth()->user()->avatar_url : asset('assets/images/users/avatar-1.jpg') }}" alt="Avatar" class="thumb-md rounded-circle object-fit-cover border border-2 border-primary-subtle">
                    </a>
                    <div class="dropdown-menu dropdown-menu-end py-0 shadow border-0">
                        <div class="d-flex align-items-center dropdown-item py-2 bg-secondary-subtle">
                            <div class="flex-shrink-0">
                                <img src="{{ auth()->check() ? auth()->user()->avatar_url : asset('assets/images/users/avatar-1.jpg') }}" alt="Avatar" class="thumb-md rounded-circle object-fit-cover">
                            </div>
                            <div class="flex-grow-1 ms-2 text-truncate align-self-center">
                                <h6 class="my-0 fw-semibold text-dark fs-13">{{ auth()->check() ? auth()->user()->name : 'Super Admin' }}</h6>
                                <small class="text-muted mb-0">
                                    {{ auth()->check() && auth()->user()->roles->count() > 0 ? ucfirst(auth()->user()->roles->first()->name) : (auth()->check() && auth()->user()->opd ? auth()->user()->opd : 'SiFit Administrator') }}
                                </small>
                            </div>
                        </div>
                        <div class="dropdown-divider mt-0"></div>
                        <a class="dropdown-item" href="{{ route('profile.index') }}">
                            <i class="las la-user fs-18 me-1 align-text-bottom text-primary"></i> Profile
                        </a>
                        <div class="dropdown-divider mb-0"></div>
                        <form method="POST" action="{{ route('logout') }}" class="m-0 p-0">
                            @csrf
                            <button type="submit" class="dropdown-item text-danger border-0 bg-transparent w-100 text-start">
                                <i class="las la-power-off fs-18 me-1 align-text-bottom"></i> Logout
                            </button>
                        </form>
                    </div>
                </li>
            </ul>
        </nav>
    </div>
</div>
<!-- Top Bar End -->