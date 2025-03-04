
<!DOCTYPE html>
<html lang="en">
<head>
	<!-- META -->
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="keywords" content="" />
	<meta name="author" content="" />
	<meta name="robots" content="" />
	<meta name="description" content="AutoCare is well designed creating websites of automotive repair shops, stores with spare parts and accessories for car repairs, car washes, car danting and panting, service stations, car showrooms painting, major auto centers and other sites related to cars and car services." />
	<meta property="og:title" content="Auto Care - Car Services Template" />
	<meta property="og:description" content="AutoCare is well designed creating websites of automotive repair shops, stores with spare parts and accessories for car repairs, car washes, car danting and panting, service stations, car showrooms painting, major auto centers and other sites related to cars and car services." />
	<meta property="og:image" content="" />
	<meta name="format-detection" content="telephone=no">

	<!-- FAVICONS ICON -->
	<link rel="icon" href="{{ asset('image/no_photo_tipe_mobil.png') }}" type="image/x-icon" />
	<link rel="shortcut icon" type="image/x-icon" href="{{ asset('image/no_photo_tipe_mobil.png') }}" />

	<!-- PAGE TITLE HERE -->
	<title>Login</title>

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

</head>
<body id="bg" class="full-boxed">
<div id="loading-area"></div>
<div class="page-wrapers">
    <!-- Content -->
    <div class="page-content dlab-login bg-secondry">
		<div class="top-head logo-white text-center logo-header">
			<a href="index.html">
				<img src="{{ asset('image/no_photo_tipe_mobil.png') }}" style="width: 300px" alt=""/>
			</a>
		</div>
        <div class="login-form">
			<div class="tab-content nav">
                <div id="login" class="tab-pane active text-center">
                    <form class="p-a30 dlab-form" method="POST" action="{{ route('login') }}">
                        @csrf
                        <h3 class="form-title m-t0">Halaman Login</h3>
                        <div class="dlab-separator-outer m-b5">
                            <div class="dlab-separator bg-primary style-liner"></div>
                        </div>
                        <p>Silahkan isi Username dan Password </p>
                        <div class="form-group">
                            <input name="username" value="{{ old('username') }}" required="" class="form-control" type="text" placeholder="Username"/>
                            @error('username')
                            <div class="alert alert-warning"> <a href="#" class="close" data-bs-dismiss="alert" aria-label="close">&times;</a> <strong>{{ $message }}</strong></div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <input name="password" required="" class="form-control " placeholder="Password" type="password"/>
                            @error('password')
                            <div class="alert alert-warning"> <a href="#" class="close" data-bs-dismiss="alert" aria-label="close">&times;</a> <strong>{{ $message }}</strong></div>
                            @enderror
                        </div>
						<div class="form-group text-left">
                            <button type="submit" class="site-button m-r5 dz-xs-flex">login</button>
						</div>

                    </form>

                </div>

            </div>
        </div>
		<div class="bottom-footer text-center text-white">
			<p>{{ date('Y') }} JUNIOR </p>
		</div>
	</div>
    <!-- Content END-->
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
<script src="{{ asset('landing/js/dz.ajax.js') }}"></script>
<!-- CONTACT JS -->



</body>
</html>
