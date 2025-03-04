@extends('layouts.office')
@section('title')
    Pengecekan Kendaraan
@endsection
@section('content')
    <div class="grid columns-12 gap-6">
        <div class="g-col-12 g-col-xxl-12">
            <div class="grid columns-12 gap-6">
                <!-- BEGIN: Weekly Top Products -->
                <div class="g-col-12 mt-6">
                    <div class="intro-y d-block d-sm-flex align-items-center h-10">


                    </div>
                    <div class="container text-center">
                        <h2 class="fs-lg fw-medium truncate me-5">
                            KENDARAAN KELUAR
                        </h2>
                        <br>
                        <div class="input-group w-30 mx-auto">
                            <div id="input-group-email" class="input-group-text"> <i data-feather="slack"
                                    class="w-4 h-4"></i> </div> <input type="text" class=" form-control"
                                data-single-mode="true" id="barcode">
                        </div>

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
                                    <th class="text-center text-nowrap">No Kendaraan</th>
                                    <th class="text-center text-nowrap">Nama</th>
                                    <th class="text-center text-nowrap">Tanggal Proses</th>
                                    <th class="text-center text-nowrap">Tanggal Keluar</th>

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
            $('#barcode').val("").focus();
            $('#barcode').keyup(function(e) {
                var tex = $(this).val();
                console.log(tex);
                if (tex !== "" && e.keyCode === 13) {
                    $.ajax({
                        url: "{{ route('cekkeluar') }}",
                        type: "POST",
                        data: {
                            barcode: tex,
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(res) {
                            if ($.isEmptyObject(res.error)) {
                                $("#error").css("display", "none");
                                if (res.status == 'error') {
                                    swal(res.text, {
                                        icon: "error",
                                        timer: 2000,
                                        buttons: false,
                                        closeOnClickOutside: false
                                    });
                                    $('#barcode').val("").focus();
                                } else {
                                    $('#tabel-barang').DataTable().ajax.reload()
                                    swal(res.text, {
                                        icon: "success",
                                        timer: 2000,
                                        buttons: false,
                                        closeOnClickOutside: false
                                    });
                                    $('#barcode').val("").focus();
                                }
                            } else {
                                printErrorMsg(res.error)
                            }
                        }
                    })
                }
                e.preventDefault();
            });

        });

        function isi_tabel() {
            $('#tabel-barang').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                paging: false,
                ordering: false,
                info: false,
                destroy: true,
                ajax: "{{ route('pengecekan.index') }}",
                columns: [{
                        "data": null,
                        "sortable": false,
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1
                        }
                    },
                    {
                        data: 'no_kendaraan',
                        name: 'no_kendaraan'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },

                    {
                        data: 'tgl_proses',
                        name: 'tgl_proses'
                    },
                    {
                        data: 'tgl_selesai',
                        name: 'tgl_selesai'
                    }
                ]
            })
        }
    </script>

@endsection
