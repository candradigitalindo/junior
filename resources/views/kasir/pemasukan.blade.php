@extends('layouts.office')
@section('title')
    Dashboard Pemasukan
@endsection
@section('content')
    <div class="grid columns-12 gap-6">
        <div class="g-col-12 g-col-xxl-12">
            <div class="grid columns-12 gap-6">
                <!-- BEGIN: Weekly Top Products -->
                <div class="g-col-12 mt-6">
                    <div class="intro-y d-block d-sm-flex align-items-center h-10">
                        <h2 class="fs-lg fw-medium truncate me-5">
                            Tabel Pemasukan Lainnya
                        </h2>
                        <div class="d-flex align-items-center ms-sm-auto mt-3 mt-sm-0">
                            <button class="btn btn-warning w-45 me-8 mb-4" data-bs-toggle="modal"
                                data-bs-target="#modal-tambah" id="tambah"> <i data-feather="rewind"
                                    class="w-4 h-4 me-2"></i> Tambah</button>
                            <button style="visibility: hidden" data-bs-toggle="modal" data-bs-target="#modal-edit"
                                id="edit"></button>
                        </div>
                    </div>
                    <br>
                    <div class="intro-y overflow-auto overflow-lg-visible mt-8 mt-sm-0">
                        <table class="table table-bordered display" id="tabel-pemasukan" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th class="text-nowrap" style="width: 5%">No</th>
                                    <th class="text-nowrap">Keterangan</th>
                                    <th class="text-nowrap">Jumlah</th>
                                    <th class="text-nowrap">Tanggal</th>
                                    <th class="text-nowrap">Foto Bukti</th>
                                    <th class="text-center text-nowrap">aksi</th>
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
                        Form Pemasukan Lainnya
                    </h2>
                </div>
                <!-- END: Modal Header -->
                <!-- BEGIN: Modal Body -->
                <div class="alert alert-danger print-error-msg" style="display:none" id="error">
                    <ul></ul>
                </div>
                <form enctype="multipart/form-data" id="form-pemasukan">
                    @csrf
                    <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                        <div class="g-col-12">
                            <label for="pos-form-1" class="form-label">Keterangan Pemasukan</label>
                            <input type="text" class="form-control flex-1" id="name" name="name">
                        </div>
                        <div class="g-col-12">
                            <label for="pos-form-1" class="form-label">Jumlah</label>
                            <input type="number" class="form-control flex-1" id="jumlah" name="jumlah">
                        </div>
                        <div class="g-col-12">
                            <label for="pos-form-4" class="form-label">Foto Bukti</label>
                            <input type="file" class="form-control flex-1" id="foto_pemasukan" name="foto_pemasukan">
                        </div>
                        <input type="text" style="visibility: hidden" id="id">
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
                        Edit Pemasukan
                    </h2>
                </div>
                <!-- END: Modal Header -->
                <!-- BEGIN: Modal Body -->
                <div class="alert alert-danger print-error-msg" style="display:none" id="error-edit">
                    <ul></ul>
                </div>
                <form enctype="multipart/form-data" id="edit-pemasukan">
                    @csrf
                    <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                        <div class="g-col-12">
                            <label for="pos-form-1" class="form-label">Keterangan Pemasukan</label>
                            <input type="text" class="form-control flex-1" id="editname" name="editname">
                        </div>
                        <div class="g-col-12">
                            <label for="pos-form-1" class="form-label">Jumlah</label>
                            <input type="number" class="form-control flex-1" id="editjumlah" name="editjumlah">
                        </div>
                        <div class="g-col-12">
                            <label for="pos-form-4" class="form-label">Foto Bukti</label>
                            <input type="file" class="form-control flex-1" id="editfoto_pemasukan"
                                name="editfoto_pemasukan">
                        </div>
                    </div>
                    <!-- END: Modal Body -->
                    <!-- BEGIN: Modal Footer -->
                    <div class="modal-footer text-end">
                        <button type="button" data-bs-dismiss="modal" class="btn btn-outline-secondary w-32 me-1"
                            id="editcencel">Cancel</button>
                        <button type="submit" class="btn btn-primary w-32" id="editsimpan">Simpan</button>
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
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
        crossorigin="anonymous"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
        $(document).ready(function() {
            isi_tabel()
        });

        function isi_tabel() {
            $('#tabel-pemasukan').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                ajax: "{{ route('pemasukan.index') }}",
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
                        data: 'jumlah',
                        name: 'jumlah'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
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
            $('#jumlah').val(null)
            $('#foto_pemasukan').val(null)
            $("#error").css("display", "none")
            $("#simpan").text('Simpan')
        })


        $('#form-pemasukan').on('submit', (function(e) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            e.preventDefault();
            $('#simpan').text('Loading..').prop('disabled', true);
            var formData = new FormData(this);
            $.ajax({
                type: 'POST',
                url: "{{ route('pemasukan.store') }}",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function(res) {
                    if ($.isEmptyObject(res.error)) {
                        $('#cencel').click()
                        $('#tabel-pemasukan').DataTable().ajax.reload()
                        swal(res.text, {
                            icon: "success",
                        });
                    } else {
                        printErrorMsg(res.error);
                    }
                $('#simpan').text('Simpan').prop('disabled', false);
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
            $("#editfoto_pemasukan").val(null)
            let id = $(this).attr('id')
            let url = "{{ route('pemasukan.edit', ':id') }}"
            url = url.replace(':id', id)
            $("#edit").click()
            $.ajax({
                url: url,
                type: 'GET',
                data: {
                    _token: "{{ csrf_token() }}"
                },

                success: function(res) {
                    $('#editname').val(res.data.name)
                    $('#editjumlah').val(res.data.jumlah)
                    $('#id').val(res.data.id)
                }
            })
        })



        $('#edit-pemasukan').on('submit', (function(e) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            e.preventDefault();
            $('#editsimpan').text('Loading..').prop('disabled', true);
            var formData = new FormData(this);
            let id_edit = $("#id").val()
            let url_edit = "{{ route('pemasukan.update', ':id') }}"
            url_edit = url_edit.replace(':id', id_edit)
            $.ajax({
                type: 'POST',
                url: url_edit,
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function(res) {
                    if ($.isEmptyObject(res.error)) {
                        $('#editcencel').click()
                        $('#tabel-pemasukan').DataTable().ajax.reload()
                        swal(res.text, {
                            icon: "success",
                        });
                    } else {
                        printErrorMsg(res.error);
                    }
                $('#editsimpan').text('Edit').prop('disabled', false);
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
                        let url = "{{ route('pemasukan.destroy', ':id') }}"
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
                                $('#tabel-pemasukan').DataTable().ajax.reload()
                            }
                        })
                    }
                });
        })
    </script>
@endsection
