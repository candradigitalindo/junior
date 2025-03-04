@extends('layouts.office')
@section('title')
Orderan
@endsection
@section('content')
<h2 class="intro-y fs-2xl fw-medium mt-10 text-center me-auto">
    Best Price & Services
</h2>
<!-- BEGIN: Pricing Tab -->
<div class="intro-y d-flex justify-content-center mt-6">
    <ul class="nav nav-pills box rounded-pill overflow-hidden" role="tablist">
        @foreach ($category as $c)
            @if ($category_first->id == $c->id)
            <li id="layout-1-monthly-fees-tab" class="nav-item flex-1" role="presentation">
                <button class="nav-link w-32 w-lg-40 py-2 pt-lg-3 pb-lg-3.5 text-nowrap rounded-0 active" data-bs-toggle="pill" data-bs-target="#category{{ $c->id }}" type="button" role="tab" aria-controls="layout-1-monthly-fees-tab" aria-selected="true">{{ $c->name }}</button>
            </li>
            @else
            <li id="layout-1-monthly-fees-tab" class="nav-item flex-1" role="presentation">
                <button class="nav-link w-32 w-lg-40 py-2 pt-lg-3 pb-lg-3.5 text-nowrap rounded-0" data-bs-toggle="pill" data-bs-target="#category{{ $c->id }}" type="button" role="tab" aria-controls="layout-1-monthly-fees-tab" aria-selected="true">{{ $c->name }}</button>
            </li>
            @endif
        @endforeach
    </ul>
