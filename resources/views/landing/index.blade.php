@extends('layouts.landing')
@section('tagmeta')
    <meta name="keywords" content="{{ $tagmeta->keywords }}" />
    <meta name="author" content="Kilat" />
    <meta name="robots" content="" />
    <meta name="description" content="{{ $tagmeta->description }}" />
@endsection
@section('title')
    Kilat Premium Wash And Lab | More Than Just Carwash And Detailing
@endsection
@section('content')
    <!-- Slider -->
    <div class="main-slider style-two default-banner">
        <div class="tp-banner-container">
            <div class="tp-banner">
                <div id="rev_slider_1014_1_wrapper" class="rev_slider_wrapper fullscreen-container"
                    data-alias="typewriter-effect" data-source="gallery">
                    <!-- START REVOLUTION SLIDER 5.3.0.2 -->
                    <div id="rev_slider_1014_1" class="rev_slider fullscreenbanner" style="display:none;"
                        data-version="5.3.0.2">
                        <ul>
                            <!-- SLIDE 1 -->
                            <li data-index="rs-1000" data-transition="slidingoverlayhorizontal" data-slotamount="default"
                                data-hideafterloop="0" data-hideslideonmobile="off" data-easein="default"
                                data-easeout="default" data-masterspeed="default"
                                data-thumb="{{ asset('landing/images/main-slider/Slide1.jpg') }}" data-rotate="0"
                                data-saveperformance="off" data-title="Slide" data-param1="" data-param2="" data-param3=""
                                data-param4="" data-param5="" data-param6="" data-param7="" data-param8="" data-param9=""
                                data-param10="" data-description="">
                                <!-- MAIN IMAGE -->
                                <img src="{{ asset('landing/images/main-slider/Slide1.jpg') }}" alt=""
                                    data-bgposition="center center" data-bgfit="cover" data-bgrepeat="no-repeat"
                                    class="rev-slidebg" data-no-retina />
                                <!-- LAYER NR. 1 [ for overlay ] -->
                                <div class="tp-caption tp-shape tp-shapewrapper " id="slide-100-layer-1"
                                    data-x="['center','center','center','center']" data-hoffset="['0','0','0','0']"
                                    data-y="['middle','middle','middle','middle']" data-voffset="['0','0','0','0']"
                                    data-width="full" data-height="full" data-whitespace="nowrap" data-type="shape"
                                    data-basealign="slide" data-responsive_offset="off" data-responsive="off"
                                    data-frames='[{"from":"opacity:0;","speed":1000,"to":"o:1;","delay":0,"ease":"Power4.easeOut"},{"delay":"wait","speed":1000,"to":"opacity:0;","ease":"Power4.easeOut"}]'
                                    data-textAlign="['left','left','left','left']" data-paddingtop="[0,0,0,0]"
                                    data-paddingright="[0,0,0,0]" data-paddingbottom="[0,0,0,0]"
                                    data-paddingleft="[0,0,0,0]"
                                    style="z-index: 12;background-color:rgba(0, 0, 0, 0.50);border-color:rgba(0, 0, 0, 0);border-width:0px;">
                                </div>

                                <!-- LAYER NR. 2 [ for title ] -->
                                <div class="tp-caption tp-resizeme" id="slide-100-layer-2"
                                    data-x="['left','left','left','left']" data-hoffset="['30','30','30','30']"
                                    data-y="['top','top','top','top']" data-voffset="['150','110','110','70']"
                                    data-fontsize="['55','55','55','36']" data-lineheight="['60','60','60','46']"
                                    data-width="['800','800','800','800']" data-height="['none','none','none','none']"
                                    data-whitespace="['normal','normal','normal','normal']" data-type="text"
                                    data-responsive_offset="on"
                                    data-frames='[{"from":"y:50px(R);opacity:0;","speed":1500,"to":"o:1;","delay":500,"ease":"Power4.easeOut"},{"delay":"wait","speed":1000,"to":"y:-50px;opacity:0;","ease":"Power2.easeInOut"}]'
                                    data-textAlign="['left','left','left','left']" data-paddingtop="[0,0,0,0]"
                                    data-paddingright="[0,0,0,0]" data-paddingbottom="[0,0,0,0]"
                                    data-paddingleft="[0,0,0,0]"
                                    style="z-index: 13; white-space: normal; font-size: 60px; line-height: 60px; font-weight: 700; color: rgba(255, 255, 255, 1.00); border-width:0px;">
                                    <span class="text-uppercase" style="font-family: 'Poppins',sans-serif;">Premium Wash &
                                        Lab</span>
                                </div>

                                <!-- LAYER NR. 3 [ for paragraph] -->
                                <div class="tp-caption tp-resizeme" id="slide-100-layer-3"
                                    data-x="['left','left','left','left']" data-hoffset="['30','30','30','30']"
                                    data-y="['top','top','top','top']" data-voffset="['300','250','250','190']"
                                    data-fontsize="['20','20','20','20']" data-lineheight="['30','30','30','30']"
                                    data-width="['800','800','700','420']" data-height="['none','none','none','none']"
                                    data-whitespace="['normal','normal','normal','normal']" data-type="text"
                                    data-responsive_offset="on"
                                    data-frames='[
                                                            {"from":"y:50px(R);opacity:0;","speed":1500,"to":"o:1;","delay":500,"ease":"Power4.easeOut"},
                                                            {"delay":"wait","speed":1000,"to":"y:-50px;opacity:0;","ease":"Power2.easeInOut"}]'
                                    data-textAlign="['left','left','left','left']" data-paddingtop="[0,0,0,0]"
                                    data-paddingright="[0,0,0,0]" data-paddingbottom="[0,0,0,0]"
                                    data-paddingleft="[0,0,0,0]"
                                    style="z-index: 13; font-weight: 500; color: rgba(255, 255, 255, 0.85); border-width:0px;">
                                    <span> Premium Car Wash – One Step Polish – Body Care – Treatment – Coating –
                                        Restoration </span>
                                </div>

                                <!-- LAYER NR. 4 [ for readmore botton ] -->
                                <div class="tp-caption tp-resizeme" id="slide-100-layer-4"
                                    data-x="['left','left','left','left']" data-hoffset="['30','30','30','30']"
                                    data-y="['top','top','top','top']" data-voffset="['420','370','370','370']"
                                    data-fontsize="['none','none','none','none']"
                                    data-lineheight="['none','none','none','none']" data-width="['700','700','700','700']"
                                    data-height="['none','none','none','none']" data-fontweight="['700','700','700','700']"
                                    data-whitespace="['normal','normal','normal','normal']" data-type="text"
                                    data-responsive_offset="on"
                                    data-frames='[
                                                            {"from":"y:50px(R);opacity:0;","speed":1500,"to":"o:1;","delay":500,"ease":"Power4.easeOut"},
                                                            {"delay":"wait","speed":1000,"to":"y:-50px;opacity:0;","ease":"Power2.easeInOut"}]'
                                    data-textAlign="['left','left','left','left']" data-paddingtop="[0,0,0,0]"
                                    data-paddingright="[0,0,0,0]" data-paddingbottom="[0,0,0,0]"
                                    data-paddingleft="[0,0,0,0]" style="z-index: 13;">
                                    <a href="{{ route('landing.layanan') }}" class="site-button button-skew"><span>Booking
                                            Now</span><i class="fas fa-angle-right"></i></a>
                                </div>
                            </li>
                            <!-- SLIDE 2 -->
                            <li data-index="rs-2000" data-transition="slidingoverlayhorizontal" data-slotamount="default"
                                data-hideafterloop="0" data-hideslideonmobile="off" data-easein="default"
                                data-easeout="default" data-masterspeed="default"
                                data-thumb="{{ asset('landing/images/main-slider/Slide2.jpg') }}" data-rotate="0"
                                data-saveperformance="off" data-title="Slide" data-param1="" data-param2="" data-param3=""
                                data-param4="" data-param5="" data-param6="" data-param7="" data-param8="" data-param9=""
                                data-param10="" data-description="">
                                <!-- MAIN IMAGE -->
                                <img src="{{ asset('landing/images/main-slider/Slide2.jpg') }}" alt=""
                                    data-bgposition="center center" data-bgfit="cover" data-bgrepeat="no-repeat"
                                    class="rev-slidebg" data-no-retina />
                                <!-- LAYERS -->
                                <!-- LAYER NR. 1 [ for overlay ] -->
                                <div class="tp-caption tp-shape tp-shapewrapper " id="slide-200-layer-1"
                                    data-x="['center','center','center','center']" data-hoffset="['0','0','0','0']"
                                    data-y="['middle','middle','middle','middle']" data-voffset="['0','0','0','0']"
                                    data-width="full" data-height="full" data-whitespace="nowrap" data-type="shape"
                                    data-basealign="slide" data-responsive_offset="off" data-responsive="off"
                                    data-frames='[{"from":"opacity:0;","speed":1000,"to":"o:1;","delay":0,"ease":"Power4.easeOut"},{"delay":"wait","speed":1000,"to":"opacity:0;","ease":"Power4.easeOut"}]'
                                    data-textAlign="['left','left','left','left']" data-paddingtop="[0,0,0,0]"
                                    data-paddingright="[0,0,0,0]" data-paddingbottom="[0,0,0,0]"
                                    data-paddingleft="[0,0,0,0]"
                                    style="z-index: 12;background-color:rgba(0, 0, 0, 0.50);border-color:rgba(0, 0, 0, 0);border-width:0px;">
                                </div>
                                <!-- LAYER NR. 2 [ for title ] -->
                                <div class="tp-caption tp-resizeme" id="slide-200-layer-2"
                                    data-x="['left','left','left','left']" data-hoffset="['30','30','30','30']"
                                    data-y="['top','top','top','top']" data-voffset="['150','110','110','70']"
                                    data-fontsize="['55','55','55','36']" data-lineheight="['60','60','60','46']"
                                    data-width="['800','800','800','800']" data-height="['none','none','none','none']"
                                    data-whitespace="['normal','normal','normal','normal']" data-type="text"
                                    data-responsive_offset="on"
                                    data-frames='[{"from":"y:50px(R);opacity:0;","speed":1500,"to":"o:1;","delay":500,"ease":"Power4.easeOut"},{"delay":"wait","speed":1000,"to":"y:-50px;opacity:0;","ease":"Power2.easeInOut"}]'
                                    data-textAlign="['left','left','left','left']" data-paddingtop="[0,0,0,0]"
                                    data-paddingright="[0,0,0,0]" data-paddingbottom="[0,0,0,0]"
                                    data-paddingleft="[0,0,0,0]"
                                    style="z-index: 13; white-space: normal; font-size: 60px; line-height: 60px; font-weight: 700; color: rgba(255, 255, 255, 1.00); border-width:0px;">
                                    <span class="text-uppercase" style="font-family: 'Poppins',sans-serif;">Premium Wash &
                                        Lab</span>
                                </div>

                                <!-- LAYER NR. 3 [ for paragraph] -->
                                <div class="tp-caption tp-resizeme" id="slide-200-layer-3"
                                    data-x="['left','left','left','left']" data-hoffset="['30','30','30','30']"
                                    data-y="['top','top','top','top']" data-voffset="['300','250','250','190']"
                                    data-fontsize="['20','20','20','20']" data-lineheight="['30','30','30','30']"
                                    data-width="['800','800','700','420']" data-height="['none','none','none','none']"
                                    data-whitespace="['normal','normal','normal','normal']" data-type="text"
                                    data-responsive_offset="on"
                                    data-frames='[
                                                            {"from":"y:50px(R);opacity:0;","speed":1500,"to":"o:1;","delay":500,"ease":"Power4.easeOut"},
                                                            {"delay":"wait","speed":1000,"to":"y:-50px;opacity:0;","ease":"Power2.easeInOut"}]'
                                    data-textAlign="['left','left','left','left']" data-paddingtop="[0,0,0,0]"
                                    data-paddingright="[0,0,0,0]" data-paddingbottom="[0,0,0,0]"
                                    data-paddingleft="[0,0,0,0]"
                                    style="z-index: 13; font-weight: 500; color: rgba(255, 255, 255, 0.85); border-width:0px;">
                                    <span> Premium Car Wash – One Step Polish – Body Care – Treatment – Coating –
                                        Restoration </span>
                                </div>

                                <!-- LAYER NR. 4 [ for readmore botton ] -->
                                <div class="tp-caption tp-resizeme" id="slide-200-layer-4"
                                    data-x="['left','left','left','left']" data-hoffset="['30','30','30','30']"
                                    data-y="['top','top','top','top']" data-voffset="['420','370','370','370']"
                                    data-fontsize="['none','none','none','none']"
                                    data-lineheight="['none','none','none','none']" data-width="['700','700','700','700']"
                                    data-height="['none','none','none','none']"
                                    data-whitespace="['normal','normal','normal','normal']" data-type="text"
                                    data-responsive_offset="on"
                                    data-frames='[
                                                            {"from":"y:50px(R);opacity:0;","speed":1500,"to":"o:1;","delay":500,"ease":"Power4.easeOut"},
                                                            {"delay":"wait","speed":1000,"to":"y:-50px;opacity:0;","ease":"Power2.easeInOut"}]'
                                    data-textAlign="['left','left','left','left']" data-paddingtop="[0,0,0,0]"
                                    data-paddingright="[0,0,0,0]" data-paddingbottom="[0,0,0,0]"
                                    data-paddingleft="[0,0,0,0]" style="z-index: 13;"><a
                                        href="{{ route('landing.layanan') }}"
                                        class="site-button  button-skew"><span>Booking Now</span><i
                                            class="fas fa-angle-right"></i></a>
                                </div>
                            </li>
                            <!-- SLIDE 3 -->
                            <li data-index="rs-3000" data-transition="slidingoverlayhorizontal" data-slotamount="default"
                                data-hideafterloop="0" data-hideslideonmobile="off" data-easein="default"
                                data-easeout="default" data-masterspeed="default"
                                data-thumb="{{ asset('landing/images/main-slider/Slide3.jpg') }}" data-rotate="0"
                                data-saveperformance="off" data-title="Slide" data-param1="" data-param2="" data-param3=""
                                data-param4="" data-param5="" data-param6="" data-param7="" data-param8="" data-param9=""
                                data-param10="" data-description="">
                                <!-- MAIN IMAGE -->
                                <img src="{{ asset('landing/images/main-slider/Slide3.jpg') }}" alt=""
                                    data-bgposition="center center" data-bgfit="cover" data-bgrepeat="no-repeat"
                                    class="rev-slidebg" data-no-retina />
                                <!-- LAYERS -->
                                <!-- LAYER NR. 1 [ for overlay ] -->
                                <div class="tp-caption tp-shape tp-shapewrapper " id="slide-300-layer-1"
                                    data-x="['center','center','center','center']" data-hoffset="['0','0','0','0']"
                                    data-y="['middle','middle','middle','middle']" data-voffset="['0','0','0','0']"
                                    data-width="full" data-height="full" data-whitespace="nowrap" data-type="shape"
                                    data-basealign="slide" data-responsive_offset="off" data-responsive="off"
                                    data-frames='[{"from":"opacity:0;","speed":1000,"to":"o:1;","delay":0,"ease":"Power4.easeOut"},{"delay":"wait","speed":1000,"to":"opacity:0;","ease":"Power4.easeOut"}]'
                                    data-textAlign="['left','left','left','left']" data-paddingtop="[0,0,0,0]"
                                    data-paddingright="[0,0,0,0]" data-paddingbottom="[0,0,0,0]"
                                    data-paddingleft="[0,0,0,0]"
                                    style="z-index: 12;background-color:rgba(0, 0, 0, 0.50);border-color:rgba(0, 0, 0, 0);border-width:0px;">
                                </div>
                                <!-- LAYER NR. 2 [ for title ] -->
                                <div class="tp-caption tp-resizeme" id="slide-300-layer-2"
                                    data-x="['left','left','left','left']" data-hoffset="['30','30','30','30']"
                                    data-y="['top','top','top','top']" data-voffset="['150','110','110','70']"
                                    data-fontsize="['55','55','55','36']" data-lineheight="['60','60','60','46']"
                                    data-width="['800','800','800','800']" data-height="['none','none','none','none']"
                                    data-whitespace="['normal','normal','normal','normal']" data-type="text"
                                    data-responsive_offset="on"
                                    data-frames='[{"from":"y:50px(R);opacity:0;","speed":1500,"to":"o:1;","delay":500,"ease":"Power4.easeOut"},{"delay":"wait","speed":1000,"to":"y:-50px;opacity:0;","ease":"Power2.easeInOut"}]'
                                    data-textAlign="['left','left','left','left']" data-paddingtop="[0,0,0,0]"
                                    data-paddingright="[0,0,0,0]" data-paddingbottom="[0,0,0,0]"
                                    data-paddingleft="[0,0,0,0]"
                                    style="z-index: 13; white-space: normal; font-size: 60px; line-height: 60px; font-weight: 700; color: rgba(255, 255, 255, 1.00); border-width:0px;">
                                    <span class="text-uppercase" style="font-family: 'Poppins',sans-serif;">Premium Wash &
                                        Lab</span>
                                </div>

                                <!-- LAYER NR. 3 [ for paragraph] -->
                                <div class="tp-caption tp-resizeme" id="slide-300-layer-3"
                                    data-x="['left','left','left','left']" data-hoffset="['30','30','30','30']"
                                    data-y="['top','top','top','top']" data-voffset="['300','250','250','190']"
                                    data-fontsize="['20','20','20','20']" data-lineheight="['30','30','30','30']"
                                    data-width="['800','800','700','420']" data-height="['none','none','none','none']"
                                    data-whitespace="['normal','normal','normal','normal']" data-type="text"
                                    data-responsive_offset="on"
                                    data-frames='[
                                                            {"from":"y:50px(R);opacity:0;","speed":1500,"to":"o:1;","delay":500,"ease":"Power4.easeOut"},
                                                            {"delay":"wait","speed":1000,"to":"y:-50px;opacity:0;","ease":"Power2.easeInOut"}]'
                                    data-textAlign="['left','left','left','left']" data-paddingtop="[0,0,0,0]"
                                    data-paddingright="[0,0,0,0]" data-paddingbottom="[0,0,0,0]"
                                    data-paddingleft="[0,0,0,0]"
                                    style="z-index: 13; font-weight: 500; color: rgba(255, 255, 255, 0.85); border-width:0px;">
                                    <span>Premium Car Wash – One Step Polish – Body Care – Treatment – Coating –
                                        Restoration</span>
                                </div>

                                <!-- LAYER NR. 4 [ for readmore botton ] -->
                                <div class="tp-caption tp-resizeme" id="slide-300-layer-4"
                                    data-x="['left','left','left','left']" data-hoffset="['30','30','30','30']"
                                    data-y="['top','top','top','top']" data-voffset="['420','370','370','370']"
                                    data-fontsize="['none','none','none','none']"
                                    data-lineheight="['none','none','none','none']" data-width="['700','700','700','700']"
                                    data-height="['none','none','none','none']"
                                    data-whitespace="['normal','normal','normal','normal']" data-type="text"
                                    data-responsive_offset="on"
                                    data-frames='[
                                                            {"from":"y:50px(R);opacity:0;","speed":1500,"to":"o:1;","delay":500,"ease":"Power4.easeOut"},
                                                            {"delay":"wait","speed":1000,"to":"y:-50px;opacity:0;","ease":"Power2.easeInOut"}]'
                                    data-textAlign="['left','left','left','left']" data-paddingtop="[0,0,0,0]"
                                    data-paddingright="[0,0,0,0]" data-paddingbottom="[0,0,0,0]"
                                    data-paddingleft="[0,0,0,0]" style="z-index: 13;"><a
                                        href="{{ route('landing.layanan') }}"
                                        class="site-button   button-skew"><span>Booking Now</span><i
                                            class="fas fa-angle-right"></i></a>
                                </div>
                            </li>
                        </ul>
                        <div class="tp-bannertimer tp-bottom" style="visibility: hidden !important;"></div>
                    </div>
                </div>
                <!-- END REVOLUTION SLIDER -->
            </div>
        </div>
    </div>
    <!-- Slider END -->
    <!-- meet & ask -->
    <div class="section-full z-index100 meet-ask-outer bg-white">
        <div class="container">
            <div class="row">
                <div class="col-lg-9 meet-ask-row p-tb30">
                    <div class="row d-flex">
                        <div class="col-lg-6">
                            <div class="icon-bx-wraper clearfix text-white left">
                                <!--<div class="icon-xl "> <span class=" icon-cell"><img src="{{ asset('landing/images/nav-active.png') }}" alt="" style="width: 100px"></span> </div>-->
                                <div class="icon-content">
                                    <h3 class="dlab-tilte text-uppercase m-b10">CEK KENDARAAN</h3>
                                    <p>Silahkan masukan No. Polisi Kendaraan Anda pada kolom pengecekan</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 m-t20">
                            <input type="text" placeholder="XX XXXX XXX" id="no_pol_kendaraan">
                            <button type="button" class="site-button-secondry button-skew m-l10" id="cek">
                                <span>Check</span></i></button>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- meet & ask END -->

    <!-- OUR SERVICES -->
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
                        <a href="#" class="site-button-secondry"><span>Show All</span></a>
                    </li>
                    @foreach ($category as $c)
                        <li data-filter="category-{{ $c->id }}" class="btn">
                            <input type="radio">
                            <a href="#" class="site-button-secondry"><span>{{ $c->name }}</span></a>
                        </li>
                    @endforeach

                </ul>
            </div>
            <ul id="masonry" class="row dlab-gallery-listing gallery-grid-4 lightgallery gallery s m-b0">
                @foreach ($product as $item)
                    <li
                        class="category-{{ $item->category_id }} card-container col-lg-4 col-md-4 col-sm-6 col-6 product-item card-container">
                        <div class="dlab-box dlab-gallery-box">
                            <div class="dlab-box ">
                                @if ($item->foto == null || $item->foto == '')
                                    <div class="dlab-thum-bx  dlab-img-effect"> <img
                                            src="{{ asset('landing/images/product/item1.jpg') }}" class="img-responsive"
                                            alt="{{ $item->name }}"></div>
                                @else
                                    <div class="dlab-thum-bx  dlab-img-effect"> <img
                                            src="{{ asset('storage/product/' . $item->foto) }}"
                                            alt="{{ $item->name }}">
                                    </div>
                                @endif
                                <div class="dlab-info p-a20 text-center">
                                    <h4 class="dlab-title m-t0 text-uppercase"><a href="#">{{ $item->name }}</a></h4>
                                    <h2 class="m-b0">{{ number_format($item->price, 0, ',', '.') }} </h2>
                                    <div class="m-t20">
                                        <a href="#" data-bs-toggle="modal"
                                            data-bs-target="#modal-tambah-{{ $item->id }}"
                                            id="tambah{{ $item->id }}" class="site-button">Booking</a><br><br>
                                        <a href="#" data-bs-toggle="modal"
                                            data-bs-target="#modal-detail-{{ $item->id }}"
                                            id="detail{{ $item->id }}" class="site-button">Detail</a>
                                    </div>
                                </div>
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
                                            <input type="text" class="form-control flex-1" value="{{ $item->name }}"
                                                id="product" disabled>
                                        </div>
                                        <div class="g-col-12">
                                            <label for="pos-form-2" class="form-label">No Pol Kendaraan</label>
                                            <input type="text" name="no_pol_kendaraan" class="form-control flex-1"
                                                placeholder="XX XXXX XXX" id="no_pol_kendaraan" required>
                                        </div>
                                        <div class="g-col-12">
                                            <label for="pos-form-3" class="form-label">Tipe Mobil</label>
                                            <select name="tipe_mobil" id="tipe_mobil"
                                                class="tipe_mobil-{{ $item->id }} form-control flex-1" required>
                                                <option value="">-- Pilih Tipe Mobil --</option>
                                                @foreach ($tipemobil as $tipe)
                                                    <option value="{{ $tipe->id }}">{{ $tipe->name }}</option>
                                                @endforeach
                                                <option value="Lainnya">LAINNYA</option>
                                            </select>
                                        </div>

                                        <div class="kolom_lainnya-{{ $item->id }} g-col-12" style="display: none"
                                            id="kolom_lainnya">
                                            <label for="pos-form-4" class="form-label">Tipe Mobil Lainnya</label>
                                            <input type="text" name="lainnya" class="form-control flex-1" id="lainnya">
                                        </div>

                                        <div class="g-col-12">
                                            <label for="pos-form-4" class="form-label">No WA</label>
                                            <input type="number" name="phone" class="form-control flex-1"
                                                placeholder="0812XXXXXXXX" id="phone" min="0" required>
                                        </div>
                                        <div class="g-col-12">
                                            <label for="pos-form-5" class="form-label">Tanggal Booking</label>
                                            <input type="date" name="tgl_booking" class="form-control flex-1"
                                                id="tgl_booking" required>
                                        </div>
                                        <div class="g-col-12">
                                            <label for="pos-form-6" class="form-label">Waktu Booking</label>
                                            <input type="time" name="waktu_booking" class="form-control flex-1"
                                                id="waktu_booking" required>
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
                                        <button type="button" data-bs-dismiss="modal"
                                            class="btn btn-outline-secondary w-32 me-1" id="cencel">Cancel</button>
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
                                    <button type="button" data-bs-dismiss="modal"
                                        class="btn btn-outline-secondary w-32 me-1" id="cencel">Tutup</button>
                                </div>

                                <!-- END: Modal Footer -->
                            </div>
                        </div>
                    </div>
                @endforeach


            </ul>
        </div>
    </div>
    <!-- OUR SERVICES END-->
    <!-- About Company END -->
    <!-- Our Projects  -->
    <div class="section-full bg-img-fix content-inner overlay-black-middle"
        style="background-image:url({{ asset('landing/images/background/bg-kilat.jpg') }});">
        <div class="container">
            <div class="section-head  text-center text-white">
                <h2 class="text-uppercase">Our Projects</h2>
                <div class="dlab-separator-outer ">
                    <div class="dlab-separator bg-white style-skew"></div>
                </div>
                {{-- <p>There are many variations of passages of Lorem Ipsum typesetting industry has been the industry's standard dummy text ever since the been when an unknown printer.</p> --}}
            </div>
            {{-- <div class="site-filters clearfix center  m-b40">
            <ul class="filters" data-bs-toggle="buttons">
                <li data-filter="" class="btn active">
                    <input type="radio">
                    <a href="#" class="site-button-secondry"><span>Show All</span></a> </li>
                <li data-filter="home" class="btn">
                    <input type="radio" >
                    <a href="#" class="site-button-secondry"><span>Brakes</span></a> </li>
                <li data-filter="office" class="btn">
                    <input type="radio">
                    <a href="#" class="site-button-secondry"><span>Suspension</span></a> </li>
                <li data-filter="commercial" class="btn">
                    <input type="radio">
                    <a href="#" class="site-button-secondry"><span>Wheels</span></a> </li>
                <li data-filter="window" class="btn">
                    <input type="radio">
                    <a href="#" class="site-button-secondry"><span>Steering	</span></a> </li>
            </ul>
        </div> --}}
            <ul id="masonry1" class="row dlab-gallery-listing gallery-grid-4 lightgallery gallery s m-b0">

                @foreach ($galery as $item)
                    <li class="home card-container col-lg-4 col-md-4 col-sm-6 col-6">
                        <div class="dlab-box dlab-gallery-box">
                            <div class="dlab-media dlab-img-overlay1 dlab-img-effect zoom-slow"> <a
                                    href="javascript:void(0);"> <img src="{{ asset('storage/galery/' . $item->galery) }}"
                                        alt=""> </a>
                                <div class="overlay-bx">
                                    <div class="overlay-icon">
                                        <a href="#"> <i class="fas fa-link icon-bx-xs"></i> </a>
                                        <span data-exthumbimage="{{ asset('storage/galery/' . $item->galery) }}"
                                            data-src="{{ asset('storage/galery/' . $item->galery) }}"
                                            class="far fa-image icon-bx-xs check-km" title="Light Gallery Grid 1"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                @endforeach

            </ul>
        </div>
    </div>
    <!-- Our Projects END -->

    <!-- Company staus -->
    <div class="section-full text-white bg-img-fix content-inner overlay-black-middle"
        style="background-image:url({{ asset('landing/images/background/bg-kilat.jpg') }});">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="dex-box text-primary border-2 counter-box m-b30">
                        <h2 class="text-uppercase m-a0 p-a15 "><i class="ti-home m-r20"></i> <span
                                class="counter">1035</span></h2>
                        <h5 class="dlab-tilte  text-uppercase m-a0"><span
                                class="dlab-tilte-inner skew-title bg-primary p-lr15 p-tb10">Active Experts</span></h5>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="dex-box text-primary border-2 counter-box m-b30">
                        <h2 class="text-uppercase m-a0 p-a15 "><i class="fas fa-users m-r20"></i> <span
                                class="counter">1226</span></h2>
                        <h5 class="dlab-tilte  text-uppercase m-a0"><span
                                class="dlab-tilte-inner skew-title bg-primary p-lr15 p-tb10">Happy Client</span></h5>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="dex-box text-primary border-2 counter-box m-b30">
                        <h2 class="text-uppercase m-a0 p-a15 "><i class="fab fa-slideshare m-r20"></i> <span
                                class="counter">1552</span></h2>
                        <h5 class="dlab-tilte  text-uppercase m-a0"><span
                                class="dlab-tilte-inner skew-title bg-primary p-lr15 p-tb10">Workers Hand</span></h5>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="dex-box text-primary border-2 counter-box m-b10">
                        <h2 class="text-uppercase m-a0 p-a15 "><i class="fas fa-home m-r20"></i> <span
                                class="counter">1156</span></h2>
                        <h5 class="dlab-tilte  text-uppercase m-a0"><span
                                class="dlab-tilte-inner skew-title bg-primary p-lr15 p-tb10">Completed Project</span></h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Company staus END -->

    <!-- Testimonials blog -->
    <div class="section-full overlay-black-middle bg-img-fix content-inner-1"
        style="background-image:url({{ asset('landing/images/background/bg-kilat.jpg') }});">
        <div class="container">
            <div class="section-head text-white text-center">
                <h2 class="text-uppercase">Testimoni</h2>
                <div class="dlab-separator-outer ">
                    <div class="dlab-separator bg-white  style-skew"></div>
                </div>
            </div>
            <div class="section-content">
                <div class="testimonial-four owl-carousel owl-none owl-theme owl-dots-white-full">
                    @foreach ($testimoni as $t)
                        <div class="item">
                            <div class="testimonial-4 testimonial-bg">
                                @if ($t->photo == null || $t->photo == '')
                                    <div class="testimonial-pic"><img
                                            src="{{ asset('landing/images/testimonials/pic1.jpg') }}" width="100"
                                            height="100" alt="Testimoni"></div>
                                @else
                                    <div class="testimonial-pic"><img
                                            src="{{ asset('storage/testimoni/' . $t->photo) }}" width="100" height="100"
                                            alt="{{ $t->name }}"></div>
                                @endif
                                <div class="testimonial-text">
                                    <p>{{ $t->testimoni }}</p>
                                </div>
                                <div class="testimonial-detail"> <strong
                                        class="testimonial-name">{{ $t->name }}</strong> <span
                                        class="testimonial-position">{{ $t->pekerjaan }}</span> </div>
                                <div class="quote-right"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <!-- Testimonials blog END -->
    <!-- Client logo -->
    <div class="section-full dlab-we-find bg-img-fix p-t50 p-b50 ">
        <div class="container">
            <div class="section-content">
                <div class="client-logo-carousel owl-carousel mfp-gallery gallery owl-btn-center-lr">
                    <div class="item">
                        <div class="ow-client-logo">
                            <div class="client-logo"><a href="#"><img
                                        src="{{ asset('landing/images/client-logo/Bosch.png') }}" alt=""></a></div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="ow-client-logo">
                            <div class="client-logo"> <a href="#"><img
                                        src="{{ asset('landing/images/client-logo/meguiars-png-6.png') }}" alt=""></a>
                            </div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="ow-client-logo">
                            <div class="client-logo"> <a href="#"><img
                                        src="{{ asset('landing/images/client-logo/KARCHER_logo.png') }}" alt=""></a>
                            </div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="ow-client-logo">
                            <div class="client-logo"> <a href="#"><img
                                        src="{{ asset('landing/images/client-logo/Rupes.png') }}" alt=""></a> </div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="ow-client-logo">
                            <div class="client-logo"> <a href="#"><img
                                        src="{{ asset('landing/images/client-logo/SGCB_LOGO_PNG_format_large.png') }}"
                                        alt=""></a> </div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="ow-client-logo">
                            <div class="client-logo"> <a href="#"><img
                                        src="{{ asset('landing/images/client-logo/Carpro_Logo.png') }}" alt=""></a>
                            </div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="ow-client-logo">
                            <div class="client-logo"> <a href="#"><img
                                        src="{{ asset('landing/images/client-logo/logo-gyeon-purple.png') }}" alt=""></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <button style="visibility: hidden" data-bs-toggle="modal" data-bs-target="#modal-pengerjaan" id="pengerjaan"></button>
    <!-- Client logo END -->
    <div class="modal fade" id="modal-pengerjaan" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Status Orderan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered" width="100%" cellspacing="0" id="tabel-histori">
                        <thead>
                            <tr>
                                <th class="text-nowrap">No Plat</th>
                                <th class="text-nowrap">Orderan</th>
                                <th class="text-nowrap">Tanggal</th>
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
@endsection
@section('css')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.4/css/jquery.dataTables.css">
@endsection
@section('js')
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
        $('#cek').on('click', function() {

            if (!$('#no_pol_kendaraan').val()) {
                swal('Nomor Kendaraan masih kosong', {
                    icon: "error",
                });
            } else {
                $("#pengerjaan").click()
                let url_a = "{{ route('landing.cek', ':id') }}"
                url_a = url_a.replace(':id', $('#no_pol_kendaraan').val())
                $('#tabel-histori').DataTable({
                    responsive: true,
                    processing: true,
                    serverSide: true,
                    destroy: true,
                    ajax: url_a,
                    columns: [{
                        data: 'no_pol_kendaraan',
                        name: 'no_pol_kendaraan'
                    }, {
                        data: 'bookingorder',
                        name: 'bookingorder'
                    }, {
                        data: 'tanggal',
                        name: 'tanggal'
                    }]
                })
            }
        })
    </script>
@endsection
