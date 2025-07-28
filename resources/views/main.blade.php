<!DOCTYPE html>
<html lang="en" dir="ltr" data-nav-layout="vertical" data-theme-mode="light" data-header-styles="light" data-menu-styles="dark" data-toggled="close">

<head>

    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title> Project baru</title>
    <meta name="Description" content="Bootstrap Responsive Admin Web Dashboard HTML5 Template">
    <meta name="Author" content="Spruko Technologies Private Limited">
	<meta name="keywords" content="template dashboard, dashboard admin template, admin panel, dashboard admin, bootstrap admin dashboard, bootstrap admin panel, template admin, dashboard, html css, html css js, template css and html, bootstrap 5 admin template, admin dashboard ui, admin, html and css template">
    <link rel="icon" href="{{ asset('assets/images/brand-logos/favicon.ico') }}" type="image/x-icon">
    <script src="{{ asset('assets/libs/choices.js/public/assets/scripts/choices.min.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>
    <link id="style" href="{{ asset('assets/libs/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" >
    <link href="{{ asset('assets/css/styles.css') }}" rel="stylesheet" >
    <link href="{{ asset('assets/css/icons.css') }}" rel="stylesheet" >
    <link href="{{ asset('assets/libs/node-waves/waves.min.css') }}" rel="stylesheet" >
    <link href="{{ asset('assets/libs/simplebar/simplebar.min.css') }}" rel="stylesheet" >
    <link rel="stylesheet" href="{{ asset('assets/libs/flatpickr/flatpickr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/libs/@simonwep/pickr/themes/nano.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/libs/choices.js/public/assets/styles/choices.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/libs/@tarekraafat/autocomplete.js/css/autoComplete.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
    <style>
        .side-menu__item {
            display: flex;
            align-items: center;
        }

        .side-menu__icon {
            font-size: 20px;
            margin-right: 10px;
            line-height: 1;
        }
    </style>
    @stack('styles') 
</head>

<body>
    <div id="loader" >
        <img src="{{ asset('assets/images/media/loader.svg') }}" alt="">
    </div>
    <div class="page">
        @include('layouts.header')
        @include('layouts.sidebar')
        @include('layouts.switcher')
        <div class="main-content app-content">
            @yield('pages') 
        </div>
         @include('layouts.footer') 
    </div>
    <div class="scrollToTop">
        <span class="arrow"><i class="ri-arrow-up-s-fill fs-20"></i></span>
    </div>
    <div id="responsive-overlay"></div>
    <script src="{{ asset('assets/libs/@popperjs/core/umd/popper.min.js') }}"></script>
    <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/defaultmenu.js') }}"></script>
    <script src="{{ asset('assets/libs/node-waves/waves.min.js') }}"></script>
    <script src="{{ asset('assets/js/sticky.js') }}"></script>
    {{-- <script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script> --}}
    {{-- <script src="{{ asset('assets/js/simplebar.js') }}"></script> --}}
    <script src="{{ asset('assets/libs/@tarekraafat/autocomplete.js/autoComplete.min.js') }}"></script>
    <script src="{{ asset('assets/libs/@simonwep/pickr/pickr.es5.min.js') }}"></script>
    {{-- <script src="{{ asset('assets/libs/apexcharts/apexcharts.min.js') }}"></script> --}}
    <script src="{{ asset('assets/libs/flatpickr/flatpickr.min.js') }}"></script>
    {{-- <script src="{{ asset('assets/js/sales-dashboard.js') }}"></script> --}}
    <script src="{{ asset('assets/js/custom_full.js') }}"></script>
    <script src="{{ asset('assets/js/custom-switcher.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    @stack('scripts')
</body>

</html> 