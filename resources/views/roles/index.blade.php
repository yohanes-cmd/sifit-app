@extends('layouts.app')

@section('title', 'Manajemen Role & Hak Akses (RBAC) - SiFit')

@push('css')
    <link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <style>
        .permission-group-title {
            font-size: 0.95rem;
            font-weight: 700;
            color: #495057;
            border-bottom: 2px solid #e9ecef;
            padding-bottom: 6px;
            margin-bottom: 12px;
            margin-top: 15px;
        }
        .permission-card {
            border: 1px solid #e3e6f0;
            border-radius: 6px;
            padding: 10px 12px;
            margin-bottom: 15px;
            background: #ffffff;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.05);
            transition: all 0.2s ease;
        }
        .permission-card:hover {
            border-color: #bac8f3;
            box-shadow: 0 0.25rem 0.5rem rgba(0, 0, 0, 0.08);
        }
        .permission-card-header {
            font-weight: 600;
            font-size: 0.88rem;
            margin-bottom: 8px;
            border-bottom: 1px solid #eef1f6;
            padding-bottom: 6px;
            color: #2c3e50;
        }
        .preset-badge-btn {
            font-size: 0.8rem;
            padding: 0.35rem 0.65rem;
            border-radius: 20px;
            cursor: pointer;
        }
        #modalRole .modal-dialog {
            max-width: 900px;
        }
        #modalRole .modal-body {
            max-height: calc(100vh - 210px);
            overflow-y: auto;
        }
    </style>
@endpush

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card shadow-sm">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="card-title mb-0 fw-bold"><i class="fas fa-user-shield text-primary me-2"></i>Manajemen Role & Hak Akses (RBAC)</h4>
                    <p class="text-muted small mb-0 mt-1">Konfigurasi hak akses modul farmasi untuk Super Admin, Admin OPD, dan peran lainnya.</p>
                </div>
                <button class="btn btn-primary" id="btnTambahRole">
                    <i class="fas fa-plus-circle me-1"></i> Tambah Role Baru
                </button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover dt-responsive nowrap" id="tabelRole" style="width: 100%;">
                        <thead class="table-light">
                            <tr>
                                <th width="5%" class="text-center">No</th>
                                <th>Nama Role</th>
                                <th>Cakupan Akses Data</th>
                                <th>Jumlah Hak Akses</th>
                                <th width="15%" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Form (Tambah & Ubah Role) -->
