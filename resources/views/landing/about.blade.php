@extends('layouts.landing')
@section('title')
About
@endsection
@section('content')

<!-- Breadcrumb row -->
<div class="breadcrumb-row">
    <div class="container">
        <ul class="list-inline">
            <li><a href="{{ route('landing.index') }}">Home</a></li>
            <li>Tentang Kami</li>
        </ul>
    </div>
</div>
<!-- Breadcrumb row END -->
<!-- contact area -->
<div class="content">
    <!-- About Company -->
    <div class="section-full content-inner bg-white">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="section-head text-left">
                        <h2 class="text-uppercase m-t0 m-b10">Tentang<span class="text-primary"> KILAT</span></h2>
                        <div class="aon-separator bg-primary"></div>
                        <p><strong>There are many variations of passages of Lorem Ipsum typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</strong></p>
                        <p class="m-b50">There are many variations of passages of Lorem Ipsum typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the with the release of Letraset sheets containing Lorem Ipsum </p>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-sm-6 col-lg-6">
                            <div class="icon-bx-wraper bx-style-2 m-l40 m-b30 p-a30 left">
                                <div class="icon-bx-sm radius bg-primary"> <a href="#" class="icon-cell"><i class="ti-user"></i></a> </div>
                                <div class="icon-content p-l40">
                                    <h4 class="w3-tilte">Our Best Workers</h4>
                                    <p>Lorem ipsum dolor sit amet, consectetuer adipiscing  sed diam nibh euismod </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-lg-6">
                            <div class="icon-bx-wraper bx-style-2 m-l40 m-b30 p-a30 left">
                                <div class="icon-bx-sm radius bg-primary"> <a href="#" class="icon-cell"><i class="ti-car"></i></a> </div>
                                <div class="icon-content p-l40">
                                    <h4 class="w3-tilte ">Fast Car Searvice</h4>
                                    <p>Lorem ipsum dolor sit amet, consectetuer adipiscing  sed diam nibh euismod </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-lg-6">
                            <div class="icon-bx-wraper bx-style-2 m-l40 m-b30 p-a30 left">
                                <div class="icon-bx-sm radius bg-primary"> <a href="#" class="icon-cell"><i class="ti-user"></i></a> </div>
                                <div class="icon-content p-l40">
                                    <h4 class="w3-tilte ">Well Qualified Staff</h4>
                                    <p>Lorem ipsum dolor sit amet, consectetuer adipiscing  sed diam nibh euismod </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-lg-6">
                            <div class="icon-bx-wraper bx-style-2 m-l40 m-b30 p-a30 left">
                                <div class="icon-bx-sm radius bg-primary"> <a href="#" class="icon-cell"><i class="ti-settings"></i></a> </div>
                                <div class="icon-content p-l40">
                                    <h4 class="w3-tilte ">24X7 Service</h4>
                                    <p>Lorem ipsum dolor sit amet, consectetuer adipiscing  sed diam nibh euismod </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-lg-6">
                            <div class="icon-bx-wraper bx-style-2 m-l40 m-b30 p-a30 left">
                                <div class="icon-bx-sm radius bg-primary"> <a href="#" class="icon-cell"><i class="ti-cup"></i></a> </div>
                                <div class="icon-content p-l40">
                                    <h4 class="w3-tilte ">Best Materials</h4>
                                    <p>Lorem ipsum dolor sit amet, consectetuer adipiscing  sed diam nibh euismod </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-lg-6">
                            <div class="icon-bx-wraper bx-style-2 m-l40 m-b10 p-a30 left">
                                <div class="icon-bx-sm radius bg-primary"> <a href="#" class="icon-cell"><i class="ti-flag-alt-2"></i></a> </div>
                                <div class="icon-content p-l40">
                                    <h4 class="w3-tilte">Auto Care</h4>
                                    <p>Lorem ipsum dolor sit amet, consectetuer adipiscing  sed diam nibh euismod </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- About Company END -->

</div>
<!-- contact area  END -->
@endsection
