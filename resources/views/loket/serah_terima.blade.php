@extends('layouts.office')
@section('title') Serah Terima Kendaraan @endsection

@section('content')
<div class="intro-y d-flex flex-column flex-sm-row align-items-center mt-8 mb-6">
    <h2 class="fs-xl fw-bold me-auto">Serah Terima Kendaraan</h2>
    <div class="w-full w-sm-auto d-flex mt-4 mt-sm-0">
        <button class="btn btn-outline-secondary shadow-none px-4 me-2 border-gray-200" id="btn-refresh">
            <i data-feather="refresh-cw" class="w-4 h-4 me-2"></i> Segarkan Data
        </button>
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
                        <input type="date" class="form-control border-gray-200 shadow-none" id="start_date" value="{{ now()->startOfMonth()->format('Y-m-d') }}">
                    </div>
                    <div class="flex-grow-1" style="min-width: 160px;">
                        <label class="form-label fs-xs text-gray-500 fw-medium text-uppercase mb-2 d-block">Sampai Tanggal</label>
                        <input type="date" class="form-control border-gray-200 shadow-none" id="end_date" value="{{ now()->endOfMonth()->format('Y-m-d') }}">
                    </div>
                </div>
                <div class="d-flex align-items-end gap-2">
                    <button class="btn btn-primary shadow-none px-5" id="btn-filter" style="background-color: #ffcc00; border-color: #ffcc00; color: #1e293b; font-weight: 600;">
                        Terapkan Filter
                    </button>
                    <button class="btn btn-outline-secondary shadow-none px-4" id="btn-reset">Reset</button>
                </div>
            </div>
        </div>
    </div>

    <div class="g-col-12 intro-y">
        <div class="box p-0 overflow-hidden">
            <div class="p-5 border-bottom border-gray-100 d-flex align-items-center">
                <div class="fw-semibold text-gray-700">Daftar Kendaraan Selesai</div>
            </div>
            <div class="p-5">
                <div class="overflow-x-auto">
                    <table class="table table-hover w-full" id="tabel-booking">
                        <thead>
                            <tr class="bg-gray-50">
                                <th class="text-gray-500 fw-bold py-4 px-4 border-bottom-0" style="width: 50px;">#</th>
                                <th class="text-gray-500 fw-bold py-4 px-4 border-bottom-0">NOMOR POLISI</th>
                                <th class="text-gray-500 fw-bold py-4 px-4 border-bottom-0">LAYANAN / ORDERAN</th>
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
        padding: 20px 16px; 
        vertical-align: middle; 
        border-bottom: 1px solid #f8fafc;
        font-size: 13px;
    }
    #tabel-booking tbody tr:hover { background-color: #fcfcfd; }
    
    /* Hide DataTables sorting icons */
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
</style>
@endsection

@section('js')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    let table;
    $(document).ready(function() {
        table = $('#tabel-booking').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('serahterima') }}",
                data: function (d) {
                    d.start_date = $('#start_date').val();
                    d.end_date   = $('#end_date').val();
                }
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'no_pol_kendaraan', name: 'no_pol_kendaraan', className: 'fw-bold text-primary' },
                { data: 'orderan', name: 'orderan' },
                { data: 'aksi', name: 'aksi', orderable: false, searchable: false, className: 'text-center' }
            ],
            language: {
                search: "",
                searchPlaceholder: "Cari plat...",
                lengthMenu: "Tampilkan _MENU_",
                info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
                paginate: { previous: "Prev", next: "Next" }
            },
            drawCallback: function() {
                if (typeof feather !== 'undefined') feather.replace();
            }
        });

        $("#btn-filter").on('click', function() {
            table.ajax.reload();
        });

        $("#btn-reset").on('click', function() {
            $('#start_date').val("{{ now()->startOfMonth()->format('Y-m-d') }}");
            $('#end_date').val("{{ now()->endOfMonth()->format('Y-m-d') }}");
            table.ajax.reload();
        });

        $("#btn-refresh").on('click', function() {
            const btn = $(this);
            btn.prop('disabled', true).html('<i data-feather="refresh-cw" class="w-4 h-4 me-2"></i> Loading...');
            if (typeof feather !== 'undefined') feather.replace();
            
            table.ajax.reload(() => {
                btn.prop('disabled', false).html('<i data-feather="refresh-cw" class="w-4 h-4 me-2"></i> Segarkan Data');
                if (typeof feather !== 'undefined') feather.replace();
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: 'Data telah diperbarui.',
                    timer: 1500,
                    showConfirmButton: false
                });
            });
        });
    });
</script>
@endsection
