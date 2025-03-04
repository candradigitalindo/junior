@extends('layouts.office')
@section('title')
Galeri
@endsection
@section('content')
<div class="grid columns-12 gap-6">
    <div class="g-col-12 g-col-xxl-12">
        <div class="grid columns-12 gap-6">
            <!-- BEGIN: Weekly Top Products -->
            <div class="g-col-12 mt-6">
                <div class="intro-y d-block d-sm-flex align-items-center h-10">
                    <h2 class="fs-lg fw-medium truncate me-5">
                        Tabel Galeri
                    </h2>
                    <div class="d-flex align-items-center ms-sm-auto mt-3 mt-sm-0">
                        <button class="btn btn-primary w-40 me-8 mb-4" data-bs-toggle="modal" data-bs-target="#modal-tambah" id="tambah"> <i data-feather="plus-circle" class="w-4 h-4 me-2"></i> Tambah Galeri </button>
                    </div>
                </div>
                <br>
                <div class="intro-y overflow-auto overflow-lg-visible mt-8 mt-sm-0">
                    <table class="table table-bordered display" id="tabel-galery" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th class="text-nowrap" style="width: 5%">No</th>
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
                    Tambah Gelary
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
                        <label for="pos-form-5" class="form-label">Foto</label>
                        <input name="galery" type="file" class="form-control flex-1" id="galery">
                    </div>

                </div>
                <!-- END: Modal Body -->
                <!-- BEGIN: Modal Footer -->
                <div class="modal-footer text-end">
                    <button type="button" data-bs-dismiss="modal" class="btn btn-outline-secondary w-32 me-1" id="cencel">Cancel</button>
                    <button type="submit" class="btn btn-primary w-32" id="simpan">Simpan</button>
                </div>
                <!-- END: Modal Footer -->
            </form>
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
        $('#tabel-galery').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            ajax : "{{ route('galery.index') }}",
            columns : [
                {
                    "data":null, "sortable":false, render: function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1
                    }
                },
                { data : 'foto', name:'foto'},
                { data : 'aksi', name:'aksi'}
            ]
        })
    }

    $('#tambah').on('click',function () {
        $('#galery').val(null)
        $("#error").css("display", "none")
    })


    $('#form-tambah').on('submit',(function(e) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        e.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            type:'POST',
            url: "{{ route('galery.store')}}",
            data:formData,
            cache:false,
            contentType: false,
            processData: false,
            success : function (res) {
                if($.isEmptyObject(res.error)){
                    $('#cencel').click()
                    $('#tabel-galery').DataTable().ajax.reload()
                    swal(res.text, {
                        icon: "success",
                    });
                }else{
                    printErrorMsg(res.error);
                }
            },
            error : function (xhr) {
                alert(xhr.responJson.text)
            }
        })
    }))



    function printErrorMsg (msg) {
        $(".print-error-msg").find("ul").html('');
        $(".print-error-msg").css('display','block');
        $.each( msg, function( key, value ) {
            $(".print-error-msg").find("ul").append('<li>'+value+'</li>');
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
                let url = "{{ route('galery.destroy',':id') }}"
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
                        $('#tabel-galery').DataTable().ajax.reload()
                    }
                })
            }
        });
    })
</script>
@endsection
