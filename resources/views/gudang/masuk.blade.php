@extends('layouts.office')
@section('title')
    Barang Masuk
@endsection
@section('content')
    <div class="grid columns-12 gap-6">
        <div class="g-col-12 g-col-xxl-12">
            <div class="grid columns-12 gap-6">
                <!-- BEGIN: Weekly Top Products -->
                <div class="g-col-12 mt-6">
                    <div class="intro-y d-block d-sm-flex align-items-center h-10">
                        <h2 class="fs-lg fw-medium truncate me-5">
                            BARANG MASUK
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
                                    <div id="input-group-email" class="input-group-text"> <i data-feather="slack"
                                            class="w-4 h-4"></i> </div> <input type="text" class=" form-control"
                                        data-single-mode="true" id="barcode">
                                </div>
                            </div>


                            <div class="col"></div>
                            <div class="col"></div>
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
                                    <th class="text-center text-nowrap">ID</th>
                                    <th class="text-center text-nowrap">Barcode</th>
                                    <th class="text-center text-nowrap">Nama Barang</th>
                                    <th class="text-center text-nowrap">Waktu</th>
                                    <th class="text-center text-nowrap" style="width: 5%">Aksi</th>
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
                        url: "{{ route('barang.post') }}",
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
                ajax: "{{ route('barang.masuk') }}",
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
                        data: 'aksi',
                        name: 'aksi'
                    }
                ]
            })
        }

        function printErrorMsg(msg) {
            $(".print-error-msg").find("ul").html('');
            $(".print-error-msg").css('display', 'block');
            $.each(msg, function(key, value) {
                $(".print-error-msg").find("ul").append('<li>' + value + '</li>');
            });
        }

        $(document).on('click','.delete', function () {
        swal({
            title   : "Apakah Anda Yakin ?",
            text    : "Jika dihapus, Anda tidak dapat mengembalikan data ini lagi!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                let id  = $(this).attr('id')
                let url = "{{ route('barang.delete',':id') }}"
                url     = url.replace(':id', id)
                $.ajax({
                    url : url,
                    type : 'POST',
                    data: {
                        _token      : "{{ csrf_token() }}"
                    },
                    success: function (res) {
                        if (res.status == 'gagal') {
                                swal(res.text, {
                                    icon: "error",
                                });
                            } else {
                                swal(res.text, {
                                    icon: "success",
                                });
                            }
                        $('#tabel-barang').DataTable().ajax.reload()
                    }
                })
            }
        });
    })
    </script>
@endsection
