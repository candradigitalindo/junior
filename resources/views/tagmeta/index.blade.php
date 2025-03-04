@extends('layouts.office')
@section('title')
    Tag Meta
@endsection
@section('content')
    <div class="grid columns-12 gap-6">
        <div class="g-col-12 g-col-xxl-12">
            <div class="grid columns-12 gap-6">
                <!-- BEGIN: Weekly Top Products -->
                <div class="g-col-12 mt-6">
                    <div class="intro-y d-block d-sm-flex align-items-center h-10">
                        <h2 class="fs-lg fw-medium truncate me-5">
                            Tabel Tag Meta
                        </h2>
                        <div class="d-flex align-items-center ms-sm-auto mt-3 mt-sm-0">
                            @if ($tagmeta == true)
                                <button style="visibility: hidden" data-bs-toggle="modal" data-bs-target="#modal-tambah"
                                    id="tambah"></button>
                            @else
                                <button class="btn btn-primary w-40 me-8 mb-4" data-bs-toggle="modal"
                                    data-bs-target="#modal-tambah" id="tambah"> <i data-feather="plus-circle"
                                        class="w-4 h-4 me-2"></i> Tambah Tagmeta </button>
                            @endif
                        </div>
                    </div>
                    <br>
                    <div class="intro-y overflow-auto overflow-lg-visible mt-8 mt-sm-0">
                        <table class="table table-bordered display" id="tabel-category" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th class="text-nowrap">Keywords</th>
                                    <th class="text-nowrap">Title</th>
                                    <th class="text-nowrap">Deskripsi</th>
                                    <th class="text-center text-nowrap">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($tagmeta == true)
                                    <tr>
                                        <td>{{ $tagmeta->keywords }}</td>
                                        <td>{{ $tagmeta->title }}</td>
                                        <td>{{ $tagmeta->description }}</td>
                                        <td>
                                            <div class="d-flex justify-content-center align-items-center"><button
                                                    class="edit btn btn-sm btn-warning w-24 me-1 mb-2"
                                                    id="{{ $tagmeta->id }}">Edit</button></div>
                                        </td>
                                    </tr>

                                @else
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>

                                        </td>
                                    </tr>
                                @endif
                            </tbody>
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
                        Tambah Tag Meta
                    </h2>
                </div>
                <!-- END: Modal Header -->
                <!-- BEGIN: Modal Body -->
                <div class="alert alert-danger print-error-msg" style="display:none" id="error">
                    <ul></ul>
                </div>
                <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                    <div class="g-col-12">
                        <label for="pos-form-1" class="form-label">Keywords</label>
                        <textarea class="form-control flex-1" name="keywords" id="keywords" cols="30"
                            rows="10">keyword 1, keyword 2, keyword 3, ... dst</textarea>
                    </div>
                    <div class="g-col-12">
                        <label for="pos-form-2" class="form-label">Title</label>
                        <input type="text" class="form-control flex-1" placeholder="title" id="title">
                    </div>
                    <div class="g-col-12">
                        <label for="pos-form-1" class="form-label">Deskripsi</label>
                        <textarea name="description" class="form-control flex-1" id="description" cols="30"
                            rows="10"></textarea>
                    </div>
                    <input type="text" style="visibility: hidden" id="id">
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
        $('#tambah').on('click', function() {
            $('#keywords').val(null)
            $('#title').val(null)
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
                url: "{{ route('tagmeta.store') }}",
                type: "POST",
                data: {
                    keywords: $('#keywords').val(),
                    title: $('#title').val(),
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
                            location.replace("{{ route('tagmeta.index') }}")
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

        function printErrorMsg(msg) {
            $(".print-error-msg").find("ul").html('');
            $(".print-error-msg").css('display', 'block');
            $.each(msg, function(key, value) {
                $(".print-error-msg").find("ul").append('<li>' + value + '</li>');
            });
        }

        $(document).on('click', '.edit', function() {
            $("#error").css("display", "none");
            let id = $(this).attr('id')
            let url = "{{ route('tagmeta.edit', ':id') }}"
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
                    $('#keywords').val(res.data.keywords)
                    $('#title').val(res.data.title)
                    $('#description').val(res.data.description)
                    $('#id').val(res.data.id)
                }
            })
        })

        function edit() {
            let id_edit = $("#id").val()
            let url_edit = "{{ route('tagmeta.update', ':id') }}"
            url_edit = url_edit.replace(':id', id_edit)
            $.ajax({
                url: url_edit,
                type: "PUT",
                data: {
                    keywords: $('#keywords').val(),
                    title: $('#title').val(),
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
                            $('#cencel').click()
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
    </script>
@endsection
