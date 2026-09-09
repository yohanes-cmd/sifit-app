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
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">Informasi Ketersediaan Barang (Real-time)</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead class="thead-light">
                                <tr>
                                    <th>No</th>
                                    <th>Kode Barang</th>
                                    <th>Nama Barang</th>
                                    <th>Kategori</th>
                                    <th>No Batch</th>
                                    <th>Lokasi Gudang</th>
                                    <th>Sisa Stok</th>
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
                                    <td>{{ $stok->gudang->nama_gudang ?? '-' }}</td>
                                    <td>
                                        <h5 class="m-0"><span class="badge bg-primary">{{ $stok->jumlah }} {{ $stok->masterObat->satuan ?? '' }}</span></h5>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center">Belum ada data persediaan stok di gudang manapun.</td>
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