@extends('layouts.office')
@section('title') Daftar Booking @endsection

@section('content')
<div class="intro-y d-flex flex-column flex-sm-row align-items-center mt-8 mb-6">
    <h2 class="fs-xl fw-bold me-auto">Daftar Booking</h2>
    <div class="w-full w-sm-auto d-flex mt-4 mt-sm-0">
        <a class="btn btn-outline-secondary shadow-none px-4 me-2 border-gray-200" href="{{ route('home') }}">
            <i data-feather="home" class="w-4 h-4 me-2"></i> Dashboard
        </a>
    </div>
</div>

<div class="grid columns-12 gap-6">
    {{-- Filter Bar --}}
    <div class="g-col-12 intro-y">
        <div class="box p-5">
            <div class="d-flex flex-column flex-lg-row gap-4">
                <div class="d-flex flex-wrap gap-4 flex-grow-1">
                    <div class="flex-grow-1" style="min-width: 160px;">
                        <label class="form-label fs-xs text-gray-500 fw-medium text-uppercase mb-2 d-block">Dari Tanggal</label>
                        <input type="date" class="form-control border-gray-200 shadow-none" id="date_from" value="{{ now()->startOfMonth()->format('Y-m-d') }}">
                    </div>
                    <div class="flex-grow-1" style="min-width: 160px;">
                        <label class="form-label fs-xs text-gray-500 fw-medium text-uppercase mb-2 d-block">Sampai Tanggal</label>
                        <input type="date" class="form-control border-gray-200 shadow-none" id="date_to" value="{{ now()->endOfMonth()->format('Y-m-d') }}">
                    </div>
                    <div class="flex-grow-1" style="min-width: 160px;">
                        <label class="form-label fs-xs text-gray-500 fw-medium text-uppercase mb-2 d-block">Status Booking</label>
                        <select class="form-select border-gray-200 shadow-none" id="filter_status">
                            <option value="">Semua Status</option>
                            <option value="Booking">Booking</option>
                            <option value="Proses">Proses</option>
                            <option value="Selesai">Selesai</option>
                        </select>
                    </div>
                </div>
                <div class="d-flex align-items-end gap-2">
                    <button class="btn btn-primary shadow-none px-5" id="btn-apply" style="background-color: #ffcc00; border-color: #ffcc00; color: #1e293b; font-weight: 600;">
                        Terapkan
                    </button>
                    <button class="btn btn-outline-secondary shadow-none px-4" id="btn-reset">Reset</button>
                </div>
            </div>
        </div>
    </div>

    <div class="g-col-12 intro-y">
        <div class="box p-0 overflow-hidden">
            <div class="p-5 border-bottom border-gray-100 d-flex align-items-center">
                <div class="fw-semibold text-gray-700">Daftar Reservasi & Booking</div>
            </div>
            <div class="p-5">
                <div class="overflow-x-auto">
                    <table class="table table-hover w-full" id="tabel-booking">
                        <thead>
                            <tr class="bg-gray-50">
                                <th class="text-gray-500 fw-bold py-4 px-4 border-bottom-0" style="width: 50px;">#</th>
                                <th class="text-gray-500 fw-bold py-4 px-4 border-bottom-0">TIPE MOBIL</th>
                                <th class="text-gray-500 fw-bold py-4 px-4 border-bottom-0">PLAT & PELANGGAN</th>
                                <th class="text-gray-500 fw-bold py-4 px-4 border-bottom-0">KONTAK</th>
                                <th class="text-gray-500 fw-bold py-4 px-4 border-bottom-0">WAKTU BOOKING</th>
                                <th class="text-gray-500 fw-bold py-4 px-4 border-bottom-0">KETERANGAN</th>
                                <th class="text-gray-500 fw-bold py-4 px-4 border-bottom-0">STATUS</th>
                                <th class="text-gray-500 fw-bold py-4 px-4 border-bottom-0 text-center">AKSI</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Hidden buttons for modal triggers --}}
<button style="display: none" data-bs-toggle="modal" data-bs-target="#modal-pengecekan" id="pengecekan"></button>
<button style="display: none" data-bs-toggle="modal" data-bs-target="#modal-pengerjaan" id="pengerjaan"></button>
<button style="display: none" data-bs-toggle="modal" data-bs-target="#modal-photo" id="photo"></button>
<button style="display: none" data-bs-toggle="modal" data-bs-target="#modal-orderan" id="orderan"></button>

{{-- Modals --}}
@include('admin.booking_modals')

<audio id="tingtung" src="{{ asset('audio/tingtung.mp3') }}"></audio>
@endsection

