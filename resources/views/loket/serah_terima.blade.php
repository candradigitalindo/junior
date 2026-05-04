@extends('layouts.office')

@section('title', 'Dashboard Serah Terima | JUNIOR AUTO CARE')

@section('content')
<div class="intro-y d-flex flex-column flex-sm-row align-items-center mt-8">
    <h2 class="fs-lg fw-medium me-auto">
        Serah Terima Kendaraan
    </h2>
    <div class="w-full w-sm-auto d-flex mt-4 sm:mt-0">
        <button class="btn btn-dark shadow-md d-flex align-items-center" id="update">
            <i data-feather="refresh-cw" class="w-4 h-4 me-2"></i> Segarkan Data
        </button>
    </div>
</div>

<div class="grid columns-12 gap-6 mt-5">
    <div class="intro-y g-col-12 overflow-auto overflow-lg-visible">
        <div class="box p-5">
            <table class="table table-report mt-n2" id="tabel-booking" width="100%">
                <thead>
                    <tr>
                        <th class="text-nowrap" style="width: 5%">NO</th>
                        <th class="text-nowrap">NOMOR POLISI</th>
                        <th class="text-nowrap">LAYANAN / ORDERAN</th>
                        <th class="text-center text-nowrap">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('css')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.4/css/jquery.dataTables.css">
<style>
    .table-report {
        border-spacing: 0 10px;
        border-collapse: separate;
    }
    .table-report thead tr th {
        border-bottom-width: 0;
        padding-left: 1.25rem;
        padding-right: 1.25rem;
        padding-top: 0.75rem;
        padding-bottom: 0.75rem;
    }
    .table-report tbody tr {
        background-color: white;
        box-shadow: 0 3px 10px rgb(0 0 0 / 2%);
    }
    .table-report tbody tr td {
        border-bottom-width: 0;
        padding-left: 1.25rem;
        padding-right: 1.25rem;
        padding-top: 1rem;
        padding-bottom: 1rem;
    }
    .table-report tbody tr td:first-child {
        border-top-left-radius: 0.375rem;
        border-bottom-left-radius: 0.375rem;
    }
    .table-report tbody tr td:last-child {
        border-top-right-radius: 0.375rem;
        border-bottom-right-radius: 0.375rem;
    }
</style>
@endsection

@section('js')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        const table = $('#tabel-booking').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            ajax: "{{ route('serahterima') }}",
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'no_pol_kendaraan', name: 'no_pol_kendaraan', className: 'fw-bold text-primary' },
                { data: 'orderan', name: 'orderan' },
                { data: 'aksi', name: 'aksi', orderable: false, searchable: false }
            ],
            dom: '<"d-flex flex-column flex-sm-row align-items-center justify-content-between mb-4"lf>rt<"d-flex flex-column flex-sm-row align-items-center justify-content-between mt-4"ip>',
            language: {
                search: "",
                searchPlaceholder: "Cari...",
                lengthMenu: "Tampilkan _MENU_ data",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data"
            },
            drawCallback: function() {
                feather.replace();
            }
        });

        $("#update").on('click', function() {
            const btn = $(this);
            btn.prop('disabled', true).html('<i data-feather="refresh-cw" class="w-4 h-4 me-2 animate-spin"></i> Loading...');
            feather.replace();
            
            table.ajax.reload(() => {
                btn.prop('disabled', false).html('<i data-feather="refresh-cw" class="w-4 h-4 me-2"></i> Segarkan Data');
                feather.replace();
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
