@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-8 mx-auto mt-4">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Tambah Instansi / OPD Baru</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('opd.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Nama Instansi / OPD <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="nama_opd" required placeholder="Contoh: Puskesmas Rumbai">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Status Kepemilikan (Kantor 1 / 2) <span class="text-danger">*</span></label>
                            <select class="form-select" name="status_kantor" required>
                                <option value="">-- Pilih Status --</option>
                                <option value="kantor_pusat">Kantor Pusat (Dinkes)</option>
                                <option value="puskesmas">Puskesmas</option>
                                <option value="upt">UPT Farmasi / Logistik</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Alamat Lengkap</label>
                            <textarea class="form-control" name="alamat" rows="3" placeholder="Opsional..."></textarea>
                        </div>
                        <div class="text-end">
                            <a href="{{ route('opd.index') }}" class="btn btn-secondary">Batal</a>
                            <button type="submit" class="btn btn-primary">Simpan Instansi</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection