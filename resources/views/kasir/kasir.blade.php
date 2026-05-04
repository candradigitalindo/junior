@extends('layouts.office')
@section('title')
    Dashboard Kasir
@endsection

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

        /* Select2 Custom Styling */
        .select2-container--default .select2-selection--single {
            background-color: #ffffff;
            border: 1px solid var(--kasir-line);
            border-radius: 0.5rem;
            height: 38px;
            display: flex;
            align-items: center;
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: var(--kasir-dark);
            padding-left: 0.75rem;
            font-weight: 400;
        }
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 36px;
            right: 0.5rem;
        }
        .select2-dropdown {
            border: 1px solid var(--kasir-line);
            border-radius: 0.5rem;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            z-index: 9999;
        }
        .select2-container--default .select2-search--dropdown .select2-search__field {
            border: 1px solid var(--kasir-line);
            border-radius: 0.375rem;
            padding: 0.4rem 0.75rem;
        }
        .select2-container--default .select2-results__option--highlighted[aria-selected] {
            background-color: var(--kasir-primary);
        }
        .modal-open .select2-container {
            z-index: 1060;
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
            padding: 1.25rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            margin-bottom: 1.5rem;
        }

        .kasir-table-card {
            background: var(--kasir-surface);
            border: 1px solid var(--kasir-line);
            border-radius: 1rem;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05);
            padding: 1.5rem;
            overflow: hidden;
        }

        #tabel-booking {
            border-collapse: separate !important;
            border-spacing: 0 0.5rem !important;
            margin: 0 !important;
        }

        #tabel-booking thead th {
            background: #f1f5f9;
            border: none !important;
            color: var(--kasir-muted);
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            padding: 1rem;
        }

        #tabel-booking tbody tr {
            transition: all 0.2s;
        }

        #tabel-booking tbody td {
            border-bottom: 1px solid var(--kasir-line) !important;
            padding: 1.25rem 1rem;
            vertical-align: middle;
            background: #fff;
        }

        /* Aggressively remove ALL DataTables sorting icons and background noise */
        #tabel-booking thead th,
        #tabel-booking thead th.sorting,
        #tabel-booking thead th.sorting_asc,
        #tabel-booking thead th.sorting_desc,
        #tabel-booking thead th.sorting_disabled {
            background-image: none !important;
            cursor: default !important;
            position: relative !important;
            padding-right: 1rem !important; /* Reset padding usually reserved for icons */
        }

        #tabel-booking thead th:before, 
        #tabel-booking thead th:after,
        #tabel-booking thead th.sorting:before,
        #tabel-booking thead th.sorting:after,
        #tabel-booking thead th.sorting_asc:before,
        #tabel-booking thead th.sorting_asc:after,
        #tabel-booking thead th.sorting_desc:before,
        #tabel-booking thead th.sorting_desc:after {
            display: none !important;
            content: "" !important;
        }

        .booking-info__plate {
            font-size: 1.15rem;
            font-weight: 800;
            color: var(--kasir-primary);
            letter-spacing: 0.02em;
        }

        .action-btns .btn {
            border: none !important;
            border-radius: 0.75rem;
            padding: 0.6rem 0.8rem;
            font-weight: 700;
            transition: all 0.2s;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        .action-btns .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            filter: brightness(1.1);
        }

        .btn-primary { background-color: var(--kasir-primary) !important; color: #fff !important; }
        .btn-success { background-color: var(--kasir-success) !important; color: #fff !important; }
        .btn-warning { background-color: #f59e0b !important; color: #fff !important; } /* Bolder amber */
        .btn-danger { background-color: var(--kasir-danger) !important; color: #fff !important; }
        .btn-dark { background-color: var(--kasir-dark) !important; color: #fff !important; }

        .badge-soft {
            font-weight: 700;
            padding: 0.5em 0.8em;
            border-radius: 0.6rem;
            text-transform: uppercase;
            font-size: 0.7rem;
        }

        /* Mobile specific */
        @media (max-width: 768px) {
            .kasir-page-title { font-size: 1.25rem; }
            .kasir-table-card { padding: 0.75rem; }
            #tabel-booking tbody td { padding: 0.75rem 0.5rem; }
            .action-btns .btn { padding: 0.5rem; }
            .booking-info__plate { font-size: 1rem; }
        }

        .kasir-stat-inline {
            border-radius: 0.75rem;
            padding: 0.5rem 1rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            height: 42px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            border-width: 2px !important;
            transition: transform 0.2s;
        }
        .kasir-stat-inline:hover { transform: translateY(-2px); }
        
        .kasir-stat-inline--paid { background: #ecfdf5; border-color: #10b981 !important; }
        .kasir-stat-inline--unpaid { background: #fffbeb; border-color: #f59e0b !important; }

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
            font-size: 1.25rem;
            font-weight: 900;
            line-height: 1;
            letter-spacing: -0.01em;
        }

        /* Stronger Table Nominals */
        .text-total-strong {
            font-size: 1.1rem;
            font-weight: 800;
            color: var(--kasir-success);
        }

        /* Action Buttons Responsive */
        .btn-pay-text { display: inline; }
        .btn-pay-icon { display: none; }

        @media (max-width: 768px) {
            .btn-pay-text { display: none; }
            .btn-pay-icon { display: inline-block; }
            .action-btns .btn-sm { padding: 0.75rem !important; }
            .kasir-stat-inline { height: auto; padding: 0.4rem 0.75rem; }
            .kasir-stat-inline__value { font-size: 0.9rem; }
        }

        /* Modal styling */
        .modal-content {
            border: none;
            border-radius: 1rem;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
        }
        .modal-header { border-bottom: 1px solid var(--kasir-line); padding: 1.25rem; }
        .modal-footer { border-top: 1px solid var(--kasir-line); padding: 1.25rem; }
    </style>
@endsection

@section('content')
    <div class="intro-y d-flex flex-column flex-sm-row align-items-center mt-8 mb-5">
        <h2 class="kasir-page-title me-auto">Dashboard Kasir</h2>
        <div class="w-full w-sm-auto d-flex mt-4 mt-sm-0 gap-2">
            <button class="btn btn-primary shadow-md fw-bold px-4" id="update">
                <i data-feather="refresh-cw" class="w-4 h-4 me-2"></i> Update Tabel
            </button>
            
            {{-- Hidden Triggers --}}
            <button style="display: none" data-bs-toggle="modal" data-bs-target="#modal-tambah" id="tambah"></button>
            <button style="display: none" data-bs-toggle="modal" data-bs-target="#modal-pengecekan" id="pengecekan"></button>
            <button style="display: none" data-bs-toggle="modal" data-bs-target="#modal-pengerjaan" id="pengerjaan"></button>
            <button style="display: none" data-bs-toggle="modal" data-bs-target="#modal-diskon" id="diskon"></button>
            <button style="display: none" data-bs-toggle="modal" data-bs-target="#modal-photo" id="photo"></button>
            <button style="display: none" data-bs-toggle="modal" data-bs-target="#modal-orderan" id="orderan"></button>
        </div>
    </div>

    <div class="intro-y kasir-filter-card">
        <div class="row align-items-end g-3">
            <div class="col-12 col-md-3 col-lg-2">
                <label class="form-label small fw-bold text-muted">DARI TANGGAL</label>
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0"><i data-feather="calendar" class="w-4 h-4"></i></span>
                    <input type="date" class="form-control border-start-0 ps-0" id="start_date" 
                        value="{{ date('Y-m-d') }}" 
                        min="{{ date('Y-m-d', strtotime('-3 months')) }}">
                </div>
            </div>
            <div class="col-12 col-md-3 col-lg-2">
                <label class="form-label small fw-bold text-muted">SAMPAI TANGGAL</label>
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0"><i data-feather="calendar" class="w-4 h-4"></i></span>
                    <input type="date" class="form-control border-start-0 ps-0" id="end_date" 
                        value="{{ date('Y-m-d') }}"
                        min="{{ date('Y-m-d', strtotime('-3 months')) }}">
                </div>
            </div>
            <div class="col-12 col-md-auto">
                <button class="btn btn-dark fw-bold" style="height: 38px;" id="btn-filter">
                    <i data-feather="search" class="w-4 h-4 me-2"></i> Filter
                </button>
            </div>
            <div class="col-12 col-md-auto ms-lg-auto d-flex flex-wrap gap-2">
                <div class="kasir-stat-inline kasir-stat-inline--paid">
                    <div>
                        <div class="kasir-stat-inline__label">Sudah Bayar</div>
                        <div class="kasir-stat-inline__value text-success" id="summary-paid">Rp 0</div>
                    </div>
                </div>
                <div class="kasir-stat-inline kasir-stat-inline--unpaid">
                    <div>
                        <div class="kasir-stat-inline__label">Belum Bayar</div>
                        <div class="kasir-stat-inline__value text-warning" id="summary-unpaid">Rp 0</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="intro-y kasir-table-card">
        <div class="table-responsive">
            <table class="table table-hover display" id="tabel-booking" width="100%">
                <thead>
                    <tr>
                        <th class="no-sort text-center" style="width: 5%">NO</th>
                        <th>INFO KENDARAAN</th>
                        <th>WAKTU</th>
                        <th>BIAYA & ORDER</th>
                        <th class="text-center">STATUS</th>
                        <th>TRANSAKSI</th>
                        <th class="text-center">AKSI</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
    <div id="modal-tambah" class="modal fade" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- BEGIN: Modal Header -->
                <div class="modal-header">
                    <h2 class="fw-medium fs-base me-auto">
                        Pembayaran
                    </h2>
                </div>
                <!-- END: Modal Header -->
                <!-- BEGIN: Modal Body -->
                <div class="alert alert-danger print-error-msg" style="display:none" id="error">
                    <ul></ul>
                </div>
                <form enctype="multipart/form-data" id="form-pembayaran">
                    @csrf
                    <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                        <div class="g-col-12">
                            <label for="pos-form-1" class="form-label">No Pol Kendaraan</label>
                            <input type="text" class="form-control flex-1" id="xno_pol_kendaraan" name="no_pol_kendaraan"
                                disabled>
                        </div>

                        <div class="g-col-12">
                            <label for="pos-form-4" class="form-label">Metode Pembayaran</label>
                            <select id="metode_pembayaran" name="metode_pembayaran" class="form-control flex-1" required>
                                <option value="">-- Pilih Medote --</option>
                                <option value="CASH">CASH</option>
                                <option value="QRIS">QRIS</option>
                                <option value="DEBIT BCA">DEBIT BCA</option>
                                <option value="DEBIT MANDIRI">DEBIT MANDIRI</option>
                                <option value="KARTU">KARTU</option>
                                <option value="TRANSFER BANK">TRANSFER BANK</option>
                                <option value="E-MONEY">E-MONEY</option>
                            </select>
                        </div>
                        <div class="g-col-12">
                            <label for="pos-form-4" class="form-label">Foto Bukti Pembayaran</label>
                            <input type="file" class="form-control flex-1" id="foto_pembayaran"
                                name="foto_pembayaran">
                        </div>

                        <input type="text" style="visibility: hidden" id="booking_id" name="booking_id">
                    </div>
                    <!-- END: Modal Body -->
                    <!-- BEGIN: Modal Footer -->
                    <div class="modal-footer text-end">
                        <button type="button" data-bs-dismiss="modal" class="btn btn-outline-secondary w-32 me-1"
                            id="cencel">Cancel</button>
                        <button type="submit" class="btn btn-primary w-32" id="simpan">Simpan</button>
                    </div>
                </form>
                <!-- END: Modal Footer -->
            </div>
        </div>
    </div>
    <div id="modal-pengecekan" class="modal fade" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- BEGIN: Modal Header -->
                <div class="modal-header">
                    <h2 class="fw-medium fs-base me-auto">
                        CEK KENDARAAN
                    </h2>
                </div>
                <!-- END: Modal Header -->
                <!-- BEGIN: Modal Body -->
                <div class="alert alert-danger print-error-msg" style="display:none" id="error">
                    <ul></ul>
                </div>
                <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                    <div class="g-col-12">
                        <label for="pos-form-1" class="form-label">No Pol. Kendaraan</label>
                        <input type="text" class="form-control flex-1" id="cno_pol_kendaraan" disabled>
                    </div>
                    <div class="g-col-12">
                        <label for="pos-form-2" class="form-label">Tipe Mobil</label>
                        <input type="text" class="form-control flex-1" placeholder="Exp. FORTUNER" id="ctipe_mobil"
                            disabled>
                    </div>

                    <div class="g-col-12">
                        <label for="pos-form-4" class="form-label">Bagian Exterior</label>
                        <textarea class="form-control flex-1" name="exterior" id="cexterior" cols="30" rows="10" disabled></textarea>
                    </div>
                    <div class="g-col-12">
                        <label for="pos-form-4" class="form-label">Bagian Interior</label>
                        <textarea class="form-control flex-1" name="interior" id="cinterior" cols="30" rows="10" disabled></textarea>
                    </div>
                    <div class="g-col-12">
                        <label for="pos-form-4" class="form-label">Mesin</label>
                        <textarea class="form-control flex-1" name="mesin" id="cmesin" cols="30" rows="10" disabled></textarea>
                    </div>
                    <div class="g-col-12">
                        <label for="pos-form-4" class="form-label">Barang didalam Mobil</label>
                        <textarea class="form-control flex-1" name="barang_mobil" id="cbarang_mobil" cols="30" rows="10"
                            disabled></textarea>
                    </div>

                </div>
                <!-- END: Modal Body -->
                <!-- BEGIN: Modal Footer -->
                <div class="modal-footer text-end">
                    <button type="button" data-bs-dismiss="modal"
                        class="btn btn-outline-secondary w-32 me-1">Tutup</button>
                </div>
                <!-- END: Modal Footer -->
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-pengerjaan" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Pekerjaan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="g-col-12">
                        <label for="pos-form-2" class="form-label">No Pol. Kendaraan</label>
                        <input type="text" class="form-control flex-1" id="pno_pol_kendaraan" disabled>
                    </div>

                    <br>
                    <br>
                    <table class="table table-bordered" width="100%" cellspacing="0" id="tabel-histori">
                        <thead>
                            <tr>
                                <th class="text-nowrap">Histori</th>
                            </tr>
                        </thead>
                        <tbody id="tbody-histori"></tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-diskon" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Diskon</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger print-error-msg" style="display:none" id="error_diskon">
                        <ul></ul>
                    </div>
                    <div class="g-col-12">
                        <label for="pos-form-2" class="form-label">Nominal Diskon</label>
                        <input type="number" class="form-control flex-1" id="nominal_diskon" min="0">
                    </div>
                    <input type="text" style="visibility: hidden" id="diskon_booking_id">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                        id="tutup_diskon">Tutup</button>
                    <button type="button" class="btn btn-primary w-32" id="simpan_diskon">Simpan</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-photo" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Upload Foto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger print-error-msg" style="display:none" id="error-photo">
                        <ul></ul>
                    </div>

                    <br>
                    <br>
                    <table class="table table-bordered" width="100%" cellspacing="0" id="tabel-photo">
                        <thead>
                            <tr>
                                <th class="text-nowrap">Foto</th>
                            </tr>
                        </thead>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-orderan" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Orderan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger print-error-msg" style="display:none" id="error-orderan">
                        <ul></ul>
                    </div>
                    <div class="g-col-12">
                        <label for="pos-form-2" class="form-label">No Pol. Kendaraan</label>
                        <input type="text" class="form-control flex-1" id="ono_pol_kendaraan" disabled>
                    </div>
                    <br>
                    <div class="g-col-12">
                        <label for="pos-form-1" class="form-label">Layanan</label>
                        <select id="product" class="form-control">

                        </select>
                    </div>
                    <br>
                    <div class="g-col-12" style="display: none" id="form-extraservice">
                        <label for="pos-form-1" class="form-label">Extra Layanan</label>
                        <select id="extraservice" class="form-control flex-1">

                        </select>
                    </div>
                    <input type="text" style="visibility: hidden" id="orderan_booking_id">
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary w-32" id="simpan_orderan">Tambah</button>
                    </div>
                    <br>
                    <table class="table table-bordered" width="100%" cellspacing="0" id="tabel-orderan">
                        <thead>
                            <tr>
                                <th class="text-nowrap">Orderan</th>
                            </tr>
                        </thead>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
    <audio id="tingtung" src="{{ asset('audio/tingtung.mp3') }}"></audio>
@endsection
@section('js')
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="https://code.responsivevoice.org/responsivevoice.js?key=Pqiovi6G"></script>
    <script>
        $(document).ready(function() {
            isi_tabel();
            initSelect2();

            // Auto-trigger payment if ID is in URL
            const urlParams = new URLSearchParams(window.location.search);
            const bookingId = urlParams.get('id');
            if (bookingId) {
                // Wait for table to load or just trigger directly via ID
                setTimeout(() => {
                    const $btn = $(`.bayar[id="${bookingId}"]`);
                    if ($btn.length) {
                        $btn.click();
                    } else {
                        // If not in current table view (due to date filter), force load it
                        forceTriggerPayment(bookingId);
                    }
                }, 1000);
            }
        });

        function forceTriggerPayment(id) {
            let url = "{{ route('booking.edit', ':id') }}".replace(':id', id);
            $('#form-pembayaran')[0].reset();
            $('#booking_id').val(id);
            
            $.get(url, function(res) {
                $('#xno_pol_kendaraan').val(res.data.no_pol_kendaraan);
                $('#tambah').click();
            });
        }

        // Global Select2 Initialization
        function initSelect2(selector = 'select:not(.dataTables_length select)') {
            $(selector).each(function() {
                const $select = $(this);
                $select.select2({
                    width: '100%',
                    dropdownParent: $select.closest('.modal').length ? $select.closest('.modal') : $(document.body)
                });
            });
        }

        // Utility: Format Rupiah
        function formatRupiah(amount) {
            return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(amount).replace('Rp','Rp ');
        }

        // Simple Format without prefix for input
        function formatNumber(n) {
            return n.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }

        $(document).on('keyup', '#nominal_diskon', function() {
            $(this).val(formatNumber($(this).val()));
            
            // Validation: Cannot exceed total
            const rawValue = parseInt($(this).val().replace(/\./g, '')) || 0;
            const totalAmount = parseInt($('#diskon_booking_id').data('total')) || 0;
            
            if (rawValue > totalAmount) {
                $(this).addClass('border-danger text-danger');
                if (!$('#error-diskon-limit').length) {
                    $(this).after('<div id="error-diskon-limit" class="text-danger small mt-1 fw-bold">Diskon tidak boleh melebihi total tagihan!</div>');
                }
                $('#simpan_diskon').prop('disabled', true);
            } else {
                $(this).removeClass('border-danger text-danger');
                $('#error-diskon-limit').remove();
                $('#simpan_diskon').prop('disabled', false);
            }
        });

        // Utility: Format Date Time
        function formatDateTime(dateTimeString) {
            if (!dateTimeString) return '-';
            const date = new Date(dateTimeString);
            return date.toLocaleDateString('id-ID', { day: '2-digit', month: '2-digit', year: 'numeric' }) + ' ' + 
                   date.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });
        }

        $('.modal').on('shown.bs.modal', function() {
            if (typeof feather !== 'undefined') feather.replace();
            initSelect2($(this).find('select'));
        });

        function isi_tabel(start_date = '', end_date = '') {
            $('#tabel-booking').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                destroy: true,
                order: [[2, 'desc']], // Sort by time desc
                columnDefs: [
                    { targets: 'no-sort', orderable: false }
                ],
                ajax: {
                    url: "{{ route('kasir.index') }}",
                    data: {
                        start_date: start_date,
                        end_date: end_date
                    },
                },
                drawCallback: function(settings) {
                    if (typeof feather !== 'undefined') {
                        feather.replace();
                    }
                    
                    // Update Summaries
                    const json = settings.json;
                    if (json) {
                        $('#summary-paid').text(formatRupiah(json.totalPaid || 0));
                        $('#summary-unpaid').text(formatRupiah(json.totalUnpaid || 0));
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
                            return `
                                <div class="booking-info">
                                    <div class="booking-info__plate">${data}</div>
                                    <div class="booking-info__customer">${row.name || '-'} (${row.status_kendaraan || '-'})</div>
                                    <div class="booking-info__meta">${row.tipe_mobil || '-'} | ${row.phone || '-'}</div>
                                </div>
                            `;
                        }
                    },
                    {
                        data: 'tgl_booking',
                        render: function(data, type, row) {
                            let html = `<div class="text-xs">
                                <div><span class="text-muted fw-bold">BOOK:</span> ${formatDateTime(data)}</div>`;
                            if (row.tgl_proses) html += `<div><span class="text-muted fw-bold">PROS:</span> ${formatDateTime(row.tgl_proses)}</div>`;
                            if (row.tgl_selesai) html += `<div><span class="text-muted fw-bold">DONE:</span> ${formatDateTime(row.tgl_selesai)}</div>`;
                            html += `</div>`;
                            return html;
                        }
                    },
                    {
                        data: 'total_tagihan',
                        render: function(data, type, row) {
                            return `
                                <div class="text-start">
                                    <button class="orderan btn btn-xs btn-primary mb-2 py-1 px-2 fw-bold" id="${row.id}">View Order</button>
                                    <div class="text-total-strong mb-1">Total: ${formatRupiah(data)}</div>
                                    <div class="text-muted text-xs fw-bold">Disc: ${formatRupiah(row.discount_amount || 0)}</div>
                                    <div class="mt-2 d-flex gap-1">
                                        <button class="diskon btn btn-xs btn-warning text-white" id="${row.id}" data-total="${data}" title="Beri Diskon">Disc</button>
                                        <button class="reset_diskon btn btn-xs btn-outline-secondary" id="${row.id}" title="Reset Diskon">Reset</button>
                                    </div>
                                </div>
                            `;
                        }
                    },
                    {
                        data: 'status',
                        className: 'text-center',
                        render: function(data, type, row) {
                            let statusClass = 'badge-soft-primary';
                            if (data === 'Selesai') statusClass = 'badge-soft-success';
                            if (data === 'Batal') statusClass = 'badge-soft-danger';

                            let payClass = row.status_pembayaran === 'Sudah Bayar' ? 'badge-soft-success' : 'badge-soft-warning';
                            
                            return `
                                <div class="mb-2"><span class="badge-soft ${statusClass}">${data}</span></div>
                                <div><span class="badge-soft ${payClass}">${row.status_pembayaran || 'Belum Bayar'}</span></div>
                            `;
                        }
                    },
                    {
                        data: 'invoice_number',
                        render: function(data, type, row) {
                            if (data === '-') return '<div class="text-muted italic text-xs">Belum ada transaksi</div>';
                            let html = `<div class="text-xs">
                                <div><span class="fw-bold">Inv:</span> ${data}</div>
                                <div><span class="fw-bold">Via:</span> ${row.payment_method}</div>`;
                            if (row.paid_at) html += `<div><span class="fw-bold">Paid:</span> ${formatDateTime(row.paid_at)}</div>`;
                            if (row.payment_proof) {
                                html += `<div class="mt-1"><img src="/storage/bukti-pembayaran/${row.payment_proof}" class="rounded shadow-sm" style="width: 40px; cursor: pointer;" onclick="window.open(this.src)"/></div>`;
                            }
                            html += `</div>`;
                            return html;
                        }
                    },
                    {
                        data: 'id',
                        className: 'text-center',
                        render: function(data, type, row) {
                            let mainBtn = '';
                            if (row.status_pembayaran === 'Sudah Bayar') {
                                mainBtn = `
                                    <a target="_blank" href="/invoice/${data}/cetak" class="btn btn-sm btn-dark w-full mb-2">
                                        <span class="btn-pay-text">Cetak Invoice</span>
                                        <i data-feather="printer" class="btn-pay-icon w-4 h-4"></i>
                                    </a>`;
                            } else {
                                mainBtn = `
                                    <button class="bayar btn btn-sm btn-warning text-white w-full mb-2 fw-bold shadow-sm" id="${data}">
                                        <span class="btn-pay-text">Proses Bayar</span>
                                        <i data-feather="credit-card" class="btn-pay-icon w-5 h-5"></i>
                                    </button>`;
                            }

                            return `
                                <div class="action-btns">
                                    ${mainBtn}
                                    <div class="d-flex justify-content-center gap-1 flex-wrap">
                                        <button class="upload btn btn-xs btn-outline-secondary" id="${data}" title="Dokumentasi"><i data-feather="camera" class="w-3 h-3"></i></button>
                                        <button class="pengerjaan btn btn-xs btn-outline-secondary" id="${data}" title="Pengerjaan"><i data-feather="activity" class="w-3 h-3"></i></button>
                                        <button class="panggil btn btn-xs btn-dark" id="${data}" title="Panggil Customer"><i data-feather="volume-2" class="w-3 h-3"></i></button>
                                        <button class="whatsapp btn btn-xs btn-success text-white" id="${data}" title="Kirim WA"><i data-feather="message-circle" class="w-3 h-3"></i></button>
                                    </div>
                                </div>
                            `;
                        }
                    }
                ],
                drawCallback: function(settings) {
                    if (typeof feather !== 'undefined') {
                        feather.replace();
                    }
                    
                    // Update Summaries from AJAX response
                    const json = settings.json;
                    if (json) {
                        $('#summary-paid').text(formatRupiah(json.totalPaid || 0));
                        $('#summary-unpaid').text(formatRupiah(json.totalUnpaid || 0));
                    }
                }
            });
        }

        $("#update").on('click', function() {
            const $btn = $(this);
            const originalHtml = $btn.html();
            $btn.prop('disabled', true).html('<i data-feather="loader" class="w-4 h-4 me-2 animate-spin"></i> Loading..');
            
            $('#tabel-booking').DataTable().ajax.reload(function() {
                $btn.prop('disabled', false).html(originalHtml);
                if (typeof feather !== 'undefined') feather.replace();
                swal('Tabel Diperbarui', 'Data booking terbaru telah dimuat.', 'success');
            }, false);
        });

        $("#btn-filter").on('click', function() {
            const start_date = $('#start_date').val();
            const end_date = $('#end_date').val();
            
            if (!start_date || !end_date) {
                swal('Perhatian', 'Mohon pilih rentang tanggal yang lengkap.', 'warning');
                return;
            }

            // Robust 3 months limit check
            const today = new Date();
            today.setHours(0, 0, 0, 0);
            
            const limit = new Date(today);
            limit.setMonth(limit.getMonth() - 3);
            
            const selected = new Date(start_date);
            
            if (selected < limit) {
                swal({
                    title: "Pembatasan Akses",
                    text: "Kasir hanya diperbolehkan melihat data maksimal 3 bulan terakhir.",
                    icon: "error",
                    button: "Tutup"
                });
                return;
            }
            
            isi_tabel(start_date, end_date);
        });

        // Action Handlers
        $(document).on('click', '.cekmasuk, .cekkeluar', function() {
            const id = $(this).attr('id');
            let url = "{{ route('pengecekan.home', ':id') }}".replace(':id', id);
            
            $.ajax({
                url: url,
                type: 'GET',
                success: function(res) {
                    $('#cno_pol_kendaraan').val(res.data.no_pol_kendaraan);
                    $('#ctipe_mobil').val(res.data.tipe_mobil);
                    const dataPengecekan = $(this).hasClass('cekmasuk') ? res.data.cekmasuk : res.data.cekkeluar;
                    
                    $('#cexterior').val(dataPengecekan ? dataPengecekan.exterior : '');
                    $('#cinterior').val(dataPengecekan ? dataPengecekan.interior : '');
                    $('#cmesin').val(dataPengecekan ? dataPengecekan.mesin : '');
                    $('#cbarang_mobil').val(dataPengecekan ? dataPengecekan.barang_mobil : '');
                    
                    $('#pengecekan').click();
                }
            });
        });

        $(document).on('click', '.pengerjaan', function() {
            const id = $(this).attr('id');
            let url = "{{ route('booking.edit', ':id') }}".replace(':id', id);
            
            $.ajax({
                url: url,
                type: 'GET',
                success: function(res) {
                    $('#pno_pol_kendaraan').val(res.data.no_pol_kendaraan);
                    let url_histori = "{{ route('pengerjaan.show', ':id') }}".replace(':id', res.data.id);
                    
                    $('#tabel-histori').DataTable({
                        responsive: true,
                        processing: true,
                        serverSide: true,
                        destroy: true,
                        ajax: url_histori,
                        columns: [{ data: 'histori', name: 'histori' }]
                    });
                    $('#pengerjaan').click();
                }
            });
        });

        $(document).on('click', '.bayar', function() {
            const id = $(this).attr('id');
            let url = "{{ route('booking.edit', ':id') }}".replace(':id', id);
            
            $('#form-pembayaran')[0].reset();
            $('#booking_id').val(id);
            
            $.ajax({
                url: url,
                type: 'GET',
                success: function(res) {
                    $('#xno_pol_kendaraan').val(res.data.no_pol_kendaraan);
                    $('#tambah').click();
                }
            });
        });

        $('#form-pembayaran').on('submit', function(e) {
            e.preventDefault();
            const $btn = $('#simpan');
            $btn.prop('disabled', true).text('Memproses...');
            
            const id = $('#booking_id').val();
            let url = "{{ route('kasir.bayar', ':id') }}".replace(':id', id);
            
            $.ajax({
                type: 'POST',
                url: url,
                data: new FormData(this),
                cache: false,
                contentType: false,
                processData: false,
                success: function(res) {
                    if (res.error) {
                        printErrorMsg(res.error);
                    } else {
                        $('#modal-tambah').modal('hide');
                        $('#tabel-booking').DataTable().ajax.reload(null, false);
                        swal('Berhasil', res.text, 'success');
                    }
                },
                complete: function() {
                    $btn.prop('disabled', false).text('Simpan');
                }
            });
        });

        $(document).on('click', '.diskon', function() {
            const id = $(this).attr('id');
            const total = $(this).data('total');
            $('#nominal_diskon').val('').removeClass('border-danger text-danger');
            $('#error-diskon-limit').remove();
            $('#simpan_diskon').prop('disabled', false);
            $('#diskon_booking_id').val(id).data('total', total);
            $('#diskon').click();
        });

        $("#simpan_diskon").on('click', function() {
            const id = $('#diskon_booking_id').val();
            let url = "{{ route('kasir.diskon', ':id') }}".replace(':id', id);
            
            // Clean formatting before sending
            const diskonRaw = $('#nominal_diskon').val().replace(/\./g, '');
            
            $.ajax({
                url: url,
                type: "POST",
                data: {
                    diskon: diskonRaw,
                    _token: "{{ csrf_token() }}"
                },
                success: function(res) {
                    if (res.error) {
                        printErrorMsg(res.error, "#error_diskon");
                    } else if (res.status == 'gagal') {
                        swal('Gagal', res.text, 'error');
                    } else {
                        $('#tabel-booking').DataTable().ajax.reload(null, false);
                        $('#modal-diskon').modal('hide');
                        swal('Berhasil', res.text, 'success');
                    }
                }
            });
        });

        $(document).on('click', '.reset_diskon', function() {
            const id = $(this).attr('id');
            let url = "{{ route('kasir.diskon.reset', ':id') }}".replace(':id', id);
            
            swal({
                title: "Reset Diskon?",
                text: "Nominal diskon akan dikembalikan ke 0.",
                icon: "warning",
                buttons: true,
            }).then((willReset) => {
                if (willReset) {
                    $.ajax({
                        url: url,
                        type: 'GET',
                        success: function(res) {
                            if (res.status == 'gagal') {
                                swal('Gagal', res.text, 'error');
                            } else {
                                $('#tabel-booking').DataTable().ajax.reload(null, false);
                                swal('Berhasil', res.text, 'success');
                            }
                        }
                    });
                }
            });
        });

        $(document).on('click', '.upload', function() {
            const id = $(this).attr('id');
            $('#photo_booking_id').val(id);
            let url_photo = "{{ route('photocek.index', ':id') }}".replace(':id', id);
            
            $('#tabel-photo').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                destroy: true,
                ajax: url_photo,
                columns: [{ data: 'photo', name: 'photo' }]
            });
            $('#photo').click();
        });

        $(document).on('click', '.panggil', function() {
            const id = $(this).attr('id');
            let url = "{{ route('booking.edit', ':id') }}".replace(':id', id);
            const $btn = $(this);
            
            $btn.prop('disabled', true);
            $.ajax({
                url: url,
                type: 'GET',
                success: function(res) {
                    const plate = res.data.no_pol_kendaraan.split("").join(" ");
                    const bell = document.getElementById('tingtung');
                    bell.play();
                    
                    setTimeout(function() {
                        responsiveVoice.speak("Nomor Kendaraan " + plate + ", Sudah Selesai", "Indonesian Male", {
                            rate: 0.9, pitch: 1, volume: 1
                        });
                    }, 1500);
                    
                    setTimeout(() => $btn.prop('disabled', false), 5000);
                }
            });
        });

        $(document).on('click', '.whatsapp', function() {
            const id = $(this).attr('id');
            let url = "{{ route('wa.send', ':id') }}".replace(':id', id);
            const $btn = $(this);
            
            $btn.prop('disabled', true);
            $.ajax({
                url: url,
                type: 'GET',
                success: function(res) {
                    swal(res.status === 'gagal' ? 'Gagal' : 'Berhasil', res.text, res.status === 'gagal' ? 'error' : 'success');
                    $btn.prop('disabled', false);
                }
            });
        });

        $(document).on('click', '.orderan', function() {
            const id = $(this).attr('id');
            const $btn = $(this);
            const originalText = $btn.text();

            $btn.prop('disabled', true).text('Loading..');

            // 1. Fetch Booking Details (for Plate Number)
            let url_edit = "{{ route('booking.edit', ':id') }}".replace(':id', id);
            $.get(url_edit, function(res) {
                $('#ono_pol_kendaraan').val(res.data.no_pol_kendaraan);
                $('#orderan_booking_id').val(id);

                // 2. Refresh Order Table
                let url_orderan = "{{ route('orderan', ':id') }}".replace(':id', id);
                $('#tabel-orderan').DataTable({
                    responsive: true,
                    processing: true,
                    serverSide: true,
                    destroy: true,
                    ajax: url_orderan,
                    columns: [{ data: 'bookingorder', name: 'bookingorder' }]
                });

                // 3. Load Products
                $.get("{{ route('getProduk') }}", function(resProduk) {
                    $("#product").empty().append('<option value="">--- Pilih Layanan ---</option>');
                    $.each(resProduk.data, function(i, item) {
                        $("#product").append(`<option value="${item.id}">${item.name} | ${formatRupiah(item.price)}</option>`);
                    });
                    
                    initSelect2("#product");
                    $btn.prop('disabled', false).text(originalText);
                    $('#orderan').click(); // Trigger Modal
                });
            });
        });
        $('#product').on('change', function() {
            const productId = $(this).val();
            if (!productId) {
                $('#form-extraservice').hide();
                return;
            }
            
            $.get("{{ route('extraservice.create') }}", { id: productId }, function(res) {
                if (res.data && res.data.length > 0) {
                    $("#extraservice").empty().append('<option value="">--- Pilih Extra Service ---</option>');
                    $.each(res.data, function(i, item) {
                        $("#extraservice").append(`<option value="${item.id}">${item.name} | ${formatRupiah(item.price)}</option>`);
                    });
                    $('#form-extraservice').show();
                    initSelect2("#extraservice");
                } else {
                    $('#form-extraservice').hide();
                }
            });
        });

        $("#simpan_orderan").on('click', function() {
            const id = $('#orderan_booking_id').val();
            let url = "{{ route('orderan.store', ':id') }}".replace(':id', id);
            
            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    product: $('#product').val(),
                    extraservice: $('#extraservice').val(),
                    _token: "{{ csrf_token() }}"
                },
                success: function(res) {
                    if (res.error) {
                        printErrorMsg(res.error, "#error-orderan");
                    } else {
                        $('#tabel-orderan').DataTable().ajax.reload();
                        $('#tabel-booking').DataTable().ajax.reload(null, false);
                        swal('Berhasil', res.text, 'success');
                    }
                }
            });
        });

        function printErrorMsg(msg, container = ".print-error-msg") {
            $(container).find("ul").html('');
            $(container).css('display', 'block');
            $.each(msg, function(key, value) {
                $(container).find("ul").append('<li>' + value + '</li>');
            });
        }
    </script>
@endsection
