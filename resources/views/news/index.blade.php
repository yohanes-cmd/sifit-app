@extends('layouts.app')

@section('title', 'Manajemen Berita - SiFit')

@push('css')
    <link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <!-- Summernote CSS -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    <style>
        .note-editor .dropdown-toggle::after { all: unset; }
        .note-editor .dropdown-menu { min-width: 90px; }
    </style>
@endpush

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title">Manajemen Berita & Informasi</h4>
                <button class="btn btn-primary" id="btnTambahNews">
                    <i class="fas fa-plus"></i> Tambah Berita
                </button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered dt-responsive nowrap" id="tabelNews" style="width: 100%;">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th>Judul Berita</th>
                                <th>Kategori</th>
                                <th>Penulis</th>
                                <th>Status</th>
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

<!-- Modal Form (Tambah & Edit) -->
<div class="modal fade" id="modalNews" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="formNews" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title" id="judulModal">Tambah Berita</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="news_id" id="news_id">
                    
                    <div class="mb-3">
                        <label for="title" class="form-label">Judul Berita <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="title" name="title" placeholder="Masukkan judul berita..." required>
                        <span class="text-danger error-text title_error"></span>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="category_id" class="form-label">Kategori <span class="text-danger">*</span></label>
                            <select class="form-select" id="category_id" name="category_id" required>
                                <option value="">-- Pilih Kategori --</option>
                                @foreach(\App\Models\Category::all() as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endforeach
                            </select>
                            <span class="text-danger error-text category_id_error"></span>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="status" class="form-label">Status Publikasi <span class="text-danger">*</span></label>
                            <select class="form-select" id="status" name="status" required>
                                <option value="draft">Draft (Simpan sementara)</option>
                                <option value="publish">Publish (Tampilkan ke publik)</option>
                            </select>
                            <span class="text-danger error-text status_error"></span>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="content" class="form-label">Isi Berita / Konten <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="content" name="content" rows="6" placeholder="Tulis konten berita di sini..." required></textarea>
                        <span class="text-danger error-text content_error"></span>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="image" class="form-label">Thumbnail / Gambar Utama</label>
                            <input type="file" class="form-control" id="image" name="image" accept="image/*">
                            <small class="text-muted">Format: JPG, PNG, WEBP (Maks. 2MB)</small>
                            <span class="text-danger error-text image_error"></span>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="pdf_file" class="form-label">Lampiran Dokumen (Opsional)</label>
                            <input type="file" class="form-control" id="pdf_file" name="pdf_file" accept=".pdf">
                            <small class="text-muted">Format: PDF (Maks. 10MB)</small>
                            <span class="text-danger error-text pdf_file_error"></span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" id="btnSimpan">Simpan Berita</button>
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
    <!-- Summernote JS -->
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>

    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
            });

            // Inisialisasi Summernote
            $('#content').summernote({
                placeholder: 'Tulis isi berita atau informasi di sini...',
                tabsize: 2,
                height: 300, // Saya tinggikan sedikit jadi 300 agar lebih lega
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    // Tambahkan 'picture' dan 'video' di baris bawah ini:
                    ['insert', ['link', 'picture', 'video']], 
                    ['view', ['fullscreen', 'codeview', 'help']]
                ]
            });

            var table = $('#tabelNews').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('news.index') }}",
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
                    {data: 'title', name: 'title'},
                    {data: 'category_name', name: 'category_name', orderable: false, searchable: false},
                    {data: 'author_name', name: 'author_name', orderable: false, searchable: false},
                    {data: 'status_badge', name: 'status_badge', orderable: false, searchable: false},
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

            $('#btnTambahNews').click(function() {
                $('#formNews').trigger("reset");
                $('#news_id').val('');
                $('#content').summernote('code', ''); // Kosongkan editor saat tambah
                $('.error-text').text('');
                $('#judulModal').html("Tambah Berita Baru");
                $('#modalNews').modal('show');
            });

            $('body').on('click', '.editNews', function() {
                var news_id = $(this).data('id');
                $.get("{{ route('news.index') }}/" + news_id + "/edit", function(data) {
                    $('#judulModal').html("Edit Berita");
                    $('.error-text').text('');
                    $('#modalNews').modal('show');
                    
                    $('#news_id').val(data.id);
                    $('#title').val(data.title);
                    $('#category_id').val(data.category_id);
                    $('#status').val(data.status);
                    
                    // Masukkan konten ke Summernote saat edit
                    $('#content').summernote('code', data.content); 
                });
            });

            $('#formNews').submit(function(e) {
                e.preventDefault();
                $('#btnSimpan').html('Menyimpan...');
                $('.error-text').text('');

                var id = $('#news_id').val();
                var actionUrl = id ? "{{ route('news.index') }}/" + id : "{{ route('news.store') }}";
                
                var formData = new FormData(this);
                if (id) {
                    formData.append('_method', 'PUT');
                }

                $.ajax({
                    url: actionUrl,
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(data) {
                        $('#btnSimpan').html('Simpan Berita');
                        if (data.status === 'error') {
                            if (data.errors.title) $('.title_error').text(data.errors.title[0]);
                            if (data.errors.category_id) $('.category_id_error').text(data.errors.category_id[0]);
                            if (data.errors.content) $('.content_error').text(data.errors.content[0]);
                            if (data.errors.status) $('.status_error').text(data.errors.status[0]);
                            if (data.errors.image) $('.image_error').text(data.errors.image[0]);
                            if (data.errors.pdf_file) $('.pdf_file_error').text(data.errors.pdf_file[0]);
                        } else {
                            $('#formNews').trigger("reset");
                            $('#content').summernote('code', ''); // Kosongkan editor
                            $('#modalNews').modal('hide');
                            table.draw();
                            Toast.fire({ icon: 'success', title: data.message });
                        }
                    },
                    error: function(xhr) {
                        $('#btnSimpan').html('Simpan Berita');
                        Swal.fire('Gagal!', 'Terjadi kesalahan sistem.', 'error');
                    }
                });
            });

            $('body').on('click', '.deleteNews', function() {
                var news_id = $(this).data("id");
                Swal.fire({
                    title: 'Apakah Anda Yakin?',
                    text: "Berita akan dihapus permanen!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, Hapus!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "DELETE",
                            url: "{{ route('news.index') }}/" + news_id,
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