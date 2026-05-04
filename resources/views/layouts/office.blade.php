<!DOCTYPE html>
<html lang="en" class="light">
<!-- BEGIN: Head -->

<head>
    <meta charset="utf-8">
    <link href="{{ asset('image/no_photo_tipe_mobil.png') }}" rel="shortcut icon">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description"
        content="Rubick admin is super flexible, powerful, clean & modern responsive bootstrap admin template with unlimited possibilities.">
    <meta name="keywords"
        content="admin template, Rubick Admin Template, dashboard template, flat admin template, responsive admin template, web app">
    <meta name="author" content="LEFT4CODE">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    <!-- BEGIN: CSS Assets-->
    <link rel="stylesheet" href="{{ asset('office/dist/css/app.css') }}" />
    @yield('css')
    <!-- END: CSS Assets-->
</head>
<!-- END: Head -->

<body class="main">
    <!-- BEGIN: Mobile Menu -->
    <div class="mobile-menu d-md-none">
        <div class="mobile-menu-bar">
            <a href="" class="d-flex me-auto text-decoration-none">
                <span class="text-white fw-bold fs-xl" style="letter-spacing: 1px;">JUNIOR <span class="text-warning">PREMIUM</span></span>
            </a>
            <a href="javascript:;" id="mobile-menu-toggler" class="mobile-menu-bar__toggler"> <i
                    data-feather="bar-chart-2" class="w-8 h-8 text-warning"></i> </a>
        </div>
        <ul class="mobile-menu-wrapper border-top border-theme-1 dark-border-dark-3 py-5">
            <li>
                <a href="{{ route('home') }}" class="menu {{ request()->is('home') ? 'menu--active' : '' }}">
                    <div class="menu__icon"> <i data-feather="home"></i> </div>
                    <div class="menu__title"> Dashboard <i
                            class="menu__sub-icon {{ request()->is('home') ? 'menu__sub-icon--active' : '' }} "></i>
                    </div>
                </a>
            </li>
            @if (auth()->user()->role->role == 'loket')
                <li>
                    <a href="{{ route('serahterima') }}"
                        class="menu {{ request()->is('serah-terima') ? 'menu--active' : '' }}">
                        <div class="menu__icon"> <i data-feather="home"></i> </div>
                        <div class="menu__title"> Form Penerimaan <i
                                class="menu__sub-icon {{ request()->is('serah-terima') ? 'menu__sub-icon--active' : '' }} "></i>
                        </div>
                    </a>
                </li>
            @endif
            @if (auth()->user()->role->role == 'Superadmin')

                <li>
                    <a href="{{ route('category.index') }}"
                        class="menu {{ request()->is('category*') ? 'menu--active' : '' }}">
                        <div class="menu__icon"> <i data-feather="box"></i> </div>
                        <div class="menu__title"> Kategori <i
                                class="menu__sub-icon {{ request()->is('categori*') ? 'menu__sub-icon--active' : '' }} "></i>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="{{ route('product.index') }}"
                        class="menu {{ request()->is('product*') ? 'menu--active' : '' }}">
                        <div class="menu__icon"> <i data-feather="package"></i> </div>
                        <div class="menu__title"> Produk <i
                                class="menu__sub-icon {{ request()->is('produk*') ? 'menu__sub-icon--active' : '' }} "></i>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="{{ route('gudang.index') }}"
                        class="menu {{ request()->is('gudang*') ? 'menu--active' : '' }}">
                        <div class="menu__icon"> <i data-feather="package"></i> </div>
                        <div class="menu__title"> Gudang <i
                                class="menu__sub-icon {{ request()->is('gudang*') ? 'menu__sub-icon--active' : '' }} "></i>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="{{ route('extraservice.index') }}"
                        class="menu {{ request()->is('extraservice*') ? 'menu--active' : '' }}">
                        <div class="menu__icon"> <i data-feather="package"></i> </div>
                        <div class="menu__title"> Extra Layanan <i
                                class="menu__sub-icon {{ request()->is('extraservice*') ? 'menu__sub-icon--active' : '' }} "></i>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="{{ route('pengguna.index') }}"
                        class="menu {{ request()->is('pengguna*') ? 'menu--active' : '' }}">
                        <div class="menu__icon"> <i data-feather="user-check"></i> </div>
                        <div class="menu__title"> Pengguna <i
                                class="menu__sub-icon {{ request()->is('pengguna*') ? 'menu__sub-icon--active' : '' }} "></i>
                        </div>
                    </a>
                </li>
                {{-- <li>
                    <a href="{{ route('galery.index') }}"
                        class="menu {{ request()->is('galery*') ? 'menu--active' : '' }}">
                        <div class="menu__icon"> <i data-feather="image"></i> </div>
                        <div class="menu__title"> Galeri <i
                                class="menu__sub-icon {{ request()->is('galery*') ? 'menu__sub-icon--active' : '' }} "></i>
                        </div>
                    </a>
                </li> --}}
                <li>
                    <a href="{{ route('tipemobil.index') }}"
                        class="menu {{ request()->is('tipemobil*') ? 'menu--active' : '' }}">
                        <div class="menu__icon"> <i data-feather="codesandbox"></i> </div>
                        <div class="menu__title"> Tipe Mobil <i
                                class="menu__sub-icon {{ request()->is('tipemobil*') ? 'menu__sub-icon--active' : '' }} "></i>
                        </div>
                    </a>
                </li>
                {{-- <li>
                    <a href="{{ route('device.index') }}"
                        class="menu {{ request()->is('device*') ? 'menu--active' : '' }}">
                        <div class="menu__icon"> <i data-feather="codesandbox"></i> </div>
                        <div class="menu__title"> WhatsApp <i
                                class="menu__sub-icon {{ request()->is('device*') ? 'menu__sub-icon--active' : '' }} "></i>
                        </div>
                    </a>
                </li> --}}
                {{-- <li>
                    <a href="{{ route('tagmeta.index') }}"
                        class="menu {{ request()->is('tagmeta*') ? 'menu--active' : '' }}">
                        <div class="menu__icon"> <i data-feather="code"></i> </div>
                        <div class="menu__title"> Meta Tag <i
                                class="menu__sub-icon {{ request()->is('tagmeta*') ? 'menu__sub-icon--active' : '' }} "></i>
                        </div>
                    </a>
                </li> --}}
            @endif
            @if (strtolower(auth()->user()->role->role) == 'kasir')
                <li>
                    <a href="{{ route('kasir.dashboard') }}"
                        class="menu {{ request()->is('dashboard*') ? 'menu--active' : '' }}">
                        <div class="menu__icon"> <i data-feather="home"></i> </div>
                        <div class="menu__title"> Dashboard </div>
                    </a>
                </li>
                <li>
                    <a href="{{ route('kasir.unpaid') }}"
                        class="menu {{ request()->is('kasir/unpaid') ? 'menu--active' : '' }}">
                        <div class="menu__icon"> <i data-feather="alert-circle"></i> </div>
                        <div class="menu__title"> Belum Bayar </div>
                    </a>
                </li>
                <li>
                    <a href="{{ route('pemasukan.index') }}"
                        class="menu {{ request()->is('pemasukan') ? 'menu--active' : '' }}">
                        <div class="menu__icon"> <i data-feather="plus-square"></i> </div>
                        <div class="menu__title"> Pemasukan Lain </div>
                    </a>
                </li>
                <li>
                    <a href="{{ route('pengeluaran.index') }}"
                        class="menu {{ request()->is('pengeluaran') ? 'menu--active' : '' }}">
                        <div class="menu__icon"> <i data-feather="minus-square"></i> </div>
                        <div class="menu__title"> Pengeluaran </div>
                    </a>
                </li>
            @endif


        </ul>
    </div>
    <!-- END: Mobile Menu -->
    <!-- BEGIN: Top Bar -->
    <div
        class="border-bottom border-theme-29 dark-border-dark-3 mt-n10 mt-md-n5 mx-n3 mx-sm-n8 px-3 px-sm-8 pt-3 pt-md-0 mb-10">
        <div class="top-bar-boxed d-flex align-items-center">
            <!-- BEGIN: Logo -->
            <a href="" class="-intro-x d-none d-md-flex text-decoration-none">
                <span class="text-white fw-bold fs-xl" style="letter-spacing: 1px;">JUNIOR <span class="text-warning">PREMIUM</span></span>
            </a>
            <!-- END: Logo -->
            <!-- BEGIN: Breadcrumb -->
            <div class="-intro-x breadcrumb breadcrumb--light me-auto"> <a href="">Application</a> <i
                    data-feather="chevron-right" class="breadcrumb__icon"></i> <a href=""
                    class="breadcrumb--active">Dashboard</a> </div>
            <!-- END: Breadcrumb -->

            <!-- BEGIN: Account Menu -->
            <div class="intro-x dropdown w-8 h-8">
                <div class="dropdown-toggle w-8 h-8 rounded-pill overflow-hidden shadow-lg image-fit zoom-in"
                    role="button" aria-expanded="false" data-bs-toggle="dropdown">
                    <img alt="Rubick Tailwind HTML Admin Template"
                        src="{{ asset('office/dist/images/avatar.png') }}">
                </div>
                <div class="dropdown-menu w-56">
                    <ul class="dropdown-content bg-theme-2 dark-bg-dark-6 text-white">
                        <li class="p-2">
                            <div class="fw-medium text-dark">{{ auth()->user()->name }}</div>
                            <div class="fs-xs text-theme-1 mt-0.5 dark-text-dark-600">
                                {{ auth()->user()->role->role }}</div>
                        </li>
                        <li>
                            <hr class="dropdown-divider border-theme-11 dark-border-dark-3">
                        </li>
                        <li>
                            <a href="" class="dropdown-item text-dark bg-theme-1-hover dark-bg-dark-3-hover">
                                <i data-feather="lock" class="w-4 h-4 me-2"></i> Reset Password </a>
                        </li>

                        <li>
                            <hr class="dropdown-divider border-theme-11 dark-border-dark-3">
                        </li>
                        <li>
                            <a class="dropdown-item text-dark bg-theme-1-hover dark-bg-dark-3-hover"
                                href="javascript:;" data-bs-toggle="modal" data-bs-target="#logoutModal"> <i
                                    data-feather="toggle-right" class="w-4 h-4 me-2"></i> Logout </a>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- END: Account Menu -->
        </div>
    </div>
    <!-- END: Top Bar -->
    <!-- BEGIN: Top Menu -->
    <nav class="top-nav">
        <ul>
            @if (auth()->user()->role->role == 'loket')
                <li>
                    <a href="{{ route('loket.home') }}"
                        class="top-menu {{ request()->is('loket*') ? 'top-menu--active' : '' }}">
                        <div class="top-menu__icon"> <i data-feather="home"></i> </div>
                        <div class="top-menu__title"> Loket <i class="top-menu__sub-icon"></i> </div>
                    </a>
                </li>
                <li>
                    <a href="{{ route('serahterima') }}"
                        class="top-menu {{ request()->is('serah*') ? 'top-menu--active' : '' }}">
                        <div class="top-menu__icon"> <i data-feather="home"></i> </div>
                        <div class="top-menu__title"> Form Penerimaan <i class="top-menu__sub-icon"></i> </div>
                    </a>
                </li>
            @endif
            @if (auth()->user()->role->role == 'pengecekan')
                <li>
                    <a href="{{ route('pengecekan.index') }}"
                        class="top-menu {{ request()->is('pengecekan*') ? 'top-menu--active' : '' }}">
                        <div class="top-menu__icon"> <i data-feather="home"></i> </div>
                        <div class="top-menu__title"> Pengecekan <i class="top-menu__sub-icon"></i> </div>
                    </a>
                </li>
            @endif
            @if (auth()->user()->role->role == 'pengerjaan')
                <li>
                    <a href="{{ route('histori.index') }}"
                        class="top-menu {{ request()->is('histori*') ? 'top-menu--active' : '' }}">
                        <div class="top-menu__icon"> <i data-feather="home"></i> </div>
                        <div class="top-menu__title"> Pengerjaan <i class="top-menu__sub-icon"></i> </div>
                    </a>
                </li>
            @endif
            @if (strtolower(auth()->user()->role->role) == 'kasir')
                <li>
                    <a href="{{ route('kasir.dashboard') }}"
                        class="top-menu {{ request()->is('dashboard*') ? 'top-menu--active' : '' }}">
                        <div class="top-menu__icon"> <i data-feather="home"></i> </div>
                        <div class="top-menu__title"> Dashboard </div>
                    </a>
                </li>
                <li>
                    <a href="{{ route('kasir.unpaid') }}"
                        class="top-menu {{ request()->is('kasir/unpaid') ? 'top-menu--active' : '' }}">
                        <div class="top-menu__icon"> <i data-feather="alert-circle"></i> </div>
                        <div class="top-menu__title"> Belum Bayar </div>
                    </a>
                </li>
                <li>
                    <a href="{{ route('pemasukan.index') }}"
                        class="top-menu {{ request()->is('pemasukan*') ? 'top-menu--active' : '' }}">
                        <div class="top-menu__icon"> <i data-feather="plus-square"></i> </div>
                        <div class="top-menu__title"> Pemasukan Lain </div>
                    </a>
                </li>
                <li>
                    <a href="{{ route('pengeluaran.index') }}"
                        class="top-menu {{ request()->is('pengeluaran*') ? 'top-menu--active' : '' }}">
                        <div class="top-menu__icon"> <i data-feather="minus-square"></i> </div>
                        <div class="top-menu__title"> Pengeluaran </div>
                    </a>
                </li>
            @endif
            @if (auth()->user()->role->role == 'gudang')
            <li>
                <a href="{{ route('gudang.index') }}"
                    class="top-menu {{ request()->is('gudang*') ? 'top-menu--active' : '' }}">
                    <div class="top-menu__icon"> <i data-feather="package"></i> </div>
                    <div class="top-menu__title"> Gudang </div>
                </a>
            </li>
            @endif


            @if (strtolower(auth()->user()->role->role) == 'superadmin')
                <li>
                    <a href="{{ route('admin.index') }}"
                        class="top-menu {{ request()->is('admin*') ? 'top-menu--active' : '' }}">
                        <div class="top-menu__icon"> <i data-feather="home"></i> </div>
                        <div class="top-menu__title"> Dashboard </div>
                    </a>
                </li>
                <li>
                    <a href="{{ route('pemasukan.index') }}"
                        class="top-menu {{ request()->is('pemasukan*') ? 'top-menu--active' : '' }}">
                        <div class="top-menu__icon"> <i data-feather="plus-square"></i> </div>
                        <div class="top-menu__title"> Pemasukan Lain </div>
                    </a>
                </li>
                <li>
                    <a href="{{ route('pengeluaran.index') }}"
                        class="top-menu {{ request()->is('pengeluaran*') ? 'top-menu--active' : '' }}">
                        <div class="top-menu__icon"> <i data-feather="minus-square"></i> </div>
                        <div class="top-menu__title"> Pengeluaran </div>
                    </a>
                </li>

                <li>
                    <a href="{{ route('category.index') }}"
                        class="top-menu {{ request()->is('category*') ? 'top-menu--active' : '' }}">
                        <div class="top-menu__icon"> <i data-feather="box"></i> </div>
                        <div class="top-menu__title"> Kategori </div>
                    </a>
                </li>
                <li>
                    <a href="{{ route('product.index') }}"
                        class="top-menu {{ request()->is('product*') ? 'top-menu--active' : '' }}">
                        <div class="top-menu__icon"> <i data-feather="package"></i> </div>
                        <div class="top-menu__title"> Produk </div>
                    </a>
                </li>
                <li>
                    <a href="{{ route('gudang.index') }}"
                        class="top-menu {{ request()->is('gudang*') ? 'top-menu--active' : '' }}">
                        <div class="top-menu__icon"> <i data-feather="package"></i> </div>
                        <div class="top-menu__title"> Gudang </div>
                    </a>
                </li>
                <li>
                    <a href="{{ route('extraservice.index') }}"
                        class="top-menu {{ request()->is('extraservice*') ? 'top-menu--active' : '' }}">
                        <div class="top-menu__icon"> <i data-feather="package"></i> </div>
                        <div class="top-menu__title"> Extra layanan </div>
                    </a>
                </li>
                <li>
                    <a href="{{ route('pengguna.index') }}"
                        class="top-menu {{ request()->is('pengguna*') ? 'top-menu--active' : '' }}">
                        <div class="top-menu__icon"> <i data-feather="user-check"></i> </div>
                        <div class="top-menu__title"> Pengguna <i class="top-menu__sub-icon"></i> </div>
                    </a>
                </li>
                {{-- <li>
                    <a href="{{ route('galery.index') }}"
                        class="top-menu {{ request()->is('galery*') ? 'top-menu--active' : '' }}">
                        <div class="top-menu__icon"> <i data-feather="image"></i> </div>
                        <div class="top-menu__title"> Galeri <i class="top-menu__sub-icon"></i> </div>
                    </a>
                </li> --}}
                {{-- <li>
                    <a href="{{ route('testimoni.index') }}"
                        class="top-menu {{ request()->is('testimoni*') ? 'top-menu--active' : '' }}">
                        <div class="top-menu__icon"> <i data-feather="message-circle"></i> </div>
                        <div class="top-menu__title"> Testimoni <i class="top-menu__sub-icon"></i> </div>
                    </a>
                </li> --}}
                <li>
                    <a href="{{ route('tipemobil.index') }}"
                        class="top-menu {{ request()->is('tipemobil*') ? 'top-menu--active' : '' }}">
                        <div class="top-menu__icon"> <i data-feather="codesandbox"></i> </div>
                        <div class="top-menu__title"> Tipe Mobil <i class="top-menu__sub-icon"></i> </div>
                    </a>
                </li>
                {{-- <li>
                    <a href="{{ route('device.index') }}"
                        class="top-menu {{ request()->is('device*') ? 'top-menu--active' : '' }}">
                        <div class="top-menu__icon"> <i data-feather="code"></i> </div>
                        <div class="top-menu__title"> WhatsApp <i class="top-menu__sub-icon"></i> </div>
                    </a>
                </li> --}}
                {{-- <li>
                    <a href="{{ route('tagmeta.index') }}"
                        class="top-menu {{ request()->is('tagmeta*') ? 'top-menu--active' : '' }}">
                        <div class="top-menu__icon"> <i data-feather="code"></i> </div>
                        <div class="top-menu__title"> Tag Meta <i class="top-menu__sub-icon"></i> </div>
                    </a>
                </li> --}}
            @endif
        </ul>
    </nav>
    <!-- END: Top Menu -->
    <!-- BEGIN: Content -->
    <div class="content">
        @yield('content')

        <div id="logoutModal" class="modal fade" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- BEGIN: Modal Header -->
                    <div class="modal-header">
                        <h2 class="fw-medium fs-base me-auto">
                            Keluar Aplikasi ?
                        </h2>
                    </div>
                    <!-- END: Modal Header -->

                    <!-- BEGIN: Modal Footer -->
                    <div class="modal-footer text-end">
                        <button type="button" data-bs-dismiss="modal"
                            class="btn btn-outline-secondary w-32 me-1">Cancel</button>
                        <a href="{{ url('logout') }}" class="btn btn-primary w-32">Keluar</a>
                    </div>
                    <!-- END: Modal Footer -->
                </div>
            </div>
        </div>
    </div>
    <!-- END: Content -->

    <!-- BEGIN: JS Assets-->
    <script src="{{ asset('office/dist/js/app.js') }}"></script>
    @yield('js')
    <!-- END: JS Assets-->
</body>

</html>