@section('css')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.4/css/jquery.dataTables.css">
<style>
    /* Global Overrides */
    .box { box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.05), 0 1px 2px 0 rgba(0, 0, 0, 0.03); border: 1px solid #f1f5f9; }
    
    /* Table Styling */
    #tabel-booking { border-collapse: separate; border-spacing: 0; }
    #tabel-booking thead th { 
        font-size: 11px; 
        text-transform: uppercase; 
        letter-spacing: 0.05em;
        background-color: #f8fafc;
        border-top: 1px solid #f1f5f9;
        border-bottom: 1px solid #f1f5f9;
    }
    #tabel-booking tbody td { 
        padding: 16px; 
        vertical-align: middle; 
        border-bottom: 1px solid #f8fafc;
        font-size: 13px;
    }
    #tabel-booking tbody tr:hover { background-color: #fcfcfd; }
    
    /* Hide messy default DataTables sorting icons */
    .dataTables_wrapper .dataTable thead th.sorting:before,
    .dataTables_wrapper .dataTable thead th.sorting:after,
    .dataTables_wrapper .dataTable thead th.sorting_asc:before,
    .dataTables_wrapper .dataTable thead th.sorting_asc:after {
        display: none !important;
    }

    /* Modern Controls */
    .dataTables_wrapper .dataTables_filter { margin-bottom: 24px; }
    .dataTables_wrapper .dataTables_filter input {
        border: 1px solid #e2e8f0;
        border-radius: 0.5rem;
        padding: 0.5rem 1rem;
        font-size: 0.875rem;
        width: 300px;
        outline: none;
    }
    .dataTables_wrapper .dataTables_length select {
        border: 1px solid #e2e8f0;
        border-radius: 0.5rem;
        padding: 0.25rem 0.75rem;
        outline: none;
    }

    .dataTables_wrapper .dataTables_info { font-size: 12px; color: #64748b; padding-top: 24px; }
    .dataTables_wrapper .dataTables_paginate { padding-top: 24px; }
    
    .paginate_button {
        background: white !important;
        border: 1px solid #e2e8f0 !important;
        border-radius: 0.5rem !important;
        margin-left: 6px !important;
        padding: 6px 14px !important;
        font-size: 12px !important;
        font-weight: 500 !important;
        color: #64748b !important;
    }
    .paginate_button.current {
        background: #1e293b !important;
        color: white !important;
        border-color: #1e293b !important;
    }

    /* Custom Badge Styles */
    .badge-soft-primary { background-color: #eff6ff; color: #1d4ed8; border: 1px solid #dbeafe; }
    .badge-soft-warning { background-color: #fffbeb; color: #b45309; border: 1px solid #fef3c7; }
    .badge-soft-success { background-color: #f0fdf4; color: #15803d; border: 1px solid #dcfce7; }
    .btn-soft-warning { background-color: #fffbeb; color: #b45309; border: none; }
    .btn-soft-warning:hover { background-color: #fef3c7; }
</style>
@endsection

@section('js')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
    let table;
    $(function() {
        table = $('#tabel-booking').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('admin.booking') }}",
                data: function (d) {
                    d.date_from = $('#date_from').val();
                    d.date_to   = $('#date_to').val();
                    d.status    = $('#filter_status').val();
                }
            },
            columns: [
                { data: null, sortable: false, render: (d, t, r, m) => m.row + m.settings._iDisplayStart + 1 },
                { data: 'tipe_mobil', sortable: false },
                { data: 'no_pol_kendaraan' },
                { data: 'phone' },
                { data: 'tgl_booking' },
                { data: 'description', sortable: false },
                { data: 'status', sortable: false },
                { data: 'aksi', sortable: false, className: 'text-center' }
            ],
            language: {
                search: "",
                searchPlaceholder: "Cari plat atau nama...",
                lengthMenu: "Tampilkan _MENU_",
                info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
                paginate: { previous: "Prev", next: "Next" }
            },
            drawCallback: function() {
                if (typeof feather !== 'undefined') feather.replace();
            }
        });

        $('#btn-apply').on('click', function () {
            table.ajax.reload();
        });

        $('#btn-reset').on('click', function () {
            $('#date_from, #date_to, #filter_status').val('');
            table.ajax.reload();
        });
    });

    $(document).on('click', '.cekmasuk', function() {
        let id = $(this).attr('id');
        let url = "{{ route('pengecekan.home', ':id') }}".replace(':id', id);
        $("#pengecekan").click();
        $.get(url, function(res) {
            $('#cno_pol_kendaraan').val(res.data.no_pol_kendaraan);
            $('#ctipe_mobil').val(res.data.tipe_mobil);
            $('#cexterior').val(res.data.cekmasuk.exterior);
            $('#cinterior').val(res.data.cekmasuk.interior);
            $('#cmesin').val(res.data.cekmasuk.mesin);
            $('#cbarang_mobil').val(res.data.cekmasuk.barang_mobil);
        });
    });

    $(document).on('click', '.pengerjaan', function() {
        let id = $(this).attr('id');
        let url = "{{ route('booking.edit', ':id') }}".replace(':id', id);
        $("#pengerjaan").click();
        $.get(url, function(res) {
            $('#pno_pol_kendaraan').val(res.data.no_pol_kendaraan);
            let url_a = "{{ route('pengerjaan.show', ':id') }}".replace(':id', res.data.id);
            $('#tabel-histori').DataTable({
                processing: true,
                serverSide: true,
                destroy: true,
                ajax: url_a,
                columns: [{ data: 'histori', name: 'histori' }],
                dom: 't',
                language: { emptyTable: "Belum ada log aktivitas" }
            });
        });
    });

    $(document).on('click', '.upload', function() {
        let id = $(this).attr('id');
        let url = "{{ route('booking.edit', ':id') }}".replace(':id', id);
        $("#photo").click();
        $.get(url, function(res) {
            let url_a = "{{ route('photocek.index', ':id') }}".replace(':id', res.data.id);
            $('#tabel-photo').DataTable({
                processing: true,
                serverSide: true,
                destroy: true,
                ajax: url_a,
                columns: [{ data: 'photo', name: 'photo' }],
                dom: 't'
            });
        });
    });

    $(document).on('click', '.orderan', function() {
        let id = $(this).attr('id');
        let url = "{{ route('booking.edit', ':id') }}".replace(':id', id);
        $("#orderan").click();
        $.get(url, function(res) {
            $('#ono_pol_kendaraan').val(res.data.no_pol_kendaraan);
            $('#orderan_booking_id').val(res.data.id);
            let url_a = "{{ route('orderan', ':id') }}".replace(':id', res.data.id);
            $('#tabel-orderan').DataTable({
                processing: true,
                serverSide: true,
                destroy: true,
                ajax: url_a,
                columns: [{ data: 'bookingorder', name: 'bookingorder' }],
                dom: 't'
            });
        });
        
        $.get("{{ route('getProduk') }}", function(res) {
            $("#product").empty().append('<option value="">--- Pilih Layanan ---</option>');
            $.each(res.data, function(id, item) {
                $("#product").append('<option value="' + item.id + '">' + item.name + ' | Rp. ' + item.price.toLocaleString('id-ID') + '</option>');
            });
        });
    });

    $(document).on('click', '.delete', function() {
        let id = $(this).attr('id');
        swal({
            title: "Hapus booking?",
            text: "Data yang dihapus tidak dapat dikembalikan!",
            icon: "warning",
            buttons: ["Batal", "Ya, Hapus"],
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    url: "{{ route('booking.destroy', ':id') }}".replace(':id', id),
                    type: 'DELETE',
                    data: { _token: "{{ csrf_token() }}" },
                    success: function(res) {
                        swal(res.text, { icon: res.status === 'gagal' ? "error" : "success" });
                        $('#tabel-booking').DataTable().ajax.reload();
                    }
                });
            }
        });
    });

    $(document).on('click', '.delete_photo', function() {
        let id = $(this).data('id');
        swal({
            title: "Hapus foto?",
            icon: "warning",
            buttons: ["Batal", "Ya, Hapus"],
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    url: "{{ route('photocek.delete', ':id') }}".replace(':id', id),
                    type: 'DELETE',
                    data: { _token: "{{ csrf_token() }}" },
                    success: function(res) {
                        swal(res.text, { icon: "success" });
                        $('#tabel-photo').DataTable().ajax.reload();
                    }
                });
            }
        });
    });

    $(document).on('click', '.delete_layanan', function() {
        let id = $(this).attr('id');
        swal({
            title: "Hapus layanan?",
            icon: "warning",
            buttons: ["Batal", "Ya, Hapus"],
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    url: "{{ route('orderan.delete', ':id') }}".replace(':id', id),
                    type: 'DELETE',
                    data: { _token: "{{ csrf_token() }}" },
                    success: function(res) {
                        swal(res.text, { icon: "success" });
                        $('#tabel-orderan').DataTable().ajax.reload();
                    }
                });
            }
        });
    });

    $("#simpan_orderan").on('click', function() {
        let booking_id = $('#orderan_booking_id').val();
        $.ajax({
            url: "{{ route('orderan.store', ':id') }}".replace(':id', booking_id),
            type: 'POST',
            data: {
                product: $('#product').val(),
                _token: "{{ csrf_token() }}"
            },
            success: function(res) {
                if (res.status === 'sukses') {
                    swal(res.text, { icon: "success" });
                    $('#tabel-orderan').DataTable().ajax.reload();
                    $('#product').val('');
                } else {
                    swal(res.text || "Terjadi kesalahan", { icon: "error" });
                }
            }
        });
    });
</script>
@endsection
