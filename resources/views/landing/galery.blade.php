@extends('layouts.landing')
@section('title')
Galery Kami
@endsection
@section('content')
<!-- Our Projects  -->
<div class="section-full bg-img-fix content-inner overlay-black-middle" style="background-image:url({{ asset('landing/images/background/bg-kilat.jpg') }});">
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
                    <div class="dlab-media dlab-img-overlay1 dlab-img-effect zoom-slow"> <a href="javascript:void(0);"> <img src="{{ asset('storage/galery/'.$item->galery) }}"  alt=""> </a>
                        <div class="overlay-bx">
                            <div class="overlay-icon">
                                <a href="#"> <i class="fas fa-link icon-bx-xs"></i> </a>
                                <span data-exthumbimage="{{ asset('storage/galery/'.$item->galery) }}" data-src="{{ asset('storage/galery/'.$item->galery) }}" class="far fa-image icon-bx-xs check-km" title="Light Gallery Grid 1"></span>
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
@endsection
