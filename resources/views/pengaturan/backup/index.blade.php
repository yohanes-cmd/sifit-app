@extends('layouts.app')
@section('title', 'Backup Database - SIFIT')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="row">
                    <div class="col">
                        <h4 class="page-title">Backup Database</h4>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="#">Pengaturan</a></li>
                            <li class="breadcrumb-item active">Backup Database</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-danger text-white">
                    <h5 class="mb-0"><i class="las la-database me-2"></i>Backup Database</h5>
                </div>
                <div class="card-body text-center py-5">
                    <div class="mb-4">
                        <i class="las la-database" style="font-size: 80px; color: #dee2e6;"></i>
                    </div>
                    <h4 class="fw-bold text-muted mb-2">Fitur Backup Database</h4>
                    <p class="text-muted mb-4">
                        Fitur backup database akan segera tersedia. Halaman ini adalah placeholder.<br>
                        Fitur ini akan memungkinkan Anda untuk membuat salinan cadangan database secara berkala.
                    </p>

                    <div class="row justify-content-center g-3 mb-4">
                        <div class="col-md-4">
                            <div class="card border-1 border-dashed p-3 text-center">
                                <i class="las la-clock text-primary mb-2" style="font-size: 32px;"></i>
                                <h6 class="fw-bold">Backup Otomatis</h6>
                                <small class="text-muted">Jadwalkan backup secara berkala</small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card border-1 border-dashed p-3 text-center">
                                <i class="las la-download text-success mb-2" style="font-size: 32px;"></i>
                                <h6 class="fw-bold">Unduh Backup</h6>
                                <small class="text-muted">Unduh file backup ke komputer</small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card border-1 border-dashed p-3 text-center">
                                <i class="las la-undo text-warning mb-2" style="font-size: 32px;"></i>
                                <h6 class="fw-bold">Restore Data</h6>
                                <small class="text-muted">Pulihkan data dari backup</small>
                            </div>
                        </div>
                    </div>

                    <div class="alert alert-warning d-inline-flex align-items-center gap-2">
                        <i class="las la-exclamation-triangle"></i>
                        <span>Halaman ini masih dalam pengembangan. Silakan hubungi administrator sistem.</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-light">
                    <h6 class="mb-0 fw-bold"><i class="las la-info-circle me-2 text-info"></i>Informasi Sistem</h6>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between px-0">
                            <span class="text-muted">Database</span>
                            <span class="fw-semibold">MySQL</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between px-0">
                            <span class="text-muted">Framework</span>
                            <span class="fw-semibold">Laravel</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between px-0">
                            <span class="text-muted">Versi PHP</span>
                            <span class="fw-semibold">{{ PHP_VERSION }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between px-0">
                            <span class="text-muted">Status Fitur</span>
                            <span class="badge bg-warning">Coming Soon</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
