@extends('layouts.office')
@section('title')
    Dashboard Loket
@endsection
@section('content')
    <div class="grid columns-12 gap-6">
        <div class="g-col-12 g-col-xxl-12">
            <div class="grid columns-12 gap-6">
                <!-- BEGIN: Weekly Top Products -->
                <div class="g-col-12 mt-6">
                    <div class="intro-y d-block d-sm-flex align-items-center h-10">
                        <h2 class="fs-lg fw-medium truncate me-5">
                            Tabel Booking
                        </h2>
                        <div class="d-flex align-items-center ms-sm-auto mt-3 mt-sm-0">
                            <button class="btn btn-warning w-40 me-8 mb-4" id="tambah" data-bs-toggle="modal"
                                data-bs-target="#modal-tambah"> <i data-feather="plus-circle" class="w-4 h-4 me-2"></i>
                                Tambah </button>
                            <button class="btn btn-dark w-40 me-8 mb-4" id="update"> <i data-feather="plus-circle"
                                    class="w-4 h-4 me-2"></i> Update </button>
                            <button class="btn btn-success w-35 me-8 mb-4" id="selesai" data-bs-toggle="modal"
                                data-bs-target="#modal-selesai"> Selesai </button>
                            <button style="visibility: hidden" data-bs-toggle="modal" data-bs-target="#modal-tambah"
                                id="tambah"></button>
                            <button style="visibility: hidden" data-bs-toggle="modal" data-bs-target="#modal-pengecekan"
                                id="pengecekan"></button>
                            <button style="visibility: hidden" data-bs-toggle="modal" data-bs-target="#modal-pengerjaan"
                                id="pengerjaan"></button>
                            <button style="visibility: hidden" data-bs-toggle="modal" data-bs-target="#modal-photo"
                                id="photo"></button>
                            <button style="visibility: hidden" data-bs-toggle="modal" data-bs-target="#modal-orderan"
                                id="orderan"></button>
                        </div>
                    </div>
                    <br>
                    <div class="intro-y overflow-auto overflow-lg-visible mt-8 mt-sm-0">
                        <table class="table table-bordered display" id="tabel-booking" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th class="text-nowrap" style="width: 5%">No</th>
                                    <th class="text-nowrap">Orderan</th>
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
                        Form Booking
                    </h2>
                </div>
                <!-- END: Modal Header -->
                <!-- BEGIN: Modal Body -->
                <div class="alert alert-danger print-error-msg" style="display:none" id="error">
                    <ul></ul>
                </div>
                <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                    {{-- <div class="g-col-12">
                        <label for="pos-form-1" class="form-label">Layanan</label>
                        <select id="product" class="form-control">

                        </select>
                    </div>
                    <div class="g-col-12" style="display: none" id="form-extraservice">
                        <label for="pos-form-1" class="form-label">Extra Layanan</label>
                        <select id="extraservice" class="form-control">

                        </select>
                    </div> --}}
                    <div class="g-col-12">
                        <label for="pos-form-1" class="form-label">No Pol Kendaraan</label>
                        <input type="text" class="form-control flex-1" placeholder="BK XXXX XXX" id="no_pol_kendaraan">
                    </div>
                    <div class="g-col-12">
                        <label for="pos-form-1" class="form-label">Nama Pelanggan</label>
                        <input type="text" class="form-control flex-1" id="name_pelanggan">
                    </div>
                    <div class="g-col-12">
                        <label for="pos-form-2" class="form-label">Tipe Mobil</label>
                        <select id="tipe_mobil" class="form-control">

                        </select>
                    </div>

                    <div class="g-col-12">
                        <label for="pos-form-4" class="form-label">No WA</label>
                        <input type="number" class="form-control flex-1" placeholder="0812XXXXXXXX" id="phone">
                    </div>

                    <div class="g-col-12">
                        <label for="pos-form-4" class="form-label">Status Kendaraan</label>
                        <select id="status_kendaraan" name="status_kendaraan" class="form-control flex-1">
                            <option value="">-- Pilih Status Kendaraan --</option>
                            <option value="Ditunggu">Ditunggu</option>
                            <option value="Ditinggal">Ditinggal</option>
                        </select>
                    </div>
                    <input type="text" style="visibility: hidden" id="id">
                    <input type="text" style="visibility: hidden" id="product_id">
                    <input type="text" style="visibility: hidden" id="tipe_mobil_name">
                </div>
                <!-- END: Modal Body -->
                <!-- BEGIN: Modal Footer -->
                <div class="modal-footer text-end">
                    <button type="button" data-bs-dismiss="modal" class="btn btn-outline-secondary w-32 me-1"
                        id="cencel">Tutup</button>
                    <button type="button" class="btn btn-primary w-32" id="simpan">Simpan</button>
                </div>
                <!-- END: Modal Footer -->
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-photo" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Upload Foto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger print-error-msg" style="display:none" id="error-photo">
                        <ul></ul>
                    </div>
                    <form enctype="multipart/form-data" id="form-photo">
                        @csrf
                        <div class="g-col-12">
                            <label for="pos-form-2" class="form-label">No Pol. Kendaraan</label>
                            <input type="text" class="form-control flex-1" id="fno_pol_kendaraan" disabled>
                        </div>
                        <br>
                        <div class="g-col-12">
                            <label for="pos-form-3" class="form-label">Foto</label>
                            <input type="file" class="form-control flex-1" id="gambar" name="photo">
                        </div>
                        <br>
                        <div class="g-col-12">
                            <label for="pos-form-2" class="form-label">Nama Foto</label>
                            <input type="text" class="form-control flex-1" id="name_photo" name="name_photo">
                        </div>
                        <input type="text" style="visibility: hidden" id="photo_booking_id">
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary w-32" id="simpan_photo">Upload Foto</button>
                        </div>
                    </form>
                    <br>
                    <br>
                    <table class="table table-bordered" width="100%" cellspacing="0" id="tabel-photo">
                        <thead>
                            <tr>
                                <th class="text-nowrap">Foto</th>
                            </tr>
                        </thead>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-orderan" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Orderan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger print-error-msg" style="display:none" id="error-orderan">
                        <ul></ul>
                    </div>
                    <div class="g-col-12">
                        <label for="pos-form-2" class="form-label">No Pol. Kendaraan</label>
                        <input type="text" class="form-control flex-1" id="ono_pol_kendaraan" disabled>
                    </div>
                    <br>
                    <div class="g-col-12">
                        <label for="pos-form-1" class="form-label">Layanan</label>
                        <select id="product" class="form-control">

                        </select>
                    </div>
                    <br>
                    <div class="g-col-12" style="display: none" id="form-extraservice">
                        <label for="pos-form-1" class="form-label">Extra Layanan</label>
                        <select id="extraservice" class="form-control flex-1">

                        </select>
                    </div>
                    <input type="text" style="visibility: hidden" id="orderan_booking_id">
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary w-32" id="simpan_orderan">Tambah</button>
                    </div>
                    <br>
                    <br>
                    <table class="table table-bordered" width="100%" cellspacing="0" id="tabel-orderan">
                        <thead>
                            <tr>
                                <th class="text-nowrap">Orderan</th>
                            </tr>
                        </thead>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-selesai" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Mobil Selesai {{ date('d M Y') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered" width="100%" cellspacing="0" id="tabel-selesai">
                        <thead>
                            <tr>
                                <th class="text-nowrap">No</th>
                                <th class="text-nowrap">No Kendaraan</th>
                                <th class="text-nowrap">Orderan</th>
                            </tr>
                        </thead>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
    <audio id="tingtung" src="{{ asset('audio/tingtung.mp3') }}"></audio>
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
            $('#tabel-booking').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                ajax: "{{ route('loket.home') }}",
                columns: [{
                        "data": null,
                        "sortable": false,
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1
                        }
                    },
                    {
                        data: 'booking',
                        name: 'booking'
                    }
                ]
            })
        }

        $('#tambah').on('click', function() {
            $('#tambah').text('Loading..').prop('disabled', true);
            $('#no_pol_kendaraan').val(null)
            $('#tipe_mobil').val(null)
            $('#phone').val(null)
            $("#error").css("display", "none")
            $("#simpan").text('Simpan')
            tipe_mobil()
            $('#tambah').text('Tambah').prop('disabled', false);
        })

        function tipe_mobil() {
            $.ajax({
                url: "{{ route('tipemobil.create') }}",
                type: 'GET',
                data: {
                    _token: "{{ csrf_token() }}"
                },
                success: function(res) {
                    $("#tipe_mobil").empty();
                    $("#tipe_mobil").append(
                        '<option value="">--- Pilih Tipe Mobil ---</option>');
                    $.each(res.data, function(id, item) {
                        $("#tipe_mobil").append('<option value="' + item
                            .id + '">' + item.name + '</option>');
                    })

                }
            })
        }

        function rupiah(nStr) {
            nStr += '';
            x = nStr.split('.');
            x1 = x[0];
            x2 = x.length > 1 ? '.' + x[1] : '';
            var rgx = /(\d+)(\d{3})/;
            while (rgx.test(x1)) {
                x1 = x1.replace(rgx, '$1' + '.' + '$2');
            }
            return x1 + x2;
        }

        $("#simpan").on('click', function() {
            if ($(this).text() === 'Edit') {
                edit()
            } else {
                tambah()
            }
        })

        function tambah() {
            $('#tambah').text('Loading..').prop('disabled', true);
            $.ajax({
                url: "{{ route('bookingorder') }}",
                type: 'POST',
                data: {
                    no_pol_kendaraan: $('#no_pol_kendaraan').val(),
                    name: $('#name_pelanggan').val(),
                    tipe_mobil: $('#tipe_mobil').val(),
                    phone: $('#phone').val(),
                    status_kendaraan: $('#status_kendaraan').val(),
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
                            $('#tabel-booking').DataTable().ajax.reload()
                            $("#cencel").click()
                            swal(res.text, {
                                icon: "success",
                            });

                        }

                    } else {
                        printErrorMsg(res.error)
                    }
                    $('#tambah').text('Simpan').prop('disabled', false);

                }
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
            let url = "{{ route('booking.edit', ':id') }}"
            url = url.replace(':id', id)
            $("#tambah").click()
            $("#simpan").text('Edit')
            $('.edit').text('Loading..').prop('disabled', true);
            $.ajax({
                url: url,
                type: 'GET',
                data: {
                    _token: "{{ csrf_token() }}"
                },

                success: function(res) {
                    $('#no_pol_kendaraan').val(res.data.no_pol_kendaraan)
                    $('#name_pelanggan').val(res.data.name)
                    $('#tipe_mobil_name').val(res.data.tipe_mobil)
                    $('#phone').val(res.data.phone)
                    $('#id').val(res.data.id)
                    $('#status_kendaraan').val(res.data.status_kendaraan)
                    $.ajax({
                        url: "{{ route('tipemobil.create') }}",
                        type: 'GET',
                        data: {
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(res) {
                            $("#tipe_mobil").empty();
                            $("#tipe_mobil").append(
                                '<option value="">--- Pilih Tipe Mobil ---</option>');
                            $.each(res.data, function(id, item) {
                                if (item.name == $('#tipe_mobil_name').val()) {
                                    $("#tipe_mobil").append('<option value="' + item
                                        .id + '" selected>' + item.name +
                                        '</option>');

                                } else {
                                    $("#tipe_mobil").append('<option value="' + item
                                        .id + '">' + item.name + '</option>');
                                }
                            })
                        }
                    })
                    $('.edit').text('Edit').prop('disabled', false);
                }
            })
        })

        $('#product').change(function() {
            let url_extra = "{{ route('extraservice.create') }}"
            $.ajax({
                url: url_extra,
                type: 'GET',
                data: {
                    id: $('#product').val(),
                    _token: "{{ csrf_token() }}"
                },
                success: function(res) {
                    if (res.data.length > 0) {
                        $('#form-extraservice').show()
                        $("#extraservice").empty();
                        $("#extraservice").append(
                            '<option value="">--- Pilih Extra Service ---</option>');
                        $.each(res.data, function(id, item) {
                            $("#extraservice").append('<option value="' + item.id + '">' + item
                                .name + ' | Rp. ' + rupiah(item.price) + '</option>');
                        })
                    } else {
                        $('#form-extraservice').hide()
                    }
                }
            })
        })

        function edit() {
            let id_edit = $("#id").val()
            let url_edit = "{{ route('booking.update', ':id') }}"
            url_edit = url_edit.replace(':id', id_edit)
            $('#simpan').text('Loading..').prop('disabled', true);
            $.ajax({
                url: url_edit,
                type: "PUT",
                data: {
                    no_pol_kendaraan: $('#no_pol_kendaraan').val(),
                    name: $('#name_pelanggan').val(),
                    tipe_mobil: $('#tipe_mobil').val(),
                    phone: $('#phone').val(),
                    status_kendaraan: $('#status_kendaraan').val(),
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
                            $('#tabel-booking').DataTable().ajax.reload()
                            $("#cencel").click()
                            swal(res.text, {
                                icon: "success",
                            });

                        }

                    } else {
                        printErrorMsg(res.error)
                    }
                    $('#simpan').text('Edit').prop('disabled', false);
                }
            })
        }

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
                        let url = "{{ route('booking.destroy', ':id') }}"
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
                                $('#tabel-booking').DataTable().ajax.reload()
                            }
                        })
                    }
                });
        })



        $(document).on('click', '.delete_layanan', function() {
            swal({
                    title: "Apakah Anda Yakin ?",
                    text: "Jika dihapus, Anda tidak dapat mengembalikan data ini lagi!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        $('#product').val(null)
                        $('#extraservice').val(null)
                        $('#form-extraservice').hide()
                        let id = $(this).attr('id')
                        let url = "{{ route('orderan.delete', ':id') }}"
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
                                $('#tabel-orderan').DataTable().ajax.reload()
                            }
                        })
                    }
                });
        })

        $(document).on('click', '.photo', function() {
            $("#error-photo").css("display", "none");
            $('#photo').val(null)
            $('#name_photo').val(null)
            let id = $(this).attr('id')
            let url = "{{ route('booking.edit', ':id') }}"
            url = url.replace(':id', id)
            $("#photo").click()

            $.ajax({
                url: url,
                type: 'GET',
                data: {
                    _token: "{{ csrf_token() }}"
                },

                success: function(res) {
                    $('#fno_pol_kendaraan').val(res.data.no_pol_kendaraan)
                    $('#photo_booking_id').val(res.data.id)
                    let url_a = "{{ route('photocek.index', ':id') }}"
                    url_a = url_a.replace(':id', res.data.id)
                    $('#tabel-photo').DataTable({
                        responsive: true,
                        processing: true,
                        serverSide: true,
                        destroy: true,
                        ajax: url_a,
                        columns: [{
                            data: 'photo',
                            name: 'photo'
                        }]
                    })
                }
            })
        })

        $(document).on('click', '.upload', function() {
            $("#error-photo").css("display", "none");
            $('#gambar').val(null)
            $('#name_photo').val(null)
            let id = $(this).attr('id')
            let url = "{{ route('booking.edit', ':id') }}"
            url = url.replace(':id', id)
            $("#photo").click()
            $('.upload').text('Loading..').prop('disabled', true);
            $.ajax({
                url: url,
                type: 'GET',
                data: {
                    _token: "{{ csrf_token() }}"
                },

                success: function(res) {
                    $('#fno_pol_kendaraan').val(res.data.no_pol_kendaraan)
                    $('#photo_booking_id').val(res.data.id)
                    let url_a = "{{ route('photocek.index', ':id') }}"
                    url_a = url_a.replace(':id', res.data.id)
                    $('#tabel-photo').DataTable({
                        responsive: true,
                        processing: true,
                        serverSide: true,
                        destroy: true,
                        ajax: url_a,
                        columns: [

                            {
                                data: 'photo',
                                name: 'photo'
                            }
                        ]
                    })

                    $('.upload').text('Upload').prop('disabled', false);
                }
            })
        })

        $('#form-photo').on('submit', (function(e) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            e.preventDefault();
            var formData = new FormData(this);
            let id = $('#photo_booking_id').val()
            let url = "{{ route('photocek.store', ':id') }}"
            url = url.replace(':id', id)
            $('#simpan_photo').text('Loading..').prop('disabled', true);
            $.ajax({
                type: 'POST',
                url: url,
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function(res) {
                    if ($.isEmptyObject(res.error)) {
                        $("#error-photo").css("display", "none");
                        $('#gambar').val(null)
                        $('#name_photo').val(null)
                        $('#tabel-photo').DataTable().ajax.reload()
                        swal(res.text, {
                            icon: "success",
                        });
                        $('#simpan_photo').text('Upload Foto').prop('disabled', false);
                    } else {
                        printErrorMsg(res.error);
                        $('#simpan_photo').text('Upload Foto').prop('disabled', false);
                    }
                },
                error: function(xhr) {
                    alert(xhr.responJson.text)
                }
            })
        }))

        $(document).on('click', '.delete_photo', function() {
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
                        let url = "{{ route('photocek.delete', ':id') }}"
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
                                $('#tabel-photo').DataTable().ajax.reload()
                            }
                        })
                    }
                });
        })

        $(document).on('click', '.orderan', function() {
            $("#error-orderan").css("display", "none");
            $('#product').val(null)
            $('#extraservice').val(null)
            $('#form-extraservice').hide()
            let id = $(this).attr('id')
            let url = "{{ route('booking.edit', ':id') }}"
            url = url.replace(':id', id)
            $("#orderan").click()
            $('.orderan').text('Loading..').prop('disabled', true);
            $.ajax({
                url: url,
                type: 'GET',
                data: {
                    _token: "{{ csrf_token() }}"
                },

                success: function(res) {
                    $('#ono_pol_kendaraan').val(res.data.no_pol_kendaraan)
                    $('#orderan_booking_id').val(res.data.id)
                    let url_a = "{{ route('orderan', ':id') }}"
                    url_a = url_a.replace(':id', res.data.id)
                    $('#tabel-orderan').DataTable({
                        responsive: true,
                        processing: true,
                        serverSide: true,
                        destroy: true,
                        ajax: url_a,
                        columns: [

                            {
                                data: 'bookingorder',
                                name: 'bookingorder'
                            }
                        ]
                    })

                }
            })
            $.ajax({
                url: "{{ route('getProduk') }}",
                type: 'GET',
                data: {
                    _token: "{{ csrf_token() }}"
                },
                success: function(res) {
                    $("#product").empty();
                    $("#product").append(
                        '<option value="">--- Pilih Layanan ---</option>');
                    $.each(res.data, function(id, item) {
                        $("#product").append('<option value="' + item
                            .id + '">' + item.name + ' | Rp. ' +
                            rupiah(item.price) + '</option>');
                    })
                }
            })
            $('.orderan').text('Orderan').prop('disabled', false);
        })

        $("#simpan_orderan").on('click', function() {
            $('#simpan_orderan').text('Loading..').prop('disabled', true);
            let url = "{{ route('orderan.store', ':id') }}"
            url = url.replace(':id', $('#orderan_booking_id').val())
            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    product: $('#product').val(),
                    extraservice: $('#extraservice').val(),
                    _token: "{{ csrf_token() }}"
                },
                success: function(res) {
                    $('#product').val(null)
                    $('#extraservice').val(null)
                    $('#form-extraservice').hide()
                    if ($.isEmptyObject(res.error)) {
                        if (res.status == 'gagal') {
                            swal(res.text, {
                                icon: "error",
                            });
                        } else {
                            swal(res.text, {
                                icon: "success",
                            });
                        }
                        $('#tabel-orderan').DataTable().ajax.reload()
                    } else {
                        printErrorMsg(res.error)
                    }
                    $('#simpan_orderan').text('Tambah').prop('disabled', false);
                }
            })
        })

        $('#selesai').on('click', function() {
            $('#tabel-selesai').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                destroy: true,
                ajax: "{{ route('selesai') }}",
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
                    }
                ]
            })
        })
    </script>
@endsection
