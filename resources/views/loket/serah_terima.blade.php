@extends('layouts.office')
@section('title')
    Dashboard Serah Terima
@endsection
@section('content')
    <div class="grid columns-12 gap-6">
        <div class="g-col-12 g-col-xxl-12">
            <div class="grid columns-12 gap-6">
                <!-- BEGIN: Weekly Top Products -->
                <div class="g-col-12 mt-6">
                    <div class="intro-y d-block d-sm-flex align-items-center h-10">
                        <h2 class="fs-lg fw-medium truncate me-5">
                            Tabel Pengerjaan
                        </h2>
                        <div class="d-flex align-items-center ms-sm-auto mt-3 mt-sm-0">
                            <button class="btn btn-dark w-40 me-8 mb-4" id="update"> <i data-feather="plus-circle"
                                    class="w-4 h-4 me-2"></i> Update </button>
                        </div>
                    </div>
                    <br>
                    <div class="intro-y overflow-auto overflow-lg-visible mt-8 mt-sm-0">
                        <table class="table table-bordered display" id="tabel-booking" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th class="text-nowrap" style="width: 5%">No</th>
                                    <th class="text-nowrap">No Pol</th>
                                    <th class="text-nowrap">Orderan</th>
                                    <th class="text-center text-nowrap">Aksi</th>
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
            // setInterval(() => {
            //     $('#tabel-booking').DataTable().ajax.reload()
            // }, 60000);
        });

        function isi_tabel() {
            $('#tabel-booking').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                ajax: "{{ route('serahterima') }}",
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
                        data: 'orderan',
                        name: 'orderan'
                    },
                    {
                        data: 'aksi',
                        name: 'aksi'
                    }
                ]
            })
        }

        $("#update").on('click', function() {
            $('#update').text('Loading..').prop('disabled', true);
            $('#tabel-booking').DataTable().ajax.reload()
            swal('Update Berhasil', {
                icon: "success",
            });
            $('#update').text('Update').prop('disabled', false);
        })
    </script>
@endsection
