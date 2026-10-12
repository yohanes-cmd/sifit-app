@extends('layouts.app')
@section('title', 'Import Instansi CSV - SIFIT')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="row">
                    <div class="col">
                        <h4 class="page-title">Import Data Instansi</h4>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('opd.index') }}">Instansi / OPD</a></li>
                            <li class="breadcrumb-item active">Import CSV</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-12 col-md-6">
            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-4 text-primary">Upload File CSV</h5>
                    <form action="{{ route('opd.import') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Pilih File (.csv, .xlsx)</label>
                            <input type="file" name="file" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary mt-2">
                            <i class="las la-upload me-1"></i> Import Data
                        </button>
                        <a href="{{ route('opd.index') }}" class="btn btn-outline-secondary mt-2 ms-2">Batal</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
