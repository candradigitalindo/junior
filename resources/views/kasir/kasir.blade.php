@extends('layouts.office')
@section('title')
    Dashboard Kasir
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
                            <button class="btn btn-dark w-40 me-8 mb-4" id="update"> <i data-feather="plus-circle"
                                    class="w-4 h-4 me-2"></i> Update </button>
                            <button style="visibility: hidden" data-bs-toggle="modal" data-bs-target="#modal-tambah"
                                id="tambah"></button>
                            <button style="visibility: hidden" data-bs-toggle="modal" data-bs-target="#modal-pengecekan"
                                id="pengecekan"></button>
                            <button style="visibility: hidden" data-bs-toggle="modal" data-bs-target="#modal-pengerjaan"
                                id="pengerjaan"></button>
                            <button style="visibility: hidden" data-bs-toggle="modal" data-bs-target="#modal-diskon"
                                id="diskon"></button>
                            <button style="visibility: hidden" data-bs-toggle="modal" data-bs-target="#modal-photo"
                                id="photo"></button>
                            <button style="visibility: hidden" data-bs-toggle="modal" data-bs-target="#modal-orderan"
                                id="orderan"></button>

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
                    </div>
                    <br>
                    <div class="intro-y overflow-auto overflow-lg-visible mt-8 mt-sm-0">
                        <table class="table table-bordered display" id="tabel-booking" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th class="text-nowrap" style="width: 1%">No</th>
                                    <th class="text-nowrap">Info Pelanggan</th>
                                    <th class="text-nowrap">Tgl Booking</th>
                                    <th class="text-nowrap">Keterangan</th>
                                    <th class="text-nowrap">Status</th>
                                    <th class="text-nowrap">Transaksi</th>
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
                        Pembayaran
                    </h2>
                </div>
                <!-- END: Modal Header -->
                <!-- BEGIN: Modal Body -->
                <div class="alert alert-danger print-error-msg" style="display:none" id="error">
                    <ul></ul>
                </div>
                <form enctype="multipart/form-data" id="form-pembayaran">
                    @csrf
                    <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                        <div class="g-col-12">
                            <label for="pos-form-1" class="form-label">No Pol Kendaraan</label>
                            <input type="text" class="form-control flex-1" id="xno_pol_kendaraan" name="no_pol_kendaraan"
                                disabled>
                        </div>

                        <div class="g-col-12">
                            <label for="pos-form-4" class="form-label">Metode Pembayaran</label>
                            <select id="metode_pembayaran" name="metode_pembayaran" class="form-control flex-1" required>
                                <option value="">-- Pilih Medote --</option>
                                <option value="CASH">CASH</option>
                                <option value="QRIS">QRIS</option>
                                <option value="DEBIT BCA">DEBIT BCA</option>
                                <option value="DEBIT MANDIRI">DEBIT MANDIRI</option>
                                <option value="KARTU">KARTU</option>
                                <option value="TRANSFER BANK">TRANSFER BANK</option>
                                <option value="E-MONEY">E-MONEY</option>
                            </select>
                        </div>
                        <div class="g-col-12">
                            <label for="pos-form-4" class="form-label">Foto Bukti Pembayaran</label>
                            <input type="file" class="form-control flex-1" id="foto_pembayaran"
                                name="foto_pembayaran">
                        </div>

                        <input type="text" style="visibility: hidden" id="booking_id" name="booking_id">
                    </div>
                    <!-- END: Modal Body -->
                    <!-- BEGIN: Modal Footer -->
                    <div class="modal-footer text-end">
                        <button type="button" data-bs-dismiss="modal" class="btn btn-outline-secondary w-32 me-1"
                            id="cencel">Cancel</button>
                        <button type="submit" class="btn btn-primary w-32" id="simpan">Simpan</button>
                    </div>
                </form>
                <!-- END: Modal Footer -->
            </div>
        </div>
    </div>
    <div id="modal-pengecekan" class="modal fade" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- BEGIN: Modal Header -->
                <div class="modal-header">
                    <h2 class="fw-medium fs-base me-auto">
                        CEK KENDARAAN
                    </h2>
                </div>
                <!-- END: Modal Header -->
                <!-- BEGIN: Modal Body -->
                <div class="alert alert-danger print-error-msg" style="display:none" id="error">
                    <ul></ul>
                </div>
                <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                    <div class="g-col-12">
                        <label for="pos-form-1" class="form-label">No Pol. Kendaraan</label>
                        <input type="text" class="form-control flex-1" id="cno_pol_kendaraan" disabled>
                    </div>
                    <div class="g-col-12">
                        <label for="pos-form-2" class="form-label">Tipe Mobil</label>
                        <input type="text" class="form-control flex-1" placeholder="Exp. FORTUNER" id="ctipe_mobil"
                            disabled>
                    </div>

                    <div class="g-col-12">
                        <label for="pos-form-4" class="form-label">Bagian Exterior</label>
                        <textarea class="form-control flex-1" name="exterior" id="cexterior" cols="30" rows="10" disabled></textarea>
                    </div>
                    <div class="g-col-12">
                        <label for="pos-form-4" class="form-label">Bagian Interior</label>
                        <textarea class="form-control flex-1" name="interior" id="cinterior" cols="30" rows="10" disabled></textarea>
                    </div>
                    <div class="g-col-12">
                        <label for="pos-form-4" class="form-label">Mesin</label>
                        <textarea class="form-control flex-1" name="mesin" id="cmesin" cols="30" rows="10" disabled></textarea>
                    </div>
                    <div class="g-col-12">
                        <label for="pos-form-4" class="form-label">Barang didalam Mobil</label>
                        <textarea class="form-control flex-1" name="barang_mobil" id="cbarang_mobil" cols="30" rows="10"
                            disabled></textarea>
                    </div>

                </div>
                <!-- END: Modal Body -->
                <!-- BEGIN: Modal Footer -->
                <div class="modal-footer text-end">
                    <button type="button" data-bs-dismiss="modal"
                        class="btn btn-outline-secondary w-32 me-1">Tutup</button>
                </div>
                <!-- END: Modal Footer -->
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-pengerjaan" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Pekerjaan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="g-col-12">
                        <label for="pos-form-2" class="form-label">No Pol. Kendaraan</label>
                        <input type="text" class="form-control flex-1" id="pno_pol_kendaraan" disabled>
                    </div>

                    <br>
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
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-diskon" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Diskon</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger print-error-msg" style="display:none" id="error_diskon">
                        <ul></ul>
                    </div>
                    <div class="g-col-12">
                        <label for="pos-form-2" class="form-label">Nominal Diskon</label>
                        <input type="number" class="form-control flex-1" id="nominal_diskon" min="0">
                    </div>
                    <input type="text" style="visibility: hidden" id="diskon_booking_id">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                        id="tutup_diskon">Tutup</button>
                    <button type="button" class="btn btn-primary w-32" id="simpan_diskon">Simpan</button>
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
    <script src="https://code.responsivevoice.org/responsivevoice.js?key=Pqiovi6G"></script>
    <script>
        $(document).ready(function() {
            isi_tabel()
            // setInterval(() => {
            //     $('#tabel-booking').DataTable().ajax.reload()
            // }, 100000);
        });



        function isi_tabel(start_date = '', end_date = '') {
            $('#tabel-booking').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                destroy: true,
                ajax: {
                    url: "{{ route('kasir.index') }}",
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
                        data: 'no_pol_kendaraan',
                        name: 'no_pol_kendaraan'
                    },
                    {
                        data: 'tgl_booking',
                        name: 'tgl_booking'
                    },
                    {
                        data: 'description',
                        name: 'description'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'transaksi',
                        name: 'transaksi'
                    },
                    {
                        data: 'aksi',
                        name: 'aksi'
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

        function printErrorMsg(msg) {
            $(".print-error-msg").find("ul").html('');
            $(".print-error-msg").css('display', 'block');
            $.each(msg, function(key, value) {
                $(".print-error-msg").find("ul").append('<li>' + value + '</li>');
            });
        }

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

        $(document).on('click', '.pengerjaan', function() {
            $("#error").css("display", "none");
            let id = $(this).attr('id')
            let url = "{{ route('booking.edit', ':id') }}"
            url = url.replace(':id', id)
            $("#pengerjaan").click()
            $.ajax({
                url: url,
                type: 'GET',
                data: {
                    _token: "{{ csrf_token() }}"
                },

                success: function(res) {
                    $('#pno_pol_kendaraan').val(res.data.no_pol_kendaraan)
                    $('#tabel-histori').empty();
                    let url_a = "{{ route('pengerjaan.show', ':id') }}"
                    url_a = url_a.replace(':id', res.data.id)
                    $('#tabel-histori').DataTable({
                        responsive: true,
                        processing: true,
                        serverSide: true,
                        destroy: true,
                        ajax: url_a,
                        columns: [{
                            data: 'histori',
                            name: 'histori'
                        }]
                    })
                }
            })
        })

        $(document).on('click', '.cekkeluar', function() {
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
                    $('#cexterior').val(res.data.cekkeluar.exterior)
                    $('#cinterior').val(res.data.cekkeluar.interior)
                    $('#cmesin').val(res.data.cekkeluar.mesin)
                    $('#cbarang_mobil').val(res.data.cekkeluar.barang_mobil)
                }
            })
        })

        $(document).on('click', '.bayar', function() {
            $("#error").css("display", "none");
            $('#metode_pembayaran').val(null);
            $('#foto_pembayaran').val(null);
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
                    $('#xno_pol_kendaraan').val(res.data.no_pol_kendaraan)
                    $('#booking_id').val(res.data.id)
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




        $('#form-pembayaran').on('submit', (function(e) {
            $('#simpan').text('Loading..').prop('disabled', true);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            e.preventDefault();
            var formData = new FormData(this);
            let id = $('#booking_id').val();
            let url = "{{ route('kasir.bayar', ':id') }}"
            url = url.replace(':id', id)
            $.ajax({
                type: 'POST',
                url: url,
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function(res) {
                    if ($.isEmptyObject(res.error)) {
                        $('#cencel').click()
                        $('#tabel-booking').DataTable().ajax.reload()
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

        $(document).on('click', '.diskon', function() {
            $("#error_diskon").css("display", "none");
            $('#nominal_diskon').val(null)
            let id = $(this).attr('id')
            let url = "{{ route('booking.edit', ':id') }}"
            url = url.replace(':id', id)
            $("#diskon").click()
            $.ajax({
                url: url,
                type: 'GET',
                data: {
                    _token: "{{ csrf_token() }}"
                },

                success: function(res) {
                    $('#diskon_booking_id').val(res.data.id)
                }
            })
        })


        $("#simpan_diskon").on('click', function() {
            $("#error_diskon").css("display", "none");
            let id = $('#diskon_booking_id').val();
            let url = "{{ route('kasir.diskon', ':id') }}"
            url = url.replace(':id', id)
            $.ajax({
                url: url,
                type: "POST",
                data: {
                    diskon: $('#nominal_diskon').val(),
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
                            $("#tutup_diskon").click()
                            swal(res.text, {
                                icon: "success",
                            });

                        }
                    } else {
                        printErrorMsg(res.error)
                    }
                }
            })
        })

        $(document).on('click', '.reset_diskon', function() {
            $("#error_diskon").css("display", "none");
            let id = $(this).attr('id')
            let url = "{{ route('kasir.diskon.reset', ':id') }}"
            url = url.replace(':id', id)
            $.ajax({
                url: url,
                type: 'GET',
                data: {
                    _token: "{{ csrf_token() }}"
                },

                success: function(res) {
                    if ($.isEmptyObject(res.error)) {
                        if (res.status == 'gagal') {
                            swal(res.text, {
                                icon: "error",
                            });
                        } else {
                            $('#tabel-booking').DataTable().ajax.reload()
                            swal(res.text, {
                                icon: "success",
                            });

                        }
                    } else {
                        printErrorMsg(res.error)
                    }
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
                }
            })
        })

        $(document).on('click', '.informasi', function() {
            $('.informasi').text('Loading..').prop('disabled', true);
            let id = $(this).attr('id')
            let url = "{{ route('booking.edit', ':id') }}"
            url = url.replace(':id', id)
            $.ajax({
                url: url,
                type: 'GET',
                data: {
                    _token: "{{ csrf_token() }}"
                },

                success: function(res) {
                    const d = res.data.no_pol_kendaraan
                    const e = d.split("").join(" ");
                    var bell = document.getElementById('tingtung');
                    bell.pause();
                    bell.currentTime = 0;
                    bell.play();
                    durasi_bell = bell.duration * 770;
                    setTimeout(function() {
                        responsiveVoice.speak("Nomor Kendaraan " + e +
                            ", dalam proses pengerjaan", "Indonesian Male", {
                                rate: 0.9,
                                pitch: 1,
                                volume: 1
                            });

                    }, durasi_bell);
                    setTimeout(() => {
                        $('.informasi').text('Informasi').prop('disabled', false);
                    }, 8000);
                }
            })
        })

        $(document).on('click', '.panggil', function() {
            $('.panggil').text('Loading..').prop('disabled', true);
            let id = $(this).attr('id')
            let url = "{{ route('booking.edit', ':id') }}"
            url = url.replace(':id', id)
            $.ajax({
                url: url,
                type: 'GET',
                data: {
                    _token: "{{ csrf_token() }}"
                },

                success: function(res) {
                    const d = res.data.no_pol_kendaraan
                    const e = d.split("").join(" ");
                    var bell = document.getElementById('tingtung');
                    bell.pause();
                    bell.currentTime = 0;
                    bell.play();
                    durasi_bell = bell.duration * 770;
                    setTimeout(function() {
                        responsiveVoice.speak("Nomor Kendaraan " + e + ", Sudah Selesai",
                            "Indonesian Male", {
                                rate: 0.9,
                                pitch: 1,
                                volume: 1
                            });

                    }, durasi_bell);
                    setTimeout(() => {
                        $('.panggil').text('Panggil').prop('disabled', false);
                    }, 8000);
                }
            })
        })

        $(document).on('click', '.whatsapp', function() {
            $('.whatsapp').text('Loading..').prop('disabled', true);
            let id = $(this).attr('id')
            let url = "{{ route('wa.send', ':id') }}"
            url = url.replace(':id', id)
            $.ajax({
                url: url,
                type: 'GET',
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
                    $('.whatsapp').text('Info WA').prop('disabled', false);
                }
            })
        })

        $(document).on('click', '.wa_foto', function() {
            $('.wa_foto').text('Loading..').prop('disabled', true);
            let id = $(this).attr('id')
            let url = "{{ route('wa.foto', ':id') }}"
            url = url.replace(':id', id)
            $.ajax({
                url: url,
                type: 'GET',
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
                    $('.wa_foto').text('WA Foto').prop('disabled', false);
                }
            })
        })

        $(document).on('click', '.wa_invoice', function() {
            $('.wa_invoice').text('Loading..').prop('disabled', true);
            let id = $(this).attr('id')
            let url = "{{ route('wa.pdf', ':id') }}"
            url = url.replace(':id', id)
            $.ajax({
                url: url,
                type: 'GET',
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
                    $('.wa_invoice').text('WA Foto').prop('disabled', false);
                }
            })
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

        $("#simpan_orderan").on('click', function() {
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
                }
            })
        })

        function printErrorMsg(msg) {
            $(".print-error-msg").find("ul").html('');
            $(".print-error-msg").css('display', 'block');
            $.each(msg, function(key, value) {
                $(".print-error-msg").find("ul").append('<li>' + value + '</li>');
            });
        }

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

        $("#btn-filter").on('click', function() {
            $('#btn-filter').text('Loading..').prop('disabled', true);
            var start_date = $('#start_date').val()
            var end_date = $('#end_date').val()
            if ($('#start_date').val() == '' || $('#end_date').val() == '') {
                alert('Mohon isi Tanggal awal dan Tanggal akhir')
                $('#btn-filter').text('Filter').prop('disabled', false);
            } else {
                // $('#tabel-booking').DataTable().empty();
                isi_tabel(start_date, end_date);
                $('#btn-filter').text('Filter').prop('disabled', false);
            }
        });
    </script>
@endsection
