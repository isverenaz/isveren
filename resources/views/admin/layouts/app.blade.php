<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <title>Vacancy | Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description"/>
    <meta content="Themesbrand" name="author"/>
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('admin/assets/images/favicon.ico') }}">
    <!-- Bootstrap Css -->
    <link href="{{ asset('admin/assets/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet"
          type="text/css"/>
    <!-- Icons Css -->
    <link href="{{ asset('admin/assets/css/icons.min.css') }}" rel="stylesheet" type="text/css"/>
    <!-- App Css-->
    <link href="{{ asset('admin/assets/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css"/>
    @yield('admin.css')
</head>
<body data-sidebar="dark" data-layout-mode="light">
<!-- Begin page -->
<div id="layout-wrapper">
@include('admin.layouts.parents.header')
<!-- ========== Left Sidebar Start ========== -->
@include('admin.layouts.parents.left-sidebar')
<!-- Left Sidebar End -->
    <div class="main-content">

        <!-- Start right Content here -->
        @yield('admin.content')
        @include('admin.layouts.parents.footer')
    </div>
    <!-- end main content-->
</div>
<!-- END layout-wrapper -->
<script src="{{ asset('admin/assets/libs/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('admin/assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('admin/assets/libs/metismenu/metisMenu.min.js') }}"></script>
<script src="{{ asset('admin/assets/libs/simplebar/simplebar.min.js') }}"></script>
<script src="{{ asset('admin/assets/libs/node-waves/waves.min.js') }}"></script>
<!-- apexcharts -->
<script src="{{ asset('admin/assets/libs/apexcharts/apexcharts.min.js') }}"></script>
<!-- dashboard init -->
<script src="{{ asset('admin/assets/js/pages/dashboard.init.js') }}"></script>
<!-- App js -->
<script src="{{ asset('admin/assets/js/app.js') }}"></script>
@yield('admin.js')
</body>
</html>
