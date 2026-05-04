
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
    <style>
        html,
        body {
            min-height: 100%;
        }

        body {
            overflow-x: hidden;
        }

        .page-wrapers {
            min-height: 100vh;
        }

        .dlab-login {
            background-image: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.9)), url("https://images.unsplash.com/photo-1603584173870-7f309f8a71c2?ixlib=rb-1.2.1&auto=format&fit=crop&w=1920&q=80");
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: clamp(18px, 4vw, 40px) 20px;
            font-family: 'Poppins', sans-serif;
            width: 100%;
        }
        .top-head {
            margin: 0 auto 26px;
            text-align: center;
            width: min(100%, 1000px);
        }
        .brand-title {
            font-size: clamp(2rem, 6vw, 4.25rem);
            letter-spacing: clamp(0.2rem, 1.1vw, 0.5rem);
            line-height: 0.95;
            margin: 0;
            text-shadow: 0 10px 20px rgba(0,0,0,0.5);
            text-wrap: balance;
        }
        .brand-subtitle {
            font-size: clamp(0.72rem, 1.6vw, 0.95rem);
            letter-spacing: clamp(0.18rem, 1vw, 0.75rem);
            line-height: 1.6;
            margin-top: 0.55rem;
            opacity: 0.8;
        }
        .main-container {
            display: grid;
            grid-template-columns: minmax(0, 0.95fr) minmax(0, 1.05fr);
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(25px);
            -webkit-backdrop-filter: blur(25px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 30px;
            box-shadow: 0 30px 60px rgba(0,0,0,0.7);
            max-width: 1000px;
            width: 100%;
            overflow: hidden;
            animation: fadeInScale 0.8s ease-out;
            margin: 0 auto;
        }
        @keyframes fadeInScale {
            from { opacity: 0; transform: scale(0.95); }
            to { opacity: 1; transform: scale(1); }
        }
        .info-section {
            min-width: 0;
            padding: clamp(24px, 4vw, 50px);
            background: rgba(243, 156, 18, 0.05);
            border-right: 1px solid rgba(255, 255, 255, 0.05);
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        .login-section {
            min-width: 0;
            padding: clamp(24px, 4vw, 50px);
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        .login-title {
            font-size: clamp(1.45rem, 3vw, 1.9rem);
            line-height: 1.15;
        }
        .login-copy {
            line-height: 1.7;
            margin-bottom: 1.6rem;
        }
        .form-control {
            background: rgba(255, 255, 255, 0.07) !important;
            border: 1px solid rgba(255, 255, 255, 0.15) !important;
            color: #fff !important;
            border-radius: 12px !important;
            padding: 16px 25px !important;
            font-size: 16px !important;
            height: auto !important;
            transition: all 0.3s ease !important;
            width: 100% !important;
            margin-bottom: 5px;
        }
        .form-control:focus {
            background: rgba(255, 255, 255, 0.1) !important;
            border-color: #f39c12 !important;
            box-shadow: 0 0 20px rgba(243, 156, 18, 0.2) !important;
        }
        .site-button {
            border-radius: 12px !important;
            padding: 16px !important;
            font-weight: 700 !important;
            text-transform: uppercase;
            letter-spacing: 3px;
            width: 100%;
            background: linear-gradient(45deg, #f39c12, #e67e22) !important;
            border: none !important;
            color: #fff !important;
            transition: all 0.3s ease !important;
            box-shadow: 0 10px 20px rgba(230, 126, 34, 0.3) !important;
            margin-top: 15px;
        }
        .site-button:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 30px rgba(230, 126, 34, 0.5) !important;
            filter: brightness(1.1);
        }
        .info-item {
            display: flex;
            align-items: center;
            margin-bottom: 25px;
            color: #fff;
        }
        .info-icon {
            width: 45px;
            height: 45px;
            background: rgba(243, 156, 18, 0.2);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 20px;
            color: #f39c12;
            font-size: 20px;
        }
        .info-text h4 {
            margin: 0;
            font-size: 16px;
            font-weight: 700;
            color: #f39c12;
        }
        .info-text p {
            margin: 0;
            font-size: 14px;
            color: rgba(255,255,255,0.7);
        }
        .bottom-footer {
            margin: 20px auto 0;
            padding: 0 8px;
            text-align: center;
            width: min(100%, 1000px);
        }
        .bottom-footer p {
            line-height: 1.6;
        }
        .bt-support-now {
            bottom: 20px !important;
            left: auto !important;
            right: 20px !important;
        }
        @media (max-width: 991px) {
            .dlab-login {
                background-attachment: scroll;
                justify-content: flex-start;
            }
            .main-container {
                grid-template-columns: 1fr;
                max-width: 640px;
            }
            .info-section {
                border-right: none;
                border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            }
            .top-head {
                margin-bottom: 20px;
            }
        }
        @media (max-width: 767.98px) {
            .info-section {
                display: none !important;
            }
            .main-container {
                grid-template-columns: 1fr;
                max-width: 480px;
            }
            .dlab-login {
                padding: 16px 14px 20px;
                justify-content: center;
            }
            .top-head {
                margin-bottom: 16px;
            }
            .brand-title {
                font-size: 2.1rem;
                letter-spacing: 0.18rem;
            }
            .brand-subtitle {
                font-size: 0.76rem;
                letter-spacing: 0.22rem;
                margin-top: 0.45rem;
            }
            .main-container {
                border-radius: 24px;
            }
            .login-section {
                padding: 28px 24px;
            }
            .info-section > p {
                margin-bottom: 1.35rem !important;
            }
            .info-item {
                align-items: flex-start;
                gap: 12px;
                margin-bottom: 18px;
            }
            .info-icon {
                flex: 0 0 auto;
                height: 40px;
                margin-right: 0;
                width: 40px;
            }
            .site-button {
                letter-spacing: 0.16em;
                padding: 15px 16px !important;
            }
            .bottom-footer {
                margin-top: 16px;
            }
        }
        @media (max-width: 575.98px) {
            .dlab-login {
                padding-inline: 12px;
            }
            .brand-title {
                font-size: 1.82rem;
                letter-spacing: 0.14rem;
            }
            .brand-subtitle {
                font-size: 0.7rem;
                letter-spacing: 0.16rem;
            }
            .main-container {
                border-radius: 20px;
            }
            .info-section,
            .login-section {
                padding: 18px;
            }
            .login-copy,
            .info-section > p,
            .info-text p {
                font-size: 0.92rem;
            }
            .info-text h4 {
                font-size: 0.98rem;
            }
            .form-control {
                border-radius: 10px !important;
                padding: 14px 18px !important;
            }
            .site-button {
                font-size: 0.84rem;
                letter-spacing: 0.12em;
            }
            .tracking-btn {
                font-size: 0.9rem;
                margin-top: 14px;
            }
            .bottom-footer p {
                font-size: 0.74rem;
            }
            .bt-support-now {
                align-items: center !important;
                border-radius: 999px !important;
                bottom: 12px !important;
                display: inline-flex !important;
                height: 52px !important;
                justify-content: center !important;
                padding: 0 !important;
                right: 12px !important;
                width: 52px !important;
            }
            .bt-support-now span {
                display: none !important;
            }
            .bt-support-now i {
                margin: 0 !important;
            }
        }
        @media (max-width: 380px) {
            .brand-title {
                font-size: 1.68rem;
                letter-spacing: 0.12rem;
            }
            .brand-subtitle {
                letter-spacing: 0.12rem;
            }
        }
        .tracking-btn {
            display: inline-block;
            margin-top: 20px;
            color: #f39c12;
            text-decoration: none;
            font-weight: 600;
            border-bottom: 1px dashed #f39c12;
            transition: all 0.3s;
        }
        .tracking-btn:hover {
            color: #fff;
            border-color: #fff;
        }

        /* Fix for stray bootstrap-select in SweetAlert */
        .swal2-container .bootstrap-select {
            display: none !important;
        }
    </style>

</head>
<body id="bg" class="full-boxed">
<div class="page-wrapers">
    <div class="page-content dlab-login">
    <div class="top-head">
    <a href="{{ url('/') }}" class="text-decoration-none">
    <div class="text-center">
                    <h1 class="text-white fw-bold brand-title">JUNIOR <span style="color: #f39c12;">AUTO CARE</span></h1>
                    <p class="text-white-50 fw-medium brand-subtitle">THE BEST CAR CARE IN TOWN</p>
                </div>
    </a>
    </div>

        <div class="main-container">
            <!-- INFO SECTION -->
            <div class="info-section">
                <h2 class="text-white fw-bold mb-4">THE BEST CAR CARE IN TOWN</h2>
                <p class="text-white-50 mb-5">Professional Auto Detailing, Coating, and Premium Wash in Medan. We treat your car like ours.</p>
                
                <div class="info-item">
                    <div class="info-icon"><i class="fa fa-gem"></i></div>
                    <div class="info-text">
                        <h4>Nano Ceramic Coating</h4>
                        <p>Long-term protection & ultimate gloss finish.</p>
                    </div>
                </div>
                
                <div class="info-item">
                    <div class="info-icon"><i class="fa fa-car"></i></div>
                    <div class="info-text">
                        <h4>Full Auto Detailing</h4>
                        <p>Interior, Exterior, and Engine Bay cleaning.</p>
                    </div>
                </div>

                <div class="info-item">
                    <div class="info-icon"><i class="fa fa-map-marker-alt"></i></div>
                    <div class="info-text">
                        <h4>Location</h4>
                        <p>Jl. Perjuangan No.23, Medan Sunggal.</p>
                    </div>
                </div>

                <a href="https://www.instagram.com/junior.autocare/" target="_blank" class="tracking-btn"><i class="fab fa-instagram"></i> Follow @junior.autocare</a>
            </div>

            <!-- LOGIN SECTION -->
            <div class="login-section">
                <h3 class="text-white fw-bold m-b10 login-title">LOGIN PORTAL</h3>
                <p class="text-white-50 m-b30 login-copy">Masuk ke dashboard untuk mengelola data operasional.</p>
                
                <form class="dlab-form" method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="form-group m-b20">
                        <label class="text-white-50 small mb-2 d-block">Username</label>
                        <input name="username" value="{{ old('username') }}" required="" class="form-control" type="text" placeholder="Masukkan username Anda" autocomplete="username"/>
                    </div>
                    <div class="form-group m-b30">
                        <label class="text-white-50 small mb-2 d-block">Password</label>
                        <input name="password" required="" class="form-control" placeholder="Masukkan password Anda" type="password" autocomplete="current-password"/>
                    </div>
                    <button type="submit" class="site-button">MASUK KE SISTEM</button>
                </form>
            </div>
        </div>

		<div class="bottom-footer text-white mt-5 opacity-50">
			<p class="mb-0 small">&copy; {{ date('Y') }} JUNIOR PREMIUM AUTO CARE. All Rights Reserved.</p>
		</div>
	</div>
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

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        if ($.fn.selectpicker) {
            $.fn.selectpicker.Constructor.DEFAULTS.noneSelectedText = '';
        }

        @if($errors->any())
            Swal.fire({
                icon: 'warning',
                title: 'Autentikasi Gagal',
                html: '<ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>',
                background: 'rgba(20, 20, 20, 0.95)',
                color: '#fff',
                confirmButtonColor: '#f39c12'
            });
        @endif

        @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Opps...',
                text: '{{ session('error') }}',
                background: 'rgba(20, 20, 20, 0.95)',
                color: '#fff',
                confirmButtonColor: '#f39c12'
            });
        @endif

        @if(session('status'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: '{{ session('status') }}',
                background: 'rgba(20, 20, 20, 0.95)',
                color: '#fff',
                confirmButtonColor: '#f39c12'
            });
        @endif
    });
</script>

</body>
</html>
