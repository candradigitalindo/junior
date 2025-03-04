<!DOCTYPE html>
<html lang="en" class="light">
    <!-- BEGIN: Head -->
    <head>
        <meta charset="utf-8">
        <link href="{{ asset('office/dist/images/logo2.png') }}" rel="shortcut icon">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Rubick admin is super flexible, powerful, clean & modern responsive bootstrap admin template with unlimited possibilities.">
        <meta name="keywords" content="admin template, Rubick Admin Template, dashboard template, flat admin template, responsive admin template, web app">
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
                <a href="" class="d-flex me-auto">
                    <img alt="logo Kilat Premium Wash" class="w-10" src="{{ asset('office/dist/images/logo.png') }}">
                </a>
                <a href="javascript:;" id="mobile-menu-toggler" class="mobile-menu-bar__toggler"> <i data-feather="bar-chart-2" class="w-8 h-8 text-white"></i> </a>
            </div>
        </div>
        <!-- END: Mobile Menu -->
        <!-- BEGIN: Top Bar -->
        <div class="border-bottom border-theme-29 dark-border-dark-3 mt-n10 mt-md-n5 mx-n3 mx-sm-n8 px-3 px-sm-8 pt-3 pt-md-0 mb-10">
            <div class="top-bar-boxed d-flex align-items-center">
                <!-- BEGIN: Logo -->
                <a href="" class="-intro-x d-none d-md-flex">
                    <img alt="Rubick Tailwind HTML Admin Template" class="w-10" src="{{ asset('office/dist/images/logo.png') }}">
                </a>
                <!-- END: Logo -->
                <!-- BEGIN: Breadcrumb -->
                <div class="-intro-x breadcrumb breadcrumb--light me-auto"> <a href="">Application</a> <i data-feather="chevron-right" class="breadcrumb__icon"></i></div>
                <!-- END: Breadcrumb -->

            </div>
        </div>
        <!-- END: Top Bar -->
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
                            <button type="button" data-bs-dismiss="modal" class="btn btn-outline-secondary w-32 me-1">Cancel</button>
                            <form method="POST" action="{{route('logout')}}">
                                @csrf
                                <button class="btn btn-primary w-32" type="submit" id="logout">Keluar</button>
                                {{-- <a  href="#" onclick="$('#logout').click()">Keluar</a> --}}
                            </form>
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
