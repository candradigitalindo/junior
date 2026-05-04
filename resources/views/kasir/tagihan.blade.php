@extends('layouts.office')
@section('title', 'Tagihan | JUNIOR AUTO CARE')

@section('css')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.4/css/jquery.dataTables.css">
    <style>
        :root {
            --tagihan-primary: #3b82f6;
            --tagihan-success: #10b981;
            --tagihan-warning: #f59e0b;
            --tagihan-dark: #1e293b;
            --tagihan-muted: #64748b;
            --tagihan-line: #e2e8f0;
            --tagihan-surface: #ffffff;
        }
        .page-title { font-size: 1.5rem; font-weight: 700; color: var(--tagihan-dark); }
        .table-card {
            background: var(--tagihan-surface);
            border: 1px solid var(--tagihan-line);
            border-radius: 1rem;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05);
            padding: 1.5rem;
            overflow: hidden;
            margin-top: 1.5rem;
        }
        #tabel-booking { border-collapse: separate !important; border-spacing: 0 0.5rem !important; }
        #tabel-booking thead th {
            background: #f1f5f9;
            border: none !important;
            color: var(--tagihan-muted);
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            padding: 1rem;
        }
        #tabel-booking thead th { background-image: none !important; cursor: default !important; position: relative !important; }
        #tabel-booking thead th:before, #tabel-booking thead th:after { display: none !important; content: "" !important; }
        #tabel-booking tbody td {
            border-bottom: 1px solid var(--tagihan-line) !important;
            padding: 1rem;
            vertical-align: middle;
            background: #fff;
        }
        @media (max-width: 768px) {
            .table-card { padding: 0.75rem; }
            #tabel-booking tbody td { padding: 0.75rem 0.5rem; font-size: 0.8rem; }
        }
    </style>
@endsection

@section('content')
    <div class="intro-y d-flex flex-column flex-sm-row align-items-center mt-8 mb-5">
        <h2 class="page-title me-auto">Daftar Tagihan</h2>
    </div>

    <div class="intro-y table-card mt-0">
        <div class="table-responsive">
            <table class="table table-hover display" id="tabel-booking" width="100%">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 5%">NO</th>
                        <th>INFO PELANGGAN</th>
                        <th>TGL BOOKING</th>
                        <th>KETERANGAN</th>
                        <th>TRANSAKSI</th>
                        <th class="text-center">AKSI</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection

@section('js')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
        $(document).ready(function() {
            isi_tabel();
        });

        function formatRupiah(amount) {
            return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(amount).replace('Rp','Rp ');
        }

        function formatDateTime(dateTimeString) {
            if (!dateTimeString) return '-';
            var date = new Date(dateTimeString);
            return date.toLocaleDateString('id-ID', { day: '2-digit', month: '2-digit', year: 'numeric' }) + ' ' + 
                   date.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });
        }

        function isi_tabel() {
            $('#tabel-booking').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                ajax: "{{ route('tagihan.index') }}",
                columns: [
                    {
                        data: null,
                        sortable: false,
                        className: 'text-center',
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
                        data: 'no_pol_kendaraan',
                        render: function(data, type, row) {
                            return '<div class="fw-bold text-primary">' + data + '</div>' +
                                   '<div class="small text-muted">' + (row.name || '-') + '</div>';
                        }
                    },
                    {
                        data: 'tgl_booking',
                        render: function(data) { return formatDateTime(data); }
                    },
                    {
                        data: 'description',
                        render: function(data) { return '<div class="small">' + data + '</div>'; }
                    },
                    {
                        data: 'transaksi',
                        render: function(data) { return '<div class="small">' + data + '</div>'; }
                    },
                    {
                        data: 'aksi',
                        className: 'text-center',
                        render: function(data) {
                            if ("{{ strtolower(auth()->user()->role->role) }}" === 'superadmin') {
                                return '<span class="text-muted small italic">Read Only</span>';
                            }
                            return data;
                        }
                    }
                ],
                drawCallback: function() {
                    if (typeof feather !== 'undefined') feather.replace();
                }
            });
        }
    </script>
@endsection
