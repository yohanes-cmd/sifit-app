@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-6 mx-auto mt-4">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Tambah Gudang Baru</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('gudang.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Nama Gudang <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="nama_gudang" required placeholder="Contoh: Gudang Farmasi Utama">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tipe Gudang <span class="text-danger">*</span></label>
                            <select class="form-select" name="tipe" required>
                                <option value="pusat">Pusat</option>
                                <option value="upt">UPT</option>
                                <option value="vaksin">Vaksin</option>
                                <option value="logistik">Logistik / Alkes</option>
                            </select>
                        </div>
                        <div class="text-end">
                            <a href="{{ route('gudang.index') }}" class="btn btn-secondary">Batal</a>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection