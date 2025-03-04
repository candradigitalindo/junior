@extends('layouts.landing')
@section('title')
Booking
@endsection
@section('content')
<!-- Testimonials blog -->
<div class="section-full overlay-black-middle bg-img-fix content-inner-1" style="background-image:url({{ asset('landing/images/background/bg-kilat.jpg') }});">
    <div class="container">
        <div class="section-head text-white text-center">
            <h2 class="text-uppercase">Tabel Informasi Booking</h2>
            <h4 class="text-uppercase">{{ date('d M Y') }}</h4>
            <div class="dlab-separator-outer ">
                <div class="dlab-separator bg-white  style-skew"></div>
            </div>
        </div>
        <table class="table table-dark table-striped" id="tabel-booking">
            <thead>
                <tr>
                    <th class="text-nowrap" style="width: 1%"><font color="white">No</font> </th>
                    <th class="text-nowrap" style="width: 80%"><font color="white">Informasi</font></th>
                </tr>
            </thead>
            <tbody>
                @php
                    $no =1;
                @endphp
                @foreach ($booking as $item)
                <tr>
                    <td><font color="white">{{ $no++ }}</font></td>
                    <td><font color="white">
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <tbody>
                                <tr>
                                    <td style="width: 20%"><font color="white">Kendaraan</font></td>
                                    <td style="width: 2%"><font color="white">:</font></td>
                                    <td style="width: 50%"><font color="white">
                                        {{ $item->no_pol_kendaraan }}
                                    </font></td>
                                </tr>

                                <tr>
                                    <td style="width: 20%"><font color="white">Status</font></td>
                                    <td style="width: 2%"><font color="white">:</font></td>
                                    <td style="width: 50%"><font color="white">
                                        {{ $item->status }}
                                    </font></td>
                                </tr>
                                <tr>
                                    <td style="width: 20%"><font color="white">Waktu Booking</font></td>
                                    <td style="width: 2%"><font color="white">:</font></td>
                                    <td style="width: 50%"><font color="white">
                                        {{ $item->waktu_booking }} WIB
                                    </font></td>
                                </tr>
                                <tr>
                                    <td style="width: 20%"><font color="white">Pekerjaan</font></td>
                                    <td style="width: 2%"><font color="white">:</font></td>
                                    <td style="width: 50%"><font color="white">
                                        @foreach ($item->histori as $h)
                                            - {{ $h->histori }} <br>
                                        @endforeach
                                    </font></td>
                                </tr>
                                {{-- <tr >
                                    @if ($item->photo_tipe_mobil == null || $item->photo_tipe_mobil == '')
                                        <td colspan="3" style="margin: 0 auto;" ><font color="white">
                                            <center><img src="{{ asset('image/no_photo_tipe_mobil.png') }}"  style="width: 250px; height: 60px; padding: 0px; box-sizing: border-box; "></div></center>
                                        </font></td>
                                    @else
                                        <td colspan="3" style="margin: 0 auto;" ><font color="white">
                                            <center><img src="{{ asset('storage/tipemobil/'.$item->photo_tipe_mobil) }}"  style="width: 250px; height: 90px; padding: 0px; box-sizing: border-box; "></div></center>
                                            <center><h3><font color="white">{{ $item->tipe_mobil }}</font></h3></center>
                                        </font></td>
                                    @endif
                                </tr> --}}

                            </tbody>
                        </table>
                    </font></td>

                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<!-- Testimonials blog END -->
@endsection