</div>
<!-- END: Pricing Tab -->
<!-- BEGIN: Pricing Content -->
<div class="d-flex mt-10">
    <div class="tab-content">
        @foreach ($category as $ca)
        @if ($category_first->id == $ca->id)
        <div class="tab-pane fade show active" id="category{{ $ca->id }}" role="tabpanel" aria-labelledby="layout-1-monthly-fees-tab">

            <div class="pos intro-y grid columns-12 gap-7 mt-7">
                <!-- BEGIN: Item List -->
                <div class="intro-y g-col-12 g-col-lg-8">
                    <div class="grid columns-12 gap-5 mt-5 pt-5 border-top border-theme-5 dark-border-dark-3">
                        @foreach ($ca->product as $item)
                        <a href="javascript:;" data-bs-toggle="modal" data-bs-target="#modal-tambah-{{ $item->id }}" id="tambah{{ $item->id }}" class="intro-y d-block g-col-12 g-col-sm-4 g-col-xxl-3">
                            <div class="box rounded-2 p-3 position-relative zoom-in">
                                <div class="flex-none pos-image position-relative d-block">
                                    <div class="pos-image__preview image-fit">
                                        @if ($item->foto == null || $item->foto == '')
                                        <img alt="Rubick Bootstrap HTML Admin Template" src="{{ asset('office/dist/images/food-beverage-14.jpg') }}">
                                        @else
                                        <img alt="Rubick Bootstrap HTML Admin Template" src="{{ asset('storage/product/'.$item->foto) }}">
                                        @endif

                                    </div>
                                </div>
                                <div class="d-block fw-medium text-center truncate mt-3">{{ $item->name }}</div>
                                <div class="d-block fw-medium text-center truncate mt-3">{{ number_format($item->price, 0, ',','.') }}</div>
                            </div>
                        </a>
                        <div id="modal-tambah-{{ $item->id }}" class="modal fade" tabindex="-1" aria-hidden="true">
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
                                    <form action="{{ route('bookingorder', $item->id) }}" method="POST">
                                        @csrf
                                        <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                                            <div class="g-col-12">
                                                <label for="pos-form-1" class="form-label">Produk</label>
                                                <input  type="text" class="form-control flex-1" value="{{ $item->name }}" id="product" disabled>
                                            </div>
                                            <div class="g-col-12">
                                                <label for="pos-form-2" class="form-label">No Pol Kendaraan</label>
                                                <input  type="text" name="no_pol_kendaraan" class="form-control flex-1" placeholder="XX XXXX XXX" id="no_pol_kendaraan" required>
                                            </div>
                                            <div class="g-col-12">
                                                <label for="pos-form-3" class="form-label">Tipe Mobil</label>
                                                <select name="tipe_mobil" id="tipe_mobil" class="form-control flex-1" required>
                                                    <option value="">-- Pilih Tipe Mobil --</option>
                                                    @foreach ($tipemobil as $tipe)
                                                        <option value="{{ $tipe->id }}">{{ $tipe->name }}</option>
                                                    @endforeach
                                                    <option value="Lainnya">LAINNYA</option>
                                                </select>
                                            </div>

                                            <div class="g-col-12">
                                                <label for="pos-form-4" class="form-label">No WA</label>
                                                <input  type="number" name="phone" class="form-control flex-1" placeholder="0812XXXXXXXX" id="phone" min="0" required>
                                            </div>
                                            <div class="g-col-12">
                                                <label for="pos-form-5" class="form-label">Tanggal Booking</label>
                                                <input  type="date" name="tgl_booking" class="form-control flex-1" id="tgl_booking" required>
                                            </div>
                                            <div class="g-col-12">
                                                <label for="pos-form-6" class="form-label">Waktu Booking</label>
                                                <input  type="time" name="waktu_booking" class="form-control flex-1" id="waktu_booking" required>
                                            </div>
                                            {{-- <div class="g-col-12">
                                                <label for="pos-form-7" class="form-label">Layanan</label>
                                                <select id="layanan" name="layanan" class="form-control flex-1" required>
                                                    <option value="">-- Pilih Layanan --</option>
                                                    <option value="Visit">Visit</option>
                                                    <option value="Delivery">Delivery</option>
                                                </select>
                                            </div> --}}
                                            <div class="g-col-12">
                                                <label for="pos-form-7" class="form-label">Status Kendaraan</label>
                                                <select id="status_kendaraan" name="status_kendaraan" class="form-control flex-1" required>
                                                    <option value="">-- Pilih Status Kendaraan --</option>
                                                    <option value="Ditunggu">Ditunggu</option>
                                                    <option value="Ditinggal">Ditinggal</option>
                                                </select>
                                            </div>

                                        </div>
                                        <!-- END: Modal Body -->
                                        <!-- BEGIN: Modal Footer -->
                                        <div class="modal-footer text-end">
                                            <button type="button" data-bs-dismiss="modal" class="btn btn-outline-secondary w-32 me-1" id="cencel">Cancel</button>
                                            <button type="submit" class="btn btn-primary w-32" id="simpan">Simpan</button>
                                        </div>
                                    </form>

                                    <!-- END: Modal Footer -->
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                <!-- END: Item List -->
            </div>

        </div>
        @else
        <div class="tab-pane fade" id="category{{ $ca->id }}" role="tabpanel" aria-labelledby="layout-1-monthly-fees-tab">
            <div class="pos intro-y grid columns-12 gap-7 mt-7">
                <!-- BEGIN: Item List -->
                <div class="intro-y g-col-12 g-col-lg-8">
                    <div class="grid columns-12 gap-5 mt-5 pt-5 border-top border-theme-5 dark-border-dark-3">
                        @foreach ($ca->product as $item)
                        <a href="javascript:;" data-bs-toggle="modal" data-bs-target="#modal-tambah-{{ $item->id }}" id="tambah{{ $item->id }}" class="intro-y d-block g-col-12 g-col-sm-4 g-col-xxl-3">
                            <div class="box rounded-2 p-3 position-relative zoom-in">
                                <div class="flex-none pos-image position-relative d-block">
                                    <div class="pos-image__preview image-fit">
                                        @if ($item->foto == null || $item->foto == '')
                                        <img alt="Rubick Bootstrap HTML Admin Template" src="{{ asset('office/dist/images/food-beverage-14.jpg') }}">
                                        @else
                                        <img alt="Rubick Bootstrap HTML Admin Template" src="{{ asset('storage/product/'.$item->foto) }}">
                                        @endif
                                    </div>
                                </div>
                                <div class="d-block fw-medium text-center truncate mt-3">{{ $item->name }}</div>
                                <div class="d-block fw-medium text-center truncate mt-3">{{ number_format($item->price, 0, ',','.') }}</div>
                            </div>
                        </a>
                        <div id="modal-tambah-{{ $item->id }}" class="modal fade" tabindex="-1" aria-hidden="true">
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
                                    <form action="{{ route('bookingorder', $item->id) }}" method="POST">
                                        @csrf
                                        <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                                            <div class="g-col-12">
                                                <label for="pos-form-1" class="form-label">Produk</label>
                                                <input  type="text" class="form-control flex-1" value="{{ $item->name }}" id="product" disabled>
                                            </div>
                                            <div class="g-col-12">
                                                <label for="pos-form-2" class="form-label">No Pol Kendaraan</label>
                                                <input  type="text" name="no_pol_kendaraan" class="form-control flex-1" placeholder="XX XXXX XXX" id="no_pol_kendaraan" required>
                                            </div>
                                            <div class="g-col-12">
                                                <label for="pos-form-3" class="form-label">Tipe Mobil</label>
                                                <select name="tipe_mobil" id="tipe_mobil" class="form-control flex-1" required>
                                                    <option value="">-- Pilih Tipe Mobil --</option>
                                                    @foreach ($tipemobil as $tipe)
                                                        <option value="{{ $tipe->id }}">{{ $tipe->name }}</option>
                                                    @endforeach
                                                    <option value="Lainnya">LAINNYA</option>
                                                </select>
                                            </div>

                                            <div class="g-col-12">
                                                <label for="pos-form-4" class="form-label">No WA</label>
                                                <input  type="number" name="phone" class="form-control flex-1" placeholder="0812XXXXXXXX" id="phone" min="0" required>
                                            </div>
                                            <div class="g-col-12">
                                                <label for="pos-form-5" class="form-label">Tanggal Booking</label>
                                                <input  type="date" name="tgl_booking" class="form-control flex-1" id="tgl_booking" required>
                                            </div>
                                            <div class="g-col-12">
                                                <label for="pos-form-6" class="form-label">Waktu Booking</label>
                                                <input  type="time" name="waktu_booking" class="form-control flex-1" id="waktu_booking" required>
                                            </div>
                                            <div class="g-col-12">
                                                <label for="pos-form-7" class="form-label">Layanan</label>
                                                <select id="layanan" name="layanan" class="form-control flex-1" required>
                                                    <option value="">-- Pilih Layanan --</option>
                                                    <option value="Visit">Visit</option>
                                                    <option value="Delivery">Delivery</option>
                                                </select>
                                            </div>

                                        </div>
                                        <!-- END: Modal Body -->
                                        <!-- BEGIN: Modal Footer -->
                                        <div class="modal-footer text-end">
                                            <button type="button" data-bs-dismiss="modal" class="btn btn-outline-secondary w-32 me-1" id="cencel">Cancel</button>
                                            <button type="submit" class="btn btn-primary w-32" id="simpan">Simpan</button>
                                        </div>
                                    </form>

                                    <!-- END: Modal Footer -->
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                <!-- END: Item List -->
            </div>

        </div>

        @endif

        @endforeach

    </div>
</div>

@endsection
@section('js')
<script
  src="https://code.jquery.com/jquery-3.6.0.js"
  integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
  crossorigin="anonymous"></script>
    <script>
        $('#tipe_mobil').change(function () {
            if ($('#tipe_mobil').val() == 'Lainnya') {
                $('#kolom_lainnya').show()
                $('#kolom_lainnya').prop('required',true);
            } else {
                $('#kolom_lainnya').hide()
                $('#kolom_lainnya').prop('required',false);
            }
        })
    </script>
@endsection
