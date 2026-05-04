@extends('layouts.office')
@section('title') Riwayat Transaksi @endsection

@section('content')
<div class="intro-y d-flex flex-column flex-sm-row align-items-center mt-8 mb-6">
    <h2 class="fs-xl fw-bold me-auto">Riwayat Transaksi</h2>
</div>

<div class="grid columns-12 gap-6">
    {{-- Filter Bar --}}
    <div class="g-col-12 intro-y">
        <div class="box p-5">
            <div class="d-flex flex-column flex-lg-row gap-4">
                <div class="d-flex flex-wrap gap-4 flex-grow-1">
                    <div class="flex-grow-1" style="min-width: 160px;">
                        <label class="form-label fs-xs text-gray-500 fw-medium text-uppercase mb-2 d-block">Dari Tanggal</label>
                        <input type="date" class="form-control border-gray-200 shadow-none" id="date_from">
                    </div>
                    <div class="flex-grow-1" style="min-width: 160px;">
                        <label class="form-label fs-xs text-gray-500 fw-medium text-uppercase mb-2 d-block">Sampai Tanggal</label>
                        <input type="date" class="form-control border-gray-200 shadow-none" id="date_to">
                    </div>
                    <div class="flex-grow-1" style="min-width: 160px;">
                        <label class="form-label fs-xs text-gray-500 fw-medium text-uppercase mb-2 d-block">Metode Pembayaran</label>
                        <select class="form-select border-gray-200 shadow-none" id="filter_metode">
                            <option value="">Semua Metode</option>
                            <option value="Cash">Cash</option>
                            <option value="QRIS">QRIS</option>
                            <option value="Transfer">Transfer</option>
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

    {{-- Stats Cards - Minimalist Version --}}
    <div class="g-col-12 g-col-md-6 g-col-xl-3 intro-y">
        <div class="box p-5 d-flex align-items-center">
            <div class="flex-grow-1">
                <div class="text-gray-500 fs-xs text-uppercase fw-semibold mb-1">Total Transaksi</div>
                <div class="fs-2xl fw-bold text-dark" id="stat-count">—</div>
            </div>
            <div class="ms-auto p-3 bg-gray-100 rounded-circle text-gray-500">
                <i data-feather="file-text" class="w-6 h-6"></i>
            </div>
        </div>
    </div>
    <div class="g-col-12 g-col-md-6 g-col-xl-3 intro-y">
        <div class="box p-5 d-flex align-items-center border-start border-success border-4">
            <div class="flex-grow-1">
                <div class="text-gray-500 fs-xs text-uppercase fw-semibold mb-1">Total Pendapatan</div>
                <div class="fs-2xl fw-bold text-success" id="stat-revenue">—</div>
            </div>
        </div>
    </div>
    <div class="g-col-12 g-col-md-6 g-col-xl-3 intro-y">
        <div class="box p-5 d-flex align-items-center border-start border-primary border-4">
            <div class="flex-grow-1">
                <div class="text-gray-500 fs-xs text-uppercase fw-semibold mb-1">Cash</div>
                <div class="fs-2xl fw-bold text-primary" id="stat-cash">—</div>
            </div>
        </div>
    </div>
    <div class="g-col-12 g-col-md-6 g-col-xl-3 intro-y">
        <div class="box p-5 d-flex align-items-center border-start border-warning border-4">
            <div class="flex-grow-1">
                <div class="text-gray-500 fs-xs text-uppercase fw-semibold mb-1">Non-Cash</div>
                <div class="fs-2xl fw-bold text-warning" id="stat-non-cash">—</div>
            </div>
        </div>
    </div>

    {{-- Table Section --}}
    <div class="g-col-12 intro-y">
        <div class="box p-0 overflow-hidden">
            <div class="p-5 border-bottom border-gray-100 d-flex align-items-center">
                <div class="fw-semibold text-gray-700">Daftar Transaksi Terkini</div>
            </div>
            <div class="p-5">
                <div class="overflow-x-auto">
                    <table class="table table-hover w-full" id="tabel-transaksi">
                        <thead>
                            <tr class="bg-gray-50">
                                <th class="text-gray-500 fw-bold py-4 px-4 border-bottom-0" style="width: 50px;">#</th>
                                <th class="text-gray-500 fw-bold py-4 px-4 border-bottom-0">KENDARAAN & PELANGGAN</th>
                                <th class="text-gray-500 fw-bold py-4 px-4 border-bottom-0">WAKTU & PEMBAYARAN</th>
                                <th class="text-gray-500 fw-bold py-4 px-4 border-bottom-0">DETAIL LAYANAN</th>
                                <th class="text-gray-500 fw-bold py-4 px-4 border-bottom-0 text-center">INVOICE & METODE</th>
                                <th class="text-gray-500 fw-bold py-4 px-4 border-bottom-0 text-center">AKSI</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('css')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.4/css/jquery.dataTables.css">
