@extends('layouts.office')

@section('title')
    Manajemen Gudang | JUNIOR AUTO CARE
@endsection

@section('content')
    <div class="grid columns-12 gap-6">
        <div class="g-col-12">
            <div class="intro-y d-flex flex-column flex-sm-row align-items-center mt-8">
                <h2 class="fs-2xl fw-bold truncate me-auto">
                    Persediaan Barang & Stok
                </h2>
                <div class="w-full w-sm-auto d-flex mt-4 mt-sm-0 gap-2">
                    @if(strtolower(auth()->user()->role->role) != 'superadmin')
                    <button class="btn btn-primary shadow-md" data-bs-toggle="modal" data-bs-target="#modal-tambah" id="tambah">
                        <i data-feather="plus-circle" class="w-4 h-4 me-2"></i> Tambah Barang
                    </button>
                    <a href="{{ route('barang.masuk') }}" class="btn btn-success text-white shadow-md">
                        <i data-feather="download" class="w-4 h-4 me-2"></i> Barang Masuk
                    </a>
                    <a href="{{ route('barang.keluar') }}" class="btn btn-danger text-white shadow-md">
                        <i data-feather="upload" class="w-4 h-4 me-2"></i> Barang Keluar
                    </a>
                    @endif
                    <a href="{{ route('barcode.index') }}" class="btn btn-dark shadow-md">
                        <i data-feather="printer" class="w-4 h-4 me-2"></i> Barcode
                    </a>
                </div>
            </div>
        </div>

        <!-- Filter Section -->
        <div class="g-col-12 intro-y mt-2">
            <div class="box p-5">
                <div class="d-flex flex-column flex-sm-row align-items-end gap-4">
                    <div class="w-full w-sm-56">
                        <label class="form-label small fw-semibold text-gray-500">Tanggal Mulai</label>
                        <div class="input-group">
                            <div class="input-group-text bg-gray-100 border-2"><i data-feather="calendar" class="w-4 h-4"></i></div>
                            <input type="date" class="form-control border-2" id="start_date" value="{{ date('Y-m-d') }}">
                        </div>
                    </div>
                    <div class="w-full w-sm-56">
                        <label class="form-label small fw-semibold text-gray-500">Tanggal Akhir</label>
                        <div class="input-group">
                            <div class="input-group-text bg-gray-100 border-2"><i data-feather="calendar" class="w-4 h-4"></i></div>
                            <input type="date" class="form-control border-2" id="end_date" value="{{ date('Y-m-d') }}">
                        </div>
                    </div>
                    <button class="btn btn-primary w-full w-sm-32 shadow-md" id="btn-filter">
                        <i data-feather="search" class="w-4 h-4 me-2"></i> Filter
                    </button>
                    <button class="btn btn-outline-secondary w-full w-sm-32" id="btn-reset">
                        Reset
                    </button>
                </div>
            </div>
        </div>

        <div class="g-col-12 mt-2">
            <div class="intro-y box p-5">
                <div class="overflow-x-auto">
                    <table class="table table-report display w-full" id="tabel-barang">
                        <thead>
                            <tr>
                                <th class="text-nowrap" style="width: 5%">NO</th>
                                <th class="text-nowrap">NAMA BARANG</th>
                                <th class="text-nowrap">BARCODE</th>
                                <th class="text-nowrap text-center">MASUK (PERIODE)</th>
                                <th class="text-nowrap text-center">KELUAR (PERIODE)</th>
                                <th class="text-nowrap text-center">STOK SAAT INI</th>
                                <th class="text-nowrap">UPDATE TERAKHIR</th>
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
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="fw-bold fs-xl me-auto" id="modal-title">Registrasi Barang</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-10">
                    <div class="alert alert-danger print-error-msg mb-5" style="display:none" id="error">
                        <ul class="mb-0"></ul>
                    </div>
                    <div class="grid grid-cols-12 gap-6">
                        <div class="g-col-12 g-col-sm-6">
                            <label class="form-label fw-semibold">Nama Barang</label>
                            <input type="text" class="form-control form-control-lg border-2" placeholder="Contoh: Shampoo Salju" id="name">
                        </div>
                        <div class="g-col-12 g-col-sm-6">
                            <label class="form-label fw-semibold">Kode Barcode</label>
                            <input type="text" class="form-control form-control-lg border-2" placeholder="Scan atau Ketik Barcode" id="barcode">
                        </div>
                        <div class="g-col-12">
                            <label class="form-label fw-semibold">Keterangan / Deskripsi</label>
                            <textarea id="description" rows="4" class="form-control border-2" placeholder="Detail spesifikasi barang..."></textarea>
                        </div>
                    </div>
                    <input type="hidden" id="id">
                </div>
                <div class="modal-footer bg-gray-50">
                    <button type="button" data-bs-dismiss="modal" class="btn btn-outline-secondary w-32 me-2">Batal</button>
                    <button type="button" class="btn btn-primary w-40" id="simpan">Simpan Barang</button>
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
        .table-report td { background: #fff; border: none !important; padding: 15px 20px !important; vertical-align: middle !important; }
        .table-report td:first-child { border-radius: 10px 0 0 10px; }
        .table-report td:last-child { border-radius: 0 10px 10px 0; }
        .dark .table-report td { background: #293145; }
        
        .stok-badge { width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; border-radius: 10px; margin: 0 auto; font-weight: 800; }
    </style>
@endsection

@section('js')
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            function isi_tabel(start_date = '', end_date = '') {
                $('#tabel-barang').DataTable({
                    responsive: true, processing: true, serverSide: true, destroy: true,
                    ajax: {
                        url: "{{ route('gudang.index') }}",
                        data: { start_date: start_date, end_date: end_date }
                    },
                    columns: [
                        {
                            "data": null, "sortable": false,
                            render: (data, type, row, meta) => `<div class="fw-bold text-gray-400">${meta.row + meta.settings._iDisplayStart + 1}</div>`
                        },
                        { data: 'name', name: 'name' },
                        { data: 'barcode', name: 'barcode' },
                        { data: 'jml_barang_masuk', name: 'jml_barang_masuk' },
                        { data: 'jml_barang_keluar', name: 'jml_barang_keluar' },
                        { data: 'stok', name: 'stok' },
                        {
                            data: null,
                            render: (row) => {
                                return `<div class="text-xs text-gray-500">
                                            <div><i data-feather="arrow-down-left" class="w-3 h-3 text-success inline me-1"></i> ${row.barang_masuk || '-'}</div>
                                            <div class="mt-1"><i data-feather="arrow-up-right" class="w-3 h-3 text-danger inline me-1"></i> ${row.barang_keluar || '-'}</div>
                                        </div>`;
                            }
                        },
                        { data: 'aksi', name: 'aksi', sortable: false }
                    ],
                    drawCallback: function() { feather.replace(); },
                    dom: '<"d-flex flex-wrap align-items-center justify-content-between mb-4"f>t<"d-flex flex-wrap align-items-center justify-content-between mt-4"ip>'
                });
            }

            isi_tabel();

            $('#btn-filter').on('click', function() {
                const start = $('#start_date').val();
                const end = $('#end_date').val();
                if (!start || !end) {
                    Swal.fire('Opps', 'Pilih periode tanggal terlebih dahulu', 'warning');
                } else {
                    isi_tabel(start, end);
                }
            });

            $('#btn-reset').on('click', function() {
                $('#start_date').val('');
                $('#end_date').val('');
                isi_tabel();
            });

            $('#tambah').on('click', function() {
                $('#modal-title').text('Registrasi Barang');
                $('#simpan').text('Simpan Barang');
                $('#id').val('');
                $('#name').val('');
                $('#barcode').val('');
                $('#description').val('');
                $("#error").hide();
            });

            $("#simpan").on('click', function() {
                const isEdit = $(this).text() === 'Update Barang';
                const id = $('#id').val();
                const url = isEdit ? "{{ route('gudang.update', ':id') }}".replace(':id', id) : "{{ route('gudang.store') }}";

                $(this).text('Menyimpan...').prop('disabled', true);

                $.ajax({
                    url: url, type: "POST",
                    data: {
                        name: $('#name').val(),
                        barcode: $('#barcode').val(),
                        description: $('#description').val(),
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(res) {
                        if (res.error) {
                            printErrorMsg(res.error);
                        } else if (res.status === 'error') {
                            Swal.fire('Gagal', res.text, 'error');
                        } else {
                            $('#tabel-barang').DataTable().ajax.reload();
                            bootstrap.Modal.getInstance(document.getElementById('modal-tambah')).hide();
                            Swal.fire('Berhasil', res.text, 'success');
                        }
                        $("#simpan").text(isEdit ? 'Update Barang' : 'Simpan Barang').prop('disabled', false);
                    }
                });
            });

            $(document).on('click', '.edit', function() {
                const id = $(this).attr('id');
                $('#modal-title').text('Ubah Barang');
                $("#simpan").text('Update Barang');
                $("#error").hide();
                
                $.get("{{ route('gudang.edit', ':id') }}".replace(':id', id), (res) => {
                    $('#name').val(res.data.name);
                    $('#barcode').val(res.data.barcode);
                    $('#description').val(res.data.description);
                    $('#id').val(res.data.id);
                    bootstrap.Modal.getOrCreateInstance(document.getElementById('modal-tambah')).show();
                });
            });

            $(document).on('click', '.delete', function() {
                const id = $(this).attr('id');
                Swal.fire({
                    title: 'Hapus Barang?',
                    text: "Seluruh histori barang ini juga akan ikut terhapus!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ef4444',
                    confirmButtonText: 'Ya, Hapus!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('gudang.delete', ':id') }}".replace(':id', id),
                            type: 'POST',
                            data: { _token: "{{ csrf_token() }}" },
                            success: (res) => {
                                Swal.fire('Terhapus!', res.text, 'success');
                                $('#tabel-barang').DataTable().ajax.reload();
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
