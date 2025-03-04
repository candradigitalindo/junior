@extends('layouts.office')
@section('title')
    Dashboard Kasir
@endsection
@section('content')
    <div class="grid columns-12 gap-6">
        <div class="g-col-12 g-col-xxl-12">
            <div class="grid columns-12 gap-6">
                <!-- BEGIN: Weekly Top Products -->
                <div class="g-col-12 mt-6">
                    <div class="intro-y d-block d-sm-flex align-items-center h-10">
                        <h2 class="fs-lg fw-medium truncate me-5">
                            Tabel Transaksi
                        </h2>

                        <div class="d-flex align-items-center ms-sm-auto mt-3 mt-sm-0">
                            <a class="btn btn-warning w-45 me-8 mb-4" href="{{ route('home') }}"> <i data-feather="rewind"
                                    class="w-4 h-4 me-2"></i>Kembali Dashboard </a>
                            {{-- <button class="btn btn-warning w-45 me-8 mb-4" data-bs-toggle="modal"
                                data-bs-target="#modal-filter" id="filter"><i data-feather="filter"
                                    class="w-4 h-4 me-2"></i>Filter</button> --}}
                            <button style="visibility: hidden" data-bs-toggle="modal" data-bs-target="#modal-pengecekan"
                                id="pengecekan"></button>
                            <button style="visibility: hidden" data-bs-toggle="modal" data-bs-target="#modal-pengerjaan"
                                id="pengerjaan"></button>
                            <button style="visibility: hidden" data-bs-toggle="modal" data-bs-target="#modal-diskon"
                                id="diskon"></button>
                            <button style="visibility: hidden" data-bs-toggle="modal" data-bs-target="#modal-orderan"
                                id="orderan"></button>
                        </div>
                    </div>
                    <br>
                    <div class="intro-y overflow-auto overflow-lg-visible mt-8 mt-sm-0">
                        <table class="table table-bordered display" id="tabel-booking" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th class="text-nowrap" style="width: 1%">No</th>
                                    <th class="text-nowrap">Info Pelanggan</th>
                                    <th class="text-nowrap">Tgl Booking</th>
                                    <th class="text-nowrap">Keterangan</th>
                                    {{-- <th class="text-nowrap">Status</th> --}}
                                    <th class="text-nowrap">Transaksi</th>
                                    <th class="text-nowrap">Aksi</th>

                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
                <!-- END: Weekly Top Products -->

            </div>
        </div>
    </div>


    <div class="modal fade" id="modal-filter" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Filter Transaksi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="g-col-12">
                        <label for="pos-form-2" class="form-label"> Tanggal Awal</label>
                        <input type="date" class="form-control flex-1" id="start_date">
                    </div>

                    <br>
                    <div class="g-col-12">
                        <label for="pos-form-2" class="form-label"> Tanggal Akhir</label>
                        <input type="date" class="form-control flex-1" id="end_date">
                    </div>
                    <br>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="btn-filter">Filter</button>
                    </div>
                    <table class="table table-bordered" width="100%" cellspacing="0" id="tabel-histori">
                        <thead>
                            <tr>
                                <th class="text-nowrap">Data</th>
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
@endsection
@section('css')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.4/css/jquery.dataTables.css">
@endsection
@section('js')
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
        crossorigin="anonymous"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
        $(document).ready(function() {
            isi_tabel()
        });

        function isi_tabel() {
            $('#tabel-booking').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.transaksi') }}",
                columns: [{
                        "data": null,
                        "sortable": false,
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1
                        }
                    },
                    {
                        data: 'no_pol_kendaraan',
                        name: 'no_pol_kendaraan'
                    },
                    {
                        data: 'tgl_booking',
                        name: 'tgl_booking'
                    },
                    {
                        data: 'description',
                        name: 'description'
                    },

                    {
                        data: 'transaksi',
                        name: 'transaksi'
                    },
                    {
                        data: 'aksi',
                        name: 'aksi'
                    },
                ]
            })
        }



        $(document).on('click', '.reset', function() {
            swal({
                    title: "Apakah Anda Yakin ?",
                    text: "Jika direset, Data Transaksi Akan terupdate menjadi Belum Bayar!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        let id = $(this).attr('id')
                        let url = "{{ route('admin.reset.transaksi', ':id') }}"
                        url = url.replace(':id', id)
                        $.ajax({
                            url: url,
                            type: 'GET',
                            data: {
                                _token: "{{ csrf_token() }}"
                            },
                            success: function(res) {
                                if (res.status == 'gagal') {
                                    swal(res.text, {
                                        icon: "error",
                                    });
                                } else {
                                    swal(res.text, {
                                        icon: "success",
                                    });
                                }
                                $('#tabel-booking').DataTable().ajax.reload()
                            }
                        })
                    }
                });
        })

        $("#filter").on('click', function() {
            console.log($('#daterange').val())
        })
    </script>
@endsection
