@extends('layouts.landing')
@section('title')
Layanan Kami
@endsection
@section('content')
<div class="section-full bg-white content-inner">
    <div class="container">
        <div class="section-head text-center">
            <h2 class="text-uppercase"> OUR SERVICES</h2>
            <div class="dlab-separator-outer ">
                <div class="dlab-separator bg-secondry style-skew"></div>
            </div>
            {{-- <p>There are many variations of passages of Lorem Ipsum typesetting industry has been the industry's standard dummy text ever since the been when an unknown printer.</p> --}}
        </div>
        <div class="site-filters clearfix center  m-b40">
            <ul class="filters" data-bs-toggle="buttons">
                <li data-filter="" class="btn active">
                    <input type="radio">
                    <a href="#" class="site-button-secondry"><span>Show All</span></a> </li>
                @foreach ($category as $c)
                <li data-filter="category-{{ $c->id }}" class="btn">
                    <input type="radio" >
                    <a href="#" class="site-button-secondry"><span>{{ $c->name }}</span></a> </li>
                @endforeach

            </ul>
        </div>
        <ul id="masonry" class="row dlab-gallery-listing gallery-grid-4 lightgallery gallery s m-b0">
            @foreach ($product as $item)

            <li class="category-{{ $item->category_id }} card-container col-lg-4 col-md-4 col-sm-6 col-6 product-item card-container">
                <div class="dlab-box dlab-gallery-box">
                    <div class="dlab-box ">
                        @if ($item->foto == null || $item->foto == '')
                        <div class="dlab-thum-bx  dlab-img-effect "> <img src="{{ asset('landing/images/product/item1.jpg') }}" alt="{{ $item->name }}"></div>

                        @else
                        <div class="dlab-thum-bx  dlab-img-effect "> <img src="{{ asset('storage/product/'.$item->foto) }}" alt="{{ $item->name }}"></div>
                        @endif
                        <div class="dlab-info p-a20 text-center">
                            <h4 class="dlab-title m-t0 text-uppercase"><a href="#">{{ $item->name }}</a></h4>
                            <h2 class="m-b0">{{ number_format($item->price, 0, ',','.') }} </h2>
                            <div class="m-t20">
                                <a href="#" data-bs-toggle="modal" data-bs-target="#modal-tambah-{{ $item->id }}" id="tambah{{ $item->id }}" class="site-button">Booking</a><br><br>
                                <a href="#" data-bs-toggle="modal" data-bs-target="#modal-detail-{{ $item->id }}" id="detail{{ $item->id }}" class="site-button">Detail</a>
                            </div>
                        </div>
                        {{-- <div class="sale">
                            <span class="site-button button-sm">Sale</span>
                        </div> --}}
                    </div>
                </div>
            </li>
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
                        <form action="{{ route('landing.bookingorder', $item->id) }}" method="POST">
                            @csrf
                            <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                                <div class="g-col-12">
                                    <label for="pos-form-1" class="form-label">Layanan</label>
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
                                <div class="g-col-12" style="display: none" id="kolom_lainnya">
                                    <label for="pos-form-4" class="form-label">Tipe Mobil Lainnya</label>
                                    <input  type="text" name="lainnya" class="form-control flex-1" id="lainnya">
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
                                    <label for="pos-form-7" class="form-label">Metode Layanan</label>
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
            <div id="modal-detail-{{ $item->id }}" class="modal fade" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <!-- BEGIN: Modal Header -->
                        <div class="modal-header">
                            <h2 class="fw-medium fs-base me-auto">
                                Info Jasa Layanan {{ $item->name }}
                            </h2>
                        </div>
                        <!-- END: Modal Header -->
                        <!-- BEGIN: Modal Body -->
                            <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                                <div class="g-col-12">
                                    <p align="justify">{{ $item->description }}</p>
                                </div>
                            </div>
                            <!-- END: Modal Body -->
                            <!-- BEGIN: Modal Footer -->
                            <div class="modal-footer text-end">
                                <button type="button" data-bs-dismiss="modal" class="btn btn-outline-secondary w-32 me-1" id="cencel">Tutup</button>
                            </div>

                        <!-- END: Modal Footer -->
                    </div>
                </div>
            </div>
            @endforeach


        </ul>
    </div>
</div>
@endsection
@section('js')
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
