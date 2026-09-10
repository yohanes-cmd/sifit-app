@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-8 mx-auto mt-4">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Edit Instansi / OPD</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('opd.update', $opd->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label class="form-label">Nama Instansi / OPD <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="nama_opd" value="{{ old('nama_opd', $opd->nama_opd) }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Status Kepemilikan (Kantor 1 / 2) <span class="text-danger">*</span></label>
                            <select class="form-select" name="status_kantor" required>
                                <option value="kantor_pusat" {{ old('status_kantor', $opd->status_kantor) == 'kantor_pusat' ? 'selected' : '' }}>Kantor Pusat (Dinkes)</option>
                                <option value="puskesmas" {{ old('status_kantor', $opd->status_kantor) == 'puskesmas' ? 'selected' : '' }}>Puskesmas</option>
                                <option value="upt" {{ old('status_kantor', $opd->status_kantor) == 'upt' ? 'selected' : '' }}>UPT Farmasi / Logistik</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Alamat Lengkap</label>
                            <textarea class="form-control" name="alamat" rows="3">{{ old('alamat', $opd->alamat) }}</textarea>
                        </div>
                        <div class="text-end">
                            <a href="{{ route('opd.index') }}" class="btn btn-secondary">Batal</a>
                            <button type="submit" class="btn btn-warning">Perbarui Instansi</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection