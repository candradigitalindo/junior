@extends('layouts.office')
@section('title')
Extra Service
@endsection
@section('content')
<div class="grid columns-12 gap-6">
    <div class="g-col-12 g-col-xxl-12">
        <div class="grid columns-12 gap-6">
            <!-- BEGIN: Weekly Top Products -->
            <div class="g-col-12 mt-6">
                <div class="intro-y d-block d-sm-flex align-items-center h-10">
                    <h2 class="fs-lg fw-medium truncate me-5">
                        Tabel Extra Service
                    </h2>
                    <div class="d-flex align-items-center ms-sm-auto mt-3 mt-sm-0">
                        <button class="btn btn-primary w-45 me-8 mb-4" data-bs-toggle="modal" data-bs-target="#modal-tambah" id="tambah"> <i data-feather="plus-circle" class="w-4 h-4 me-2"></i> Tambah Extra Service </button>
                    </div>
                </div>
                <br>
                <div class="intro-y overflow-auto overflow-lg-visible mt-8 mt-sm-0">
                    <table class="table table-bordered display" id="tabel-extra" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th class="text-nowrap" style="width: 5%">No</th>
                                <th class="text-nowrap">Nama Produk</th>
                                <th class="text-nowrap">Nama Extra Service</th>
                                <th class="text-nowrap">Harga</th>
                                <th class="text-nowrap">Deskripsi</th>
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
<div id="modal-tambah" class="modal fade" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- BEGIN: Modal Header -->
            <div class="modal-header">
                <h2 class="fw-medium fs-base me-auto">
                    Tambah Extra Service
                </h2>
            </div>
            <!-- END: Modal Header -->
            <!-- BEGIN: Modal Body -->
            <div class="alert alert-danger print-error-msg" style="display:none" id="error">
                <ul></ul>
            </div>
            <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                <div class="g-col-12">
                    <label for="pos-form-1" class="form-label">Produk</label>
                    <input type="text" style="visibility: hidden" id="product_id">
                    <select id="product" class="form-control flex-1">

                    </select>
                </div>
                <div class="g-col-12">
                    <label for="pos-form-2" class="form-label">Nama Extra Service</label>
                    <input  type="text" class="form-control flex-1" placeholder="Nama Extra Service" id="name">
                </div>
                <div class="g-col-12">
                    <label for="pos-form-3" class="form-label">Harga</label>
                    <input  type="number" class="form-control flex-1" placeholder="Harga Extra Service" id="price">
                </div>
                <div class="g-col-12">
                    <label for="pos-form-3" class="form-label">Deskripsi</label>
                    <textarea class="form-control flex-1" id="description" cols="30" rows="10"></textarea>
                </div>
                <input type="text" style="visibility: hidden" id="id">
            </div>
            <!-- END: Modal Body -->
            <!-- BEGIN: Modal Footer -->
            <div class="modal-footer text-end">
                <button type="button" data-bs-dismiss="modal" class="btn btn-outline-secondary w-32 me-1" id="cencel">Cancel</button>
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
<script
  src="https://code.jquery.com/jquery-3.6.0.js"
  integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
  crossorigin="anonymous"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
    $(document).ready(function() {
        isi_tabel()
    });

    function isi_tabel() {
        $('#tabel-extra').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            ajax : "{{ route('extraservice.index') }}",
            columns : [
                {
                    "data":null, "sortable":false, render: function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1
                    }
                },
                { data : 'name_product', name:'name_product'},
                { data : 'name', name:'name'},
                { data : 'price', name:'price'},
                { data : 'description', name:'description'},
                { data : 'aksi', name:'aksi'}
            ]
        })
    }

    $('#tambah').on('click',function () {
        $('#name').val(null)
        $('#price').val(null)
        $('#description').val(null)
        $("#error").css("display", "none")
        $("#simpan").text('Simpan')
        getProduct()
    })

    function getProduct() {
        $.ajax({
            url : "{{route('product.create')}}",
            type : 'GET',
            data : {
                _token : "{{csrf_token()}}"
            },
            success: function (res) {
                $("#product").empty();
                $("#product").append('<option value="">--- Pilih Produk ---</option>');
                $.each(res.data, function (id, item) {
                    $("#product").append('<option value="'+item.id+'">'+item.name+'</option>');
                })
            }
        })
    }

    $("#simpan").on('click', function () {
        if ($(this).text() === 'Edit') {
            edit()
        }else{
            tambah()
        }
    })

    function tambah() {
        $.ajax({
            url     : "{{ route('extraservice.store') }}",
            type    : "POST",
            data    : {
                product    : $('#product').val(),
                name        : $('#name').val(),
                price       : $('#price').val(),
                description : $('#description').val(),
                _token      : "{{ csrf_token() }}"
            },
            success : function (res) {
                if ($.isEmptyObject(res.error)) {
                    $("#error").css("display", "none");
                    if (res.status == 'gagal') {
                        swal(res.text, {
                            icon: "error",
                        });
                    }else{
                        $('#tabel-extra').DataTable().ajax.reload()
                        $("#cencel").click()
                        swal(res.text, {
                            icon: "success",
                        });

                    }
                }else{
                    printErrorMsg(res.error)
                }
            }
        })
    }

    function printErrorMsg (msg) {
        $(".print-error-msg").find("ul").html('');
        $(".print-error-msg").css('display','block');
        $.each( msg, function( key, value ) {
            $(".print-error-msg").find("ul").append('<li>'+value+'</li>');
        });
    }

    $(document).on('click','.edit', function () {
        $("#error").css("display", "none");
        let id  = $(this).attr('id')
        let url = "{{ route('extraservice.edit',':id') }}"
        url     = url.replace(':id', id)
        $("#tambah").click()
        $("#simpan").text('Edit')
        $.ajax({
            url     : url,
            type    : 'GET',
            data    : {
                _token  : "{{ csrf_token() }}"
            },

            success: function (res) {
                console.log(res.data)
                $('#name').val(res.data.name)
                $('#price').val(res.data.price)
                $('#description').val(res.data.description)
                $('#product_id').val(res.data.product_id)
                $('#id').val(res.data.id)
                $.ajax({
                    url : "{{route('product.create')}}",
                    type : 'GET',
                    data : {
                        _token : "{{csrf_token()}}"
                    },
                    success: function (res) {
                        $("#product").empty();
                        $("#product").append('<option value="">--- Pilih Produk ---</option>');
                        $.each(res.data, function (id, item) {
                            if (item.id == $("#product_id").val()) {
                                $("#product").append('<option value="'+item.id+'" selected>'+item.name+'</option>');
                            }else{
                                $("#product").append('<option value="'+item.id+'">'+item.name+'</option>');
                            }
                        })
                    }
                })
            }
        })
    })

    function edit() {
        let id_edit  = $("#id").val()
        let url_edit = "{{ route('extraservice.update',':id') }}"
        url_edit     = url_edit.replace(':id', id_edit)
        $.ajax({
            url     : url_edit,
            type    : "PUT",
            data    : {
                product    : $('#product').val(),
                name        : $('#name').val(),
                price       : $('#price').val(),
                description : $('#description').val(),
                _token      : "{{ csrf_token() }}"
            },

            success : function (res) {
                if ($.isEmptyObject(res.error)) {
                    $("#error").css("display", "none");
                    if (res.status == 'gagal') {
                        swal(res.text, {
                            icon: "error",
                        });
                    }else{
                        $('#tabel-extra').DataTable().ajax.reload()
                        $("#cencel").click()
                        swal(res.text, {
                            icon: "success",
                        });

                    }
                }else {
                    printErrorMsg(res.error)
                }
            }
        })
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
                let url = "{{ route('extraservice.destroy',':id') }}"
                url     = url.replace(':id', id)
                $.ajax({
                    url : url,
                    type : 'DELETE',
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
                        $('#tabel-extra').DataTable().ajax.reload()
                    }
                })
            }
        });
    })
</script>
@endsection
