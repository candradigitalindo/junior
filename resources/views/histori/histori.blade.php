@extends('layouts.office')
@section('title')
    Dashboard Histori Pengerjaan
@endsection
@section('content')
    <div class="grid columns-12 gap-6">
        <div class="g-col-12 g-col-xxl-12">
            <div class="grid columns-12 gap-6">
                <!-- BEGIN: Weekly Top Products -->
                <div class="g-col-12 mt-6">
                    <div class="intro-y d-block d-sm-flex align-items-center h-10">
                        <h2 class="fs-lg fw-medium truncate me-5">
                            Tabel Pengerjaan
                        </h2>
                        <div class="d-flex align-items-center ms-sm-auto mt-3 mt-sm-0">
                            <button class="btn btn-dark w-40 me-8 mb-4" id="update"> <i data-feather="plus-circle"
                                    class="w-4 h-4 me-2"></i> Update </button>
                            <button class="btn btn-success w-35 me-8 mb-4" id="selesai" data-bs-toggle="modal"
                                data-bs-target="#modal-selesai"> Selesai </button>
                            <button style="visibility: hidden" data-bs-toggle="modal" data-bs-target="#modal-tambah"
                                id="tambah"></button>
                            <button style="visibility: hidden" data-bs-toggle="modal" data-bs-target="#modal-photo"
                                id="photo"></button>
                            <button style="visibility: hidden" data-bs-toggle="modal" data-bs-target="#modal-waktu"
                                id="waktu"></button>
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
                                    {{-- <th class="text-nowrap">Tipe Mobil</th>
                                    <th class="text-nowrap">Keterangan</th>
                                    <th class="text-center text-nowrap">Aksi</th> --}}
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
                <!-- END: Weekly Top Products -->
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-tambah" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Pekerjaan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="alert alert-danger print-error-msg" style="display:none" id="error">
                    <ul></ul>
                </div>
                <div class="modal-body">
                    <div class="g-col-12">
                        <label for="pos-form-2" class="form-label">No Pol. Kendaraan</label>
                        <input type="text" class="form-control flex-1" id="no_pol_kendaraan" disabled>
                    </div>
                    <br>
                    <div class="g-col-12">
                        <label for="pos-form-2" class="form-label">Update Pekerjaan</label>
                        <input type="text" style="visibility: hidden" id="booking_id">
                        {{-- <input  type="text" class="form-control flex-1" id="histori"> --}}
                        <select name="histori" id="histori" class="form-control flex-1">
                            <option value="">-- Pilih Proses --</option>
                            <option value="Dalam Proses Pengerjaan">Dalam Proses Pengerjaan</option>
                        </select>
                    </div>
                    <br>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="simpan">Simpan</button>
                    </div>
                    <br>
                    <table class="table table-bordered" width="100%" cellspacing="0" id="tabel-histori">
                        <thead>
                            <tr>
                                <th class="text-nowrap">Histori</th>
                            </tr>
                        </thead>
                        <tbody id="tbody-histori"></tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="tutup">Tutup</button>
                </div>
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
                    <div class="g-col-12">
                        <label for="pos-form-2" class="form-label">No Pol. Kendaraan</label>
                        <input type="text" class="form-control flex-1" id="fno_pol_kendaraan" disabled>
                    </div>
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
    <div class="modal fade" id="modal-waktu" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Update Estimasi Waktu Selesai</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger print-error-msg" style="display:none" id="error-waktu">
                        <ul></ul>
                    </div>
                    <div class="g-col-12">
                        <label for="pos-form-2" class="form-label">No Pol. Kendaraan</label>
                        <input type="text" class="form-control flex-1" id="wno_pol_kendaraan" disabled>
                    </div>
                    <br>
                    <div class="g-col-12">
                        <label for="pos-form-2" class="form-label">Tgl. Selesai</label>
                        <input type="date" class="form-control flex-1" id="wtgl_selesai_booking">
                    </div>
                    <br>
                    <div class="g-col-12">
                        <label for="pos-form-2" class="form-label">Waktu Selesai</label>
                        <input type="time" class="form-control flex-1" id="wwaktu_selesai_booking">
                    </div>
                    <input type="text" style="visibility: hidden" id="booking_waktu_id">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="tutup_waktu">Tutup</button>
                    <button type="button" class="btn btn-primary" id="update_waktu">Update Waktu</button>
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
            // setInterval(() => {
            //     $('#tabel-booking').DataTable().ajax.reload()
            // }, 60000);
        });

        function isi_tabel() {
            $('#tabel-booking').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                ajax: "{{ route('histori.index') }}",
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

        $("#update").on('click', function() {
            $('#update').text('Loading..').prop('disabled', true);
            $('#tabel-booking').DataTable().ajax.reload()
            swal('Update Berhasil', {
                icon: "success",
            });
            $('#update').text('Update').prop('disabled', false);
        })

        $('#tambah').on('click', function() {
            $('#exterior').val(null)
            $('#interior').val(null)
            $('#mesin').val(null)
            $('#barang_mobil').val(null)
            $("#error").css("display", "none")

        })


        function printErrorMsg(msg) {
            $(".print-error-msg").find("ul").html('');
            $(".print-error-msg").css('display', 'block');
            $.each(msg, function(key, value) {
                $(".print-error-msg").find("ul").append('<li>' + value + '</li>');
            });
        }

        $(document).on('click', '.pekerjaan', function() {
            $('.pekerjaan').text('Loading..').prop('disabled', true);
            $('#histori').val(null)
            $("#error").css("display", "none");
            let id = $(this).attr('id')
            let url = "{{ route('booking.edit', ':id') }}"
            url = url.replace(':id', id)
            $("#tambah").click()
            $.ajax({
                url: url,
                type: 'GET',
                data: {
                    _token: "{{ csrf_token() }}"
                },

                success: function(res) {
                    $('#booking_id').val(res.data.id)
                    $('#no_pol_kendaraan').val(res.data.no_pol_kendaraan)
                    // let url_b = "{{ route('step.show', ':id') }}"
                    // url_b = url_b.replace(':id', res.data.product_id)
                    // $.ajax({
                    //     url: url_b,
                    //     type: 'GET',
                    //     data: {
                    //         _token: "{{ csrf_token() }}"
                    //     },
                    //     success: function(res) {
                    //         $("#histori").empty();
                    //         $("#histori").append(
                    //             '<option value="">--- Pilih Step Pekerjaan ---</option>'
                    //         );
                    //         $.each(res.data, function(id, item) {
                    //             $("#histori").append('<option value="' + item.id +
                    //                 '">' + item.step + '</option>');
                    //         })
                    //     }
                    // })
                    let url_a = "{{ route('histori.show', ':id') }}"
                    url_a = url_a.replace(':id', res.data.id)
                    $('#tabel-histori').DataTable({
                        responsive: true,
                        processing: true,
                        serverSide: true,
                        destroy: true,
                        ajax: url_a,
                        columns: [

                            {
                                data: 'histori',
                                name: 'histori'
                            }
                        ]
                    })
                    $('.pekerjaan').text('Pekerjaan').prop('disabled', false);
                }
            })
        })

        $("#simpan").on('click', function() {
            if ($(this).text() === 'Edit') {
                edit()
            } else {
                tambah()
            }
        })

        function tambah() {
            $('#simpan').text('Loading..').prop('disabled', true);
            let id = $('#booking_id').val()
            let url = "{{ route('histori.store', ':id') }}"
            url = url.replace(':id', id)
            $.ajax({
                url: url,
                type: "POST",
                data: {
                    histori: $('#histori').val(),
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
                            $('#tabel-histori').DataTable().ajax.reload()
                            $('#histori').val(null)
                            swal(res.text, {
                                icon: "success",
                            });

                        }
                    } else {
                        printErrorMsg(res.error)
                    }

                    $('#simpan').text('Simpan').prop('disabled', false);
                }
            })
        }

        $(document).on('click', '.hapus', function() {
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
                        let url = "{{ route('histori.destroy', ':id') }}"
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
                                $('#tabel-histori').DataTable().ajax.reload()
                            }
                        })
                    }
                });
        })

        $(document).on('click', '.cekmasuk', function() {
            $("#error").css("display", "none");
            let id = $(this).attr('id')
            let url = "{{ route('pengecekan.home', ':id') }}"
            url = url.replace(':id', id)
            $("#pengecekan").click()
            $.ajax({
                url: url,
                type: 'GET',
                data: {
                    _token: "{{ csrf_token() }}"
                },

                success: function(res) {
                    $('#cno_pol_kendaraan').val(res.data.no_pol_kendaraan)
                    $('#ctipe_mobil').val(res.data.tipe_mobil)
                    $('#cexterior').val(res.data.cekmasuk.exterior)
                    $('#cinterior').val(res.data.cekmasuk.interior)
                    $('#cmesin').val(res.data.cekmasuk.mesin)
                    $('#cbarang_mobil').val(res.data.cekmasuk.barang_mobil)
                }
            })
        })

        $(document).on('click', '.upload', function() {
            $('.upload').text('Loading..').prop('disabled', true);
            $("#error-photo").css("display", "none");
            $('#gambar').val(null)
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
                        columns: [

                            {
                                data: 'photo',
                                name: 'photo'
                            }
                        ]
                    })
                    $('.upload').text('Foto').prop('disabled', false);
                }
            })
        })

        $(document).on('click', '.waktu', function() {
            $("#error-waktu").css("display", "none");
            $('.waktu').text('Loading..').prop('disabled', true);
            let id = $(this).attr('id')
            let url = "{{ route('booking.edit', ':id') }}"
            url = url.replace(':id', id)
            $("#waktu").click()
            $.ajax({
                url: url,
                type: 'GET',
                data: {
                    _token: "{{ csrf_token() }}"
                },

                success: function(res) {
                    $('#booking_waktu_id').val(res.data.id)
                    $('#wno_pol_kendaraan').val(res.data.no_pol_kendaraan)
                    $('#wtgl_selesai_booking').val(res.data.tgl_selesai_booking)
                    $('#wwaktu_selesai_booking').val(res.data.waktu_selesai_booking)
                    $('.waktu').text('Waktu').prop('disabled', false);
                }
            })
        })

        $("#update_waktu").on('click', function() {
            $('#update_waktu').text('Loading..').prop('disabled', true);
            let id_edit = $("#booking_waktu_id").val()
            let url_edit = "{{ route('histori.update_waktu', ':id') }}"
            url_edit = url_edit.replace(':id', id_edit)
            $.ajax({
                url: url_edit,
                type: "POST",
                data: {
                    tgl_selesai_booking: $('#wtgl_selesai_booking').val(),
                    waktu_selesai_booking: $('#wwaktu_selesai_booking').val(),
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
                            $("#tutup_waktu").click()
                            swal(res.text, {
                                icon: "success",
                            });

                        }

                    } else {
                        printErrorMsg(res.error)
                    }
                    $('#update_waktu').text('Update Waktu').prop('disabled', false);
                }
            })

        })

        $(document).on('click', '.orderan', function() {
            $("#error-orderan").css("display", "none");
            $('#service').val(null)
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
                    $('.orderan').text('Orderan').prop('disabled', false);
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
