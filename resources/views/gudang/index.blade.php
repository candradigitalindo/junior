@extends('layouts.office')
@section('title')
    Gudang
@endsection
@section('content')
    <div class="grid columns-12 gap-6">
        <div class="g-col-12 g-col-xxl-12">
            <div class="grid columns-12 gap-6">
                <!-- BEGIN: Weekly Top Products -->
                <div class="g-col-12 mt-6">
                    <div class="intro-y d-block d-sm-flex align-items-center h-10">
                        <h2 class="fs-lg fw-medium truncate me-5">
                            Tabel Barang
                        </h2>

                        <div class="d-flex align-items-center ms-sm-auto mt-3 mt-sm-0">
                            <button class="btn btn-primary w-45 me-8 mb-4" data-bs-toggle="modal"
                                data-bs-target="#modal-tambah" id="tambah"> <i data-feather="plus-circle"
                                    class="w-4 h-4 me-2"></i> Daftar Barang </button>
                                    <a href="{{ route('barcode.index') }}" class="btn btn-dark w-45 me-8 mb-4"> <i data-feather="slack"
                                    class="w-4 h-4 me-2"></i> Buat Barcode </a>
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
                        <div class="row">
                            <div class="col"></div>
                            <div class="col"></div>
                            <div class="col">

                                <div class="input-group w-56 mx-auto">
                                    <a href="{{ route('barang.masuk') }}" class="btn btn-success w-45 me-8 mb-4"> <i
                                            data-feather="plus-circle" class="w-4 h-4 me-2"></i> Barang Masuk </a>
                                </div>
                            </div>

                            <div class="col">

                                <div class="input-group w-56 mx-auto">
                                    <a href="{{ route('barang.keluar') }}" class="btn btn-danger w-45 me-8 mb-4"> <i
                                            data-feather="minus-circle" class="w-4 h-4 me-2"></i> Barang Keluar </a>
                                </div>
                            </div>
                            <div class="col"></div>
                            <div class="col"></div>
                        </div>
                    </div>
                    <br>
                    <div class="intro-y overflow-auto overflow-lg-visible mt-8 mt-sm-0">
                        <table class="table table-bordered display" id="tabel-barang" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th class="text-nowrap" style="width: 5%">No</th>
                                    <th class="text-center text-nowrap">Nama Barang</th>
                                    <th class="text-center text-nowrap">Barcode</th>
                                    <th class="text-center text-nowrap">Barang Masuk</th>
                                    <th class="text-center text-nowrap">Barang Keluar</th>
                                    <th class="text-center text-nowrap">Stok</th>
                                    <th class="text-center text-nowrap">Update Masuk</th>
                                    <th class="text-center text-nowrap">Update Keluar</th>
                                    <th class="text-center text-nowrap">Keterangan</th>
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
    <div id="modal-tambah" class="modal fade" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- BEGIN: Modal Header -->
                <div class="modal-header">
                    <h2 class="fw-medium fs-base me-auto">
                        Tambah Produk
                    </h2>
                </div>
                <!-- END: Modal Header -->
                <!-- BEGIN: Modal Body -->
                <div class="alert alert-danger print-error-msg" style="display:none" id="error">
                    <ul></ul>
                </div>

                <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                    <div class="g-col-12">
                        <label for="pos-form-1" class="form-label">Nama Barang</label>
                        <input type="text" name="name" class="form-control flex-1" id="name" required>
                    </div>
                    <div class="g-col-12">
                        <label for="pos-form-2" class="form-label">Barcode</label>
                        <input type="text" name="barcode" class="form-control flex-1" id="barcode" required>
                    </div>

                    <div class="g-col-12">
                        <label for="pos-form-4" class="form-label">Keterangan</label>
                        <textarea name="description" class="form-control flex-1" id="description" cols="30" rows="10"></textarea>
                    </div>

                    <input type="text" style="visibility: hidden" name="tambah_id" id="id">
                </div>
                <!-- END: Modal Body -->
                <!-- BEGIN: Modal Footer -->
                <div class="modal-footer text-end">
                    <button type="button" data-bs-dismiss="modal" class="btn btn-outline-secondary w-32 me-1"
                        id="cencel">Cancel</button>
                    <button type="button" class="btn btn-primary w-32" id="simpan">Simpan</button>
                </div>
                <!-- END: Modal Footer -->

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
            $('#tabel-barang').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                paging: false,
                ordering: false,
                info: false,
                destroy: true,
                ajax: {
                    url: "{{ route('gudang.index') }}",
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
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'barcode',
                        name: 'barcode'
                    },
                    {
                        data: 'jml_barang_masuk',
                        name: 'jml_barang_masuk'
                    },
                    {
                        data: 'jml_barang_keluar',
                        name: 'jml_barang_keluar'
                    },
                    {
                        data: 'stok',
                        name: 'stok'
                    },

                    {
                        data: 'barang_masuk',
                        name: 'barang_masuk'
                    },

                    {
                        data: 'barang_keluar',
                        name: 'barang_keluar'
                    },
                    {
                        data: 'description',
                        name: 'description'
                    },
                    {
                        data: 'aksi',
                        name: 'aksi'
                    }
                ]
            })
        }

        $('#tambah').on('click', function() {
            $('#name').val(null)
            $('#barcode').val(null)
            $('#description').val(null)
            $("#error").css("display", "none")
            $("#simpan").text('Simpan')
        })

        $("#simpan").on('click', function() {
            if ($(this).text() === 'Edit') {
                edit()
            } else {
                tambah()
            }
        })

        function tambah() {
            $.ajax({
                url: "{{ route('gudang.store') }}",
                type: "POST",
                data: {
                    name: $('#name').val(),
                    barcode: $('#barcode').val(),
                    description: $('#description').val(),
                    _token: "{{ csrf_token() }}"
                },
                success: function(res) {
                    if ($.isEmptyObject(res.error)) {
                        $("#error").css("display", "none");
                        if (res.status == 'gagal') {
                            swal(res.text, {
                                icon: "error",
                            });
                        } else {
                            $('#tabel-barang').DataTable().ajax.reload()
                            $("#cencel").click()
                            swal(res.text, {
                                icon: "success",
                            });

                        }
                    } else {
                        printErrorMsg(res.error)
                    }
                }
            })
        }

        $(document).on('click', '.edit', function() {
            $("#error").css("display", "none");
            let id = $(this).attr('id')
            let url = "{{ route('gudang.edit', ':id') }}"
            url = url.replace(':id', id)
            $("#tambah").click()
            $("#simpan").text('Edit')
            $.ajax({
                url: url,
                type: 'GET',
                data: {
                    _token: "{{ csrf_token() }}"
                },

                success: function(res) {
                    $('#name').val(res.data.name)
                    $('#id').val(res.data.id)
                    $('#barcode').val(res.data.barcode)
                    $('#description').val(res.data.description)
                }
            })
        })

        function edit() {
            let id_edit = $("#id").val()
            let url_edit = "{{ route('gudang.update', ':id') }}"
            url_edit = url_edit.replace(':id', id_edit)
            $.ajax({
                url: url_edit,
                type: "POST",
                data: {
                    name: $('#name').val(),
                    barcode: $('#barcode').val(),
                    description: $('#description').val(),
                    _token: "{{ csrf_token() }}"
                },

                success: function(res) {
                    if ($.isEmptyObject(res.error)) {
                        $("#error").css("display", "none");
                        if (res.status == 'error') {
                            swal(res.text, {
                                icon: "error",
                            });
                        } else {
                            $('#tabel-barang').DataTable().ajax.reload()
                            $("#cencel").click()
                            swal(res.text, {
                                icon: "success",
                            });

                        }
                    } else {
                        printErrorMsg(res.error)
                    }
                }
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
                isi_tabel(start_date, end_date);
                $('#btn-filter').text('Filter').prop('disabled', false);
            }
        });



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
                let url = "{{ route('gudang.delete',':id') }}"
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
