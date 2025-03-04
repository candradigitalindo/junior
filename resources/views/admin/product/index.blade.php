@extends('layouts.office')
@section('title')
    Produk
@endsection
@section('content')
    <div class="grid columns-12 gap-6">
        <div class="g-col-12 g-col-xxl-12">
            <div class="grid columns-12 gap-6">
                <!-- BEGIN: Weekly Top Products -->
                <div class="g-col-12 mt-6">
                    <div class="intro-y d-block d-sm-flex align-items-center h-10">
                        <h2 class="fs-lg fw-medium truncate me-5">
                            Tabel Produk
                        </h2>
                        <div class="d-flex align-items-center ms-sm-auto mt-3 mt-sm-0">
                            <button class="btn btn-primary w-40 me-8 mb-4" data-bs-toggle="modal"
                                data-bs-target="#modal-tambah" id="tambah"> <i data-feather="plus-circle"
                                    class="w-4 h-4 me-2"></i> Tambah Produk </button>
                            <button style="visibility: hidden" data-bs-toggle="modal" data-bs-target="#modal-edit"
                                id="edit"></button>
                            <button style="visibility: hidden" data-bs-toggle="modal" data-bs-target="#modal-step"
                                data-bs-dismiss="modal" id="step"></button>
                        </div>
                    </div>
                    <br>
                    <div class="intro-y overflow-auto overflow-lg-visible mt-8 mt-sm-0">
                        <table class="table table-bordered display" id="tabel-product" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th class="text-nowrap" style="width: 5%">No</th>
                                    <th class="text-nowrap">Nama Kategori</th>
                                    <th class="text-nowrap">Nama Produk</th>
                                    <th class="text-nowrap">Harga</th>
                                    <th class="text-nowrap">Deskripsi</th>
                                    <th class="text-nowrap">Foto</th>
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
                        Tambah Produk
                    </h2>
                </div>
                <!-- END: Modal Header -->
                <!-- BEGIN: Modal Body -->
                <div class="alert alert-danger print-error-msg" style="display:none" id="error">
                    <ul></ul>
                </div>
                <form enctype="multipart/form-data" id="form-tambah">
                    @csrf
                    <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                        <div class="g-col-12">
                            <label for="pos-form-1" class="form-label">Kategori</label>
                            <input name="category_id" type="text" style="visibility: hidden" id="category_id">
                            <select name="name_category" id="category" class="form-control flex-1">

                            </select>
                        </div>
                        <div class="g-col-12">
                            <label for="pos-form-2" class="form-label">Nama Produk</label>
                            <input type="text" name="name" class="form-control flex-1" placeholder="Nama Produk"
                                id="name" required>
                        </div>
                        <div class="g-col-12">
                            <label for="pos-form-3" class="form-label">Harga</label>
                            <input type="number" name="price" class="form-control flex-1" placeholder="Harga Produk"
                                id="price" required>
                        </div>
                        <div class="g-col-12">
                            <label for="pos-form-4" class="form-label">Deskripsi</label>
                            <textarea name="description" class="form-control flex-1" id="description" cols="30" rows="10"></textarea>
                        </div>
                        <div class="g-col-12">
                            <label for="pos-form-5" class="form-label">Foto</label>
                            <input name="foto" type="file" class="form-control flex-1" id="foto">
                        </div>
                        <input type="text" style="visibility: hidden" name="tambah_id" id="id">
                    </div>
                    <!-- END: Modal Body -->
                    <!-- BEGIN: Modal Footer -->
                    <div class="modal-footer text-end">
                        <button type="button" data-bs-dismiss="modal" class="btn btn-outline-secondary w-32 me-1"
                            id="cencel">Cancel</button>
                        <button type="submit" class="btn btn-primary w-32" id="simpan">Simpan</button>
                    </div>
                    <!-- END: Modal Footer -->
                </form>
            </div>
        </div>
    </div>
    <div id="modal-edit" class="modal fade" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- BEGIN: Modal Header -->
                <div class="modal-header">
                    <h2 class="fw-medium fs-base me-auto">
                        Edit Produk
                    </h2>
                </div>
                <!-- END: Modal Header -->
                <!-- BEGIN: Modal Body -->
                <div class="alert alert-danger print-error-msg" style="display:none" id="error-edit">
                    <ul></ul>
                </div>
                <form enctype="multipart/form-data" id="form-edit">
                    @csrf
                    <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                        <div class="g-col-12">
                            <label for="pos-form-6" class="form-label">Kategori</label>
                            <input name="category_id_edit" type="text" style="visibility: hidden"
                                id="category_id_edit">
                            <select name="name_category_edit" id="category_edit" class="form-control flex-1">

                            </select>
                        </div>
                        <div class="g-col-12">
                            <label for="pos-form-7" class="form-label">Nama Produk</label>
                            <input type="text" name="name_edit" class="form-control flex-1" placeholder="Nama Produk"
                                id="name_edit" required>
                        </div>
                        <div class="g-col-12">
                            <label for="pos-form-8" class="form-label">Harga</label>
                            <input type="number" name="price_edit" class="form-control flex-1"
                                placeholder="Harga Produk" id="price_edit" required>
                        </div>
                        <div class="g-col-12">
                            <label for="pos-form-9" class="form-label">Deskripsi</label>
                            <textarea name="description_edit" class="form-control flex-1" id="description_edit" cols="30" rows="10"></textarea>
                        </div>
                        <div class="g-col-12">
                            <label for="pos-form-10" class="form-label">Foto</label>
                            <input name="foto_edit" type="file" class="form-control flex-1" id="foto_edit">
                        </div>
                        <input type="text" style="visibility: hidden" name="edit_id" id="edit_id">
                    </div>
                    <!-- END: Modal Body -->
                    <!-- BEGIN: Modal Footer -->
                    <div class="modal-footer text-end">
                        <button type="button" data-bs-dismiss="modal" class="btn btn-outline-secondary w-32 me-1"
                            id="cencel_edit">Cancel</button>
                        <button type="submit" class="btn btn-primary w-32" id="simpan_edit">Simpan</button>
                    </div>
                    <!-- END: Modal Footer -->
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-step" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Pekerjaan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="alert alert-danger print-error-msg" style="display:none" id="error-step">
                    <ul></ul>
                </div>
                <div class="modal-body">
                    <div class="g-col-12">
                        <label for="pos-form-2" class="form-label">Nama Jasa</label>
                        <input type="text" class="form-control flex-1" id="s_product" disabled>
                    </div>
                    <br>
                    <div class="g-col-12">
                        <label for="pos-form-2" class="form-label">Step Pengerjaan</label>
                        <input type="text" style="visibility: hidden" id="step_booking_id">
                        <input type="text" class="form-control flex-1" id="step_product">
                    </div>
                    <br>
                    <br>
                    <table class="table table-bordered" width="100%" cellspacing="0" id="tabel-step">
                        <thead>
                            <tr>
                                <th class="text-nowrap">Step Pekerjaan</th>
                            </tr>
                        </thead>
                        <tbody id="tbody-histori"></tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                        id="tutup_step">Tutup</button>
                    <button type="button" class="btn btn-primary" id="simpan_step">Simpan</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('css')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.4/css/jquery.dataTables.css">
    <style>
        /* .modal:nth-of-type(even) {
            z-index: 1052 !important;
        }
        .modal-backdrop.show:nth-of-type(even) {
            z-index: 1051 !important;
        } */
    </style>
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
            $('#tabel-product').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                ajax: "{{ route('product.index') }}",
                columns: [{
                        "data": null,
                        "sortable": false,
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1
                        }
                    },
                    {
                        data: 'name_category',
                        name: 'name_category'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'price',
                        name: 'price'
                    },
                    {
                        data: 'description',
                        name: 'description'
                    },
                    {
                        data: 'foto',
                        name: 'foto'
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
            $('#price').val(null)
            $('#description').val(null)
            $('#foto').val(null)
            $("#error").css("display", "none")
            $("#simpan").text('Simpan')
            getKategori()
        })

        function getKategori() {
            $.ajax({
                url: "{{ route('category.create') }}",
                type: 'GET',
                data: {
                    _token: "{{ csrf_token() }}"
                },
                success: function(res) {
                    $("#category").empty();
                    $("#category").append('<option value="">--- Pilih Kategori ---</option>');
                    $.each(res.data, function(id, item) {
                        $("#category").append('<option value="' + item.id + '">' + item.name +
                            '</option>');
                    })
                }
            })
        }

        // $("#simpan").on('click', function () {
        //     if ($(this).text() === 'Edit Produk') {
        //         edit()
        //     }else{
        //         tambah()
        //     }
        // })
        $('#form-tambah').on('submit', (function(e) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            e.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                type: 'POST',
                url: "{{ route('product.store') }}",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function(res) {
                    if ($.isEmptyObject(res.error)) {
                        $('#cencel').click()
                        $('#tabel-product').DataTable().ajax.reload()
                        swal(res.text, {
                            icon: "success",
                        });
                    } else {
                        printErrorMsg(res.error);
                    }
                },
                error: function(xhr) {
                    alert(xhr.responJson.text)
                }
            })
        }))



        function printErrorMsg(msg) {
            $(".print-error-msg").find("ul").html('');
            $(".print-error-msg").css('display', 'block');
            $.each(msg, function(key, value) {
                $(".print-error-msg").find("ul").append('<li>' + value + '</li>');
            });
        }

        $(document).on('click', '.edit', function() {
            $("#error-edit").css("display", "none");
            $('#foto_edit').val(null)
            let id = $(this).attr('id')
            let url = "{{ route('product.edit', ':id') }}"
            url = url.replace(':id', id)
            $("#edit").click()

            $.ajax({
                url: url,
                type: 'GET',
                data: {
                    _token: "{{ csrf_token() }}"
                },

                success: function(res) {
                    $('#name_edit').val(res.data.name)
                    $('#price_edit').val(res.data.price)
                    $('#description_edit').val(res.data.description)
                    $('#category_id_edit').val(res.data.category_id)
                    $('#edit_id').val(res.data.id)
                    $.ajax({
                        url: "{{ route('category.create') }}",
                        type: 'GET',
                        data: {
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(res) {
                            $("#category_edit").empty();
                            $("#category_edit").append(
                                '<option value="">--- Pilih Kategori ---</option>');
                            $.each(res.data, function(id, item) {
                                if (item.id == $("#category_id_edit").val()) {
                                    $("#category_edit").append('<option value="' +
                                        item.id + '" selected>' + item.name +
                                        '</option>');
                                } else {
                                    $("#category_edit").append('<option value="' +
                                        item.id + '">' + item.name + '</option>'
                                        );
                                }
                            })
                        }
                    })
                }
            })
        })

        $('#form-edit').on('submit', (function(e) {
            let id_edit = $("#edit_id").val()
            let url_edit = "{{ route('product.update', ':id') }}"
            url_edit = url_edit.replace(':id', id_edit)
            console.log(url_edit)
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            e.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                type: 'POST',
                url: url_edit,
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function(res) {
                    console.log(res);
                    if ($.isEmptyObject(res.error)) {
                        $('#cencel_edit').click()
                        $('#tabel-product').DataTable().ajax.reload()
                        swal(res.text, {
                            icon: "success",
                        });
                    } else {
                        printErrorMsg(res.error);
                    }
                },
                error: function(xhr) {
                    alert(xhr.responJson.text)
                }
            })
        }))

        $(document).on('click', '.delete', function() {
            swal({
                    title: "Apakah Anda Yakin ?",
                    text: "Jika dihapus, Anda tidak dapat mengembalikan data ini lagi!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        let id = $(this).attr('id')
                        let url = "{{ route('product.destroy', ':id') }}"
                        url = url.replace(':id', id)
                        $.ajax({
                            url: url,
                            type: 'DELETE',
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
                                $('#tabel-product').DataTable().ajax.reload()
                            }
                        })
                    }
                });
        })

        $(document).on('click', '.step', function() {
            $('#step_product').val(null)
            $("#error-step").css("display", "none");
            let id = $(this).attr('id')
            let url = "{{ route('product.edit', ':id') }}"
            url = url.replace(':id', id)
            $("#step").click()
            $.ajax({
                url: url,
                type: 'GET',
                data: {
                    _token: "{{ csrf_token() }}"
                },

                success: function(res) {
                    $('#step_booking_id').val(res.data.id)
                    $('#s_product').val(res.data.name)
                    let url_a = "{{ route('product.step', ':id') }}"
                    url_a = url_a.replace(':id', res.data.id)
                    $('#tabel-step').DataTable({
                        responsive: true,
                        processing: true,
                        serverSide: true,
                        destroy: true,
                        ajax: url_a,
                        columns: [

                            {
                                data: 'step',
                                name: 'step'
                            }
                        ]
                    })
                }
            })
        })

        $("#simpan_step").on('click', function() {
            tambah_step()
        })

        function tambah_step() {
            let id = $('#step_booking_id').val()
            let url = "{{ route('step.store', ':id') }}"
            url = url.replace(':id', id)
            $.ajax({
                url: url,
                type: "POST",
                data: {
                    step: $('#step_product').val(),
                    _token: "{{ csrf_token() }}"
                },
                success: function(res) {
                    if ($.isEmptyObject(res.error)) {
                        $("#error-error").css("display", "none");
                        if (res.status == 'gagal') {
                            swal(res.text, {
                                icon: "error",
                            });
                        } else {
                            $('#tabel-step').DataTable().ajax.reload()
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

        $(document).on('click', '.edit_step', function() {
            $("#error-step2").css("display", "none");
            let id = $(this).attr('id')
            let url = "{{ route('step.edit', ':id') }}"
            url = url.replace(':id', id)
            // $("#modal-step").modal('hide')
            // $("#modal-step2").modal('show')
            $("#step2").click()
            $.ajax({
                url: url,
                type: 'GET',
                data: {
                    _token: "{{ csrf_token() }}"
                },

                success: function(res) {
                    $('#step_pekerjaan_id').val(res.data.id)
                    $('#step_product2').val(res.data.step)
                }
            })
        })

        $("#simpan_step2").on('click', function() {
            edit_step()
        })
    </script>
@endsection
