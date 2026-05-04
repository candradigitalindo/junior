<!DOCTYPE html>
<html lang="en">
<head>
	<!-- META -->
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	    @yield('tagmeta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
	<meta name="format-detection" content="telephone=no">

	<!-- FAVICONS ICON -->
	<link rel="icon" href="{{ asset('office/dist/images/logo2.png') }}" type="image/x-icon" />
	<link rel="shortcut icon" type="image/x-icon" href="{{ asset('office/dist/images/logo2.png') }}" />

	<!-- PAGE TITLE HERE -->
	<title>@yield('title')</title>

	<!-- MOBILE SPECIFIC -->
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!--[if lt IE 9]>
		<script src="js/html5shiv.min.js"></script>
		<script src="js/respond.min.js"></script>
	<![endif]-->

	<!-- STYLESHEETS -->
	<link rel="stylesheet" type="text/css" href="{{ asset('landing/css/style.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('landing/css/templete.min.css') }}">
	<link class="skin"  rel="stylesheet" type="text/css" href="{{ asset('landing/css/skin/skin-4.css') }}">
	<!-- Revolution Slider Css -->
	<link rel="stylesheet" type="text/css" href="{{ asset('landing/plugins/revolution/css/settings.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('landing/plugins/revolution/css/navigation.css') }}">
    @yield('css')

</head>
<body id="bg">
<div class="page-wraper">
    <!-- header -->
    <header class="site-header header mo-left header-style-1">
        <!-- top bar -->
        <div class="top-bar">
            <div class="container">
                <div class="row d-flex justify-content-between">
                    <div class="dlab-topbar-left"> </div>
                    <div class="dlab-topbar-right">
                        <ul class="social-bx list-inline float-end">
                            <li><a class="fab fa-instagram" href="https://www.instagram.com/juniorwash/" target="blank"></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- top bar END-->
        <!-- main header -->
        <div class="sticky-header header-curve main-bar-wraper navbar-expand-lg">
            <div class="main-bar bg-primary clearfix ">
                <div class="container clearfix">
                    <!-- website logo -->
                    <div class="logo-header logo-white mostion"><a href=""><img src="{{ asset('office/dist/images/logo3.png') }}" width="20" height="20" alt=""></a></div>
                    <!-- nav toggle button -->
					<button class="navbar-toggler collapsed navicon justify-content-end" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
						<span></span>
						<span></span>
						<span></span>
					</button>
                    <!-- extra nav -->
                    <div class="extra-nav">
                        <div class="extra-cell">
                            <a href="{{ route('login') }}" class="site-button bg-primary-dark"><i class="fas fa-unlock-alt"></i></a>
                        </div>
                    </div>
                    <!-- Quik search -->
                    <div class="dlab-quik-search bg-primary">
                        <form action="#">
                            <input name="search" value="" type="text" class="form-control" placeholder="Type to search">
                            <span id="quik-search-remove"><i class="fas fa-times"></i></span>
                        </form>
                    </div>
                    <!-- main nav -->
                    <div class="header-nav navbar-collapse collapse justify-content-end" id="navbarNavDropdown">
                        <ul class="nav navbar-nav nav-style">
                            <li class="{{ (request()->is('/')) ? 'active' : ''}}"><a href="{{ route('landing.index') }}" style="font-weight: bold">Home</a></li>
                            <li class="{{ (request()->is('about')) ? 'active' : ''}}"><a href="{{ route('landing.about') }}" style="font-weight: bold">About Us</a></li>
                            <li class="{{ (request()->is('layanan')) ? 'active' : ''}}"><a href="{{ route('landing.layanan') }}" style="font-weight: bold">Service</a></li>
                            <li class="{{ (request()->is('booking')) ? 'active' : ''}}"><a href="{{ route('landing.booking') }}" style="font-weight: bold">Booking</a></li>
                            <li class="{{ (request()->is('galery')) ? 'active' : ''}}"><a href="{{ route('landing.galery') }}" style="font-weight: bold">Gallery</a></li>
                            <li class="{{ (request()->is('contact')) ? 'active' : ''}}"><a href="{{ route('landing.contact') }}" style="font-weight: bold">Contact Us</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- main header END -->
    </header>
    <!-- header END -->
    <!-- Content -->
    <div class="page-content">
        @yield('content')
    </div>
    <!-- Content END-->
    <!-- Footer -->
    <footer class="site-footer">
        <!-- newsletter part -->
        <div class="bg-primary dlab-newsletter">
            <div class="container equal-wraper">
				<form class="dzSubscribe" action="script/mailchamp.php" method="post">
					<div class="row position-relative">
                        <div class="col-lg-4 col-md-4 col-sm-12">
                            <div class="icon-bx-wraper equal-col p-t30 p-b20 left">
                                <div class="icon-lg text-white radius">

								</div>
                                <div class="icon-content"> <strong class="text-black text-uppercase font-18"></strong>

                                </div>
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-3 col-sm-12 offset-lg-1 offset-md-1">
                            <div class="equal-col p-t40 p-b10 skew-subscribe">

                            </div>
                        </div>
					</div>
				</form>
            </div>
        </div>
        <!-- footer top part -->
        <div class="footer-top">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-md-6 col-sm-6 footer-col-4">
                        <div class="widget widget_about">
                            <div class="logo-footer logo-white">
                                <h2 class="text-white fw-bold" style="letter-spacing: 2px;">JUNIOR <span class="text-primary">PREMIUM</span></h2>
                                <p class="text-white-50" style="letter-spacing: 4px; font-size: 10px; margin-top: -10px;">AUTO CARE</p>
                            </div>
                            <p><strong>JUNIOR PREMIUM AUTO CARE</strong> – One Step Polish – Body Care – Treatment – Coating – Restoration</p>
                            <ul class="dlab-social-icon dez-border">
                                <li><a class="fab fa-instagram" href="https://www.instagram.com/juniorwash/" target="blank"></a></li>
                            </ul>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6 col-sm-6 footer-col-4">
                        <div class="widget widget_services">
                            <h4 class="m-b15 text-uppercase">Our services</h4>
                            <div class="dlab-separator-outer m-b10">
                                <div class="dlab-separator bg-white style-skew"></div>
                            </div>
                            <ul>
                                <li><a href="">Premium Car Wash</a></li>
                                <li><a href="">One Step Polish</a></li>
                                <li><a href="">Body Care</a></li>
                                <li><a href="">Treatment</a></li>
                                <li><a href="">Coating</a></li>
                                <li><a href="">Restoration</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 footer-col-4">
                        <div class="widget widget_getintuch">
                            <h4 class="m-b15 text-uppercase">Contact us</h4>
                            <div class="dlab-separator-outer m-b10">
                                <div class="dlab-separator bg-white style-skew"></div>
                            </div>
                            <ul>
                                <li><i class="ti-location-pin"></i><strong>address</strong> Jl. Garuda No.79, Sei Sikambing B, Kec. Medan Sunggal, Kota Medan, Sumatera Utara. </li>
                                <li><i class="ti-mobile"></i><strong>Telp/Whatsapp</strong>0821 6061 9089</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- footer bottom part -->
        <div class="footer-bottom footer-line">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 col-md-4 text-left">
						<span>© Copyright {{ date('Y') }}</span>
					</div>
                    <div class="col-lg-4 col-md-4 text-center">

					</div>
					<div class="col-lg-4 col-md-4 text-right">
						<span> Development & Design</i> By<a href="https://candio.co.id/" target="_blank">Candio | Web & Mobile Developer</a> </span>
					</div>

                </div>
            </div>
        </div>
    </footer>
    <!-- Footer END-->
    <!-- scroll top button -->
    <button class="scroltop fas fa-arrow-up style5" ></button>
</div>

<!-- JavaScript  files ========================================= -->
<script src="{{ asset('landing/js/jquery.min.js') }}"></script><!-- JQUERY.MIN JS -->
<script src="{{ asset('landing/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script><!-- BOOTSTRAP.MIN JS -->
<script src="{{ asset('landing/plugins/bootstrap-select/bootstrap-select.min.js') }}"></script><!-- FORM JS -->
<script src="{{ asset('landing/plugins/bootstrap-touchspin/jquery.bootstrap-touchspin.js') }}"></script><!-- FORM JS -->
<script src="{{ asset('landing/plugins/magnific-popup/magnific-popup.js') }}"></script><!-- MAGNIFIC POPUP JS -->
<script src="{{ asset('landing/plugins/counter/waypoints-min.js') }}"></script><!-- WAYPOINTS JS -->
<script src="{{ asset('landing/plugins/counter/counterup.min.js') }}"></script><!-- COUNTERUP JS -->
<script src="{{ asset('landing/plugins/imagesloaded/imagesloaded.js') }}"></script><!-- IMAGESLOADED -->
<script src="{{ asset('landing/plugins/masonry/masonry-3.1.4.js') }}"></script><!-- MASONRY -->
<script src="{{ asset('landing/plugins/masonry/masonry.filter.js') }}"></script><!-- MASONRY -->
<script src="{{ asset('landing/plugins/owl-carousel/owl.carousel.js') }}"></script><!-- OWL SLIDER -->
<script src="{{ asset('landing/js/custom.min.js') }}"></script><!-- CUSTOM FUCTIONS  -->
<script src="{{ asset('landing/js/dz.carousel.min.js') }}"></script><!-- SORTCODE FUCTIONS  -->
<script src="{{ asset('landing/plugins/lightgallery/js/lightgallery-all.js') }}"></script><!-- LIGHT GALLERY -->
<script src="{{ asset('landing/js/dz.ajax.js') }}"></script><!-- CONTACT JS -->

<!-- REVOLUTION JS FILES -->
<script src="{{ asset('landing/plugins/revolution/js/jquery.themepunch.tools.min.js') }}"></script>
<script src="{{ asset('landing/plugins/revolution/js/jquery.themepunch.revolution.min.js') }}"></script>
<!-- Slider revolution 5.0 Extensions  (Load Extensions only on Local File Systems !  The following part can be removed on Server for On Demand Loading) -->
<script src="{{ asset('landing/plugins/revolution/js/extensions/revolution.extension.actions.min.js') }}"></script>
<script src="{{ asset('landing/plugins/revolution/js/extensions/revolution.extension.carousel.min.js') }}"></script>
<script src="{{ asset('landing/plugins/revolution/js/extensions/revolution.extension.kenburn.min.js') }}"></script>
<script src="{{ asset('landing/plugins/revolution/js/extensions/revolution.extension.layeranimation.min.js') }}"></script>
<script src="{{ asset('landing/plugins/revolution/js/extensions/revolution.extension.migration.min.js') }}"></script>
<script src="{{ asset('landing/plugins/revolution/js/extensions/revolution.extension.navigation.min.js') }}"></script>
<script src="{{ asset('landing/plugins/revolution/js/extensions/revolution.extension.parallax.min.js') }}"></script>
<script src="{{ asset('landing/plugins/revolution/js/extensions/revolution.extension.slideanims.min.js') }}"></script>
<script src="{{ asset('landing/plugins/revolution/js/extensions/revolution.extension.video.min.js') }}"></script>
<script src="{{ asset('landing/js/rev.slider.js') }}"></script>
<script>
jQuery(document).ready(function() {
	'use strict';
	dz_rev_slider_1();
});	/*ready*/
</script>
@yield('js')
</body>
</html>