<div class="modal fade" id="modalRole" tabindex="-1" aria-hidden="true" style="z-index: 1060;">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <form id="formRole" class="d-flex flex-column h-100 mb-0">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title fw-bold" id="judulModal"><i class="fas fa-key me-2"></i>Tambah Role Baru</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="role_id" id="role_id">
                    
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label for="name" class="form-label fw-semibold">Nama Role <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Misal: admin_puskesmas" required>
                            <small class="text-muted">Gunakan huruf, spasi, atau underscore</small>
                            <span class="text-danger error-text name_error d-block"></span>
                        </div>

                        <div class="col-md-6">
                            <label for="akses_data" class="form-label fw-semibold">Cakupan Akses Data <span class="text-danger">*</span></label>
                            <select class="form-select" id="akses_data" name="akses_data" required>
                                <option value="">-- Pilih Cakupan --</option>
                                <option value="Global">Global (Gudang Pusat / Semua Data)</option>
                                <option value="OPD">OPD (Hanya data di OPD masing-masing)</option>
                                <option value="Personal">Personal / Publik (Front-end Belanja Obat)</option>
                            </select>
                            <small class="text-muted">Menentukan batasan akses data pemohon/gudang</small>
                            <span class="text-danger error-text akses_data_error d-block"></span>
                        </div>
                    </div>

                    <div class="card bg-light border-0 mb-3">
                        <div class="card-body p-3">
                            <div class="d-flex flex-wrap justify-content-between align-items-center gap-2">
                                <div>
                                    <span class="fw-bold text-dark d-block"><i class="fas fa-magic text-warning me-1"></i> Preset Hak Akses Cepat:</span>
                                    <small class="text-muted">Pilih paket standar untuk pengisian cepat</small>
                                </div>
                                <div class="d-flex flex-wrap gap-2">
                                    <button type="button" class="btn btn-outline-primary btn-sm preset-badge-btn" id="btnPresetAdminOpd">
                                        <i class="fas fa-hospital me-1"></i> Paket Admin OPD
                                    </button>
                                    <button type="button" class="btn btn-outline-danger btn-sm preset-badge-btn" id="btnPresetSuperAdmin">
                                        <i class="fas fa-warehouse me-1"></i> Paket Super Admin (Semua)
                                    </button>
                                    <button type="button" class="btn btn-outline-secondary btn-sm preset-badge-btn" id="btnResetSemua">
                                        <i class="fas fa-undo me-1"></i> Kosongkan
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr class="my-3">
                    <label class="form-label fw-bold mb-2 text-dark"><i class="fas fa-shield-alt text-primary me-1"></i> Rincian Hak Akses Modul Farmasi</label>

                    <!-- Container Modul & Permission -->
                    <div id="permissionContainer">
                        @foreach($permissionGroups as $groupName => $modules)
                            <div class="permission-group-title">
                                <i class="fas fa-folder-open text-primary me-2"></i>{{ $groupName }}
                            </div>
                            <div class="row">
                                @foreach($modules as $moduleKey => $moduleInfo)
                                    <div class="col-md-6 mb-2">
                                        <div class="permission-card h-100">
                                            <div class="permission-card-header d-flex justify-content-between align-items-center">
                                                <span title="{{ $moduleKey }}">{{ $moduleInfo['label'] }}</span>
                                                <div class="form-check m-0">
                                                    <input type="checkbox" class="form-check-input select-module-all" data-module="{{ $moduleKey }}" id="mod_all_{{ $moduleKey }}" title="Pilih semua hak akses di modul ini">
                                                    <label class="form-check-label small text-muted" for="mod_all_{{ $moduleKey }}">Semua</label>
                                                </div>
                                            </div>
                                            <div class="permission-body d-flex flex-wrap pt-1">
                                                @foreach($moduleInfo['actions'] as $actionKey => $actionLabel)
                                                    @php $permName = $moduleKey . '-' . $actionKey; @endphp
                                                    <div class="form-check me-3 mb-2" style="min-width: 45%;">
                                                        <input class="form-check-input permission-checkbox module-{{ $moduleKey }}" 
                                                               type="checkbox" 
                                                               name="permissions[]" 
                                                               value="{{ $permName }}" 
                                                               id="perm_{{ $permName }}"
                                                               data-module="{{ $moduleKey }}">
                                                        <label class="form-check-label small" for="perm_{{ $permName }}">
                                                            {{ $actionLabel }}
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endforeach
                    </div>

                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary px-4" id="btnSimpan">
                        <i class="fas fa-save me-1"></i> Simpan Role
                    </button>
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
                    {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false, className: 'text-center'},
                    {
                        data: 'name', 
                        name: 'name',
                        render: function(data) {
                            return '<strong>' + data + '</strong>';
                        }
                    },
                    {
                        data: 'akses_data', 
                        name: 'akses_data', 
                        orderable: false, 
                        searchable: false,
                        render: function(data) {
                            if (data === 'Global') return '<span class="badge bg-danger px-2 py-1"><i class="fas fa-globe me-1"></i>Global (Gudang Pusat)</span>';
                            if (data === 'OPD') return '<span class="badge bg-primary px-2 py-1"><i class="fas fa-hospital me-1"></i>OPD Pemohon</span>';
                            if (data === 'Personal') return '<span class="badge bg-info text-dark px-2 py-1"><i class="fas fa-user me-1"></i>Personal / Publik</span>';
                            return '<span class="badge bg-secondary px-2 py-1">Belum Diatur</span>';
                        }
                    },
                    {
                        data: 'jumlah_permission', 
                        name: 'jumlah_permission', 
                        orderable: false, 
                        searchable: false,
                        className: 'text-center',
                        render: function(data) {
                            return '<span class="badge bg-light text-dark border">' + data + ' Permission</span>';
                        }
                    },
                    {data: 'action', name: 'action', orderable: false, searchable: false, className: 'text-center'},
                ]
            });

            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
            });

            // Daftar hak akses standar Admin OPD
            const presetOpdPermissions = [
                'permohonan-view',
                'permohonan-create',
                'permohonan-edit',
                'permohonan-delete',
                'permohonan-print',
                'pemasukan-view',
                'pemasukan-print',
                'pengeluaran-view',
                'pengeluaran-create',
                'pengeluaran-print',
                'pemindahan-view',
                'pemindahan-create',
                'pemindahan-print',
                'master-obat-view'
            ];

            function syncModuleSelectAll() {
                $('.select-module-all').each(function() {
                    let moduleName = $(this).data('module');
                    let checkboxes = $('.module-' + moduleName);
                    let checkedCount = checkboxes.filter(':checked').length;
                    $(this).prop('checked', checkedCount > 0 && checkedCount === checkboxes.length);
                });
            }

            // Tombol Tambah Role
            $('#btnTambahRole').click(function() {
                $('#formRole').trigger("reset");
                $('#role_id').val('');
                $('.error-text').text('');
                $('.permission-checkbox').prop('checked', false);
                $('.select-module-all').prop('checked', false);
                $('#judulModal').html('<i class="fas fa-plus-circle me-2"></i>Tambah Role Baru');
                $('#modalRole').modal('show');
            });

            // Tombol Edit Role
            $('body').on('click', '.editRole', function() {
                var role_id = $(this).data('id');
                $.get("{{ route('roles.index') }}/" + role_id + "/edit", function(data) {
                    $('#judulModal').html('<i class="fas fa-edit me-2"></i>Edit Role & Hak Akses');
                    $('.error-text').text('');
                    $('#modalRole').modal('show');
                    
                    $('#role_id').val(data.role.id);
                    $('#name').val(data.role.name);
                    $('#akses_data').val(data.role.akses_data);

                    // Reset semua centang
                    $('.permission-checkbox').prop('checked', false);
                    $('.select-module-all').prop('checked', false);

                    // Centang hak akses yang dimiliki
                    if (data.rolePermissions && data.rolePermissions.length > 0) {
                        data.rolePermissions.forEach(function(permName) {
                            $('#perm_' + permName.replace(/\./g, '\\.')).prop('checked', true);
                        });
                    }
                    syncModuleSelectAll();
                });
            });

            // Presets
            $('#btnPresetAdminOpd').click(function() {
                $('#akses_data').val('OPD');
                $('.permission-checkbox').prop('checked', false);
                presetOpdPermissions.forEach(function(perm) {
                    $('#perm_' + perm).prop('checked', true);
                });
                syncModuleSelectAll();
                Toast.fire({ icon: 'info', title: 'Paket Hak Akses Admin OPD telah diterapkan!' });
            });

            $('#btnPresetSuperAdmin').click(function() {
                $('#akses_data').val('Global');
                $('.permission-checkbox').prop('checked', true);
                $('.select-module-all').prop('checked', true);
                Toast.fire({ icon: 'info', title: 'Paket Super Admin (Semua Hak Akses) telah diterapkan!' });
            });

            $('#btnResetSemua').click(function() {
                $('.permission-checkbox').prop('checked', false);
                $('.select-module-all').prop('checked', false);
                Toast.fire({ icon: 'info', title: 'Semua hak akses telah dikosongkan.' });
            });

            // Toggle per Modul
            $('.select-module-all').change(function() {
                let moduleName = $(this).data('module');
                let isChecked = $(this).prop('checked');
                $('.module-' + moduleName).prop('checked', isChecked);
            });

            $('.permission-checkbox').change(function() {
                syncModuleSelectAll();
            });

            // Submit Form Role
            $('#formRole').submit(function(e) {
                e.preventDefault();
                $('#btnSimpan').html('<i class="fas fa-spinner fa-spin me-1"></i> Menyimpan...').prop('disabled', true);
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
                        $('#btnSimpan').html('<i class="fas fa-save me-1"></i> Simpan Role').prop('disabled', false);
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
                        $('#btnSimpan').html('<i class="fas fa-save me-1"></i> Simpan Role').prop('disabled', false);
                        Swal.fire('Gagal!', 'Terjadi kesalahan sistem.', 'error');
                    }
                });
            });

            // Hapus Role
            $('body').on('click', '.deleteRole', function() {
                var role_id = $(this).data("id");
                Swal.fire({
                    title: 'Hapus Role Ini?',
                    text: "Seluruh hak akses yang melekat pada role ini akan ikut terhapus!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: '<i class="fas fa-trash me-1"></i> Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "DELETE",
                            url: "{{ route('roles.index') }}/" + role_id,
                            success: function(data) {
                                table.draw();
                                Toast.fire({ icon: 'success', title: data.message });
                            },
                            error: function() {
                                Swal.fire('Gagal!', 'Role tidak dapat dihapus karena masih digunakan.', 'error');
                            }
                        });
                    }
                });
            });
        });
    </script>
@endpush
