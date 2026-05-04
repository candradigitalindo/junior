@extends('layouts.office')

@section('title')
    Riwayat Barang | JUNIOR AUTO CARE
@endsection

@section('content')
    <div class="grid columns-12 gap-6">
        <div class="g-col-12">
            <div class="intro-y d-flex flex-column flex-sm-row align-items-center mt-8">
                <h2 class="fs-2xl fw-bold truncate me-auto">
                    Riwayat: <span class="text-theme-1">{{ $query->name }}</span>
                </h2>
                <div class="w-full w-sm-auto d-flex mt-4 mt-sm-0">
                    <a href="{{ route('gudang.index') }}" class="btn btn-outline-secondary shadow-md w-32 me-2">
                        <i data-feather="corner-up-left" class="w-4 h-4 me-2"></i> Kembali
                    </a>
                </div>
            </div>
        </div>

        <!-- Filter Section -->
        <div class="g-col-12 intro-y mt-2">
            <div class="box p-5">
                <div class="d-flex flex-column flex-sm-row align-items-end gap-4">
                    <div class="w-full w-sm-56">
                        <label class="form-label small fw-semibold text-gray-500">Dari Tanggal</label>
                        <div class="input-group">
                            <div class="input-group-text bg-gray-100 border-2"><i data-feather="calendar" class="w-4 h-4"></i></div>
                            <input type="date" class="form-control border-2" id="start_date" value="{{ date('Y-m-d') }}">
                        </div>
                    </div>
                    <div class="w-full w-sm-56">
                        <label class="form-label small fw-semibold text-gray-500">Sampai Tanggal</label>
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

        <!-- History Table -->
        <div class="g-col-12 mt-2">
            <div class="intro-y box p-5">
                <div class="overflow-x-auto">
                    <table class="table table-report display w-full" id="tabel-barang">
                        <thead>
                            <tr>
                                <th class="text-nowrap" style="width: 5%">NO</th>
                                <th class="text-nowrap">BARCODE</th>
                                <th class="text-nowrap">NAMA BARANG</th>
                                <th class="text-nowrap">WAKTU AKTIVITAS</th>
                                <th class="text-center text-nowrap">STATUS</th>
                                <th class="text-center text-nowrap">AKSI</th>
                            </tr>
                        </thead>
                    </table>
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
            function isi_tabel(start_date = '', end_date = '') {
                const id = "{{ $query->id }}";
                const url = "{{ route('gudang.histori', ':id') }}".replace(':id', id);

                $('#tabel-barang').DataTable({
                    responsive: true, processing: true, serverSide: true, destroy: true,
                    ajax: {
                        url: url,
                        data: { start_date: start_date, end_date: end_date }
                    },
                    columns: [
                        {
                            "data": null, "sortable": false,
                            render: (data, type, row, meta) => `<div class="fw-bold text-gray-400">${meta.row + meta.settings._iDisplayStart + 1}</div>`
                        },
                        { data: 'barcode', name: 'barcode' },
                        { data: 'name', name: 'name' },
                        { data: 'created_at', name: 'created_at' },
                        { data: 'status', name: 'status' },
                        { data: 'aksi', name: 'aksi', sortable: false }
                    ],
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

            $(document).on('click', '.delete', function() {
                const id = $(this).attr('id');
                Swal.fire({
                    title: 'Hapus Log?',
                    text: "Menghapus log akan mempengaruhi jumlah stok!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ef4444',
                    confirmButtonText: 'Ya, Hapus!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.post("{{ route('barang.delete', ':id') }}".replace(':id', id), { _token: "{{ csrf_token() }}" }, (res) => {
                            Swal.fire('Berhasil!', res.text, 'success');
                            $('#tabel-barang').DataTable().ajax.reload();
                        });
                    }
                });
            });
        });
    </script>
@endsection
