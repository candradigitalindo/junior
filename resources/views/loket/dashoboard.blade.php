@extends('layouts.office')

@section('title', 'Loket Reception | JUNIOR AUTO CARE')

@section('content')
<div class="intro-y d-flex flex-column flex-sm-row align-items-start align-items-sm-center mt-8 gap-3">
    <div class="me-auto">
        <div class="loket-eyebrow">Reception Desk</div>
        <h2 class="loket-page-title">Penerimaan Kendaraan</h2>
    </div>
    <div class="w-full w-sm-auto d-flex flex-wrap gap-2">
        <button class="btn btn-primary shadow-md fw-bold px-4" id="tambah" data-bs-toggle="modal" data-bs-target="#modal-tambah">
            <i data-feather="plus-circle" class="w-4 h-4 me-2"></i> Pesanan Baru
        </button>
        <button class="btn btn-dark shadow-md fw-bold px-4" id="btn-refresh">
            <i data-feather="refresh-ccw" class="w-4 h-4 me-2"></i> Segarkan
        </button>
        <button class="btn btn-success text-white shadow-md fw-bold px-4" id="selesai" data-bs-toggle="modal" data-bs-target="#modal-selesai">
            <i data-feather="check-circle" class="w-4 h-4 me-2"></i> Selesai Hari Ini
        </button>
    </div>
</div>

<div class="grid columns-12 gap-4 mt-5">
    <div class="intro-y g-col-6 g-col-sm-6 g-col-xl-3">
        <div class="loket-stat-card">
            <div class="loket-stat-card__label">Booking Aktif</div>
            <div class="loket-stat-card__value">{{ number_format($stats['active'], 0, ',', '.') }}</div>
        </div>
    </div>
    <div class="intro-y g-col-6 g-col-sm-6 g-col-xl-3">
        <div class="loket-stat-card">
            <div class="loket-stat-card__label">Kendaraan Ditunggu</div>
            <div class="loket-stat-card__value">{{ number_format($stats['waiting'], 0, ',', '.') }}</div>
        </div>
    </div>
    <div class="intro-y g-col-6 g-col-sm-6 g-col-xl-3">
        <div class="loket-stat-card">
            <div class="loket-stat-card__label">Kendaraan Ditinggal</div>
            <div class="loket-stat-card__value">{{ number_format($stats['dropoff'], 0, ',', '.') }}</div>
        </div>
    </div>
    <div class="intro-y g-col-6 g-col-sm-6 g-col-xl-3">
        <div class="loket-stat-card">
            <div class="loket-stat-card__label">Belum Bayar</div>
            <div class="loket-stat-card__value">{{ number_format($stats['unpaid'], 0, ',', '.') }}</div>
        </div>
    </div>
</div>

<div class="intro-y loket-table-shell mt-5">
    <div class="loket-table-shell__header">
        <div>
            <div class="loket-eyebrow">Default: Hari Ini + Belum Bayar</div>
            <h3 class="loket-section-title">Daftar Kendaraan Masuk</h3>
        </div>
    </div>
    <div class="loket-table-wrap">
        <table class="table loket-table" id="tabel-booking" width="100%">
            <thead>
                <tr>
                    <th class="text-center" style="width: 5%">NO</th>
                    <th>KENDARAAN</th>
                    <th>PELANGGAN</th>
                    <th>LAYANAN</th>
                    <th>STATUS</th>
                    <th class="text-end">AKSI</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>

@include('loket.partials.modals')

<audio id="tingtung" src="{{ asset('audio/tingtung.mp3') }}"></audio>
@endsection

