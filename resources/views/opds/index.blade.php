@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <h4 class="page-title">Manajemen OPD</h4>
        </div>
    </div>
</div>

<div class="row">
    <!-- Form Tambah OPD di sebelah kiri -->
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h5 class="header-title mt-0 mb-3">Tambah OPD Baru</h5>
                <form action="{{ route('opds.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label>Nama OPD <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" required placeholder="Misal: Dinas Kesehatan">
                    </div>
                    <button type="submit" class="btn btn-primary btn-block mt-3">Simpan OPD</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Tabel Daftar OPD di sebelah kanan -->
    <div class="col-md-8">
        @if(session('success'))
            <div class="alert alert-success border-0" role="alert">
                {{ session('success') }}
            </div>
        @endif

        <div class="card">
            <div class="card-body">
                <table class="table table-bordered mb-0">
                    <thead>
                        <tr>
                            <th width="10%">No</th>
                            <th>Nama OPD</th>
                            <th width="15%" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($opds as $key => $opd)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $opd->name }}</td>
                            <td class="text-center">
                                <form action="{{ route('opds.destroy', $opd->id) }}" method="POST" onsubmit="return confirm('Hapus OPD ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"><i class="las la-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="text-center">Belum ada data OPD.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection