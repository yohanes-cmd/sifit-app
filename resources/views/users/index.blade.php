@extends('layouts.app')

@section('title', 'Manajemen Pengguna - SiFit')

@push('css')
    <link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
@endpush

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Manajemen Data Pengguna</h4>
            </div>
            <div class="card-body">
                <button class="btn btn-primary mb-4" id="btnTambahUser">
                    <i class="fas fa-plus"></i> Tambah Pengguna
                </button>

                <div class="table-responsive">
                    <table class="table table-bordered dt-responsive nowrap" id="tabelUser" style="width: 100%;">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th>Nama Lengkap</th>
                                <th>Email</th>
                                <th>OPD</th> <!-- Kolom OPD Ditambahkan di Sini -->
                                <th>Role / Hak Akses</th>
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

<!-- Modal Form User -->
<div class="modal fade" id="modalUser" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="formUser">
                <div class="modal-header">
                    <h5 class="modal-title" id="judulModal">Tambah Pengguna</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="user_id" id="user_id">
                    
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="name" name="name" required>
                        <span class="text-danger error-text name_error"></span>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Alamat Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control" id="email" name="email" required>
                        <span class="text-danger error-text email_error"></span>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Minimal 6 karakter">
                        <small class="text-muted">Kosongkan jika tidak ingin mengubah password saat edit.</small>
                        <span class="text-danger error-text password_error"></span>
                    </div>

                    <div class="mb-3">
                        <label for="role" class="form-label">Pilih Role <span class="text-danger">*</span></label>
                        <select class="form-select" id="role" name="role" required>
                            <option value="">-- Pilih Role --</option>
                            @foreach($roles as $role)
                                <option value="{{ $role->name }}">{{ ucfirst($role->name) }}</option>
                            @endforeach
                        </select>
                        <span class="text-danger error-text role_error"></span>
                    </div>
                    
                    <div class="mb-3">
                        <label for="opd" class="form-label">OPD <span class="text-danger">*</span></label>
                        <!-- Tambahkan id="opd" agar terbaca oleh jQuery saat Edit -->
                        <select name="opd" id="opd" class="form-select" required>
                            <option value="">-- Pilih OPD --</option>
                            @foreach($opds as $opd)
                                <option value="{{ $opd->name }}">{{ $opd->name }}</option>
                            @endforeach
                        </select>
                        <span class="text-danger error-text opd_error"></span>
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

            var table = $('#tabelUser').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('users.index') }}",
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
                    {data: 'name', name: 'name'},
                    {data: 'email', name: 'email'},
                    {data: 'opd', name: 'opd'}, // Kolom OPD Ditambahkan ke DataTables
                    {data: 'role_name', name: 'role_name', orderable: false, searchable: false},
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

            $('#btnTambahUser').click(function() {
                $('#formUser').trigger("reset");
                $('#user_id').val('');
                $('.error-text').text('');
                $('#judulModal').html("Tambah Pengguna Baru");
                $('#modalUser').modal('show');
            });

            $('body').on('click', '.editUser', function() {
                var user_id = $(this).data('id');
                $.get("{{ route('users.index') }}/" + user_id + "/edit", function(data) {
                    $('#judulModal').html("Edit Pengguna");
                    $('.error-text').text('');
                    $('#modalUser').modal('show');
                    $('#user_id').val(data.user.id);
                    $('#name').val(data.user.name);
                    $('#email').val(data.user.email);
                    $('#role').val(data.role);
                    $('#opd').val(data.user.opd); // Mengisi nilai dropdown OPD
                    $('#password').val('');
                });
            });

            $('#formUser').submit(function(e) {
                e.preventDefault();
                $('#btnSimpan').html('Menyimpan...');
                $('.error-text').text('');

                var id = $('#user_id').val();
                var actionUrl = id ? "{{ route('users.index') }}/" + id : "{{ route('users.store') }}";
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
                            if (data.errors.email) $('.email_error').text(data.errors.email[0]);
                            if (data.errors.password) $('.password_error').text(data.errors.password[0]);
                            if (data.errors.role) $('.role_error').text(data.errors.role[0]);
                            if (data.errors.opd) $('.opd_error').text(data.errors.opd[0]);
                        } else {
                            $('#formUser').trigger("reset");
                            $('#modalUser').modal('hide');
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

            $('body').on('click', '.deleteUser', function() {
                var user_id = $(this).data("id");
                Swal.fire({
                    title: 'Apakah Anda Yakin?',
                    text: "Data pengguna akan dihapus permanen!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, Hapus!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "DELETE",
                            url: "{{ route('users.index') }}/" + user_id,
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