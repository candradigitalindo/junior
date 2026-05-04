@extends('layouts.office')

@section('title', 'Tipe Mobil')

@section('content')
<div class="intro-y d-flex flex-column flex-sm-row align-items-center mt-8">
    <h2 class="fs-lg fw-medium me-auto">
        Tipe Mobil
    </h2>
    <div class="w-full w-sm-auto d-flex mt-4 mt-sm-0">
        <button class="btn btn-primary shadow-md me-2" data-bs-toggle="modal" data-bs-target="#modal-form" id="btn-tambah">
            <i data-feather="plus-circle" class="w-4 h-4 me-2"></i> Tambah Tipe Mobil
        </button>
    </div>
</div>

<div class="grid columns-12 gap-6 mt-5">
    <div class="intro-y g-col-12 overflow-auto overflow-lg-visible">
        <div class="box p-5 mt-5">
            <table class="table table-report mt-n2" id="tabel-tipe" width="100%">
                <thead>
                    <tr>
                        <th class="text-nowrap" style="width: 5%">NO</th>
                        <th class="text-center text-nowrap">FOTO</th>
                        <th class="text-nowrap">TIPE MOBIL</th>
                        <th class="text-center text-nowrap">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- BEGIN: Modal Form -->
<div id="modal-form" class="modal fade" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="fw-medium fs-base me-auto">
                    Tambah Tipe Mobil
                </h2>
            </div>
            <form id="form-tipe" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="alert alert-danger mb-4" style="display:none" id="error-container">
                        <ul id="error-list" class="mb-0"></ul>
                    </div>
                    <div class="mb-3">
                        <label for="photo" class="form-label">Foto</label>
                        <input name="photo" type="file" class="form-control" id="photo">
                        <div class="form-help text-xs text-gray-500 mt-1">Format: JPG, PNG, JPEG. Max 2MB.</div>
                    </div>
                    <div class="mb-0">
                        <label for="name" class="form-label">Nama Tipe Mobil</label>
                        <input name="name" type="text" class="form-control" placeholder="Contoh: TOYOTA AVANZA" id="name">
                    </div>
                </div>
                <div class="modal-footer text-end">
                    <button type="button" data-bs-dismiss="modal" class="btn btn-outline-secondary w-32 me-1">Batal</button>
                    <button type="submit" class="btn btn-primary w-32" id="btn-simpan">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- END: Modal Form -->
@endsection

@section('css')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.4/css/jquery.dataTables.css">
<style>
    .table-report {
        border-spacing: 0 10px;
        border-collapse: separate;
    }
    .table-report thead tr th {
        border-bottom-width: 0;
        padding-left: 1.25rem;
        padding-right: 1.25rem;
        padding-top: 0.75rem;
        padding-bottom: 0.75rem;
    }
    .table-report tbody tr {
        background-color: white;
        box-shadow: 0 3px 10px rgb(0 0 0 / 2%);
    }
    .table-report tbody tr td {
        border-bottom-width: 0;
        padding-left: 1.25rem;
        padding-right: 1.25rem;
        padding-top: 1rem;
        padding-bottom: 1rem;
    }
    .table-report tbody tr td:first-child {
        border-top-left-radius: 0.375rem;
        border-bottom-left-radius: 0.375rem;
    }
    .table-report tbody tr td:last-child {
        border-top-right-radius: 0.375rem;
        border-bottom-right-radius: 0.375rem;
    }
    .image-fit {
        position: relative;
    }
    .image-fit img {
        width: 100%;
        height: 100%;
    }
</style>
@endsection

@section('js')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
    $(document).ready(function() {
        const table = $('#tabel-tipe').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            ajax: "{{ route('tipemobil.index') }}",
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'photo', name: 'photo', orderable: false, searchable: false },
                { data: 'name', name: 'name', className: 'fw-medium' },
                { data: 'aksi', name: 'aksi', orderable: false, searchable: false }
            ],
            dom: '<"d-flex flex-column flex-sm-row align-items-center justify-content-between mb-4"lf>rt<"d-flex flex-column flex-sm-row align-items-center justify-content-between mt-4"ip>',
            language: {
                search: "",
                searchPlaceholder: "Cari...",
                lengthMenu: "Tampilkan _MENU_ data",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                paginate: {
                    previous: '<i class="w-4 h-4" data-feather="chevron-left"></i>',
                    next: '<i class="w-4 h-4" data-feather="chevron-right"></i>'
                }
            },
            drawCallback: function() {
                feather.replace();
            }
        });

        $('#btn-tambah').on('click', function() {
            $('#form-tipe')[0].reset();
            $('#error-container').hide();
        });

        $('#form-tipe').on('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            
            $.ajax({
                url: "{{ route('tipemobil.store') }}",
                type: 'POST',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function(res) {
                    if (res.status === 'sukses') {
                        $('#modal-form').modal('hide');
                        table.ajax.reload();
                        swal("Berhasil!", res.text, "success");
                    } else if (res.status === 'error') {
                        $('#error-list').empty();
                        res.errors.forEach(err => $('#error-list').append(`<li>${err}</li>`));
                        $('#error-container').show();
                    }
                },
                error: function() {
                    swal("Gagal!", "Terjadi kesalahan pada sistem.", "error");
                }
            });
        });

        $(document).on('click', '.delete', function() {
            const id = $(this).attr('id');
            swal({
                title: "Apakah Anda Yakin?",
                text: "Data yang dihapus tidak dapat dikembalikan!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        url: "{{ route('tipemobil.destroy', ':id') }}".replace(':id', id),
                        type: 'DELETE',
                        data: { _token: "{{ csrf_token() }}" },
                        success: function(res) {
                            if (res.status === 'sukses') {
                                table.ajax.reload();
                                swal("Berhasil!", res.text, "success");
                            } else {
                                swal("Gagal!", res.text, "error");
                            }
                        }
                    });
                }
            });
        });
    });
</script>
@endsection