<style>
    /* Global Overrides */
    .box { box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.05), 0 1px 2px 0 rgba(0, 0, 0, 0.03); border: 1px solid #f1f5f9; }
    
    /* Table Styling */
    #tabel-transaksi { border-collapse: separate; border-spacing: 0; }
    #tabel-transaksi thead th { 
        font-size: 11px; 
        text-transform: uppercase; 
        letter-spacing: 0.05em;
        background-color: #f8fafc;
        border-top: 1px solid #f1f5f9;
        border-bottom: 1px solid #f1f5f9;
    }
    #tabel-transaksi tbody td { 
        padding: 20px 16px; 
        vertical-align: middle; 
        border-bottom: 1px solid #f8fafc;
        font-size: 13px;
    }
    #tabel-transaksi tbody tr:hover { background-color: #fcfcfd; }
    
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
        transition: all 0.2s;
        outline: none;
    }
    .dataTables_wrapper .dataTables_filter input:focus { border-color: #cbd5e1; box-shadow: 0 0 0 2px rgba(203, 213, 225, 0.2); }
    
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
        transition: all 0.2s !important;
    }
    .paginate_button:hover { background: #f8fafc !important; color: #1e293b !important; }
    .paginate_button.current {
        background: #1e293b !important;
        color: white !important;
        border-color: #1e293b !important;
    }
    .paginate_button.disabled { opacity: 0.5; cursor: not-allowed; }

    /* Custom Badge Styles */
    .badge-soft-success { background-color: #f0fdf4; color: #15803d; border: 1px solid #dcfce7; }
    .badge-soft-warning { background-color: #fffbeb; color: #b45309; border: 1px solid #fef3c7; }
    .badge-soft-primary { background-color: #eff6ff; color: #1d4ed8; border: 1px solid #dbeafe; }
</style>
@endsection

@section('js')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
    const STATS_URL = "{{ route('admin.transaksi.stats') }}";
    const RESET_URL = "{{ route('admin.reset.transaksi', ':id') }}";
    const TABLE_URL = "{{ route('admin.transaksi') }}";

    let table;

    function getFilters() {
        return {
            date_from: $('#date_from').val(),
            date_to:   $('#date_to').val(),
            metode:    $('#filter_metode').val(),
        };
    }

    function fmtRupiah(n) {
        return 'Rp ' + Number(n).toLocaleString('id-ID');
    }

    function formatInputDate(dateObj) {
        const y = dateObj.getFullYear();
        const m = String(dateObj.getMonth() + 1).padStart(2, '0');
        const d = String(dateObj.getDate()).padStart(2, '0');
        return `${y}-${m}-${d}`;
    }

    function setDefaultDateRange() {
        const to = new Date();
        const from = new Date();
        from.setMonth(from.getMonth() - 1);
        $('#date_from').val(formatInputDate(from));
        $('#date_to').val(formatInputDate(to));
    }

    function loadStats() {
        $.getJSON(STATS_URL, getFilters(), function (d) {
            $('#stat-count').text(d.count);
            $('#stat-revenue').text(fmtRupiah(d.revenue));
            $('#stat-cash').text(fmtRupiah(d.cash));
            $('#stat-non-cash').text(fmtRupiah(d.non_cash));
        });
    }

    $(function () {
        setDefaultDateRange();

        table = $('#tabel-transaksi').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: TABLE_URL,
                data: function (d) {
                    const f = getFilters();
                    d.date_from = f.date_from;
                    d.date_to   = f.date_to;
                    d.metode    = f.metode;
                }
            },
            columns: [
                { data: null, sortable: false, render: (d, t, r, m) => m.row + m.settings._iDisplayStart + 1 },
                { data: 'no_pol_kendaraan' },
                { data: 'tgl_booking' },
                { data: 'description' },
                { data: 'transaksi_html', sortable: false, className: 'text-center' },
                { data: 'aksi', sortable: false, className: 'text-center' },
            ],
            language: {
                search: "",
                searchPlaceholder: "Cari nomor plat atau nama...",
                lengthMenu: "Tampilkan _MENU_",
                info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
                paginate: { previous: "Prev", next: "Next" }
            }
        });

        loadStats();

        $('#btn-apply').on('click', function () {
            table.ajax.reload();
            loadStats();
        });

        $('#btn-reset').on('click', function () {
            setDefaultDateRange();
            $('#filter_metode').val('');
            table.ajax.reload();
            loadStats();
        });

        $(document).on('click', '.reset', function () {
            const id  = $(this).attr('id');
            const url = RESET_URL.replace(':id', id);
            swal({
                title:      'Reset transaksi?',
                text:       'Data pembayaran akan dihapus dan status kembali ke Belum Bayar.',
                icon:       'warning',
                buttons:    ['Batal', 'Ya, Reset'],
                dangerMode: true,
            }).then(ok => {
                if (!ok) return;
                $.ajax({
                    url,
                    type: 'GET',
                    success: function (res) {
                        swal('Berhasil!', res.text, 'success');
                        table.ajax.reload(null, false);
                        loadStats();
                    }
                });
            });
        });
    });
</script>
@endsection
