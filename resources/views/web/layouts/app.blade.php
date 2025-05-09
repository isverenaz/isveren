<!DOCTYPE html>
<html lang="en">
<head>
    <!-- META -->
    <meta charset="utf-8">
    <meta name="google-adsense-account" content="ca-pub-1721827883325225">
    @if($_SERVER['REQUEST_URI'] != '/cv')
        @include('components.web.meta')
    @endif
    <!-- FAVICONS ICON -->
    <link rel="icon" href="{{ asset('site/images/logo/img/favicon.png') }}" type="image/x-icon"/>
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('site/images/logo/img/favicon.png') }}"/>
    <title>İş elanları <?php echo date('Y') ?> - @yield('site.title')</title>
    <!-- MOBILE SPECIFIC -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="{{ asset("site/css/bootstrap.min.css") }}"><!-- BOOTSTRAP STYLE SHEET -->
    <link rel="stylesheet" type="text/css" href="{{ asset("site/css/font-awesome.min.css") }}"><!-- FONTAWESOME STYLE SHEET -->
    <link rel="stylesheet" type="text/css" href="{{ asset("site/css/feather.css") }}"><!-- FEATHER ICON SHEET -->
    <link rel="stylesheet" type="text/css" href="{{ asset("site/css/owl.carousel.min.css") }}"><!-- OWL CAROUSEL STYLE SHEET -->
    <link rel="stylesheet" type="text/css" href="{{ asset("site/css/magnific-popup.min.css") }}"><!-- MAGNIFIC POPUP STYLE SHEET -->
    <link rel="stylesheet" type="text/css" href="{{ asset("site/css/lc_lightbox.css") }}"><!-- Lc light box popup -->
    <link rel="stylesheet" type="text/css" href="{{ asset("site/css/bootstrap-select.min.css") }}"><!-- BOOTSTRAP SLECT BOX STYLE SHEET  -->
    <link rel="stylesheet" type="text/css" href="{{ asset("site/css/dataTables.bootstrap5.min.css") }}"><!-- DATA table STYLE SHEET  -->
    <link rel="stylesheet" type="text/css" href="{{ asset("site/css/select.bootstrap5.min.css") }}">
    <!-- DASHBOARD select bootstrap  STYLE SHEET  -->
    <link rel="stylesheet" type="text/css" href="{{ asset("site/css/dropzone.css") }}"><!-- DROPZONE STYLE SHEET -->
    <link rel="stylesheet" type="text/css" href="{{ asset("site/css/scrollbar.css") }}"><!-- CUSTOM SCROLL BAR STYLE SHEET -->
    <link rel="stylesheet" type="text/css" href="{{ asset("site/css/datepicker.css") }}"><!-- DATEPICKER STYLE SHEET -->
    <link rel="stylesheet" type="text/css" href="{{ asset("site/css/flaticon.css") }}"> <!-- Flaticon -->
    <link rel="stylesheet" type="text/css" href="{{ asset("site/css/swiper-bundle.min.css") }}"><!-- Swiper Slider -->
    <link rel="stylesheet" type="text/css" href="{{ asset("site/css/style.css") }}"><!-- MAIN STYLE SHEET -->
    <!-- THEME COLOR CHANGE STYLE SHEET -->
    <link rel="stylesheet" class="skin" type="text/css" href="{{ asset("site/css/skins-type/skin-6.css") }}">
    <!-- SIDE SWITCHER STYLE SHEET -->
    <link rel="stylesheet" type="text/css" href="{{ asset("site/css/switcher.css") }}">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css">
    @yield('web.css')
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-1721827883325225"
            crossorigin="anonymous"></script>
</head>
<body>
<!-- LOADING AREA START ===== -->
<div class="loading-area">
    <div class="loading-box"></div>
    <div class="loading-pic">
        <div class="wrapper">
            <div class="cssload-loader"></div>
        </div>
    </div>
</div>
<!-- LOADING AREA  END ====== -->
<div class="page-wraper">
<x-web.header />
    @yield('web.section')
<x-web.footer />
