@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-6 mx-auto mt-4">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Edit Master Gudang</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('gudang.update', $gudang->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label class="form-label">Nama Gudang <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="nama_gudang" value="{{ old('nama_gudang', $gudang->nama_gudang) }}" required>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Tipe Gudang <span class="text-danger">*</span></label>
                            <select class="form-select" name="tipe" required>
                                <option value="pusat" {{ (old('tipe', $gudang->tipe) == 'pusat') ? 'selected' : '' }}>Pusat</option>
                                <option value="upt" {{ (old('tipe', $gudang->tipe) == 'upt') ? 'selected' : '' }}>UPT</option>
                                <option value="vaksin" {{ (old('tipe', $gudang->tipe) == 'vaksin') ? 'selected' : '' }}>Vaksin</option>
                                <option value="logistik" {{ (old('tipe', $gudang->tipe) == 'logistik') ? 'selected' : '' }}>Logistik / Alkes</option>
                            </select>
                        </div>
                        
                        <div class="text-end">
                            <a href="{{ route('gudang.index') }}" class="btn btn-secondary">Batal</a>
                            <button type="submit" class="btn btn-warning">Perbarui Data</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection