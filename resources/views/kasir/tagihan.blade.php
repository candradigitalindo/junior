@extends('layouts.office')
@section('title')
    Dashboard Tagihan
@endsection
@section('content')
    <div class="grid columns-12 gap-6">
        <div class="g-col-12 g-col-xxl-12">
            <div class="grid columns-12 gap-6">
                <!-- BEGIN: Weekly Top Products -->
                <div class="g-col-12 mt-6">
                    <div class="intro-y d-block d-sm-flex align-items-center h-10">
                        <h2 class="fs-lg fw-medium truncate me-5">
                            Tabel Tagihan
                        </h2>
                        <div class="d-flex align-items-center ms-sm-auto mt-3 mt-sm-0">
                            <button style="visibility: hidden" data-bs-toggle="modal" data-bs-target="#modal-tambah"
                                id="tambah"></button>
                            <button style="visibility: hidden" data-bs-toggle="modal" data-bs-target="#modal-pengecekan"
                                id="pengecekan"></button>
                            <button style="visibility: hidden" data-bs-toggle="modal" data-bs-target="#modal-pengerjaan"
                                id="pengerjaan"></button>
                            <button style="visibility: hidden" data-bs-toggle="modal" data-bs-target="#modal-diskon"
                                id="diskon"></button>
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
                                    {{-- <th class="text-nowrap">Status</th> --}}
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
                            <input type="file" class="form-control flex-1" id="foto_pembayaran" name="foto_pembayaran"
                                required>
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
                        <textarea class="form-control flex-1" name="exterior" id="cexterior" cols="30" rows="10"
                            disabled></textarea>
                    </div>
                    <div class="g-col-12">
                        <label for="pos-form-4" class="form-label">Bagian Interior</label>
                        <textarea class="form-control flex-1" name="interior" id="cinterior" cols="30" rows="10"
                            disabled></textarea>
                    </div>
                    <div class="g-col-12">
                        <label for="pos-form-4" class="form-label">Mesin</label>
                        <textarea class="form-control flex-1" name="mesin" id="cmesin" cols="30" rows="10"
                            disabled></textarea>
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
                    <button type="button" data-bs-dismiss="modal" class="btn btn-outline-secondary w-32 me-1">Tutup</button>
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
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="tutup_diskon">Tutup</button>
                    <button type="button" class="btn btn-primary w-32" id="simpan_diskon">Simpan</button>
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
        });

        function isi_tabel() {
            $('#tabel-booking').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                ajax: "{{ route('tagihan.index') }}",
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
                    // { data : 'status', name:'status'},
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
                    $('#ptipe_mobil').val(res.data.tipe_mobil)
                    $('#pproduct_price').val(res.data.bookingorder.total)
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

        function tambah() {
            $("#error").css("display", "none");
            let id = $('#booking_id').val();
            let url = "{{ route('kasir.bayar', ':id') }}"
            url = url.replace(':id', id)
            $.ajax({
                url: url,
                type: "POST",
                data: {
                    no_pol_kendaraan: $('#xno_pol_kendaraan').val(),
                    tipe_mobil: $('#ptipe_mobil').val(),
                    product_price: $('#pproduct_price').val(),
                    metode_pembayaran: $('#metode_pembayaran').val(),
                    keterangan: $('#keterangan').val(),
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
                }
            })
        }

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

        $('#form-pembayaran').on('submit', (function(e) {
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
                },
                error: function(xhr) {
                    alert(xhr.responJson.text)
                }
            })
        }))
    </script>
@endsection
