@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <h4 class="page-title">Daftar Stok Obat & Logistik</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="card-title m-0">Informasi Ketersediaan Barang (Real-time)</h4>
                        <a href="{{ route('stok-obat.export') }}" class="btn btn-success btn-sm">
                            <i class="fas fa-file-excel"></i> Export ke Excel
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead class="thead-light">
                                <tr>
                                    <th>No</th>
                                    <th>Kode Barang</th>
                                    <th>Nama Barang</th>
                                    <th>Kategori</th>
                                    <th>No Batch</th>
                                    <th>Expired Date</th>
                                    <th>Lokasi Gudang</th>
                                    <th>Sisa Stok</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($stokObats as $index => $stok)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $stok->masterObat->kode_obat ?? '-' }}</td>
                                    <td>{{ $stok->masterObat->nama_obat ?? '-' }}</td>
                                    <td>
                                        <span class="badge bg-{{ ($stok->masterObat->kategori ?? '') == 'Obat' ? 'success' : 'info' }}">
                                            {{ $stok->masterObat->kategori ?? '-' }}
                                        </span>
                                    </td>
                                    <td><strong>{{ $stok->no_batch }}</strong></td>
                                    
                                    <td>
                                        @if($stok->exp_date)
                                            @if(\Carbon\Carbon::parse($stok->exp_date)->isPast())
                                                <span class="badge bg-danger">{{ date('d-m-Y', strtotime($stok->exp_date)) }} (Expired)</span>
                                            @else
                                                <span class="badge bg-primary">{{ date('d-m-Y', strtotime($stok->exp_date)) }}</span>
                                            @endif
                                        @else
                                            <span class="text-muted">Belum diset</span>
                                        @endif
                                    </td>

                                    <td>{{ $stok->gudang->nama_gudang ?? '-' }}</td>
                                    <td>
                                        <h5 class="m-0"><span class="badge bg-primary">{{ $stok->jumlah }} {{ $stok->masterObat->satuan ?? '' }}</span></h5>
                                    </td>
                                    
                                    <td>
                                        <form action="{{ route('stok-obat.destroy', $stok->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data stok ini secara permanen?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="9" class="text-center">Belum ada data persediaan stok di gudang manapun.</td>
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