@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('landing/plugins/bootstrap-select/bootstrap-select.min.css') }}">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.4/css/jquery.dataTables.css">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    /* Select2 Custom Styling to match theme */
    .select2-container--default .select2-selection--single {
        background-color: #ffffff;
        border: 1px solid var(--loket-line);
        border-radius: 0.5rem;
        height: calc(1.5em + 0.75rem + 2px);
        display: flex;
        align-items: center;
        transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        color: var(--loket-text);
        padding-left: 0.75rem;
        padding-right: 2rem;
        font-weight: 400;
        line-height: 1.5;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 100%;
        right: 0.5rem;
        display: flex;
        align-items: center;
    }
    .select2-dropdown {
        border: 1px solid var(--loket-line);
        border-radius: 0.5rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        z-index: 9999;
    }
    .select2-container--default .select2-search--dropdown .select2-search__field {
        border: 1px solid var(--loket-line);
        border-radius: 0.375rem;
        padding: 0.4rem 0.75rem;
    }
    .select2-container--default .select2-results__option--highlighted[aria-selected] {
        background-color: var(--loket-primary);
    }
    .modal-open .select2-container {
        z-index: 1060;
    }
    
    /* Responsive Adjustments */
    @media (max-width: 768px) {
        .select2-container--default .select2-selection--single {
            height: 3rem;
        }
    }

    :root {
        --loket-surface: #ffffff;
        --loket-surface-alt: #f8fafc;
        --loket-line: #cbd5e1;
        --loket-line-soft: #f1f5f9;
        --loket-text: #0f172a;
        --loket-muted: #475569;
        --loket-primary: #2563eb;
        --loket-primary-soft: #eff6ff;
        --loket-success: #059669;
        --loket-success-soft: #ecfdf5;
        --loket-warning: #d97706;
        --loket-warning-soft: #fffbeb;
        --loket-danger: #dc2626;
        --loket-danger-soft: #fef2f2;
        --loket-dark: #1e293b;
        --loket-dark-soft: #f1f5f9;
    }

    .loket-eyebrow {
        color: var(--loket-primary);
        font-size: 0.75rem;
        font-weight: 700;
        letter-spacing: 0.12em;
        text-transform: uppercase;
        margin-bottom: 0.35rem;
    }

    .loket-page-title {
        color: var(--loket-text);
        font-size: 1.8rem;
        font-weight: 700;
        line-height: 1.1;
        margin: 0;
    }

    .loket-page-copy {
        color: var(--loket-muted);
        font-size: 0.95rem;
        margin: 0.55rem 0 0;
        max-width: 42rem;
    }

    .loket-stat-card {
        background: #ffffff;
        border: 1px solid var(--loket-line);
        border-radius: 0.75rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        padding: 1rem;
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .loket-stat-card__label {
        color: var(--loket-muted);
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 0.25rem;
    }

    .loket-stat-card__value {
        color: var(--loket-text);
        font-size: 1.5rem;
        font-weight: 800;
        line-height: 1;
    }

    .loket-table-shell {
        background: var(--loket-surface);
        border: 1px solid var(--loket-line);
        border-radius: 1.25rem;
        box-shadow: 0 24px 50px rgba(15, 23, 42, 0.06);
        overflow: hidden;
    }

    .loket-table-shell__header {
        align-items: flex-start;
        border-bottom: 1px solid var(--loket-line-soft);
        display: flex;
        flex-wrap: wrap;
        gap: 0.75rem;
        justify-content: space-between;
        padding: 1.35rem 1.5rem 1.1rem;
    }

    .loket-section-title {
        color: var(--loket-text);
        font-size: 1.15rem;
        font-weight: 700;
        margin: 0;
    }

    .loket-table-shell__note {
        color: var(--loket-muted);
        font-size: 0.85rem;
        max-width: 20rem;
        text-align: right;
    }

    .loket-table-wrap {
        overflow-x: auto;
        padding: 0.25rem 1rem 1rem;
    }

    .loket-table {
        border-collapse: collapse !important;
        color: var(--loket-text);
        margin: 0 !important;
        width: 100% !important;
    }

    .loket-table thead th,
    .table-report thead th {
        background: var(--loket-surface-alt);
        border-bottom: 1px solid var(--loket-line) !important;
        color: var(--loket-muted);
        font-size: 0.74rem;
        font-weight: 700;
        letter-spacing: 0.08em;
        padding: 0.9rem 1rem !important;
        text-transform: uppercase;
        white-space: nowrap;
    }

    .loket-table tbody td,
    .table-report tbody td {
        border-bottom: 1px solid var(--loket-line-soft) !important;
        padding: 1rem !important;
        vertical-align: middle;
    }

    .loket-table tbody tr:last-child td,
    .table-report tbody tr:last-child td {
        border-bottom: 0 !important;
    }

    .loket-table tbody tr:hover td,
    .table-report tbody tr:hover td {
        background: #fbfdff;
    }

    .booking-vehicle__plate,
    .booking-customer__name,
    .service-stack__title {
        color: var(--loket-text);
        font-weight: 700;
    }

    .booking-vehicle__plate {
        font-size: 1rem;
        letter-spacing: 0.02em;
    }

    .booking-meta,
    .booking-customer__meta,
    .service-stack__meta,
    .status-stack__meta {
        color: var(--loket-muted);
        display: flex;
        flex-wrap: wrap;
        font-size: 0.78rem;
        gap: 0.45rem;
        margin-top: 0.3rem;
    }

    .booking-meta__dot::before,
    .booking-customer__dot::before {
        content: '•';
    }

    .service-stack__title {
        line-height: 1.4;
    }

    .status-stack {
        display: flex;
        flex-direction: column;
        gap: 0.45rem;
    }

    .status-stack__chips {
        display: flex;
        flex-wrap: wrap;
        gap: 0.45rem;
    }

    .status-chip {
        border-radius: 999px;
        display: inline-flex;
        font-size: 0.74rem;
        font-weight: 700;
        line-height: 1;
        padding: 0.48rem 0.75rem;
        white-space: nowrap;
    }

    .status-chip--primary {
        background: var(--loket-primary-soft);
        color: var(--loket-primary);
    }

    .status-chip--success {
        background: var(--loket-success-soft);
        color: var(--loket-success);
    }

    .status-chip--warning {
        background: var(--loket-warning-soft);
        color: var(--loket-warning);
    }

    .status-chip--danger {
        background: var(--loket-danger-soft);
        color: var(--loket-danger);
    }

    .status-chip--dark,
    .status-chip--neutral {
        background: var(--loket-dark-soft);
        color: var(--loket-dark);
    }

    .action-group {
        display: flex;
        flex-wrap: wrap;
        gap: 0.45rem;
        justify-content: flex-end;
    }

    .action-group .btn {
        align-items: center;
        border: none !important;
        border-radius: 0.75rem;
        display: inline-flex;
        gap: 0.35rem;
        justify-content: center;
        min-width: 2.7rem;
        padding: 0.55rem 0.85rem;
        transition: all 0.2s ease;
    }

    .action-group .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15) !important;
        filter: brightness(1.1);
    }

    .btn-primary { background-color: var(--loket-primary) !important; color: #fff !important; }
    .btn-success { background-color: var(--loket-success) !important; color: #fff !important; }
    .btn-warning { background-color: var(--loket-warning) !important; color: #fff !important; }
    .btn-danger { background-color: var(--loket-danger) !important; color: #fff !important; }
    .btn-dark { background-color: var(--loket-dark) !important; color: #fff !important; }

    .action-group .btn-label {
        display: none;
        font-size: 0.74rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.02em;
    }

    .dataTables_wrapper .dataTables_length,
    .dataTables_wrapper .dataTables_filter {
        margin-bottom: 0.75rem;
    }

    .dataTables_wrapper .dataTables_length label,
    .dataTables_wrapper .dataTables_filter label {
        color: var(--loket-muted);
        font-size: 0.84rem;
        font-weight: 600;
    }

    .dataTables_wrapper .dataTables_filter input,
    .dataTables_wrapper .dataTables_length select {
        background: #ffffff;
        border: 1px solid var(--loket-line);
        border-radius: 999px;
        box-shadow: none;
        color: var(--loket-text);
        min-height: 2.75rem;
        outline: none;
    }

    .dataTables_wrapper .dataTables_filter input {
        margin-left: 0.65rem;
        min-width: 16rem;
        padding: 0.5rem 1rem;
    }

    .dataTables_wrapper .dataTables_length select {
        margin: 0 0.5rem;
        padding: 0.45rem 2.2rem 0.45rem 0.9rem;
    }

    .dataTables_wrapper .dataTables_info {
        color: var(--loket-muted);
        font-size: 0.82rem;
        padding-top: 1rem;
    }

    .dataTables_wrapper .dataTables_paginate {
        padding-top: 0.8rem;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button {
        background: transparent !important;
        border: 0 !important;
        border-radius: 999px;
        box-shadow: none !important;
        color: var(--loket-muted) !important;
        margin-left: 0.2rem;
        min-width: 2.35rem;
        padding: 0.42rem 0.7rem !important;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
        background: var(--loket-primary-soft) !important;
        color: var(--loket-primary) !important;
        font-weight: 700;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
        background: var(--loket-surface-alt) !important;
        color: var(--loket-text) !important;
    }

    div.dataTables_processing {
        background: rgba(255, 255, 255, 0.98);
        border: 1px solid var(--loket-line);
        border-radius: 1rem;
        box-shadow: 0 18px 36px rgba(15, 23, 42, 0.08);
        color: var(--loket-text);
        padding: 0.85rem 1rem;
    }

    .table-report {
        border-collapse: collapse !important;
        width: 100% !important;
    }

    .loket-searchable-select + .bootstrap-select > .dropdown-toggle {
        display: none !important;
    }

    .loket-service-modal .modal-content {
        border: 0;
        border-radius: 1.4rem;
        overflow: hidden;
    }

    .loket-service-modal .modal-header {
        align-items: flex-start;
        border-bottom: 1px solid var(--loket-line-soft);
        padding: 1.2rem 1.25rem;
    }

    .loket-service-modal__body {
        display: grid;
        gap: 1rem;
        grid-template-columns: minmax(0, 20rem) minmax(0, 1fr);
        padding: 1rem;
    }

    .loket-service-panel {
        background: var(--loket-surface-alt);
        border: 1px solid var(--loket-line-soft);
        border-radius: 1rem;
        padding: 1rem;
    }

    .loket-service-panel--list {
        background: #ffffff;
    }

    .loket-service-panel__eyebrow {
        color: var(--loket-muted);
        font-size: 0.78rem;
        font-weight: 700;
        letter-spacing: 0.08em;
        margin-bottom: 0.85rem;
        text-transform: uppercase;
    }

    .loket-service-actions {
        display: flex;
        justify-content: flex-start;
        margin-top: 1rem;
    }

    .loket-service-table-wrap {
        min-height: 12rem;
    }

    .loket-empty-state {
        background: #fff7ed;
        border: 1px solid #fdba74;
        border-radius: 0.95rem;
        color: #9a3412;
        font-size: 0.88rem;
        line-height: 1.55;
        padding: 0.85rem 1rem;
    }

    .service-item-card__title {
        color: var(--loket-text);
        font-size: 0.96rem;
        font-weight: 700;
        line-height: 1.45;
    }

    .service-item-card__price,
    .service-item-card__extra {
        color: var(--loket-muted);
        font-size: 0.82rem;
        margin-top: 0.35rem;
    }

    .service-item-card__extra {
        border-top: 1px dashed var(--loket-line);
        margin-top: 0.7rem;
        padding-top: 0.7rem;
    }

    .service-item-card__extra--empty {
        color: #94a3b8;
    }

    @media (min-width: 1200px) {
        .action-group .btn-label {
            display: inline;
        }
    }

    @media (max-width: 991.98px) {
        .loket-service-modal__body {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 767.98px) {
        .loket-page-title {
            font-size: 1.45rem;
        }

        .loket-table-shell__header {
            padding-left: 1rem;
            padding-right: 1rem;
        }

        .loket-table-shell__note {
            max-width: none;
            text-align: left;
        }

        .dataTables_wrapper .dataTables_filter input {
            min-width: 100%;
            margin-left: 0;
            margin-top: 0.5rem;
        }

        .loket-service-modal .modal-dialog {
            margin: 0;
        }

        .loket-service-modal .modal-content {
            border-radius: 0;
            min-height: 100vh;
        }

        .loket-service-modal .modal-header {
            padding: 1rem;
        }

        .loket-service-modal__body {
            gap: 0.85rem;
            padding: 0.85rem;
        }

        .loket-service-panel {
            border-radius: 0.9rem;
            padding: 0.9rem;
        }

        .loket-service-actions .btn {
            width: 100%;
        }

        .loket-searchable-select + .bootstrap-select > .dropdown-toggle {
            min-height: 3rem;
        }
    }
</style>
@endsection

@section('js')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{ asset('landing/plugins/bootstrap-select/bootstrap-select.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        // Global Select2 Initialization
        function initSelect2(selector) {
            $(selector).select2({
                width: '100%',
                dropdownParent: $(selector).closest('.modal').length ? $(selector).closest('.modal') : $(document.body)
            });
        }

        const routes = {
            bookings: "{{ route('loket.home') }}",
            bookingStore: "{{ route('bookingorder') }}",
            bookingEdit: "{{ route('booking.edit', '__ID__') }}",
            bookingUpdate: "{{ route('booking.update', '__ID__') }}",
            bookingDelete: "{{ route('booking.destroy', '__ID__') }}",
            vehicleTypes: "{{ route('tipemobil.create') }}",
            photoIndex: "{{ route('photocek.index', '__ID__') }}",
            photoStore: "{{ route('photocek.store', '__ID__') }}",
            photoDelete: "{{ route('photocek.delete', '__ID__') }}",
            productList: "{{ route('getProduk') }}",
            extraServices: "{{ route('extraservice.create') }}",
            orderList: "{{ route('orderan', '__ID__') }}",
            orderStore: "{{ route('orderan.store', '__ID__') }}",
            orderDelete: "{{ route('orderan.delete', '__ID__') }}",
            selesai: "{{ route('selesai') }}",
            qrcode: "{{ route('cetak.qrcode', '__ID__') }}"
        };

        let orderTable = null;
        let photoTable = null;
        let selesaiTable = null;

        function refreshSearchableSelect(target) {
            const selects = $(target);
            selects.each(function() {
                const select = $(this);
                if (!select.length) return;
                
                // Destroy if already initialized
                if (select.hasClass('select2-hidden-accessible')) {
                    select.select2('destroy');
                }
                
                initSelect2(select);
            });
        }

        function refreshLoketSelects(target) {
            refreshSearchableSelect(target || 'select:not(.dataTables_length select)');
        }

        function buildRoute(template, id) {
            return template.replace('__ID__', id);
        }

        function escapeHtml(value) {
            return String(value === null || value === undefined ? '' : value)
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;')
                .replace(/'/g, '&#039;');
        }

        function renderIcons() {
            if (window.feather) {
                feather.replace();
            }
        }

        function openModal(modalId) {
            bootstrap.Modal.getOrCreateInstance(document.getElementById(modalId)).show();
        }

        function closeModal(modalId) {
            bootstrap.Modal.getOrCreateInstance(document.getElementById(modalId)).hide();
        }

        function showFormErrors(target, errors) {
            const container = $(target);
            const list = container.find('ul');

            list.empty();
            (errors || []).forEach(function(error) {
                list.append('<li>' + escapeHtml(error) + '</li>');
            });
            container.show();
        }

        function showAlertErrors(errors) {
            const messages = (errors || []).map(function(error) {
                return '<li>' + escapeHtml(error) + '</li>';
            }).join('');

            Swal.fire({
                icon: 'warning',
                title: 'Periksa kembali input',
                html: '<ul class="text-start mb-0 ps-3">' + messages + '</ul>'
            });
        }

        function handleAjaxFailure(xhr, fallbackMessage) {
            const response = xhr && xhr.responseJSON ? xhr.responseJSON : {};
            const message = response.text || response.message || fallbackMessage;

            if (Array.isArray(response.errors)) {
                showAlertErrors(response.errors);
                return;
            }

            Swal.fire('Gagal', message, 'error');
        }

        function requestOptionSource(url, data) {
            return $.get(url, data || {}).then(function(res) {
                return res && Array.isArray(res.data) ? res.data : [];
            });
        }

        function clearProductEmptyState() {
            $('#product-empty-state').addClass('d-none').empty();
        }

        function setProductEmptyState(message) {
            $('#product').prop('disabled', true).html('<option value="">Belum ada layanan tersedia</option>');
            $('#extraservice').html('<option value="">--- Pilih Extra Layanan ---</option>');
            $('#form-extraservice').hide();
            $('#simpan_orderan').prop('disabled', true);
            $('#product-empty-state').removeClass('d-none').text(message);
            refreshLoketSelects('#product, #extraservice');
        }

        function setProductLoadingState() {
            clearProductEmptyState();
            $('#product').prop('disabled', true).html('<option value="">Memuat layanan...</option>');
            $('#simpan_orderan').prop('disabled', true).text('Tambah ke Pesanan');
            refreshLoketSelects('#product');
        }

        function statusTone(label, type) {
            if (type === 'payment') {
                return label === 'Sudah Bayar' ? 'success' : 'warning';
            }

            if (type === 'vehicle') {
                return label === 'Ditunggu' ? 'primary' : 'neutral';
            }

            if (label === 'Selesai') {
                return 'success';
            }

            if (label === 'Booking') {
                return 'dark';
            }

            return 'primary';
        }

        function renderStatusChip(label, type) {
            const tone = statusTone(label, type);
            return '<span class="status-chip status-chip--' + tone + '">' + escapeHtml(label) + '</span>';
        }

        function renderVehicleCell(row) {
            return '' +
                '<div class="booking-vehicle">' +
                    '<div class="booking-vehicle__plate">' + escapeHtml(row.no_pol_kendaraan || '-') + '</div>' +
                    '<div class="booking-meta">' +
                        '<span>' + escapeHtml(row.tipe_mobil || 'Tipe belum dipilih') + '</span>' +
                        '<span class="booking-meta__dot"></span>' +
                        '<span>' + escapeHtml(row.created_label || '-') + '</span>' +
                    '</div>' +
                '</div>';
        }

        function renderCustomerCell(row) {
            return '' +
                '<div class="booking-customer">' +
                    '<div class="booking-customer__name">' + escapeHtml(row.name || '-') + '</div>' +
                    '<div class="booking-customer__meta">' +
                        '<span>' + escapeHtml(row.phone || 'Nomor belum diisi') + '</span>' +
                    '</div>' +
                '</div>';
        }

        function renderServiceCell(row) {
            const summary = row.service_summary || row.service_preview || 'Belum ada layanan';
            const info = [];

            info.push((row.service_count || 0) + ' layanan');
            info.push((row.photo_count || 0) + ' foto');

            if (row.service_more_count > 0) {
                info.push('+' + row.service_more_count + ' tambahan');
            }

            return '' +
                '<div class="service-stack" title="' + escapeHtml(summary) + '">' +
                    '<div class="service-stack__title">' + escapeHtml(row.service_preview || 'Belum ada layanan') + '</div>' +
                    '<div class="service-stack__meta">' + info.map(function(item) {
                        return '<span>' + escapeHtml(item) + '</span>';
                    }).join('') + '</div>' +
                '</div>';
        }

        function renderStatusCell(row) {
            return '' +
                '<div class="status-stack">' +
                    '<div class="status-stack__chips">' +
                        renderStatusChip(row.payment_status || 'Belum Bayar', 'payment') +
                        renderStatusChip(row.vehicle_status || '-', 'vehicle') +
                        renderStatusChip(row.booking_status || 'Booking', 'booking') +
                    '</div>' +
                    '<div class="status-stack__meta">' +
                        '<span>' + escapeHtml((row.photo_count || 0) + ' dokumentasi') + '</span>' +
                    '</div>' +
                '</div>';
        }

        function renderActionCell(row) {
            return '' +
                '<div class="action-group">' +
                    '<button class="btn btn-sm btn-primary orderan text-white shadow-sm" data-id="' + escapeHtml(row.id) + '" title="Kelola layanan">' +
                        '<i data-feather="package" class="w-4 h-4"></i>' +
                        '<span class="btn-label">Layanan</span>' +
                    '</button>' +
                    '<button class="btn btn-sm btn-success upload text-white shadow-sm" data-id="' + escapeHtml(row.id) + '" title="Dokumentasi kendaraan">' +
                        '<i data-feather="camera" class="w-4 h-4"></i>' +
                        '<span class="btn-label">Foto</span>' +
                    '</button>' +
                    '<button class="btn btn-sm btn-warning edit text-white shadow-sm" data-id="' + escapeHtml(row.id) + '" title="Ubah booking">' +
                        '<i data-feather="edit" class="w-4 h-4"></i>' +
                        '<span class="btn-label">Edit</span>' +
                    '</button>' +
                    '<a target="_blank" href="' + buildRoute(routes.qrcode, row.id) + '" class="btn btn-sm btn-dark text-white shadow-sm" title="Cetak QR">' +
                        '<i data-feather="maximize" class="w-4 h-4"></i>' +
                        '<span class="btn-label">QR</span>' +
                    '</a>' +
                    '<button class="btn btn-sm btn-danger delete text-white shadow-sm" data-id="' + escapeHtml(row.id) + '" title="Hapus booking">' +
                        '<i data-feather="trash" class="w-4 h-4"></i>' +
                        '<span class="btn-label">Hapus</span>' +
                    '</button>' +
                '</div>';
        }

        function resetBookingForm() {
            $('#id').val('');
            $('#no_pol_kendaraan').val('');
            $('#name_pelanggan').val('');
            $('#phone').val('');
            $('#status_kendaraan').val('Ditunggu');
            $('#tipe_mobil').html('<option value="">--- Pilih Tipe Mobil ---</option>');
            $('#error').hide().find('ul').empty();
            $('#simpan').text('Simpan Pesanan').prop('disabled', false);
            refreshLoketSelects('#status_kendaraan, #tipe_mobil');
        }

        function loadVehicleTypes(selected) {
            return $.get(routes.vehicleTypes).done(function(res) {
                const items = res && res.data ? res.data : [];
                let options = '<option value="">--- Pilih Tipe Mobil ---</option>';

                items.forEach(function(item) {
                    const isSelected = selected && (selected === item.name || String(selected) === String(item.id));
                    options += '<option value="' + escapeHtml(item.id) + '"' + (isSelected ? ' selected' : '') + '>' + escapeHtml(item.name) + '</option>';
                });

                $('#tipe_mobil').html(options);
                refreshLoketSelects('#tipe_mobil');
            });
        }

        async function loadProducts() {
            setProductLoadingState();

            try {
                let items = await requestOptionSource(routes.productList);

                if (!items.length) {
                    items = await requestOptionSource(routes.extraServices);
                }

                if (!items.length) {
                    setProductEmptyState('Belum ada layanan aktif di master layanan. Tambahkan produk terlebih dahulu agar booking bisa diberi layanan.');
                    return [];
                }

                let options = '<option value="">--- Pilih Layanan ---</option>';

                items.forEach(function(item) {
                    options += '<option value="' + escapeHtml(item.id) + '">' + escapeHtml(item.name) + ' | Rp ' + Number(item.price || 0).toLocaleString('id-ID') + '</option>';
                });

                clearProductEmptyState();
                $('#product').prop('disabled', false).html(options);
                $('#simpan_orderan').prop('disabled', false);
                refreshLoketSelects('#product');

                return items;
            } catch (error) {
                setProductEmptyState('Daftar layanan gagal dimuat. Segarkan halaman lalu coba lagi.');
                return [];
            }
        }

        function loadExtraServices(productId) {
            if (!productId) {
                $('#form-extraservice').hide();
                $('#extraservice').html('<option value="">--- Pilih Extra Layanan ---</option>');
                refreshLoketSelects('#extraservice');
                return;
            }

            $.get(routes.extraServices, { id: productId }).done(function(res) {
                const items = res && res.data ? res.data : [];

                if (!items.length) {
                    $('#form-extraservice').hide();
                    $('#extraservice').html('<option value="">--- Pilih Extra Layanan ---</option>');
                    refreshLoketSelects('#extraservice');
                    return;
                }

                let options = '<option value="">--- Pilih Extra Layanan ---</option>';
                items.forEach(function(item) {
                    options += '<option value="' + escapeHtml(item.id) + '">' + escapeHtml(item.name) + ' | Rp ' + Number(item.price || 0).toLocaleString('id-ID') + '</option>';
                });

                $('#extraservice').html(options);
                $('#form-extraservice').show();
                refreshLoketSelects('#extraservice');
            });
        }

        refreshLoketSelects();

        const bookingTable = $('#tabel-booking').DataTable({
            ajax: {
                url: routes.bookings,
                dataSrc: 'data'
            },
            autoWidth: false,
            deferRender: true,
            ordering: false,
            pageLength: 8,
            lengthMenu: [8, 16, 32, 64],
            processing: true,
            scrollX: true,
            columns: [
                {
                    data: null,
                    orderable: false,
                    searchable: false,
                    className: 'text-center',
                    render: function(data, type, row, meta) {
                        return meta.row + 1;
                    }
                },
                {
                    data: null,
                    render: function(data, type, row) {
                        return renderVehicleCell(row);
                    }
                },
                {
                    data: null,
                    render: function(data, type, row) {
                        return renderCustomerCell(row);
                    }
                },
                {
                    data: null,
                    render: function(data, type, row) {
                        return renderServiceCell(row);
                    }
                },
                {
                    data: null,
                    render: function(data, type, row) {
                        return renderStatusCell(row);
                    }
                },
                {
                    data: null,
                    searchable: false,
                    className: 'text-end',
                    render: function(data, type, row) {
                        return renderActionCell(row);
                    }
                }
            ],
            dom: '<"d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 px-3 pt-3"lf>rt<"d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 px-3 pb-3"ip>',
            language: {
                emptyTable: 'Belum ada booking aktif pada periode ini.',
                info: 'Menampilkan _START_ sampai _END_ dari _TOTAL_ booking',
                infoEmpty: 'Belum ada booking aktif',
                lengthMenu: 'Tampilkan _MENU_ baris',
                loadingRecords: 'Memuat data...',
                processing: 'Menyiapkan tabel...',
                search: '',
                searchPlaceholder: 'Cari plat, pelanggan, atau layanan',
                zeroRecords: 'Data yang dicari tidak ditemukan',
                paginate: {
                    previous: 'Sebelumnya',
                    next: 'Berikutnya'
                }
            },
            drawCallback: function() {
                renderIcons();
            },
            initComplete: function() {
                renderIcons();
            }
        });

        $('#btn-refresh').on('click', function() {
            bookingTable.ajax.reload(null, false);
        });

        $('#tambah').on('click', function() {
            resetBookingForm();
            loadVehicleTypes();
        });

        $('#simpan').on('click', function() {
            const button = $(this);
            const bookingId = $('#id').val();
            const url = bookingId ? buildRoute(routes.bookingUpdate, bookingId) : routes.bookingStore;
            const method = bookingId ? 'PUT' : 'POST';

            button.prop('disabled', true).text('Menyimpan...');

            $.ajax({
                url: url,
                type: method,
                data: {
                    no_pol_kendaraan: $('#no_pol_kendaraan').val(),
                    name: $('#name_pelanggan').val(),
                    tipe_mobil: $('#tipe_mobil').val(),
                    phone: $('#phone').val(),
                    status_kendaraan: $('#status_kendaraan').val(),
                    _token: "{{ csrf_token() }}"
                },
                success: function(res) {
                    if (res.status === 'sukses') {
                        closeModal('modal-tambah');
                        bookingTable.ajax.reload(null, false);
                        Swal.fire('Berhasil', res.text, 'success');
                        return;
                    }

                    if (res.status === 'error') {
                        showFormErrors('#error', res.errors);
                        return;
                    }

                    Swal.fire('Gagal', res.text || 'Booking gagal disimpan.', 'error');
                },
                error: function(xhr) {
                    handleAjaxFailure(xhr, 'Terjadi kendala saat menyimpan booking.');
                },
                complete: function() {
                    button.prop('disabled', false).text(bookingId ? 'Update Pesanan' : 'Simpan Pesanan');
                }
            });
        });

        $(document).on('click', '.edit', function() {
            const bookingId = $(this).data('id');

            resetBookingForm();
            $('#id').val(bookingId);
            $('#simpan').text('Update Pesanan');

            $.get(buildRoute(routes.bookingEdit, bookingId)).done(function(res) {
                if (res.status !== 'sukses') {
                    Swal.fire('Gagal', res.text || 'Data booking tidak ditemukan.', 'error');
                    return;
                }

                $('#no_pol_kendaraan').val(res.data.no_pol_kendaraan || '');
                $('#name_pelanggan').val(res.data.name || '');
                $('#phone').val(res.data.phone || '');
                $('#status_kendaraan').val(res.data.status_kendaraan || 'Ditunggu');
                refreshLoketSelects('#status_kendaraan');

                loadVehicleTypes(res.data.tipe_mobil).always(function() {
                    openModal('modal-tambah');
                });
            }).fail(function(xhr) {
                handleAjaxFailure(xhr, 'Data booking gagal dimuat.');
            });
        });

        $(document).on('click', '.delete', function() {
            const bookingId = $(this).data('id');

            Swal.fire({
                title: 'Hapus booking?',
                text: 'Data yang dihapus tidak dapat dikembalikan.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#b91c1c',
                confirmButtonText: 'Ya, hapus',
                cancelButtonText: 'Batal'
            }).then(function(result) {
                if (!result.isConfirmed) {
                    return;
                }

                $.ajax({
                    url: buildRoute(routes.bookingDelete, bookingId),
                    type: 'DELETE',
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(res) {
                        if (res.status === 'sukses') {
                            bookingTable.ajax.reload(null, false);
                            Swal.fire('Terhapus', res.text, 'success');
                            return;
                        }

                        Swal.fire('Gagal', res.text || 'Booking tidak dapat dihapus.', 'error');
                    },
                    error: function(xhr) {
                        handleAjaxFailure(xhr, 'Terjadi kendala saat menghapus booking.');
                    }
                });
            });
        });

        function loadPhotoTable(bookingId) {
            if (photoTable) {
                photoTable.destroy();
            }

            photoTable = $('#tabel-photo').DataTable({
                destroy: true,
                processing: true,
                serverSide: true,
                searching: false,
                paging: false,
                info: false,
                ordering: false,
                ajax: buildRoute(routes.photoIndex, bookingId),
                columns: [
                    { data: 'photo', name: 'photo' }
                ],
                dom: 't',
                language: {
                    emptyTable: 'Belum ada dokumentasi kendaraan.'
                },
                drawCallback: function() {
                    renderIcons();
                }
            });
        }

        $(document).on('click', '.upload', function() {
            const bookingId = $(this).data('id');
            const photoForm = document.getElementById('form-photo');

            if (photoForm) {
                photoForm.reset();
            }

            $('#photo_booking_id').val(bookingId);
            loadPhotoTable(bookingId);
            openModal('modal-photo');
        });

        $('#form-photo').on('submit', function(event) {
            const formElement = this;
            const bookingId = $('#photo_booking_id').val();
            const submitButton = $('#simpan_photo');

            event.preventDefault();

            submitButton.prop('disabled', true).text('Mengunggah...');

            $.ajax({
                url: buildRoute(routes.photoStore, bookingId),
                type: 'POST',
                data: new FormData(formElement),
                processData: false,
                contentType: false,
                success: function(res) {
                    if (Array.isArray(res.error)) {
                        showAlertErrors(res.error);
                        return;
                    }

                    formElement.reset();
                    loadPhotoTable(bookingId);
                    bookingTable.ajax.reload(null, false);
                    Swal.fire('Berhasil', res.text || 'Dokumentasi kendaraan berhasil diunggah.', 'success');
                },
                error: function(xhr) {
                    handleAjaxFailure(xhr, 'Dokumentasi kendaraan gagal diunggah.');
                },
                complete: function() {
                    submitButton.prop('disabled', false).text('Unggah Dokumentasi');
                }
            });
        });

        $(document).on('click', '.delete_photo', function() {
            const photoId = $(this).data('id');
            const bookingId = $('#photo_booking_id').val();

            Swal.fire({
                title: 'Hapus foto?',
                text: 'Foto akan dihapus permanen dari sistem.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#b91c1c',
                confirmButtonText: 'Ya, hapus',
                cancelButtonText: 'Batal'
            }).then(function(result) {
                if (!result.isConfirmed) {
                    return;
                }

                $.ajax({
                    url: buildRoute(routes.photoDelete, photoId),
                    type: 'DELETE',
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(res) {
                        loadPhotoTable(bookingId);
                        bookingTable.ajax.reload(null, false);
                        Swal.fire('Berhasil', res.text || 'Foto berhasil dihapus.', 'success');
                    },
                    error: function(xhr) {
                        handleAjaxFailure(xhr, 'Foto gagal dihapus.');
                    }
                });
            });
        });

        function loadOrderTable(bookingId) {
            if (orderTable) {
                orderTable.destroy();
            }

            orderTable = $('#tabel-orderan').DataTable({
                destroy: true,
                processing: true,
                serverSide: true,
                searching: false,
                paging: false,
                info: false,
                ordering: false,
                ajax: buildRoute(routes.orderList, bookingId),
                columns: [
                    { data: 'bookingorder', name: 'bookingorder' }
                ],
                dom: 't',
                language: {
                    emptyTable: 'Belum ada layanan pada booking ini. Tambahkan layanan dari panel kiri.'
                },
                drawCallback: function() {
                    renderIcons();
                }
            });
        }

        $('#modal-orderan').on('shown.bs.modal', function() {
            refreshLoketSelects($(this).find('.loket-searchable-select'));

            if (orderTable) {
                orderTable.columns.adjust().draw(false);
            }
        });

        $('#modal-tambah').on('shown.bs.modal', function() {
            refreshLoketSelects($(this).find('.loket-searchable-select'));
        });

        $(document).on('click', '.orderan', function() {
            const bookingId = $(this).data('id');

            $('#orderan_booking_id').val(bookingId);
            clearProductEmptyState();
            $('#product').prop('disabled', true).html('<option value="">Memuat layanan...</option>');
            $('#extraservice').html('<option value="">--- Pilih Extra Layanan ---</option>');
            $('#form-extraservice').hide();
            $('#simpan_orderan').prop('disabled', true).text('Tambah ke Pesanan');
            refreshLoketSelects('#product, #extraservice');

            loadOrderTable(bookingId);
            loadProducts();
            openModal('modal-orderan');
        });

        $('#product').on('change', function() {
            loadExtraServices($(this).val());
        });

        $('#simpan_orderan').on('click', function() {
            const button = $(this);
            const bookingId = $('#orderan_booking_id').val();

            if (!$('#product').val()) {
                showAlertErrors(['Pilih layanan utama terlebih dahulu.']);
                return;
            }

            button.prop('disabled', true).text('Menambahkan...');

            $.post(buildRoute(routes.orderStore, bookingId), {
                product: $('#product').val(),
                extraservice: $('#extraservice').val(),
                _token: "{{ csrf_token() }}"
            }).done(function(res) {
                if (res.status === 'sukses') {
                    $('#product').val('');
                    $('#extraservice').html('<option value="">--- Pilih Extra Layanan ---</option>');
                    $('#form-extraservice').hide();
                    refreshLoketSelects('#product, #extraservice');
                    loadOrderTable(bookingId);
                    bookingTable.ajax.reload(null, false);
                    Swal.fire('Berhasil', res.text, 'success');
                    return;
                }

                if (res.status === 'error') {
                    showAlertErrors(res.errors);
                    return;
                }

                Swal.fire('Gagal', res.text || 'Layanan gagal ditambahkan.', 'error');
            }).fail(function(xhr) {
                handleAjaxFailure(xhr, 'Layanan gagal ditambahkan ke booking.');
            }).always(function() {
                button.prop('disabled', false).text('Tambah ke Pesanan');
            });
        });

        $(document).on('click', '.delete_layanan', function() {
            const orderId = $(this).attr('id');
            const bookingId = $('#orderan_booking_id').val();

            Swal.fire({
                title: 'Hapus layanan?',
                text: 'Item layanan akan dihapus dari booking ini.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#b91c1c',
                confirmButtonText: 'Ya, hapus',
                cancelButtonText: 'Batal'
            }).then(function(result) {
                if (!result.isConfirmed) {
                    return;
                }

                $.ajax({
                    url: buildRoute(routes.orderDelete, orderId),
                    type: 'DELETE',
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(res) {
                        if (res.status !== 'sukses') {
                            Swal.fire('Gagal', res.text || 'Layanan tidak dapat dihapus.', 'error');
                            return;
                        }

                        loadOrderTable(bookingId);
                        bookingTable.ajax.reload(null, false);
                        Swal.fire('Berhasil', res.text, 'success');
                    },
                    error: function(xhr) {
                        handleAjaxFailure(xhr, 'Layanan gagal dihapus.');
                    }
                });
            });
        });

        function loadFinishedTable() {
            if (selesaiTable) {
                selesaiTable.destroy();
            }

            selesaiTable = $('#tabel-selesai').DataTable({
                destroy: true,
                processing: true,
                serverSide: true,
                ajax: routes.selesai,
                columns: [
                    {
                        data: null,
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row, meta) {
                            return meta.row + 1;
                        }
                    },
                    { data: 'no_pol_kendaraan', name: 'no_pol_kendaraan' },
                    { data: 'orderan', name: 'orderan' }
                ],
                dom: '<"px-3 pt-3"f>t<"d-flex justify-content-between align-items-center px-3 pb-3"ip>',
                language: {
                    emptyTable: 'Belum ada kendaraan selesai hari ini.',
                    info: 'Menampilkan _START_ sampai _END_ dari _TOTAL_ kendaraan selesai',
                    infoEmpty: 'Belum ada kendaraan selesai',
                    search: '',
                    searchPlaceholder: 'Cari kendaraan selesai',
                    zeroRecords: 'Data selesai tidak ditemukan'
                },
                drawCallback: function() {
                    renderIcons();
                }
            });
        }

        $('#selesai').on('click', function() {
            loadFinishedTable();
        });

        renderIcons();
    });
</script>
@endsection
