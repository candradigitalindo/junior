@extends('layouts.landing')
@section('title')
Kontak Kami
@endsection
@section('content')

<!-- Breadcrumb row -->
<div class="breadcrumb-row">
    <div class="container">
        <ul class="list-inline">
            <li><a href="{{ route('landing.index') }}">Home</a></li>
            <li>Kontak Kami</li>
        </ul>
    </div>
</div>
<!-- Breadcrumb row END -->
<!-- contact area -->
<div class="section-full content-inner bg-white contact-style-1">
    <div class="container">
        <div class="row">
            <!-- right part start -->
            <div class="col-lg-4 col-md-6 d-lg-flex d-md-flex">
                <div class="p-a30 m-b30 border contact-area border-1">
                    <h2 class="m-b10">Quick Contact</h2>

                    <ul class="no-margin">
                        <li class="icon-bx-wraper left m-b30">
                            <div class="icon-bx-xs border-1"> <a href="#" class="icon-cell"><i class="ti-location-pin"></i></a> </div>
                            <div class="icon-content">
                                <h6 class="text-uppercase m-tb0 dlab-tilte">Address:</h6>
                                <p>Jl. Perjuangan No.23, Tj. Rejo, Kec. Medan Sunggal, Kota Medan, Sumatera Utara 20122.</p>
                            </div>
                        </li>

                        <li class="icon-bx-wraper left">
                            <div class="icon-bx-xs border-1"> <a href="#" class="icon-cell"><i class="ti-mobile"></i></a> </div>
                            <div class="icon-content">
                                <h6 class="text-uppercase m-tb0 dlab-tilte">Telp/Whatsapp</h6>
                                <p>0821 6061 9089</p>
                            </div>
                        </li>
                    </ul>
                    <div class="m-t20">
                        <ul class="dlab-social-icon dez-border dlab-social-icon-lg">
                            <li><a class="fab fa-instagram bg-primary" href="https://www.instagram.com/juniorwash/" target="blank"></a></li>

                        </ul>
                    </div>
                </div>
            </div>
            <!-- right part END -->

            <div class="col-lg-6 col-md-12 d-lg-flex m-b30">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3981.998457728564!2d98.63365701475854!3d3.587827797389132!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x30312f4961de63c9%3A0x491beb8cad721b72!2sKilat%20Premium%20Wash%20%26%20Lab!5e0!3m2!1sen!2sid!4v1643085659481!5m2!1sen!2sid" style="border:0; width:100%; min-height:100%;" allowfullscreen></iframe>
            </div>

        </div>
    </div>
</div>
<!-- contact area  END -->
@endsection
