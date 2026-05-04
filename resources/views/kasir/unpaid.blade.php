@extends('layouts.office')
@section('title', 'Belum Bayar | Kasir Dashboard')

@section('css')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.4/css/jquery.dataTables.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        :root {
            --kasir-primary: #2563eb;
            --kasir-success: #059669;
            --kasir-warning: #d97706;
            --kasir-danger: #dc2626;
            --kasir-dark: #1e293b;
            --kasir-muted: #64748b;
            --kasir-line: #e2e8f0;
            --kasir-surface: #ffffff;
        }

        .kasir-page-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--kasir-dark);
        }

        .kasir-filter-card {
            background: var(--kasir-surface);
            border: 1px solid var(--kasir-line);
            border-radius: 1rem;
            padding: 1rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            margin-bottom: 1.5rem;
        }

        .kasir-stat-inline {
            background: #fffbeb;
            border: 2px solid #f59e0b !important;
            border-radius: 0.75rem;
            padding: 0.5rem 1rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            height: 42px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            transition: transform 0.2s;
        }
        .kasir-stat-inline:hover { transform: translateY(-2px); }

        .kasir-stat-inline__label {
            color: var(--kasir-dark);
            font-size: 0.65rem;
            font-weight: 800;
            text-transform: uppercase;
            line-height: 1;
            margin-bottom: 2px;
            opacity: 0.8;
        }
        .kasir-stat-inline__value {
            font-size: 1.1rem;
            font-weight: 900;
            line-height: 1;
            color: #d97706;
        }

        .kasir-table-card {
            background: var(--kasir-surface);
            border: 1px solid var(--kasir-line);
            border-radius: 1rem;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05);
            padding: 1.5rem;
            overflow: hidden;
        }

        #tabel-unpaid {
            border-collapse: separate !important;
            border-spacing: 0 0.5rem !important;
            margin: 0 !important;
        }

        #tabel-unpaid thead th {
            background: #f1f5f9;
            border: none !important;
            color: var(--kasir-muted);
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            padding: 1rem;
        }
        
        /* Disable DataTables sorting icons */
        #tabel-unpaid thead th {
            background-image: none !important;
            cursor: default !important;
            position: relative !important;
        }
        #tabel-unpaid thead th:before, #tabel-unpaid thead th:after {
            display: none !important;
            content: "" !important;
        }

        #tabel-unpaid tbody td {
            border-bottom: 1px solid var(--kasir-line) !important;
            padding: 1.25rem 1rem;
            vertical-align: middle;
            background: #fff;
        }

        .booking-info__plate { font-size: 1.15rem; font-weight: 800; color: var(--kasir-primary); }
        .booking-info__customer { font-size: 0.85rem; font-weight: 600; color: var(--kasir-dark); }
        .booking-info__meta { font-size: 0.75rem; color: var(--kasir-muted); }

        .badge-soft {
            font-weight: 700;
            padding: 0.5em 0.8em;
            border-radius: 0.6rem;
            text-transform: uppercase;
            font-size: 0.7rem;
        }
        .badge-soft-warning { background: #fffbeb; color: #d97706; }

        .btn-pay {
            background-color: #f59e0b !important;
            color: #fff !important;
            border: none;
            border-radius: 0.75rem;
            padding: 0.6rem 1rem;
            font-weight: 700;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }
        .btn-pay:hover { transform: translateY(-2px); filter: brightness(1.1); }
    </style>
@endsection

@section('content')
    <div class="intro-y d-flex flex-column flex-sm-row align-items-center mt-8 mb-5">
        <h2 class="kasir-page-title me-auto">Booking Belum Bayar</h2>
        <div class="w-full w-sm-auto d-flex mt-4 mt-sm-0 gap-2">
            <a href="{{ route('kasir.dashboard') }}" class="btn btn-outline-secondary shadow-md bg-white fw-bold px-4">
                <i data-feather="arrow-left" class="w-4 h-4 me-2"></i> Kembali ke Dashboard
            </a>
        </div>
    </div>

    <div class="intro-y kasir-filter-card">
        <div class="row align-items-end g-3">
            <div class="col-12 col-md-3 col-lg-2">
                <label class="form-label small fw-bold text-muted">DARI TANGGAL</label>
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0"><i data-feather="calendar" class="w-4 h-4"></i></span>
                    <input type="date" class="form-control border-start-0 ps-0" id="start_date">
                </div>
            </div>
            <div class="col-12 col-md-3 col-lg-2">
                <label class="form-label small fw-bold text-muted">SAMPAI TANGGAL</label>
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0"><i data-feather="calendar" class="w-4 h-4"></i></span>
                    <input type="date" class="form-control border-start-0 ps-0" id="end_date">
                </div>
            </div>
            <div class="col-12 col-md-auto">
                <button class="btn btn-dark fw-bold" style="height: 38px;" id="btn-filter">
                    <i data-feather="search" class="w-4 h-4 me-2"></i> Filter
                </button>
            </div>
            <div class="col-12 col-md-auto ms-lg-auto">
                <div class="kasir-stat-inline">
                    <div>
                        <div class="kasir-stat-inline__label">Total Piutang</div>
                        <div class="kasir-stat-inline__value" id="summary-total">Rp 0</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="intro-y kasir-table-card">
        <div class="table-responsive">
            <table class="table table-hover display" id="tabel-unpaid" width="100%">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 5%">NO</th>
                        <th>INFO KENDARAAN</th>
                        <th>WAKTU BOOKING</th>
                        <th>TAGIHAN</th>
                        <th class="text-center">STATUS</th>
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
    <script>
        $(document).ready(function() {
            isi_tabel();

            $("#btn-filter").on('click', function() {
                var start = $('#start_date').val();
                var end = $('#end_date').val();
                isi_tabel(start, end);
            });
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

        function isi_tabel(start_date, end_date) {
            var start = start_date || '';
            var end = end_date || '';
            
            $('#tabel-unpaid').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                destroy: true,
                ajax: {
                    url: "{{ route('kasir.unpaid') }}",
                    data: {
                        start_date: start,
                        end_date: end
                    }
                },
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
                            var html = '<div class="booking-info">';
                            html += '<div class="booking-info__plate">' + data + '</div>';
                            html += '<div class="booking-info__customer">' + (row.name || '-') + '</div>';
                            html += '<div class="booking-info__meta">' + (row.tipe_mobil || '-') + '</div>';
                            html += '</div>';
                            return html;
                        }
                    },
                    {
                        data: 'tgl_booking',
                        render: function(data) { return formatDateTime(data); }
                    },
                    {
                        data: 'total_tagihan',
                        render: function(data) { return '<div class="fw-bold text-danger" style="font-size: 1.1rem;">' + formatRupiah(data) + '</div>'; }
                    },
                    {
                        data: 'status_pembayaran',
                        className: 'text-center',
                        render: function(data) {
                            return '<span class="badge-soft badge-soft-warning">' + (data || 'Belum Bayar') + '</span>';
                        }
                    },
                    {
                        data: 'id',
                        className: 'text-center',
                        render: function(data) {
                            var url = "{{ route('kasir.dashboard') }}?id=" + data;
                            return '<a href="' + url + '" class="btn btn-pay">' +
                                '<i data-feather="credit-card" style="width: 14px; height: 14px;"></i> Proses Bayar' +
                                '</a>';
                        }
                    }
                ],
                drawCallback: function(settings) {
                    if (typeof feather !== 'undefined') feather.replace();
                    
                    var json = settings.json;
                    if (json) {
                        $('#summary-total').text(formatRupiah(json.totalSum || 0));
                    }
                }
            });
        }
    </script>
@endsection
