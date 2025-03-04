@extends('layouts.office')
@section('title')
    Histori Barang
@endsection
@section('content')
    <div class="grid columns-12 gap-6">
        <div class="g-col-12 g-col-xxl-12">
            <div class="grid columns-12 gap-6">
                <!-- BEGIN: Weekly Top Products -->
                <div class="g-col-12 mt-6">
                    <div class="intro-y d-block d-sm-flex align-items-center h-10">
                        <h2 class="fs-lg fw-medium truncate me-5">
                            HISTORI BARANG {{ $query->name }}
                        </h2>
                        <div class="d-flex align-items-center ms-sm-auto mt-3 mt-sm-0">
                            <a href="{{ route('gudang.index') }}" class="btn btn-primary w-45 me-8 mb-4"> <i
                                    data-feather="rewind" class="w-4 h-4 me-2"></i> Kembali </a>
                        </div>
                    </div>
                    <div class="container text-center">
                        <div class="row">
                            <div class="col"></div>
                            <div class="col">

                                <div class="input-group w-56 mx-auto">
                                    <div id="input-group-email" class="input-group-text"> <i data-feather="calendar"
                                            class="w-4 h-4"></i> </div> <input type="date" class=" form-control"
                                        data-single-mode="true" id="start_date">
                                </div>
                            </div>
                            s/d
                            <div class="col">

                                <div class="input-group w-56 mx-auto">
                                    <div id="input-group-email" class="input-group-text"> <i data-feather="calendar"
                                            class="w-4 h-4"></i> </div> <input type="date" class=" form-control"
                                        data-single-mode="true" id="end_date">
                                </div>
                            </div>

                            <div class="col">

                                <button class="btn btn-primary w-32 me-2 mb-2" id="btn-filter"> <i data-feather="calendar"
                                        class="w-4 h-4 me-2"></i> Filter </button>
                            </div>
                            <div class="col"></div>
                        </div>
                        <br>

                    </div>
                    <br>
                    <div class="intro-y overflow-auto overflow-lg-visible mt-8 mt-sm-0">
                        <div class="alert alert-danger print-error-msg" style="display:none" id="error">
                            <ul></ul>
                        </div>
                        <table class="table table-bordered display" id="tabel-barang" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th class="text-nowrap" style="width: 5%">No</th>
                                    <th class="text-center text-nowrap">ID</th>
                                    <th class="text-center text-nowrap">Barcode</th>
                                    <th class="text-center text-nowrap">Nama Barang</th>
                                    <th class="text-center text-nowrap">Waktu</th>
                                    <th class="text-center text-nowrap" style="width: 10%">Status</th>
                                </tr>
                            </thead>

                        </table>
                    </div>
                </div>
                <!-- END: Weekly Top Products -->
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

        function isi_tabel(start_date = '', end_date = '') {
            let id = "{{ $query->id }}"
            let url = "{{ route('gudang.histori',':id') }}"
                url     = url.replace(':id', id)
            $('#tabel-barang').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                destroy: true,
                ajax: {
                    url: url,
                    data: {
                        start_date: start_date,
                        end_date: end_date
                    },
                },
                columns: [{
                        "data": null,
                        "sortable": false,
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1
                        }
                    },
                    {
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'barcode',
                        name: 'barcode'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    }

                ]
            })
        }

        $("#btn-filter").on('click', function() {
            $('#btn-filter').text('Loading..').prop('disabled', true);
            var start_date = $('#start_date').val()
            var end_date = $('#end_date').val()
            if ($('#start_date').val() == '' || $('#end_date').val() == '') {
                alert('Mohon isi Tanggal awal dan Tanggal akhir')
                $('#btn-filter').text('Filter').prop('disabled', false);
            } else {
                // $('#tabel-booking').DataTable().empty();
                isi_tabel(start_date, end_date);
                $('#btn-filter').text('Filter').prop('disabled', false);
            }
        });
    </script>
@endsection
