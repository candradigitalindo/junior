@extends('layouts.office')

@section('title')
    Kategori Layanan | JUNIOR AUTO CARE
@endsection

@section('content')
    <div class="grid columns-12 gap-6">
        <div class="g-col-12">
            <div class="intro-y d-flex flex-column flex-sm-row align-items-center mt-8">
                <h2 class="fs-2xl fw-bold truncate me-auto">
                    Kategori Layanan
                </h2>
                <div class="w-full w-sm-auto d-flex mt-4 mt-sm-0">
                    <button class="btn btn-primary shadow-md me-2" data-bs-toggle="modal" data-bs-target="#modal-tambah" id="tambah">
                        <i data-feather="plus-circle" class="w-4 h-4 me-2"></i> Tambah Kategori
                    </button>
                </div>
            </div>
        </div>

        <div class="g-col-12 mt-2">
            <div class="intro-y box p-5">
                <div class="overflow-x-auto">
                    <table class="table table-report display w-full" id="tabel-category">
                        <thead>
                            <tr>
                                <th class="text-nowrap" style="width: 5%">NO</th>
                                <th class="text-nowrap">NAMA KATEGORI</th>
                                <th class="text-nowrap text-center">TOTAL PRODUK</th>
                                <th class="text-center text-nowrap">AKSI</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL TAMBAH/EDIT -->
    <div id="modal-tambah" class="modal fade" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="fw-bold fs-xl me-auto" id="modal-title">Registrasi Kategori</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-10">
                    <div class="alert alert-danger print-error-msg mb-5" style="display:none" id="error">
                        <ul class="mb-0"></ul>
                    </div>
                    <div class="g-col-12">
                        <label class="form-label fw-semibold">Nama Kategori</label>
                        <input type="text" class="form-control form-control-lg border-2" placeholder="Contoh: EXTERIOR CARE" id="name">
                    </div>
                    <input type="hidden" id="id">
                </div>
                <div class="modal-footer bg-gray-50">
                    <button type="button" data-bs-dismiss="modal" class="btn btn-outline-secondary w-32 me-2">Batal</button>
                    <button type="button" class="btn btn-primary w-40" id="simpan">Simpan Kategori</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('css')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.4/css/jquery.dataTables.css">
    <style>
        .table-report { border-collapse: separate; border-spacing: 0 10px; margin-top: -10px !important; }
        .table-report tr { border-radius: 10px; transition: all 0.3s; }
        .table-report td { background: #fff; border: none !important; padding: 15px 20px !important; }
        .table-report td:first-child { border-radius: 10px 0 0 10px; }
        .table-report td:last-child { border-radius: 0 10px 10px 0; }
        .dark .table-report td { background: #293145; }
    </style>
@endsection

@section('js')
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            const table = $('#tabel-category').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                ajax: "{{ route('category.index') }}",
                columns: [
                    {
                        "data": null, "sortable": false,
                        render: (data, type, row, meta) => `<div class="fw-bold text-gray-400">${meta.row + meta.settings._iDisplayStart + 1}</div>`
                    },
                    { data: 'name', name: 'name' },
                    { data: 'product_count', name: 'product_count' },
                    { data: 'aksi', name: 'aksi' }
                ],
                dom: '<"d-flex flex-wrap align-items-center justify-content-between mb-4"f>t<"d-flex flex-wrap align-items-center justify-content-between mt-4"ip>'
            });

            $('#tambah').on('click', function() {
                $('#name').val('');
                $('#id').val('');
                $('#modal-title').text('Tambah Kategori');
                $("#simpan").text('Simpan Kategori');
                $("#error").hide();
            });

            $("#simpan").on('click', function() {
                const isEdit = $(this).text() === 'Update Kategori';
                const id = $('#id').val();
                const url = isEdit ? "{{ route('category.update', ':id') }}".replace(':id', id) : "{{ route('category.store') }}";
                const method = isEdit ? "PUT" : "POST";

                $(this).text('Menyimpan...').prop('disabled', true);

                $.ajax({
                    url: url,
                    type: method,
                    data: {
                        name: $('#name').val(),
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(res) {
                        if (res.error) {
                            printErrorMsg(res.error);
                        } else if (res.status === 'gagal') {
                            Swal.fire('Gagal', res.text, 'error');
                        } else {
                            table.ajax.reload();
                            bootstrap.Modal.getInstance(document.getElementById('modal-tambah')).hide();
                            Swal.fire('Berhasil', res.text, 'success');
                        }
                        $("#simpan").text(isEdit ? 'Update Kategori' : 'Simpan Kategori').prop('disabled', false);
                    }
                });
            });

            $(document).on('click', '.edit', function() {
                const id = $(this).attr('id');
                $('#modal-title').text('Ubah Kategori');
                $("#simpan").text('Update Kategori');
                $("#error").hide();
                
                $.get("{{ route('category.edit', ':id') }}".replace(':id', id), (res) => {
                    $('#name').val(res.data.name);
                    $('#id').val(res.data.id);
                    bootstrap.Modal.getOrCreateInstance(document.getElementById('modal-tambah')).show();
                });
            });

            $(document).on('click', '.delete', function() {
                const id = $(this).attr('id');
                Swal.fire({
                    title: 'Hapus Kategori?',
                    text: "Data yang dihapus tidak dapat dikembalikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ef4444',
                    confirmButtonText: 'Ya, Hapus!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('category.destroy', ':id') }}".replace(':id', id),
                            type: 'DELETE',
                            data: { _token: "{{ csrf_token() }}" },
                            success: (res) => {
                                if (res.status === 'gagal') Swal.fire('Gagal', res.text, 'error');
                                else {
                                    Swal.fire('Terhapus!', res.text, 'success');
                                    table.ajax.reload();
                                }
                            }
                        });
                    }
                });
            });

            function printErrorMsg(msg) {
                $("#error").find("ul").html('');
                $("#error").show();
                $.each(msg, (key, value) => $("#error").find("ul").append(`<li>${value}</li>`));
            }
        });
    </script>
@endsection
