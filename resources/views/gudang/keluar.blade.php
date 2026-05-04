@extends('layouts.office')

@section('title')
    Input Barang Keluar | JUNIOR AUTO CARE
@endsection

@section('content')
    <div class="grid columns-12 gap-6">
        <div class="g-col-12">
            <div class="intro-y d-flex flex-column flex-sm-row align-items-center mt-8">
                <h2 class="fs-2xl fw-bold truncate me-auto">
                    Input Barang Keluar
                </h2>
                <div class="w-full w-sm-auto d-flex mt-4 mt-sm-0">
                    <a href="{{ route('gudang.index') }}" class="btn btn-outline-secondary shadow-md w-32 me-2">
                        <i data-feather="corner-up-left" class="w-4 h-4 me-2"></i> Kembali
                    </a>
                </div>
            </div>
        </div>

        <!-- Scan Center -->
        <div class="g-col-12 g-col-lg-4 intro-y mt-2">
            <div class="box p-8 text-center border-2 border-danger">
                <div class="w-20 h-20 bg-danger/10 text-danger rounded-circle d-flex align-items-center justify-content-center mx-auto mb-5">
                    <i data-feather="minimize" class="w-10 h-10"></i>
                </div>
                <h3 class="fs-xl fw-bold mb-2">Scan Barcode</h3>
                <p class="text-gray-500 mb-6">Arahkan scanner untuk mencatat pengeluaran barang dari stok.</p>
                
                <div class="relative">
                    <div class="absolute w-10 h-full d-flex align-items-center justify-content-center text-gray-400">
                        <i data-feather="slack" class="w-5 h-5"></i>
                    </div>
                    <input type="text" class="form-control form-control-lg ps-12 border-2" id="barcode" autocomplete="off" placeholder="Scan Barcode Di Sini...">
                </div>

                <div class="alert alert-danger mt-5 text-start print-error-msg" style="display:none" id="error">
                    <ul class="mb-0 small"></ul>
                </div>
            </div>
        </div>

        <!-- History Today -->
        <div class="g-col-12 g-col-lg-8 intro-y mt-2">
            <div class="box p-5 h-full">
                <div class="d-flex align-items-center border-bottom border-gray-100 pb-4 mb-4">
                    <h2 class="fw-bold fs-lg">Barang Keluar Hari Ini</h2>
                    <div class="ms-auto text-gray-500 text-xs italic">{{ date('d M Y') }}</div>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="table table-report display w-full" id="tabel-barang">
                        <thead>
                            <tr>
                                <th class="text-nowrap" style="width: 5%">NO</th>
                                <th class="text-nowrap">BARCODE</th>
                                <th class="text-nowrap">NAMA BARANG</th>
                                <th class="text-nowrap">WAKTU KELUAR</th>
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
        .table-report { border-collapse: separate; border-spacing: 0 8px; margin-top: -10px !important; }
        .table-report tr { border-radius: 10px; transition: all 0.3s; }
        .table-report td { background: #fff5f5; border: none !important; padding: 12px 15px !important; vertical-align: middle !important; }
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
            const table = $('#tabel-barang').DataTable({
                responsive: true, processing: true, serverSide: true,
                paging: false, ordering: false, info: false, destroy: true,
                ajax: "{{ route('barang.keluar') }}",
                columns: [
                    {
                        "data": null,
                        render: (data, type, row, meta) => `<div class="fw-bold text-gray-400">${meta.row + 1}</div>`
                    },
                    { data: 'barcode', name: 'barcode' },
                    { 
                        data: 'name', name: 'name',
                        render: (data) => `<div class="fw-bold text-danger">${data}</div>`
                    },
                    { data: 'created_at', name: 'created_at' },
                    { data: 'aksi', name: 'aksi' }
                ],
                dom: 't'
            });

            $('#barcode').focus();

            $('#barcode').on('keypress', function(e) {
                if (e.which === 13) {
                    const code = $(this).val();
                    if (!code) return;

                    $(this).prop('disabled', true);
                    $.ajax({
                        url: "{{ route('barang.post.keluar') }}",
                        type: "POST",
                        data: { barcode: code, _token: "{{ csrf_token() }}" },
                        success: (res) => {
                            if (res.error) {
                                printErrorMsg(res.error);
                            } else if (res.status === 'error') {
                                Swal.fire({ icon: 'error', title: 'Gagal', text: res.text, timer: 1500, showConfirmButton: false });
                            } else {
                                table.ajax.reload();
                                Swal.fire({ icon: 'warning', title: 'Keluar', text: res.text, timer: 1000, showConfirmButton: false });
                                $("#error").hide();
                            }
                            $(this).val('').prop('disabled', false).focus();
                        },
                        error: () => {
                            Swal.fire('Error', 'Terjadi kesalahan sistem', 'error');
                            $(this).val('').prop('disabled', false).focus();
                        }
                    });
                }
            });

            $(document).on('click', '.delete', function() {
                const id = $(this).attr('id');
                Swal.fire({
                    title: 'Batalkan Keluar?',
                    text: "Data stok akan ditambah kembali!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3b82f6',
                    confirmButtonText: 'Ya, Pulihkan!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.post("{{ route('barang.delete.keluar', ':id') }}".replace(':id', id), { _token: "{{ csrf_token() }}" }, (res) => {
                            Swal.fire('Dipulihkan!', res.text, 'success');
                            table.ajax.reload();
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
