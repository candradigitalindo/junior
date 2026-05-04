@extends('layouts.office')

@section('title', 'Extra Service')

@section('content')
<div class="intro-y d-flex flex-column flex-sm-row align-items-center mt-8">
    <h2 class="fs-lg fw-medium me-auto">
        Extra Service
    </h2>
    <div class="w-full w-sm-auto d-flex mt-4 mt-sm-0">
        <button class="btn btn-primary shadow-md me-2" data-bs-toggle="modal" data-bs-target="#modal-form" id="btn-tambah">
            <i data-feather="plus-circle" class="w-4 h-4 me-2"></i> Tambah Extra Service
        </button>
    </div>
</div>

<div class="grid columns-12 gap-6 mt-5">
    <div class="intro-y g-col-12 overflow-auto overflow-lg-visible">
        <div class="box p-5 mt-5">
            <table class="table table-report mt-n2" id="tabel-extra" width="100%">
                <thead>
                    <tr>
                        <th class="text-nowrap" style="width: 5%">NO</th>
                        <th class="text-nowrap">PRODUK</th>
                        <th class="text-nowrap">NAMA EXTRA SERVICE</th>
                        <th class="text-nowrap">HARGA</th>
                        <th class="text-nowrap">DESKRIPSI</th>
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
                <h2 class="fw-medium fs-base me-auto" id="modal-title">
                    Tambah Extra Service
                </h2>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger mb-4" style="display:none" id="error-container">
                    <ul id="error-list" class="mb-0"></ul>
                </div>
                <input type="hidden" id="service-id">
                <div class="mb-3">
                    <label for="product" class="form-label">Produk</label>
                    <select id="product" class="form-select"></select>
                </div>
                <div class="mb-3">
                    <label for="name" class="form-label">Nama Extra Service</label>
                    <input type="text" class="form-control" placeholder="Nama Extra Service" id="name">
                </div>
                <div class="mb-3">
                    <label for="price" class="form-label">Harga</label>
                    <div class="input-group">
                        <div class="input-group-text">Rp</div>
                        <input type="text" class="form-control" placeholder="Harga" id="price">
                    </div>
                </div>
                <div class="mb-0">
                    <label for="description" class="form-label">Deskripsi</label>
                    <textarea class="form-control" id="description" rows="3" placeholder="Deskripsi (opsional)"></textarea>
                </div>
            </div>
            <div class="modal-footer text-end">
                <button type="button" data-bs-dismiss="modal" class="btn btn-outline-secondary w-32 me-1">Batal</button>
                <button type="button" class="btn btn-primary w-32" id="btn-simpan">Simpan</button>
            </div>
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
</style>
@endsection

@section('js')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
    $(document).ready(function() {
        const table = $('#tabel-extra').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            ajax: "{{ route('extraservice.index') }}",
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'product_name', name: 'product_name' },
                { data: 'name', name: 'name', className: 'fw-medium' },
                { data: 'price', name: 'price' },
                { data: 'description', name: 'description' },
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

        // Initialize Products
        let productsLoaded = false;
        function loadProducts(selectedId = null) {
            return $.ajax({
                url: "{{ route('extraservice.create') }}",
                type: 'GET',
                success: function(res) {
                    if (res.status === 'sukses') {
                        const select = $('#product');
                        select.empty().append('<option value="">--- Pilih Produk ---</option>');
                        res.data.forEach(item => {
                            select.append(`<option value="${item.id}" ${selectedId == item.id ? 'selected' : ''}>${item.name}</option>`);
                        });
                        productsLoaded = true;
                    }
                }
            });
        }

        $('#btn-tambah').on('click', function() {
            resetModal();
            $('#modal-title').text('Tambah Extra Service');
            $('#btn-simpan').text('Simpan');
            loadProducts();
        });

        function resetModal() {
            $('#service-id').val('');
            $('#name').val('');
            $('#price').val('');
            $('#description').val('');
            $('#product').val('');
            $('#error-container').hide();
        }

        // Rupiah Formatter
        function formatRupiah(angka, prefix) {
            var number_string = angka.replace(/[^,\d]/g, "").toString(),
                split = number_string.split(","),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            if (ribuan) {
                separator = sisa ? "." : "";
                rupiah += separator + ribuan.join(".");
            }

            rupiah = split[1] != undefined ? rupiah + "," + split[1] : rupiah;
            return prefix == undefined ? rupiah : rupiah ? "Rp. " + rupiah : "";
        }

        $("#price").on("keyup", function() {
            $(this).val(formatRupiah($(this).val()));
        });

        $('#btn-simpan').on('click', function() {
            const id = $('#service-id').val();
            const url = id ? "{{ route('extraservice.update', ':id') }}".replace(':id', id) : "{{ route('extraservice.store') }}";
            const method = id ? "PUT" : "POST";

            $.ajax({
                url: url,
                type: method,
                data: {
                    product: $('#product').val(),
                    name: $('#name').val(),
                    price: $('#price').val().replace(/\./g, ''), // Strip dots
                    description: $('#description').val(),
                    _token: "{{ csrf_token() }}"
                },
                success: function(res) {
                    if (res.status === 'sukses') {
                        $('#modal-form').modal('hide');
                        table.ajax.reload();
                        swal("Berhasil!", res.text, "success");
                    } else if (res.status === 'error') {
                        $('#error-list').empty();
                        res.errors.forEach(err => $('#error-list').append(`<li>${err}</li>`));
                        $('#error-container').show();
                    } else {
                        swal("Gagal!", res.text, "error");
                    }
                }
            });
        });

        $(document).on('click', '.edit', function() {
            const id = $(this).attr('id');
            resetModal();
            $('#modal-title').text('Edit Extra Service');
            $('#btn-simpan').text('Update');
            
            $.ajax({
                url: "{{ route('extraservice.edit', ':id') }}".replace(':id', id),
                type: 'GET',
                success: function(res) {
                    if (res.status === 'sukses') {
                        $('#service-id').val(res.data.id);
                        $('#name').val(res.data.name);
                        $('#price').val(formatRupiah(res.data.price.toString())); // Format on load
                        $('#description').val(res.data.description);
                        
                        loadProducts(res.data.product_id).then(() => {
                            $('#modal-form').modal('show');
                        });
                    }
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
                        url: "{{ route('extraservice.destroy', ':id') }}".replace(':id', id),
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

