@extends('layouts.app')

@section('title', 'Dashboard - SiFit')

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box d-md-flex justify-content-md-between align-items-center">
            <h4 class="page-title">Dashboard Utama</h4>
        </div>
    </div>
</div>

<div class="row mt-3">
    <div class="col-12">
        <div class="card">
            <div class="card-body text-center p-5">
                <i class="iconoir-report-columns text-primary" style="font-size: 64px;"></i>
                <h4 class="mt-4">Selamat Datang di Sistem Informasi SiFit!</h4>
                <p class="text-muted">Ini adalah ruang tunggu (Dashboard). Nantinya Anda bisa memindahkan grafik-grafik cantik dari template Dastone ke halaman ini.</p>
            </div>
        </div>
    </div>
</div>
@endsection