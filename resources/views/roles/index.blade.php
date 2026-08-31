@extends('layouts.app')

@section('title', 'Manajemen Role - SiFit')

@push('css')
    <link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <style>
        /* Styling tambahan agar kotak-kotak permission rapi */
        .permission-card {
            border: 1px solid #e3e6f0;
            border-radius: 5px;
            padding: 10px;
            margin-bottom: 15px;
            background: #f8f9fc;
        }
        .permission-card-header {
            font-weight: bold;
            margin-bottom: 8px;
            text-transform: capitalize;
            border-bottom: 1px solid #e3e6f0;
            padding-bottom: 4px;
        }
    </style>
@endpush

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Manajemen Role</h4>
            </div>
            <div class="card-body">
                <button class="btn btn-primary mb-4" id="btnTambahRole">
                    <i class="fas fa-plus"></i> Tambah Role
                </button>

                <div class="table-responsive">
                    <table class="table table-bordered dt-responsive nowrap" id="tabelRole" style="width: 100%;">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th>Nama Role</th>
                                <th>Akses Data</th>
                                <th>Jumlah Permission</th>
                                <th width="15%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Form (Edit & Tambah) -->
<div class="modal fade" id="modalRole" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg"> <!-- modal-lg agar lebar muat menampung grid -->
        <div class="modal-content">
            <form id="formRole">
                <div class="modal-header">
                    <h5 class="modal-title" id="judulModal">Tambah Role</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="role_id" id="role_id">
                    
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Role <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Misal: admin_opd" required>
                        <span class="text-danger error-text name_error"></span>
                    </div>

                    <div class="mb-3">
                        <label for="akses_data" class="form-label">Cakupan Akses Data <span class="text-danger">*</span></label>
                        <select class="form-select" id="akses_data" name="akses_data" required>
                            <option value="">-- Pilih Cakupan --</option>
                            <option value="Global">Global (Bisa akses semua data sistem)</option>
                            <option value="OPD">OPD (Hanya akses data di OPD miliknya)</option>
                            <!-- INI OPSI BARU UNTUK VIEWER/CUSTOMER -->
                            <option value="Personal">Personal / Publik (Hanya belanja & akses front-end)</option>
                        </select>
                        <span class="text-danger error-text akses_data_error"></span>
                    </div>

                    <hr>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <label class="form-label fw-bold mb-0">Pengaturan Hak Akses (Permissions)</label>
                        <button type="button" class="btn btn-sm btn-outline-primary" id="btnPilihSemua">Pilih Semua</button>
                    </div>

                    <!-- Container Kotak-kotak Permission per Modul -->
                    <div class="row" id="permissionContainer">
                        @php
                            $modules = ['opd', 'user', 'role', 'katalog', 'berita', 'kategori-berita', 'metadata', 'data-spasial', 'jdih', 'ogc', 'tes'];
                            $actions = ['view', 'create', 'edit', 'delete', 'submit', 'verify', 'validate', 'publish', 'unpublish', 'reject_verification', 'reject_validation', 'revise'];
                        @endphp

                        @foreach($modules as $module)
                            <div class="col-md-4">
                                <div class="permission-card">
                                    <div class="permission-card-header d-flex justify-content-between align-items-center">
                                        <span>{{ ucwords(str_replace('-', ' ', $module)) }}</span>
                                        <input type="checkbox" class="form-check-input select-module-all" data-module="{{ $module }}" title="Pilih semua di modul ini">
                                    </div>
                                    <div class="permission-body">
                                        @foreach($actions as $action)
                                            @php $permName = $module . '-' . $action; @endphp
                                            <div class="form-check form-check-inline mb-1" style="width: 48%;">
                                                <input class="form-check-input permission-checkbox module-{{ $module }}" type="checkbox" name="permissions[]" value="{{ $permName }}" id="perm_{{ $permName }}">
                                                <label class="form-check-label" for="perm_{{ $permName }}" style="font-size: 0.85rem;">
                                                    {{ $action }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" id="btnSimpan">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
            });

            var table = $('#tabelRole').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('roles.index') }}",
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
                    {data: 'name', name: 'name'},
                    {
                        data: 'akses_data', 
                        name: 'akses_data', 
                        orderable: false, 
                        searchable: false,
                        render: function(data) {
                            if (data === 'Global') return '<span class="badge bg-danger">Global</span>';
                            if (data === 'OPD') return '<span class="badge bg-primary">OPD</span>';
                            // INI TAMBAHAN BADGE UNTUK PERSONAL
                            if (data === 'Personal') return '<span class="badge bg-success">Personal</span>';
                            return '<span class="badge bg-secondary">Belum Diatur</span>';
                        }
                    },
                    {data: 'jumlah_permission', name: 'jumlah_permission', orderable: false, searchable: false},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ]
            });

            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
            });

            // Tombol Tambah Role
            $('#btnTambahRole').click(function() {
                $('#formRole').trigger("reset");
                $('#role_id').val('');
                $('.error-text').text('');
                $('.permission-checkbox').prop('checked', false);
                $('.select-module-all').prop('checked', false);
                $('#judulModal').html("Tambah Role Baru");
                $('#modalRole').modal('show');
            });

            // Tombol Edit Role (Mengambil data permission & mencentangnya otomatis)
            $('body').on('click', '.editRole', function() {
                var role_id = $(this).data('id');
                $.get("{{ route('roles.index') }}/" + role_id + "/edit", function(data) {
                    $('#judulModal').html("Edit Role & Permissions");
                    $('.error-text').text('');
                    $('#modalRole').modal('show');
                    
                    $('#role_id').val(data.role.id);
                    $('#name').val(data.role.name);
                    $('#akses_data').val(data.role.akses_data);

                    // Bersihkan semua centang dulu
                    $('.permission-checkbox').prop('checked', false);
                    $('.select-module-all').prop('checked', false);

                    // Centang checkbox sesuai data permission yang dimiliki role ini
                    if (data.rolePermissions) {
                        data.rolePermissions.forEach(function(permName) {
                            $('#perm_' + permName.replace(/\./g, '\\.')).prop('checked', true);
                        });
                    }
                });
            });

            // Fitur Pilih Semua Global
            let allSelected = false;
            $('#btnPilihSemua').click(function() {
                allSelected = !allSelected;
                $('.permission-checkbox').prop('checked', allSelected);
                $('.select-module-all').prop('checked', allSelected);
                $(this).text(allSelected ? 'Batal Pilih Semua' : 'Pilih Semua');
            });

            // Fitur Pilih Semua per Modul
            $('.select-module-all').change(function() {
                let moduleName = $(this).data('module');
                let isChecked = $(this).prop('checked');
                $('.module-' + moduleName).prop('checked', isChecked);
            });

            // Submit Form Role
            $('#formRole').submit(function(e) {
                e.preventDefault();
                $('#btnSimpan').html('Menyimpan...');
                $('.error-text').text('');

                var id = $('#role_id').val();
                var actionUrl = id ? "{{ route('roles.index') }}/" + id : "{{ route('roles.store') }}";
                var actionType = id ? "PUT" : "POST";

                $.ajax({
                    url: actionUrl,
                    type: actionType,
                    data: $(this).serialize(),
                    dataType: 'json',
                    success: function(data) {
                        $('#btnSimpan').html('Simpan');
                        if (data.status === 'error') {
                            if (data.errors.name) $('.name_error').text(data.errors.name[0]);
                            if (data.errors.akses_data) $('.akses_data_error').text(data.errors.akses_data[0]);
                        } else {
                            $('#formRole').trigger("reset");
                            $('#modalRole').modal('hide');
                            table.draw();
                            Toast.fire({ icon: 'success', title: data.message });
                        }
                    },
                    error: function(xhr) {
                        $('#btnSimpan').html('Simpan');
                        Swal.fire('Gagal!', 'Terjadi kesalahan sistem.', 'error');
                    }
                });
            });

            // Hapus Role
            $('body').on('click', '.deleteRole', function() {
                var role_id = $(this).data("id");
                Swal.fire({
                    title: 'Apakah Anda Yakin?',
                    text: "Data role akan dihapus permanen!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, Hapus!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "DELETE",
                            url: "{{ route('roles.index') }}/" + role_id,
                            success: function(data) {
                                table.draw();
                                Toast.fire({ icon: 'success', title: data.message });
                            }
                        });
                    }
                });
            });
        });
    </script>
@endpush