@extends('layouts.office')
@section('title')
Dashboard Step Pengerjaan
@endsection
@section('content')
<div class="grid columns-12 gap-6">
    <div class="g-col-12 g-col-xxl-12">
        <div class="grid columns-12 gap-6">
            <!-- BEGIN: Weekly Top Products -->
            <div class="g-col-12 mt-6">
                <div class="intro-y d-block d-sm-flex align-items-center h-10">
                    <h2 class="fs-lg fw-medium truncate me-5">
                        Tabel Pengerjaan {{ $product->name }}
                    </h2>
                    <div class="d-flex align-items-center ms-sm-auto mt-3 mt-sm-0">
                        <a class="btn btn-warning w-45 me-8 mb-4" href="{{ route('product.index') }}"> <i data-feather="rewind" class="w-4 h-4 me-2"></i>Kembali Produk </a>
                        <button class="btn btn-primary w-40 me-8 mb-4" data-bs-toggle="modal" data-bs-target="#modal-step2" id="tambah"> <i data-feather="plus-circle" class="w-4 h-4 me-2"></i> Tambah Step </button>
                        <button style="visibility: hidden" data-bs-toggle="modal" data-bs-target="#modal-step2" data-bs-dismiss="modal" id="step2"></button>
                    </div>
                </div>
                <br>
                <div class="intro-y overflow-auto overflow-lg-visible mt-8 mt-sm-0">
                    <table class="table table-bordered display" id="tabel-step" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th class="text-nowrap">No.</th>
                                <th class="text-nowrap">Step Pekerjaan</th>
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
<div class="modal fade" id="modal-step2" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Step Pekerjaan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="alert alert-danger print-error-msg" style="display:none" id="error-step2">
                <ul></ul>
            </div>
            <div class="modal-body">
                <div class="g-col-12">
                    <label for="pos-form-2" class="form-label">Step Pengerjaan</label>
                    <input type="text" style="visibility: hidden" id="step_pekerjaan_id">
                    <input  type="text" class="form-control flex-1" id="step_product2">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="tutup_step2">Tutup</button>
                    <button type="button" class="btn btn-primary" id="simpan_step2">Simpan</button>
                </div>
            </div>
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
        $('#tabel-step').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            ajax : "{{ route('product.step', $product->id) }}",
            columns : [
                {
                    "data":null, "sortable":false, render: function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1
                    }
                },
                { data : 'step', name:'step'},
                { data : 'aksi', name:'aksi'}
            ]
        })
    }

    $("#simpan_step2").on('click', function () {
        if ($(this).text() === 'Edit') {
            edit()
        }else{
            tambah()
        }
    })


    $('#tambah').on('click',function () {
        $('#step_product2').val(null)
        $("#error-step2").css("display", "none")
        $("#simpan_step2").text('Simpan')
    })

    function tambah()
    {
        let url = "{{ route('step.store', $product->id) }}"
        $.ajax({
            url     : url,
            type    : "POST",
            data    : {
                step    : $('#step_product2').val(),
                _token  : "{{ csrf_token() }}"
            },
            success : function (res) {
                if ($.isEmptyObject(res.error)) {
                    $("#error-error").css("display", "none");
                    if (res.status == 'gagal') {
                        swal(res.text, {
                            icon: "error",
                        });
                    }else{
                        $('#tabel-step').DataTable().ajax.reload()
                        $('#tutup_step2').click()
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

    $(document).on('click','.edit', function () {
        $("#error-step2").css("display", "none");
        let id  = $(this).attr('id')
        let url = "{{ route('step.edit',':id') }}"
        url     = url.replace(':id', id)
        $("#tambah").click()
        $.ajax({
            url     : url,
            type    : 'GET',
            data    : {
                _token  : "{{ csrf_token() }}"
            },

            success: function (res) {
                $('#step_pekerjaan_id').val(res.data.id)
                $('#step_product2').val(res.data.step)
                $("#simpan_step2").text('Edit')
            }
        })
    })

    function edit() {
        let id_edit  = $("#step_pekerjaan_id").val()
        let url_edit = "{{ route('step.update',':id') }}"
        url_edit     = url_edit.replace(':id', id_edit)
        $.ajax({
            url     : url_edit,
            type    : "PUT",
            data    : {
                step    : $('#step_product2').val(),
                _token  : "{{ csrf_token() }}"
            },

            success : function (res) {
                if ($.isEmptyObject(res.error)) {
                    $("#error").css("display", "none");
                    if (res.status == 'gagal') {
                        swal(res.text, {
                            icon: "error",
                        });
                    }else{
                        $('#tabel-step').DataTable().ajax.reload()
                        $("#tutup_step2").click()
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
                let url = "{{ route('step.destroy',':id') }}"
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
                        $('#tabel-step').DataTable().ajax.reload()
                    }
                })
            }
        });
    })

    function printErrorMsg (msg) {
        $(".print-error-msg").find("ul").html('');
        $(".print-error-msg").css('display','block');
        $.each( msg, function( key, value ) {
            $(".print-error-msg").find("ul").append('<li>'+value+'</li>');
        });
    }
</script>
@endsection
