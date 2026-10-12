@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <h4 class="page-title">Master Instansi / OPD Penerima</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">Daftar Instansi Terdaftar</h4>
                    <a href="{{ route('opd.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Tambah Instansi
                    </a>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead class="thead-light">
                                <tr>
                                    <th>No</th>
                                    <th>Nama Instansi / OPD</th>
                                    <th>Status Kepemilikan</th>
                                    <th>Alamat</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($opds as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td><strong>{{ $item->nama_opd }}</strong></td>
                                    <td>
                                        @php
                                            $statusObj = \App\Models\StatusKantor::where('slug', $item->status_kantor)->first();
                                            $statusLabel = $statusObj ? $statusObj->nama_status : \Illuminate\Support\Str::title(str_replace('_', ' ', $item->status_kantor));
                                        @endphp
                                        <span class="badge bg-primary">{{ $statusLabel }}</span>
                                    </td>
                                    <td>{{ $item->alamat ?? '-' }}</td>
                                    <td>
                                        <a href="{{ route('opd.edit', $item->id) }}" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i> Edit</a>
                                        <form action="{{ route('opd.destroy', $item->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Yakin ingin menghapus Instansi ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i> Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center">Belum ada data Instansi / OPD.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection