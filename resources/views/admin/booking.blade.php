@extends('layouts.office')
@section('title')
    Dashboard Loket
@endsection
@section('css')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.4/css/jquery.dataTables.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .select2-container--default .select2-selection--single {
            border: 1px solid #d2d6dc;
            border-radius: 0.375rem;
            height: 38px;
            display: flex;
            align-items: center;
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 38px;
            padding-left: 12px;
        }
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 36px;
        }
        .modal-open .select2-container {
            z-index: 1060;
        }
        @media (max-width: 768px) {
            .select2-container--default .select2-selection--single {
                height: 45px;
            }
            .select2-container--default .select2-selection--single .select2-selection__rendered {
                line-height: 45px;
            }
            .select2-container--default .select2-selection--single .select2-selection__arrow {
                height: 43px;
            }
        }
    </style>
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
                            <a class="btn btn-warning w-45 me-8 mb-4" href="{{ route('home') }}"> <i data-feather="rewind"
                                    class="w-4 h-4 me-2"></i>Kembali Dashboard </a>
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
                                    <th class="text-nowrap">No Pol. Kendaraan</th>
                                    <th class="text-nowrap">Tipe Mobil & Warna</th>
                                    <th class="text-nowrap">No WA</th>
                                    <th class="text-nowrap">Booking</th>
                                    <th class="text-nowrap">Keterangan</th>
                                    <th class="text-nowrap">Status</th>
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
    {{-- <div id="modal-tambah" class="modal fade" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- BEGIN: Modal Header -->
                <div class="modal-header">
                    <h2 class="fw-medium fs-base me-auto">
                        Tambah Booking
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
                        <select id="product" class="form-control">

                        </select>
                    </div>
                    <div class="g-col-12">
                        <label for="pos-form-1" class="form-label">No Plat</label>
                        <input type="text" class="form-control flex-1" placeholder="BK XXXX XXX" id="no_pol_kendaraan">
                    </div>
                    <div class="g-col-12">
                        <label for="pos-form-2" class="form-label">Tipe Mobil</label>
                        <input type="text" class="form-control flex-1" placeholder="Exp. FORTUNER" id="tipe_mobil">
                    </div>

                    <div class="g-col-12">
                        <label for="pos-form-4" class="form-label">No WA</label>
                        <input type="number" class="form-control flex-1" placeholder="0812XXXXXXXX" id="phone">
                    </div>
                    <div class="g-col-12">
                        <label for="pos-form-4" class="form-label">Tanggal Booking</label>
                        <input type="date" class="form-control flex-1" id="tgl_booking">
                    </div>
                    <div class="g-col-12">
                        <label for="pos-form-4" class="form-label">Waktu Booking</label>
                        <input type="time" class="form-control flex-1" id="waktu_booking">
                    </div>
                    <div class="g-col-12">
                        <label for="pos-form-4" class="form-label">Layanan</label>
                        <select id="layanan" name="layanan" class="form-control flex-1" required>
                            <option value="">-- Pilih Layanan --</option>
                            <option value="Visit">Visit</option>
                            <option value="Delivery">Delivery</option>
                        </select>
                    </div>
                    <div class="g-col-12">
                        <label for="pos-form-4" class="form-label">Status</label>
                        <select id="status" name="status" class="form-control flex-1" required>
                            <option value="Booking">Booking</option>
                            <option value="Proses">Proses</option>
                            <option value="Sedang Pengerjaan" disabled>Sedang Pengerjaan</option>
                        </select>
                    </div>
                    <input type="text" style="visibility: hidden" id="id">
                    <input type="text" style="visibility: hidden" id="product_id">
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
    </div> --}}
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
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <script>
        function initSelect2() {
            $('select:not(.dataTables_length select)').select2({
                width: '100%',
                dropdownParent: $('.modal.show').length ? $('.modal.show') : $(document.body)
            });
        }

        $(document).ready(function() {
            isi_tabel();
            initSelect2();
        });

        $('.modal').on('shown.bs.modal', function() {
            initSelect2();
        });

        function isi_tabel() {
            $('#tabel-booking').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.booking') }}",
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
                        data: 'tipe_mobil',
                        name: 'tipe_mobil'
                    },
                    {
                        data: 'phone',
                        name: 'phone'
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
                        data: 'aksi',
                        name: 'aksi'
                    }
                ]
            })
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
                        ],
                        drawCallback: function() {
                            if (typeof feather !== 'undefined') {
                                feather.replace();
                            }
                        }
                    })
                }
            })
        })

        $(document).on('click', '.delete_photo', function() {
            let id = $(this).data('id');
            swal({
                title: "Apakah Anda Yakin ?",
                text: "Foto akan dihapus permanen!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    let url = "{{ route('photocek.delete', ':id') }}";
                    url = url.replace(':id', id);
                    $.ajax({
                        url: url,
                        type: 'DELETE',
                        data: {
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(res) {
                            swal(res.text, { icon: "success" });
                            $('#tabel-photo').DataTable().ajax.reload();
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
    </script>
@endsection
